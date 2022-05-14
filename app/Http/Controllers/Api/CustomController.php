<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EO;
use App\Models\Peserta;
use App\Models\Kota;
use App\Models\Event;

class CustomController extends Controller
{
    //
    public function getData(Request $request)
    {
        $data['eo']= EO::count();
        $data['peserta']= Peserta::count();
        $data['kota']= Kota::count();
        $data['event']= Event::count();
        // $data['event']= Event::count();
        if (!is_null($data)) {
            return response( 
                [
                    "message" => "Retrieve All Success",
                    "data" => $data,
                ],
                200 
            );
        }
        return response(
            [
                "data" => null,
            ],
            404
        );
    }
}
