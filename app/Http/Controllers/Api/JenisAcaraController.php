<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisAcara;
use Carbon\Carbon;
use Validator;

class JenisAcaraController extends Controller
{
    //
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "nama_jenis" => "required",
            "status" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $JenisAcara = JenisAcara::create([
            "NAMA_JENIS" => $storeData["nama_jenis"],
            "STATUS" => $storeData["status"],
        ]);

        return response(
            [
                "message" => "Add Category Event Success",
                "data" => $JenisAcara,
            ],
            200
        );

        return response(
            [
                "message" => "Add Category Event Failed",
            ],
            406
        );
    }

    public function getAll()
    {
        $JenisAcara = JenisAcara::all();

        if (!is_null($JenisAcara)) {
            return response(
                [
                    "message" => "Retrieve All Category Event Success",
                    "data" => $JenisAcara,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Category Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $JenisAcara = JenisAcara::find($id);

        if (!is_null($JenisAcara)) {
            return response(
                [
                    "message" => "Retrieve All Category Event Success",
                    "data" => $JenisAcara,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Category Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $JenisAcara = JenisAcara::find($id);
        if (is_null($JenisAcara)) {
            return response(
                [
                    "message" => "Category Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "nama_jenis" => "required",
            "status" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $JenisAcara->NAMA_JENIS = $updateData["nama_jenis"];
        $JenisAcara->STATUS = $updateData["nama_jenis"];

        if ($JenisAcara->save()) {
            return response(
                [
                    "message" => "Update Category Event Success",
                    "data" => $JenisAcara,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Update Category Event Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $JenisAcara = JenisAcara::find($id);
        if (is_null($JenisAcara)) {
            return response(
                [
                    "message" => "Category Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        if ($JenisAcara->delete()) {
            return response(
                [
                    "message" => "Delete Category Event Success",
                    "data" => $JenisAcara,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete Category Event Failed",
                "data" => null,
            ],
            400
        );
    }
}
