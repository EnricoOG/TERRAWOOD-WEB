<?php

namespace App\Services;

use App\Models\ManualSale;
use App\Models\Order;
use Illuminate\Support\Carbon;

/**
 * Satu sumber data untuk halaman Analitik Penjualan DAN ekspor Excel,
 * supaya angka di layar dan di file Excel selalu sama.
 *
 * Aturan: pesanan website hanya dihitung bila berstatus "selesai".
 */
class SalesReport
{
    public static function build(?string $from, ?string $to): array
    {
        $orders = Order::query()
            ->with('product')
            ->where('status', 'selesai')
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->get();

        $manual = ManualSale::query()
            ->when($from, fn ($q) => $q->whereDate('sold_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('sold_at', '<=', $to))
            ->get();

        $websiteRevenue = (float) $orders->sum('total_price');
        $manualRevenue  = (float) $manual->sum('total');
        $totalRevenue   = $websiteRevenue + $manualRevenue;
        $totalCount     = $orders->count() + $manual->count();

        // ---------- Produk terlaris ----------
        $topWebsite = $orders
            ->groupBy(fn ($o) => $o->product?->name ?? 'Produk dihapus')
            ->map(fn ($g) => [
                'quantity' => (int) $g->sum('quantity'),
                'revenue'  => (float) $g->sum('total_price'),
            ])->sortByDesc('revenue')->take(10);

        $topManual = $manual
            ->groupBy(fn ($s) => trim((string) $s->product_name))
            ->map(fn ($g) => [
                'quantity' => (int) $g->sum('quantity'),
                'revenue'  => (float) $g->sum('total'),
            ])->sortByDesc('revenue')->take(10);

        // ---------- Omzet per saluran ----------
        $channels = collect([[
            'name'    => 'Website',
            'count'   => $orders->count(),
            'revenue' => $websiteRevenue,
        ]])->merge(
            $manual
                ->groupBy(fn ($s) => mb_convert_case(trim((string) $s->channel) ?: 'Lainnya', MB_CASE_TITLE))
                ->map(fn ($g, $name) => [
                    'name'    => $name,
                    'count'   => $g->count(),
                    'revenue' => (float) $g->sum('total'),
                ])->values()
        )->filter(fn ($c) => $c['count'] > 0)->sortByDesc('revenue')->values();

        // ---------- Tren bulanan ----------
        $end = $to ? Carbon::parse($to)->startOfMonth() : now()->startOfMonth();
        $start = $from ? Carbon::parse($from)->startOfMonth() : $end->copy()->subMonths(11);
        if ($start->gt($end)) {
            $end = $start->copy();
        }
        if ($start->diffInMonths($end) > 35) {
            $start = $end->copy()->subMonths(35);
        }

        $webByMonth = $orders->groupBy(fn ($o) => $o->created_at->format('Y-m'))
            ->map(fn ($g) => (float) $g->sum('total_price'));
        $manualByMonth = $manual->groupBy(fn ($s) => $s->sold_at->format('Y-m'))
            ->map(fn ($g) => (float) $g->sum('total'));

        $monthly = collect();
        for ($m = $start->copy(); $m->lte($end); $m->addMonth()) {
            $key = $m->format('Y-m');
            $web = (float) ($webByMonth[$key] ?? 0);
            $man = (float) ($manualByMonth[$key] ?? 0);
            $monthly->push([
                'label'   => $m->copy()->locale('id')->translatedFormat('M Y'),
                'website' => $web,
                'manual'  => $man,
                'total'   => $web + $man,
            ]);
        }

        // ---------- Detail gabungan (untuk Excel) ----------
        $detail = $orders->map(fn ($o) => [
            'type'       => 'Website',
            'ref'        => $o->order_number,
            'product'    => $o->product?->name ?? 'Produk dihapus',
            'quantity'   => (int) $o->quantity,
            'unit_price' => (float) $o->unit_price,
            'total'      => (float) $o->total_price,
            'date'       => $o->created_at,
            'channel'    => 'Website',
            'notes'      => $o->notes,
        ])->concat($manual->map(fn ($s) => [
            'type'       => 'Manual',
            'ref'        => $s->sale_reference,
            'product'    => $s->product_name,
            'quantity'   => (int) $s->quantity,
            'unit_price' => (float) $s->unit_price,
            'total'      => (float) $s->total,
            'date'       => $s->sold_at,
            'channel'    => $s->channel,
            'notes'      => $s->notes,
        ]))->sortByDesc(fn ($r) => $r['date']?->timestamp ?? 0)->values();

        return [
            'websiteRevenue' => $websiteRevenue,
            'manualRevenue'  => $manualRevenue,
            'totalRevenue'   => $totalRevenue,
            'websiteCount'   => $orders->count(),
            'manualCount'    => $manual->count(),
            'totalCount'     => $totalCount,
            'average'        => $totalCount > 0 ? $totalRevenue / $totalCount : 0.0,
            'topWebsite'     => $topWebsite,
            'topManual'      => $topManual,
            'channels'       => $channels,
            'monthly'        => $monthly,
            'detail'         => $detail,
        ];
    }
}
