<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class LaporanCheck implements FromView, ShouldAutoSize, WithStyles
{
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function view(): View
    {
        return view('laporancheck',[
            'data'=>$this->data
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