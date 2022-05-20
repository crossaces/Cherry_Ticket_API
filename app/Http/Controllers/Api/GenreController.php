<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response, File;

class GenreController extends Controller
{
    //
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "nama_genre" => "required|unique:genre,NAMA_GENRE,NULL,NULL,deleted_at,NULL",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Genre = Genre::create([
            "NAMA_GENRE" => $storeData["nama_genre"],
        ]);

        return response(
            [
                "message" => "Add Genre Success",
                "data" => $Genre,
            ],
            200
        );

        return response(
            [
                "message" => "Add Genre Failed",
            ],
            406
        );
    }

    public function getAll()
    {
        $Genre = Genre::all();

        if (!is_null($Genre)) {
            return response(
                [
                    "message" => "Retrieve All Genre Success",
                    "data" => $Genre,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Genre Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Genre = Genre::find($id);

        if (!is_null($Genre)) {
            return response(
                [
                    "message" => "Retrieve All Genre Success",
                    "data" => $Genre,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Genre Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $Genre = Genre::find($id);        
        if (is_null($Genre)) {
            return response(
                [
                    "message" => "Genre Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "nama_genre" => "required|unique:genre,NAMA_GENRE," . $id .",ID_GENRE,deleted_at,NULL",            
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Genre->NAMA_GENRE = $updateData["nama_genre"];

        if ($Genre->save()) {
            return response(
                [
                    "message" => "Update Genre Success",
                    "data" => $Genre,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Update Genre Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $Genre = Genre::find($id);
        if (is_null($Genre)) {
            return response(
                [
                    "message" => "Genre Not Found",
                    "data" => null,
                ],
                404
            );
        }

        if ($Genre->delete()) {
            return response(
                [
                    "message" => "Delete Genre Success",
                    "data" => $Genre,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete Genre Failed",
                "data" => null,
            ],
            400
        );
    }
}
