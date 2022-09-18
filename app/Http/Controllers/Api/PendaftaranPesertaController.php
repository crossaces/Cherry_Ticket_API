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
        $PendaftaranPeserta = PendaftaranPeserta::with('event.jenisacara','event.genre','event.kota','event.tiket','order.tiket')->where("ID_PESERTA", "=", $id)->orderBy('ID_PENDAFTARAN', 'DESC')->get();    
        if (!is_null($PendaftaranPeserta)) {
            return response(
                [
                    "message" => "Retrieve All Participant Success",
                    "data" => $PendaftaranPeserta,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Participant Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $PendaftaranPeserta = PendaftaranPeserta::find($id);        
        if (is_null($PendaftaranPeserta)) {
            return response(
                [
                    "message" => "Form Register Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "data_pertanyaan" => "nullable"
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $PendaftaranPeserta->DATA_PERTANYAAN = $updateData["data_pertanyaan"];

        if ($PendaftaranPeserta->save()) {
            return response(
                [
                    "message" => "Update Form Register Success",
                    "data" => $PendaftaranPeserta,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Update Form Register Failed",
                "data" => null,
            ],
            400
        );
    }


    public function getDataPendaftaranEvent($id)
    { 
        $PendaftaranPeserta = PendaftaranPeserta::with('check','peserta','order.tiket')->where("ID_EVENT", "=", $id)->orderBy('ID_PENDAFTARAN', 'DESC')->get();    
        if (!is_null($PendaftaranPeserta)) {
            return response(
                [
                    "message" => "Retrieve All Participant Success",
                    "data" => $PendaftaranPeserta,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Participant Not Found",
                "data" => null,
            ],
            404
        );
    }
}
