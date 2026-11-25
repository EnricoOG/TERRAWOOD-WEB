<?php

namespace App\Exports;

use App\Services\SalesReport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Laporan penjualan TERRAWOOD: 4 sheet
 * Ringkasan | Tren Bulanan | Produk Terlaris | Detail Penjualan
 */
class SalesReportExport implements Export, WithMultipleSheets
{
    public function __construct(private ?string $from, private ?string $to)
    {
    }

    public function sheets(): array
    {
        $r = SalesReport::build($this->from, $this->to);

        $fmt = fn ($d) => Carbon::parse($d)->format('d/m/Y');
        $period = ($this->from || $this->to)
            ? ($this->from ? $fmt($this->from) : 'awal') . ' s/d ' . ($this->to ? $fmt($this->to) : 'sekarang')
            : 'Semua periode';

        return [
            new SummarySheet($r, $period),
            new MonthlySheet($r['monthly']),
            new TopProductsSheet($r),
            new DetailSheet($r['detail']),
        ];
    }
}

/** Dasar semua sheet: warna header, format Rupiah, pengaman teks. */
abstract class ReportSheet implements FromArray, WithTitle, WithStyles
{
    protected const RP = '"Rp" #,##0';

    protected function styleHeader(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '082744']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
    }

    protected function styleTotal(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '082744']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF3DC']],
            'borders' => ['top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'F5A623']]],
        ]);
    }

    /** Teks dari pengguna yang diawali "=" akan dibaca Excel sebagai rumus; beri spasi agar aman. */
    protected static function text(?string $v): string
    {
        $v = (string) $v;

        return str_starts_with($v, '=') ? ' ' . $v : $v;
    }
}

class SummarySheet extends ReportSheet implements ShouldAutoSize
{
    private array $rows = [];
    private array $headers = [];
    private array $money = [];

    public function __construct(array $r, string $period)
    {
        $this->rows[] = ['Laporan Penjualan TERRAWOOD'];
        $this->rows[] = ['Periode', $period];
        $this->rows[] = ['Dibuat pada', now()->format('d/m/Y H:i')];
        $this->rows[] = ['Catatan', 'Pesanan website dihitung bila berstatus Selesai'];
        $this->rows[] = [''];

        $this->rows[] = ['Indikator', 'Nilai'];
        $this->headers[] = 'A' . count($this->rows) . ':B' . count($this->rows);

        $kpis = [
            ['Omzet pesanan website', $r['websiteRevenue'], true],
            ['Omzet penjualan manual', $r['manualRevenue'], true],
            ['Total omzet', $r['totalRevenue'], true],
            ['Jumlah pesanan website', $r['websiteCount'], false],
            ['Jumlah penjualan manual', $r['manualCount'], false],
            ['Total transaksi', $r['totalCount'], false],
            ['Rata-rata nilai per transaksi', $r['average'], true],
        ];
        foreach ($kpis as [$label, $value, $isMoney]) {
            $this->rows[] = [$label, $value];
            if ($isMoney) {
                $this->money[] = 'B' . count($this->rows);
            }
        }

        $this->rows[] = [''];
        $this->rows[] = ['Saluran penjualan', 'Jumlah transaksi', 'Omzet'];
        $this->headers[] = 'A' . count($this->rows) . ':C' . count($this->rows);

        foreach ($r['channels'] as $c) {
            $this->rows[] = [self::text($c['name']), $c['count'], $c['revenue']];
            $this->money[] = 'C' . count($this->rows);
        }
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('082744');
        $sheet->getStyle('A2:A4')->getFont()->setBold(true);
        $sheet->getStyle('B2:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        foreach ($this->headers as $range) {
            $this->styleHeader($sheet, $range);
        }
        foreach ($this->money as $cell) {
            $sheet->getStyle($cell)->getNumberFormat()->setFormatCode(self::RP);
        }

        return [];
    }
}

class MonthlySheet extends ReportSheet implements ShouldAutoSize
{
    private array $rows;

