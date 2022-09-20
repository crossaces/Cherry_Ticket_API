<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluasi;
use Validator, Redirect, Response, File;
use Illuminate\Support\Facades\DB;
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
        $check = Evaluasi::where('ID_FORM_EVALUASI','=',$storeData["id_form_evaluasi"])->where('ID_PENDAFTARAN','=',$storeData["id_pendaftaran"])->get();

        if (count($check)>0) {
            return response( 
                [
                    "message" => "Participant Already Check-In",
                    "data" => $check,
                ],
                400 
            );
        }else{
            $Evaluasi = Evaluasi::create([
                "DATA_JAWABAN" => json_encode($storeData['data_jawaban']),
                "ID_FORM_EVALUASI" => $storeData["id_form_evaluasi"],
                "ID_PENDAFTARAN" => $storeData["id_pendaftaran"],
            ]);

            if ($Evaluasi->save()) {
                return response(
                    [
                        "message" => "Send Your Feedback Successfully",
                        "data" => $Evaluasi,
                    ],
                    200
                );
            }
        }

      

        return response(
            [
                "message" => "Send Your Feedback Failed",
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

         $FormEvaluasi = DB::table('form_evaluasi')
                                ->join('event', 'form_evaluasi.ID_EVENT', '=', 'event.ID_EVENT')                               
                                ->where("event.ID_EVENT", "=", $id)
                                ->first();

        $Evaluasi = Evaluasi::all()->where("ID_FORM_EVALUASI", "=", $FormEvaluasi->ID_FORM_EVALUASI);    
      
        $FormEvaluasi->DATA_PERTANYAAN=json_decode($FormEvaluasi->DATA_PERTANYAAN);
        
        if (!is_null($Evaluasi)) {
            return response(
                [
                    "message" => "Retrieve All Evaluation Success",
                    "data" => $Evaluasi,
                    "dataf" => $FormEvaluasi,
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
