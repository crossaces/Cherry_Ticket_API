<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kota;
use Carbon\Carbon;
use Validator, Redirect, Response, File;

class KotaController extends Controller
{
    //
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "nama_kota" => "required|unique:kota,NAMA_KOTA,NULL,NULL,deleted_at,NULL",
            "gambar_kota" => "required|image|mimes:jpeg,png,jpg|max:1048",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar_kota")) {
            $imageName =
                time() . "Kota" . "." . $request->gambar_kota->extension();
            $request->gambar_kota->move(public_path("GambarKota"), $imageName);
        }else{
             return response(
            [
                "message" => "Image must be field",              
            ],
            400
        );
        }

        $Kota = Kota::create([
            "NAMA_KOTA" => $storeData["nama_kota"],
            "GAMBAR_KOTA" => $imageName,
        ]);

        return response(
            [
                "message" => "Add City Success",
                "data" => $Kota,
            ],
            200
        );

        return response(
            [
                "message" => "Add City Failed",
            ],
            406
        );
    }


     public function getImage($id){
        $Kota = Kota::find($id);
        $path = public_path().'/GambarKota/'.$Kota->GAMBAR_KOTA;
        return Response::download($path);   
    }

    public function getAll()
    {
        $Kota = Kota::all();

        if (!is_null($Kota)) {
            return response(
                [
                    "message" => "Retrieve All City Success",
                    "data" => $Kota,
                ],
                200
            );
        }

        return response(
            [
                "message" => "City Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Kota = Kota::find($id);

        if (!is_null($Kota)) {
            return response(
                [
                    "message" => "Retrieve All City Success",
                    "data" => $Kota,
                ],
                200
            );
        }

        return response(
            [
                "message" => "City Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $Kota = Kota::find($id);
        $gambar = $Kota->GAMBAR_KOTA;
        if (is_null($Kota)) {
            return response(
                [
                    "message" => "City Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        if ($files = $request->file("gambar_kota")) {
            $validate = Validator::make($updateData, [
                "nama_kota" => "required|unique:kota,NAMA_KOTA,". $id .",ID_KOTA,deleted_at,NULL",
                "gambar_kota" => "required|image|mimes:jpeg,png,jpg|max:1048",
            ]);
        }
        else{
             $validate = Validator::make($updateData, [
                "nama_kota" => "required|unique:kota,NAMA_KOTA,". $id .",ID_KOTA,deleted_at,NULL",               
            ]);
        }
        

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar_kota")) {
            $imageName =
                time() . "Kota" . "." . $request->gambar_kota->extension();
            $request->gambar_kota->move(public_path("GambarKota"), $imageName);
        }else{
            $imageName = $gambar;
        }

        $Kota->NAMA_KOTA = $updateData["nama_kota"];
        $Kota->GAMBAR_KOTA = $imageName;

        if ($Kota->save()) {
            if ($gambar != null && $files = $request->file("gambar_kota")) {
                File::delete(public_path() . "/GambarKota/" . $gambar);
            }
            return response(
                [
                    "message" => "Update City Success",
                    "data" => $Kota,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update City Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $Kota = Kota::find($id);
        if (is_null($Kota)) {
            return response(
                [
                    "message" => "City Not Found",
                    "data" => null,
                ],
                404
            );
        }

        if ($Kota->delete()) {
            return response(
                [
                    "message" => "Delete City Success",
                    "data" => $Kota,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete City Failed",
                "data" => null,
            ],
            400
        );
    }
}
