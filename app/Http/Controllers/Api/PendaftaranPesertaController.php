<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranPeserta;
use Illuminate\Support\Facades\DB;
use Validator;

class PendaftaranPesertaController extends Controller
{
    //
    public function getDataPendaftaranPeserta($id)
    {
        $Transaksi = PendaftaranPeserta::with('event.jenisacara','event.genre','event.kota','event.tiket')->where("ID_PESERTA", "=", $id)->orderBy('ID_PENDAFTARAN', 'DESC')->get();    
        if (!is_null($Transaksi)) {
            return response(
                [
                    "message" => "Retrieve All Transaction Success",
                    "data" => $Transaksi,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Transaction Not Found",
                "data" => null,
            ],
            404
        );
    }


    public function getDataPendaftaranEvent($id)
    {
        $Transaksi = PendaftaranPeserta::with('event.jenisacara','event.genre','event.kota','event.tiket','peserta')->where("ID_EVENT", "=", $id)->orderBy('ID_PENDAFTARAN', 'DESC')->get();    
        if (!is_null($Transaksi)) {
            return response(
                [
                    "message" => "Retrieve All Transaction Success",
                    "data" => $Transaksi,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Transaction Not Found",
                "data" => null,
            ],
            404
        );
    }
}
