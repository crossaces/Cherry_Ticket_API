<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qna;
use Validator;

class QnaController extends Controller
{
    //
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "nama_peserta" => "required",
            "pertanyaan" => "required",
            "id_event" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Qna = Qna::create([
            "NAMA_PESERTA" => $storeData["nama_peserta"],
            "PERTANYAAN" => $storeData["pertanyaan"],
            "ID_EVENT" => $storeData["id_event"],
        ]);

        return response(
            [
                "message" => "Add Qna Event Success",
                "data" => $Qna,
            ],
            200
        );

        return response(
            [
                "message" => "Add Qna Event Failed",
            ],
            406
        );
    }

    public function getAll($id)
    {
        $Qna = Qna::all();

        if (!is_null($Qna)) {
            return response(
                [
                    "message" => "Retrieve All Qna Event Success",
                    "data" => $Qna,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Qna Event Not Found",
                "data" => null,
            ],
            404
        );
    }

     public function getAllEvent($id)
    {
        $Qna = Qna::all()->where("ID_EVENT",$id);

        if (!is_null($Qna)) {
            return response(
                [
                    "message" => "Retrieve All Qna Event Success",
                    "data" => $Qna,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Qna Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Qna = Qna::find($id);

        if (!is_null($Qna)) {
            return response(
                [
                    "message" => "Retrieve All Qna Event Success",
                    "data" => $Qna,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Qna Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $Qna = Qna::find($id);
        if (is_null($Qna)) {
            return response(
                [
                    "message" => "Qna Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "nama_peserta" => "required",
            "pertanyaan" => "required",
            "id_event" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Qna->NAMA_PESERTA = $updateData["nama_peserta"];
        $Qna->PERTANYAAN = $updateData["pertanyaan"];
        $Qna->ID_EVENT = $updateData["id_event"];

        if ($Qna->save()) {
            return response(
                [
                    "message" => "Update Qna Event Success",
                    "data" => $Qna,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Update Qna Event Failed",
                "data" => null,
            ],
            400
        );
    }


    public function updateStatus(Request $request, $id)
    {
        $Qna = Qna::find($id);
        if (is_null($Qna)) {
            return response(
                [
                    "message" => "Qna Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "status_qna" => "required",
           
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Qna->STATUS_QNA = $updateData["status_qna"];       

        if ($Qna->save()) {
            return response(
                [
                    "message" => "Update Qna Event Success",
                    "data" => $Qna,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Update Qna Event Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $Qna = Qna::find($id);
        if (is_null($Qna)) {
            return response(
                [
                    "message" => "Qna Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        if ($Qna->delete()) {
            return response(
                [
                    "message" => "Delete Qna Event Success",
                    "data" => $Qna,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete Qna Event Failed",
                "data" => null,
            ],
            400
        );
    }
}
