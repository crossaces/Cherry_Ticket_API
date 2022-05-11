<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response, File;

class BeritaController extends Controller
{
    //

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "tgl_mulai" => "required|date_format:Y-m-d",
            "tgl_selesai" => "required|date_format:Y-m-d",
            "judul" => "required",
            "gambar_berita" => "required|image|mimes:jpeg,png,jpg|max:1048",
            "deskripsi" => "required",
            "id_admin" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar_berita")) {
            $imageName =
                time() . "Berita" . "." . $request->gambar_berita->extension();
            $request->gambar_berita->move(
                public_path("GambarBerita"),
                $imageName
            );
        }

        $Berita = Berita::create([
            "TGL_MULAI" => $storeData["tgl_mulai"],
            "TGL_SELESAI" => $storeData["tgl_selesai"],
            "JUDUL" => $storeData["judul"],
            "GAMBAR_BERITA" => $imageName,
            "DESKRIPSI" => $storeData["deskripsi"],
            "ID_ADMIN" => $storeData["id_admin"],
        ]);

        return response(
            [
                "message" => "Add News Success",
                "data" => $Berita,
            ],
            200
        );

        return response(
            [
                "message" => "Add News Failed",
            ],
            406
        );
    }

    public function getAll()
    {
        $Berita = Berita::all()
            ->where("TGL_MULAI", "<=", date("Y-m-d"))
            ->where("TGL_SELESAI", ">=", date("Y-m-d"));

        if (!is_null($Berita)) {
            return response(
                [
                    "message" => "Retrieve All News Success",
                    "data" => $Berita,
                ],
                200
            );
        }

        return response(
            [
                "message" => "News Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Berita = Berita::find($id);

        if (!is_null($Berita)) {
            return response(
                [
                    "message" => "Retrieve All News Success",
                    "data" => $Berita,
                ],
                200
            );
        }

        return response(
            [
                "message" => "News Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $Berita = Berita::find($id);
        $gambar = $Berita->GAMBAR_BERITA;
        if (is_null($Berita)) {
            return response(
                [
                    "message" => "News Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "tgl_mulai" => "required|date_format:Y-m-d",
            "tgl_selesai" => "required|date_format:Y-m-d",
            "judul" => "required",
            "gambar_berita" => "required",
            "deskripsi" => "required",
            "id_admin" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar_berita")) {
            $imageName =
                time() . "Berita" . "." . $request->gambar_berita->extension();
            $request->gambar_berita->move(
                public_path("GambarBerita"),
                $imageName
            );
        }

        $Berita->TGL_MULAI = $updateData["tgl_mulai"];
        $Berita->TGL_SELESAI = $updateData["tgl_selesai"];
        $Berita->JUDUL = $updateData["judul"];
        $Berita->GAMBAR_BERITA = $imageName;
        $Berita->DESKRIPSI = $updateData["deskripsi"];
        $Berita->ID_ADMIN = $updateData["id_admin"];

        if ($Berita->save()) {
            if ($gambar != null) {
                File::delete(public_path() . "/GambarBerita/" . $gambar);
            }
            return response(
                [
                    "message" => "Update News Success",
                    "data" => $Berita,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update News Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $Berita = Berita::find($id);
        if (is_null($Berita)) {
            return response(
                [
                    "message" => "News Not Found",
                    "data" => null,
                ],
                404
            );
        }

        if ($Berita->delete()) {
            return response(
                [
                    "message" => "Delete News Success",
                    "data" => $Berita,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete News Failed",
                "data" => null,
            ],
            400
        );
    }
}
