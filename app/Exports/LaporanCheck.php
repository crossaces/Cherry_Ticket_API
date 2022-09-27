<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class LaporanCheck implements FromView, ShouldAutoSize
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

    public function sheets(): array {
        $data = $this->view();
   
        return [
            view('laporancheck', $data),
            view('laporancheck', $data),
        ];
    }
}