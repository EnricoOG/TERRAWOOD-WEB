<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan customer.
     */
    public function index(Request $request)
    {
        $query = Order::with('product')->latest();

        // Pencarian nomor pesanan, nama, email, dan nomor WhatsApp.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status pesanan.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination tetap mempertahankan pencarian dan filter.
        $orders = $query->paginate(10)->withQueryString();

        // Statistik seluruh pesanan.
        $stats = [
            'total' => Order::count(),

            'pending' => Order::where(
                'status',
                'menunggu'
            )->count(),

            'processing' => Order::where(
                'status',
                'diproses'
            )->count(),

            'completed' => Order::where(
                'status',
                'selesai'
            )->count(),
        ];

        return view('admin.orders.index', compact(
            'orders',
            'stats'
        ));
    }

    /**
     * Menampilkan form tambah pesanan.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.orders.create', compact('products'));
    }

    /**
     * Menyimpan pesanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'status' => [
                'required',
                Rule::in([
                    'menunggu',
                    'diproses',
                    'dikirim',
                    'selesai',
                    'dibatalkan',
                ]),
            ],
        ]);

        $product = Product::findOrFail(
            $validated['product_id']
        );

        $unitPrice = ($product->discount_price && $product->discount_price < $product->price)
            ? (float) $product->discount_price
            : (float) $product->price;
        $quantity = (int) $validated['quantity'];

        // Membuat nomor pesanan unik.
        $orderNumber = 'TRW-' . now()->format('Ymd') .
            '-' . strtoupper(Str::random(5));

        while (Order::where('order_number', $orderNumber)->exists()) {
            $orderNumber = 'TRW-' . now()->format('Ymd') .
                '-' . strtoupper(Str::random(5));
        }

        Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_phone' => $validated['customer_phone'],
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $unitPrice * $quantity,
            'shipping_address' => $validated['shipping_address'],
            'notes' => $validated['notes'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan customer berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Order $order)
    {
        $order->load('product');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Menampilkan form edit pesanan.
     */
    public function edit(Order $order)
    {
        $products = Product::orderBy('name')->get();

        return view('admin.orders.edit', compact(
            'order',
            'products'
        ));
    }

    /**
     * Memperbarui data dan status pesanan.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'status' => [
                'required',
                Rule::in([
                    'menunggu',
                    'diproses',
                    'dikirim',
                    'selesai',
                    'dibatalkan',
                ]),
            ],
        ]);

        $product = Product::findOrFail(
            $validated['product_id']
        );

        $quantity = (int) $validated['quantity'];

        /*
         * Harga satuan:
         * - Jika produk pesanan TIDAK diganti, pertahankan harga satuan
         *   yang tersimpan saat pesanan dibuat. Dengan begitu mengubah status
         *   atau alamat tidak ikut mengubah total pesanan lama ketika harga
         *   produk di katalog sudah berubah.
         * - Jika produk diganti (atau harga tersimpan kosong), pakai harga
         *   produk saat ini.
         */
        $productChanged = (int) $order->product_id !== (int) $product->id;

        $unitPrice = ($productChanged || (float) $order->unit_price <= 0)
            ? (float) $product->price
            : (float) $order->unit_price;

        // Simpan status lama sebelum diperbarui.
        $oldStatus = $order->status;

        $order->update([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_phone' => $validated['customer_phone'],
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $unitPrice * $quantity,
            'shipping_address' => $validated['shipping_address'],
            'notes' => $validated['notes'] ?? null,
            'status' => $validated['status'],
        ]);

        // Kirim notifikasi jika status berubah.
        if (
            $oldStatus !== $order->status &&
            $order->user
        ) {
            $order->user->notify(
                new OrderStatusUpdated(
                    $order,
                    $oldStatus,
                    $order->status
                )
            );
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Data pesanan berhasil diperbarui.');
    }

    /**
     * Menghapus pesanan.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}