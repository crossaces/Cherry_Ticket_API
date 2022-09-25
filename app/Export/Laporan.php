<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;

class Laporan implements FromView
{
    

    public function __construct($data){
        $this->$data = $data;
    }

    public function view(): View
    {
        return view('laporan',[
            'data'=>$this->data
        ]);
    }
}