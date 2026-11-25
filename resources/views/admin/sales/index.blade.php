@extends('layouts.admin')

@section('title', 'Analitik Penjualan | TERRAWOOD')
@section('page_title', 'Analitik Penjualan')
@section('page_subtitle', 'Pesanan website yang selesai dan penjualan di luar website.')

@section('admin')

@php
    $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');

    // Format singkat untuk label grafik: 1,2 jt / 3 M / 500 rb
    $short = function ($n) {
        if ($n >= 1e9) return rtrim(rtrim(number_format($n / 1e9, 1, ',', '.'), '0'), ',') . ' M';
        if ($n >= 1e6) return rtrim(rtrim(number_format($n / 1e6, 1, ',', '.'), '0'), ',') . ' jt';
        if ($n >= 1e3) return number_format($n / 1e3, 0, ',', '.') . ' rb';
        return number_format($n, 0, ',', '.');
    };

    $chartMax = max(1, (float) $report['monthly']->max('total'));
    $chartH   = 130;
    $monthlyTotal = [
        'website' => $report['monthly']->sum('website'),
        'manual'  => $report['monthly']->sum('manual'),
        'total'   => $report['monthly']->sum('total'),
    ];
@endphp

<style>
    .filter-bar { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 14px; background: white; border: 1px solid var(--line); border-radius: 14px; padding: 16px 18px; margin-bottom: 18px; }
    .filter-form { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px; }
    .filter-form .field { min-width: 160px; }

    .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 8px; }
    .stat-card { background: white; border: 1px solid var(--line); border-radius: 14px; padding: 20px; box-shadow: 0 2px 10px rgba(8,39,68,.04); }
    .stat-card--highlight { border-color: #f3d28f; background: linear-gradient(180deg, #fffaf0, #ffffff); }
    .stat-label { display: block; color: var(--muted); font-size: 13px; font-weight: 600; margin-bottom: 12px; }
    .stat-number { color: var(--navy); font-family: 'Manrope', sans-serif; font-size: 26px; font-weight: 800; line-height: 1.1; font-variant-numeric: tabular-nums; }
    .stat-card--highlight .stat-number { color: var(--amber); }
    .stat-note { display: block; margin-top: 8px; color: var(--muted); font-size: 12px; }
    .rule-note { color: var(--muted); font-size: 12.5px; margin: 10px 2px 0; }

    /* Grafik tren (CSS murni, tanpa library) */
    .legend { display: flex; gap: 16px; font-size: 12px; color: var(--muted); }
    .legend i { display: inline-block; width: 10px; height: 10px; border-radius: 3px; margin-right: 6px; vertical-align: -1px; }
    .chart { display: flex; align-items: flex-end; gap: 8px; overflow-x: auto; padding: 4px 2px 2px; }
    .chart-col { flex: 1 0 46px; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; gap: 6px; min-height: 190px; }
    .chart-val { min-height: 14px; font-size: 10.5px; font-weight: 700; color: var(--navy); white-space: nowrap; }
    .chart-bar { display: flex; flex-direction: column; justify-content: flex-end; width: 100%; max-width: 44px; }
    .seg { display: block; width: 100%; }
    .seg--manual { background: var(--gold); border-radius: 5px 5px 0 0; }
    .seg--web { background: var(--navy); }
    .seg--manual + .seg--web { border-radius: 0; }
    .seg--web:first-child { border-radius: 5px 5px 0 0; }
    .seg--empty { height: 3px; background: #e6e1d4; border-radius: 3px; }
    .chart-lbl { font-size: 10.5px; color: var(--muted); text-align: center; line-height: 1.25; }

    .dashboard-columns { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px; align-items: start; }

    .rank-item { display: flex; justify-content: space-between; align-items: baseline; gap: 12px; padding: 11px 0; border-bottom: 1px solid #f1eee6; font-size: 13.5px; }
    .rank-item:last-child { border-bottom: none; padding-bottom: 0; }
    .rank-item:first-of-type { padding-top: 2px; }
    .rank-item small { display: block; color: var(--muted); font-size: 12px; margin-top: 2px; }
    .rank-item strong { color: var(--navy); white-space: nowrap; font-variant-numeric: tabular-nums; }

    .share { display: block; height: 6px; border-radius: 3px; background: #f1eee6; margin-top: 7px; overflow: hidden; }
    .share i { display: block; height: 100%; background: var(--gold); border-radius: 3px; }

    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 14px; }
    .form-grid .span-2 { grid-column: span 2; }
    .form-foot { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--line); }
    .form-total { font-size: 13px; color: var(--muted); }
    .form-total strong { display: block; color: var(--navy); font-family: 'Manrope', sans-serif; font-size: 20px; margin-top: 2px; }

    .pager { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 14px; font-size: 13px; color: var(--muted); }
    .pager .btn { padding: 8px 14px; }
    .pager .btn[aria-disabled="true"] { opacity: .4; pointer-events: none; }
    .sub-ref { display: block; color: var(--muted); font-size: 12px; font-weight: 500; margin-top: 2px; }

    @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 600px) {
        .stats-grid { gap: 10px; }
        .stat-card { padding: 15px; }
        .stat-number { font-size: 20px; }
        .filter-form, .filter-form .field { width: 100%; }
        .filter-bar .btn { flex: 1; }
        .form-grid .span-2 { grid-column: auto; }
    }
    @media (max-width: 340px) { .stats-grid { grid-template-columns: 1fr; } }
</style>

{{-- NOTIFIKASI --}}
@if($errors->any())
    <div class="alert alert--error" role="alert">
        <strong>Periksa kembali isian Anda:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert--success" role="status">{{ session('success') }}</div>
@endif

{{-- FILTER & UNDUH --}}
<div class="filter-bar">

    <form method="GET" action="{{ route('admin.sales.index') }}" class="filter-form">
        <label class="field">Dari tanggal
            <input type="date" name="from" value="{{ $from }}">
        </label>
        <label class="field">Sampai tanggal
            <input type="date" name="to" value="{{ $to }}">
        </label>
        <button type="submit" class="btn btn--navy">Terapkan</button>
        @if($from || $to)
            <a href="{{ route('admin.sales.index') }}" class="btn btn--ghost">Reset</a>
        @endif
    </form>

    <a href="{{ route('admin.sales.export', request()->only('from', 'to')) }}" class="btn btn--gold">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Unduh Excel (.xlsx)
    </a>

</div>

{{-- RINGKASAN --}}
<section class="stats-grid">

    <div class="stat-card">
        <span class="stat-label">Omzet Website</span>
        <div class="stat-number">{{ $rp($report['websiteRevenue']) }}</div>
        <span class="stat-note">{{ number_format($report['websiteCount']) }} pesanan selesai</span>
    </div>

    <div class="stat-card">
        <span class="stat-label">Omzet Penjualan Luar</span>
        <div class="stat-number">{{ $rp($report['manualRevenue']) }}</div>
        <span class="stat-note">{{ number_format($report['manualCount']) }} transaksi dicatat manual</span>
    </div>

    <div class="stat-card stat-card--highlight">
        <span class="stat-label">Total Omzet</span>
        <div class="stat-number">{{ $rp($report['totalRevenue']) }}</div>
        <span class="stat-note">Website + penjualan luar</span>
    </div>

    <div class="stat-card">
        <span class="stat-label">Total Transaksi</span>
        <div class="stat-number">{{ number_format($report['totalCount']) }}</div>
        <span class="stat-note">Rata-rata {{ $rp($report['average']) }} per transaksi</span>
    </div>

</section>

<p class="rule-note">Pesanan website baru dihitung sebagai penjualan setelah berstatus <strong>Selesai</strong>.</p>

{{-- TREN --}}
<div class="section-heading">
    <h3>Tren Omzet</h3>
    <span>{{ ($from || $to) ? 'Sesuai periode yang dipilih' : '12 bulan terakhir' }}</span>
</div>

<section class="dashboard-panel">

    <div class="panel-heading">
        <h4>Omzet per Bulan</h4>
        <div class="legend">
            <span><i style="background: var(--navy)"></i>Website</span>
            <span><i style="background: var(--gold)"></i>Penjualan luar</span>
        </div>
    </div>

    <div class="chart" role="img" aria-label="Grafik omzet per bulan">
        @foreach($report['monthly'] as $m)
            @php
                $hw = $m['website'] > 0 ? max(2, (int) round($m['website'] / $chartMax * $chartH)) : 0;
                $hm = $m['manual']  > 0 ? max(2, (int) round($m['manual']  / $chartMax * $chartH)) : 0;
            @endphp
            <div class="chart-col" title="{{ $m['label'] }} | Website: {{ $rp($m['website']) }} | Luar: {{ $rp($m['manual']) }}">
                <span class="chart-val">{{ $m['total'] > 0 ? $short($m['total']) : '' }}</span>
                <div class="chart-bar">
                    @if($hm)<i class="seg seg--manual" style="height: {{ $hm }}px"></i>@endif
                    @if($hw)<i class="seg seg--web" style="height: {{ $hw }}px"></i>@endif
                    @if(!$hm && !$hw)<i class="seg seg--empty"></i>@endif
                </div>
                <span class="chart-lbl">{{ $m['label'] }}</span>
            </div>
        @endforeach
    </div>

</section>

<section class="dashboard-panel" style="margin-top: 18px;">

    <div class="panel-heading">
        <h4>Rincian Omzet Bulanan</h4>
    </div>

    <div class="table-wrapper">
        <table class="data-table" style="min-width: 520px;">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th class="text-right">Website</th>
                    <th class="text-right">Penjualan Luar</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report['monthly'] as $m)
                    <tr>
                        <td class="item-name">{{ $m['label'] }}</td>
                        <td class="num text-right">{{ $rp($m['website']) }}</td>
                        <td class="num text-right">{{ $rp($m['manual']) }}</td>
                        <td class="num text-right"><strong>{{ $rp($m['total']) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>Total</td>
                    <td class="num text-right">{{ $rp($monthlyTotal['website']) }}</td>
                    <td class="num text-right">{{ $rp($monthlyTotal['manual']) }}</td>
                    <td class="num text-right">{{ $rp($monthlyTotal['total']) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

</section>

{{-- PRODUK & SALURAN --}}
<div class="section-heading">
    <h3>Produk & Saluran</h3>
    <span>10 produk dengan omzet tertinggi</span>
</div>

<section class="dashboard-columns">

    <div class="dashboard-panel">
        <div class="panel-heading"><h4>Omzet per Saluran</h4></div>

        @forelse($report['channels'] as $channel)
            @php $pct = $report['totalRevenue'] > 0 ? round($channel['revenue'] / $report['totalRevenue'] * 100) : 0; @endphp
            <div class="rank-item">
                <span>
                    {{ $channel['name'] }}
                    <small>{{ number_format($channel['count']) }} transaksi &middot; {{ $pct }}%</small>
                    <span class="share"><i style="width: {{ $pct }}%"></i></span>
                </span>
                <strong>{{ $rp($channel['revenue']) }}</strong>
            </div>
        @empty
            <div class="empty-data">Belum ada penjualan pada periode ini.</div>
        @endforelse
    </div>

    <div class="dashboard-panel">
        <div class="panel-heading"><h4>Produk Terlaris Website</h4></div>

        @forelse($report['topWebsite'] as $name => $item)
            <div class="rank-item">
                <span>{{ $name }}<small>{{ number_format($item['quantity']) }} pcs</small></span>
                <strong>{{ $rp($item['revenue']) }}</strong>
            </div>
        @empty
            <div class="empty-data">Belum ada pesanan website yang selesai.</div>
        @endforelse
    </div>

    <div class="dashboard-panel">
        <div class="panel-heading"><h4>Produk Terlaris Penjualan Luar</h4></div>

        @forelse($report['topManual'] as $name => $item)
            <div class="rank-item">
                <span>{{ $name }}<small>{{ number_format($item['quantity']) }} pcs</small></span>
                <strong>{{ $rp($item['revenue']) }}</strong>
            </div>
        @empty
            <div class="empty-data">Belum ada penjualan luar yang dicatat.</div>
        @endforelse
    </div>

</section>

{{-- INPUT PENJUALAN LUAR --}}
<div class="section-heading">
    <h3>Catat Penjualan di Luar Website</h3>
    <span>WhatsApp, toko offline, marketplace, dan lainnya</span>
</div>

<section class="dashboard-panel">

    <form method="POST" action="{{ route('admin.sales.store') }}">
        @csrf
        <input type="hidden" name="from" value="{{ $from }}">
        <input type="hidden" name="to" value="{{ $to }}">

        <div class="form-grid">

            <label class="field span-2">Nama produk *
                <input type="text" name="product_name" value="{{ old('product_name') }}" required maxlength="255" placeholder="Contoh: Kursi Teak Jepara">
            </label>

            <label class="field">Jumlah *
                <input type="number" name="quantity" id="f-qty" value="{{ old('quantity', 1) }}" min="1" required>
            </label>

            <label class="field">Harga satuan (Rp) *
                <input type="number" name="unit_price" id="f-price" value="{{ old('unit_price') }}" min="0" step="0.01" required placeholder="0">
            </label>

            <label class="field">Tanggal penjualan *
                <input type="date" name="sold_at" value="{{ old('sold_at', date('Y-m-d')) }}" required>
            </label>

            <label class="field">Saluran *
                <input type="text" name="channel" value="{{ old('channel', 'Offline') }}" list="channel-list" required maxlength="100">
                <datalist id="channel-list">
                    <option value="Offline">
                    <option value="WhatsApp">
                    <option value="Instagram">
                    <option value="Tokopedia">
                    <option value="Shopee">
                    <option value="Pameran">
                </datalist>
            </label>

            <label class="field">Referensi
                <input type="text" name="sale_reference" value="{{ old('sale_reference') }}" maxlength="100" placeholder="No. nota / invoice (opsional)">
            </label>

            <label class="field span-2">Catatan
                <input type="text" name="notes" value="{{ old('notes') }}" maxlength="5000" placeholder="Opsional">
            </label>

        </div>

        <div class="form-foot">
            <div class="form-total">
                Total penjualan
                <strong id="f-total">Rp 0</strong>
            </div>
            <button type="submit" class="btn btn--gold">Simpan Penjualan</button>
        </div>
    </form>

</section>

{{-- RIWAYAT --}}
<div class="section-heading">
    <h3>Riwayat Penjualan Luar</h3>
    <span>{{ number_format($manualSales->total()) }} catatan</span>
</div>

<section class="dashboard-panel">

    <div class="table-wrapper">
        <table class="data-table" style="min-width: 680px;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Total</th>
                    <th>Saluran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($manualSales as $sale)
                    <tr>
                        <td class="num">{{ $sale->sold_at->format('d M Y') }}</td>
                        <td>
                            <span class="item-name">{{ $sale->product_name }}</span>
                            @if($sale->sale_reference)
                                <span class="sub-ref">{{ $sale->sale_reference }}</span>
                            @endif
                        </td>
                        <td class="num text-right">{{ number_format($sale->quantity) }}</td>
                        <td class="num text-right">{{ $rp($sale->unit_price) }}</td>
                        <td class="num text-right"><strong>{{ $rp($sale->total) }}</strong></td>
                        <td>{{ $sale->channel }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-data">Belum ada penjualan luar yang dicatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($manualSales->hasPages())
        <nav class="pager" aria-label="Halaman riwayat">
            <a href="{{ $manualSales->previousPageUrl() ?? '#' }}" class="btn btn--ghost" @if($manualSales->onFirstPage()) aria-disabled="true" @endif>&larr; Sebelumnya</a>
            <span>Halaman {{ $manualSales->currentPage() }} dari {{ $manualSales->lastPage() }}</span>
            <a href="{{ $manualSales->nextPageUrl() ?? '#' }}" class="btn btn--ghost" @if(!$manualSales->hasMorePages()) aria-disabled="true" @endif>Berikutnya &rarr;</a>
        </nav>
    @endif

</section>

<script>
(function () {
    var qty = document.getElementById('f-qty');
    var price = document.getElementById('f-price');
    var out = document.getElementById('f-total');
    if (!qty || !price || !out) return;

    function update() {
        var total = (parseFloat(qty.value) || 0) * (parseFloat(price.value) || 0);
        out.textContent = 'Rp ' + Math.round(total).toLocaleString('id-ID');
    }

    qty.addEventListener('input', update);
    price.addEventListener('input', update);
    update();
})();
</script>

@endsection
