<?php

namespace App\Http\Controllers;

use App\Exports\SalesReportExport;
use App\Models\ManualSale;
use App\Services\SalesReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminSalesController extends Controller
{
    /** Validasi filter tanggal; mengembalikan [$from, $to]. */
    private function range(Request $request): array
    {
        $v = $request->validate([
            'from' => ['nullable', 'date'],
            'to'   => ['nullable', 'date', 'after_or_equal:from'],
        ], [
            'date'              => ':attribute bukan tanggal yang valid.',
            'to.after_or_equal' => 'Tanggal akhir harus sama dengan atau setelah tanggal mulai.',
        ], [
            'from' => 'Tanggal mulai',
            'to'   => 'Tanggal akhir',
        ]);

        return [$v['from'] ?? null, $v['to'] ?? null];
    }

    public function index(Request $request)
    {
        [$from, $to] = $this->range($request);

        $report = SalesReport::build($from, $to);

        $manualSales = ManualSale::query()
            ->when($from, fn ($q) => $q->whereDate('sold_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('sold_at', '<=', $to))
            ->latest('sold_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.sales.index', compact('report', 'manualSales', 'from', 'to'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_reference' => ['nullable', 'string', 'max:100'],
            'product_name'   => ['required', 'string', 'max:255'],
            'quantity'       => ['required', 'integer', 'min:1', 'max:1000000'],
            'unit_price'     => ['required', 'numeric', 'min:0', 'max:999999999999'],
            'sold_at'        => ['required', 'date'],
            'channel'        => ['required', 'string', 'max:100'],
            'notes'          => ['nullable', 'string', 'max:5000'],
        ], [
            'required' => ':attribute wajib diisi.',
            'integer'  => ':attribute harus berupa angka bulat.',
            'numeric'  => ':attribute harus berupa angka.',
            'date'     => ':attribute bukan tanggal yang valid.',
            'min'      => ':attribute tidak boleh kurang dari :min.',
            'max'      => ':attribute melebihi batas (maks :max).',
        ], [
            'sale_reference' => 'Referensi',
            'product_name'   => 'Nama produk',
            'quantity'       => 'Jumlah',
            'unit_price'     => 'Harga satuan',
            'sold_at'        => 'Tanggal',
            'channel'        => 'Saluran',
            'notes'          => 'Catatan',
        ]);

        $data['total'] = round($data['quantity'] * $data['unit_price'], 2);
        $data['created_by'] = $request->user()->id;

        ManualSale::create($data);

        return redirect()
            ->route('admin.sales.index', $request->only('from', 'to'))
            ->with('success', 'Penjualan berhasil dicatat.');
    }

    public function export(Request $request)
    {
        [$from, $to] = $this->range($request);

        return Excel::download(
            new SalesReportExport($from, $to),
            'laporan-penjualan-terrawood-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}
