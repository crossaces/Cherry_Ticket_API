<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class LaporanTransaksi implements FromView, ShouldAutoSize, WithStyles
{
    public function __construct($data,$count)
    {
        $this->data = $data;
        $this->count = $count;
    }
    public function view(): View
    {
        return view('laporantransaksi',[
            'data'=>$this->data,
            'count'=>$this->count
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],         
        ];
    }
}