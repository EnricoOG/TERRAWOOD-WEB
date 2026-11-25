<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CustomerOrderController extends Controller
{
    public function create(string $slug): View
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('account.checkout', compact('product'));
    }

    public function store(Request $request, string $slug): RedirectResponse
    {
        $product = Product::where('slug', $slug)
            ->firstOrFail();

        if (!is_numeric($product->price) || $product->price <= 0) {
            return redirect()
                ->route('catalog.show', $product->slug)
                ->with('error', 'Harga produk belum tersedia. Silakan hubungi admin.');
        }

        $validated = $request->validate([
            'customer_phone' => 'required|string|max:30',
            'quantity' => 'required|integer|min:1|max:100',
            'shipping_address' => 'required|string|max:5000',
            'notes' => 'nullable|string|max:2000',
        ], [
            'customer_phone.required' => 'Nomor WhatsApp wajib diisi.',
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Minimal pemesanan adalah 1 produk.',
            'quantity.max' => 'Maksimal pemesanan adalah 100 produk.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
        ]);

        $unitPrice = ($product->discount_price && $product->discount_price < $product->price)
            ? (float) $product->discount_price
            : (float) $product->price;
        $quantity = (int) $validated['quantity'];

        do {
            $orderNumber = 'TRW-' . now()->format('Ymd')
                . '-' . Str::upper(Str::random(5));
        } while (Order::where('order_number', $orderNumber)->exists());

        Order::create([
            'user_id' => $request->user()->id,
            'order_number' => $orderNumber,
            'customer_name' => $request->user()->name,
            'customer_email' => $request->user()->email,
            'customer_phone' => $validated['customer_phone'],
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $unitPrice * $quantity,
            'shipping_address' => $validated['shipping_address'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'menunggu',
        ]);

        // Kirim notifikasi pesanan ke email bisnis; pesanan tetap tersimpan jika SMTP belum dikonfigurasi.
        try {
            $recipient = config('terrawood.email');
            if ($recipient) {
                \Illuminate\Support\Facades\Mail::raw(
                    "Pesanan baru TERRAWOOD\n\nNomor: {$orderNumber}\nCustomer: {$request->user()->name}\nEmail: {$request->user()->email}\nWhatsApp: {$validated['customer_phone']}\nProduk: {$product->name}\nJumlah: {$quantity}\nHarga satuan: Rp " . number_format($unitPrice, 0, ',', '.') . "\nTotal: Rp " . number_format($unitPrice * $quantity, 0, ',', '.') . "\nAlamat: {$validated['shipping_address']}\nCatatan: " . ($validated['notes'] ?? '-') ,
                    function ($message) use ($recipient, $orderNumber) {
                        $message->to($recipient)->subject("Pesanan TERRAWOOD baru - {$orderNumber}");
                    }
                );
            }
        } catch (\Throwable $mailError) {
            \Illuminate\Support\Facades\Log::warning('Email notifikasi pesanan gagal dikirim', [
                'order_number' => $orderNumber,
                'error' => $mailError->getMessage(),
            ]);
        }

        return redirect()
            ->route('account.index')
            ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $orderNumber);
    }

public function cancel(Request $request, int $id)
{
    $order = Order::where('user_id', $request->user()->id)
        ->where('id', $id)
        ->firstOrFail();

    if ($order->status !== 'menunggu') {
        return redirect()
            ->route('account.orders.show', $order->id)
            ->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses atau statusnya telah berubah.');
    }

    $updated = Order::where('id', $order->id)
        ->where('user_id', $request->user()->id)
        ->where('status', 'menunggu')
        ->update([
            'status' => 'dibatalkan',
        ]);

    if (!$updated) {
        return redirect()
            ->route('account.orders.show', $order->id)
            ->with('error', 'Pesanan gagal dibatalkan. Silakan periksa status pesanan.');
    }

    return redirect()
        ->route('account.orders.show', $order->id)
        ->with('success', 'Pesanan berhasil dibatalkan.');
}

}
