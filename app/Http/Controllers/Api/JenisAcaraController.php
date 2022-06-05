<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisAcara;
use Carbon\Carbon;
use Validator,Redirect, Response, File;;

class JenisAcaraController extends Controller
{
    //
    public function store(Request $request)
    {

        // jenis_acara
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "nama_jenis" => "required|unique:jenis_acara,NAMA_JENIS,NULL,NULL,deleted_at,NULL",
            "status" => "required",
            "gambar" => "required|image|mimes:jpeg,png,jpg|max:1048",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar")) {
            $imageName =
                time() . "Jenis" . "." . $request->gambar->extension();
            $request->gambar->move(
                public_path("GambarJenis"),
                $imageName
            );
        }else{
             return response(
            [
                "message" => "Image must be field",              
            ],
            400
        );
        }

        $JenisAcara = JenisAcara::create([
            "NAMA_JENIS" => $storeData["nama_jenis"],
            "STATUS" => $storeData["status"],
            "GAMBAR" => $imageName,
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

    public function getImage($id){
        $JenisAcara = JenisAcara::find($id);
        $path = public_path().'/GambarJenis/'.$JenisAcara->GAMBAR;
        return Response::download($path);   
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
        $gambar = $JenisAcara->GAMBAR;
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
        if ($files = $request->file("gambar")) {
            $validate = Validator::make($updateData, [
                "nama_jenis" => "required|unique:jenis_acara,NAMA_JENIS," . $id .",ID_JENIS_ACARA,deleted_at,NULL",
                "status" => "required",
                "gambar" => "required|image|mimes:jpeg,png,jpg|max:1048",
            ]);
        }
        else{
              $validate = Validator::make($updateData, [
                "nama_jenis" => "required|unique:jenis_acara,NAMA_JENIS," . $id .",ID_JENIS_ACARA,deleted_at,NULL",
                "status" => "required",               
            ]);
        }
       

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar")) {
            $imageName =
                time() . "Jenis" . "." . $request->gambar->extension();
            $request->gambar->move(
                public_path("GambarJenis"),
                $imageName
            );
        }else{
            $imageName = $gambar;
        }
            
        $JenisAcara->NAMA_JENIS = $updateData["nama_jenis"];
        $JenisAcara->STATUS = $updateData["status"];
        $JenisAcara->GAMBAR =  $imageName;


        if ($JenisAcara->save()) {
             if ($gambar != null && $files = $request->file("gambar")) {
                File::delete(public_path() . "/GambarJenis/" . $gambar);
            }
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
