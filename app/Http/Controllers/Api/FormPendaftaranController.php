<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FormPendaftaran;
use Illuminate\Support\Facades\DB;
use Validator;

class FormPendaftaranController extends Controller
{
    //

    public function update(Request $request, $id)
    {
        $FormPendaftaran = FormPendaftaran::find($id);        
        if (is_null($FormPendaftaran)) {
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
            "data_pertanyaan" => "required"
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $FormPendaftaran->DATA_PERTANYAAN = $updateData["data_pertanyaan"];

        if ($FormPendaftaran->save()) {
            return response(
                [
                    "message" => "Update Form Register Success",
                    "data" => $FormPendaftaran,
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



    public function get($id)
    {
        $FormPendaftaran = FormPendaftaran::find($id);

        if (!is_null($FormPendaftaran)) {
            return response(
                [
                    "message" => "Retrieve Form Register Success",
                    // "data" => $FormPendaftaran,
                    "TEST" => json_decode($FormPendaftaran->DATA_PERTANYAAN),
                ],
                200
            );
        }

        return response(
            [
                "message" => "Form Register Not Found",
                "data" => null,
            ],
            404
        );
    }
}
