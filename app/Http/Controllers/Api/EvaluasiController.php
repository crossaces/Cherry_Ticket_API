<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluasi;
use Validator, Redirect, Response, File;

class EvaluasiController extends Controller
{
    //

     public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "data_jawaban" => "required",
            "id_form_evaluasi" => "required",
            "id_pendaftaran" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Evaluasi = Evaluasi::create([
            "DATA_JAWABAN" => json_encode($storeData['data_jawaban']),
            "ID_FORM_EVALUASI" => $storeData["id_form_evaluasi"],
            "ID_PENDAFTARAN" => $storeData["id_pendaftaran"],
        ]);

        return response(
            [
                "message" => "Add Evaluasi Event Success",
                "data" => $Evaluasi,
            ],
            200
        );

        return response(
            [
                "message" => "Add Evaluasi Event Failed",
            ],
            406
        );
    }

    public function getDataEvaluasiPeserta($id)
    {
        $Evaluasi = Evaluasi::with('pendaftaran')->where("ID_EVALUASI", "=", $id)->orderBy('ID_EVALUASI', 'DESC')->first();    
        if (!is_null($Evaluasi)) {
            return response(
                [
                    "message" => "Retrieve All Evaluation Success",
                    "data" => $Evaluasi,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Evaluation Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $Evaluasi = Evaluasi::find($id);        
        if (is_null($Evaluasi)) {
            return response(
                [
                    "message" => "Form Evaluation Not Found",
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

        $Evaluasi->DATA_PERTANYAAN = $updateData["data_pertanyaan"];

        if ($Evaluasi->save()) {
            return response(
                [
                    "message" => "Update Form Evaluation Success",
                    "data" => $Evaluasi,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Update Form Evaluation Failed",
                "data" => null,
            ],
            400
        );
    }


    public function getDataEvaluasiEvent($id)
    { 
        $Evaluasi = Evaluasi::with('event.jenisacara','event.genre','event.kota','event.tiket','peserta','order.tiket')->where("ID_EVENT", "=", $id)->orderBy('ID_PENDAFTARAN', 'DESC')->get();    
        if (!is_null($Evaluasi)) {
            return response(
                [
                    "message" => "Retrieve All Evaluation Success",
                    "data" => $Evaluasi,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Evaluation Not Found",
                "data" => null,
            ],
            404
        );
    }
}
