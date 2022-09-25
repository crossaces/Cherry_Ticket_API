<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    

    // public function __construct($data){
    //     $this->$data = $data;
    // }

    // public function view(): View
    // {
    //     return view('laporan',[
    //         'data'=>$this->data
    //     ]);
    // }


    public function __construct($data)
    {
        $this->data = $data;
    }
    public function view(): View
    {
        return view('productsExport',[
            'data'=>$this->data
        ]);
    }
}