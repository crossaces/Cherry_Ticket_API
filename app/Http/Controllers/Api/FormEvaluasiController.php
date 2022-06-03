<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FormEvaluasi;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Validator;

class FormEvaluasiController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        $FormEvaluasi = FormEvaluasi::find($id);        
        if (is_null($FormEvaluasi)) {
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

        $FormEvaluasi->DATA_PERTANYAAN = $updateData["data_pertanyaan"];

        if ($FormEvaluasi->save()) {
            return response(
                [
                    "message" => "Update Form Evaluation Success",
                    "data" => $FormEvaluasi,
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



    public function get($id)
    {
        $temp=FormEvaluasi::where("ID_EVENT", "=", $id)->first();
        $FormEvaluasi = FormEvaluasi::find($temp['ID_FORM_EVALUASI']);
        $FormEvaluasi->DATA_PERTANYAAN=json_decode($FormEvaluasi->DATA_PERTANYAAN);

        if (!is_null($FormEvaluasi)) {
            return response(
                [
                    "message" => "Retrieve Form Evaluation Success",
                    // "data" => $FormEvaluasi,
                    "data" => $FormEvaluasi
                ],
                200
            );
        }

        return response(
            [
                "message" => "Form Evaluation Not Found",
                "data" => null,
            ],
            404
        );
    }
}