    public function __construct($monthly)
    {
        $this->rows = [['Bulan', 'Website', 'Manual', 'Total']];
        foreach ($monthly as $m) {
            $this->rows[] = [$m['label'], $m['website'], $m['manual'], $m['total']];
        }
        $last = count($this->rows);
        $this->rows[] = ['Total', "=SUM(B2:B{$last})", "=SUM(C2:C{$last})", "=SUM(D2:D{$last})"];
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return 'Tren Bulanan';
    }

    public function styles(Worksheet $sheet): array
    {
        $n = count($this->rows);
        $this->styleHeader($sheet, 'A1:D1');
        $this->styleTotal($sheet, "A{$n}:D{$n}");
        $sheet->getStyle("B2:D{$n}")->getNumberFormat()->setFormatCode(self::RP);
        $sheet->freezePane('A2');

        return [];
    }
}

class TopProductsSheet extends ReportSheet implements ShouldAutoSize
{
    private array $rows;

    public function __construct(array $r)
    {
        $this->rows = [['Sumber', 'Produk', 'Jumlah (pcs)', 'Omzet']];
        foreach ($r['topWebsite'] as $name => $item) {
            $this->rows[] = ['Website', self::text($name), $item['quantity'], $item['revenue']];
        }
        foreach ($r['topManual'] as $name => $item) {
            $this->rows[] = ['Manual', self::text($name), $item['quantity'], $item['revenue']];
        }
        if (count($this->rows) === 1) {
            $this->rows[] = ['Tidak ada data pada periode ini'];
        }
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return 'Produk Terlaris';
    }

    public function styles(Worksheet $sheet): array
    {
        $n = count($this->rows);
        $this->styleHeader($sheet, 'A1:D1');
        $sheet->getStyle("C2:C{$n}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("D2:D{$n}")->getNumberFormat()->setFormatCode(self::RP);
        $sheet->freezePane('A2');

        return [];
    }
}

class DetailSheet extends ReportSheet implements WithColumnWidths
{
    private array $rows;
    private bool $hasData;

    public function __construct($detail)
    {
        $this->rows = [['Tipe', 'Referensi', 'Produk', 'Jumlah', 'Harga Satuan', 'Total', 'Tanggal', 'Saluran', 'Catatan']];

        foreach ($detail as $d) {
            $this->rows[] = [
                $d['type'],
                self::text($d['ref']),
                self::text($d['product']),
                $d['quantity'],
                $d['unit_price'],
                $d['total'],
                $d['date'] ? ExcelDate::dateTimeToExcel($d['date']) : '',
                self::text($d['channel']),
                self::text($d['notes']),
            ];
        }

        $this->hasData = count($this->rows) > 1;

        if ($this->hasData) {
            $last = count($this->rows);
            $this->rows[] = ['TOTAL', '', '', "=SUM(D2:D{$last})", '', "=SUM(F2:F{$last})", '', '', ''];
        } else {
            $this->rows[] = ['Tidak ada data pada periode ini'];
        }
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return 'Detail Penjualan';
    }

    public function columnWidths(): array
    {
        return ['A' => 11, 'B' => 20, 'C' => 34, 'D' => 10, 'E' => 17, 'F' => 17, 'G' => 13, 'H' => 15, 'I' => 42];
    }

    public function styles(Worksheet $sheet): array
    {
        $this->styleHeader($sheet, 'A1:I1');
        $sheet->freezePane('A2');

        if (! $this->hasData) {
            return [];
        }

        $n = count($this->rows);   // termasuk baris total
        $last = $n - 1;            // baris data terakhir

        $sheet->setAutoFilter("A1:I{$last}");
        $sheet->getStyle("D2:D{$n}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("E2:F{$n}")->getNumberFormat()->setFormatCode(self::RP);
        $sheet->getStyle("G2:G{$last}")->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        $sheet->getStyle("G2:G{$last}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A2:I{$n}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("I2:I{$n}")->getAlignment()->setWrapText(true);
        $this->styleTotal($sheet, "A{$n}:I{$n}");

        return [];
    }
}