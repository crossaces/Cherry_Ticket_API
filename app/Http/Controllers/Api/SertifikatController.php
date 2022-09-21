<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator, Redirect, Response, File;
class SertifikatController extends Controller
{
    //
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [       
            "background" => "required|image|mimes:jpeg,png,jpg|max:1048",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("background")) {
            $imageName =
                time() . "Sertifikat" . "." . $request->background->extension();
            $request->background->move(public_path("GambarSertifikat"), $imageName);
        }else{
            return response(
            [
                "message" => "Image must be field",              
            ],
            400
        );
        }

        $Sertifikat = Sertifikat::create([          
            "BACKGROUND" => $imageName,
        ]);

        return response(
            [
                "message" => "Add Ceritificate Success",
                "data" => $Sertifikat,
            ],
            200
        );

        return response(
            [
                "message" => "Add Ceritificate Failed",
            ],
            406
        );
    }


    public function getImage($id){
        $Sertifikat = Sertifikat::find($id);
        $path = public_path().'/GambarSertifikat/'.$Sertifikat->BACKGROUND;
        return Response::download($path);   
    }

     public function generate($id){
        $Sertifikat = Sertifikat::find($id);
        $path = public_path().'/GambarSertifikat/'.$Sertifikat->BACKGROUND;

            
        $image = imagecreatefromjpeg($path);

        $color = imagecolorallocate($image, 255, 255, 255);
        $string = 'William Lourensius';
        $fontSize = 14;
        $x = 300;
        $y = 400;

        // write on the image
        imagestring($image, $fontSize, $x, $y, $string, $color);

        // save the image
        $temp=imagejpeg($image, 'Test', $quality = 100);
        return Response::download('Test');   
    }


    public function getAll()
    {
        $Sertifikat = Sertifikat::all();

        if (!is_null($Sertifikat)) {
            return response(
                [
                    "message" => "Retrieve All Ceritificate Success",
                    "data" => $Sertifikat,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Ceritificate Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Sertifikat = Sertifikat::where("ID_EVENT", "=", $id)->first();

        if (!is_null($Sertifikat)) {
            return response(
                [
                    "message" => "Retrieve All Ceritificate Success",
                    "data" => $Sertifikat,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Ceritificate Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function update(Request $request, $id)
    {
        $Sertifikat = Sertifikat::find($id);
        $gambar = $Sertifikat->BACKGROUND;
        if (is_null($Sertifikat)) {
            return response(
                [
                    "message" => "Certificate Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();       
        $validate = Validator::make($updateData, [             
            "background" => "required|image|mimes:jpeg,png,jpg|max:1048",
        ]);
       
        

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("background")) {
            $imageName =
                time() . "Sertifikat" . "." . $request->background->extension();
            $request->background->move(public_path("GambarSertifikat"), $imageName);
        }else{
            return response(
            [
                "message" => "Image must be field",              
            ],
            400
        );
        }

        
        $Sertifikat->BACKGROUND = $imageName;

        if ($Sertifikat->save()) {
            if ($gambar != null && $files = $request->file("background")) {
                File::delete(public_path() . "/GambarSertifikat/" . $gambar);
            }
            return response(
                [
                    "message" => "Update Certificate Success",
                    "data" => $Sertifikat,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Certificate Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $Sertifikat = Sertifikat::find($id);
        if (is_null($Sertifikat)) {
            return response(
                [
                    "message" => "Ceritificate Not Found",
                    "data" => null,
                ],
                404
            );
        }

        if ($Sertifikat->delete()) {
            return response(
                [
                    "message" => "Delete Ceritificate Success",
                    "data" => $Sertifikat,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete Ceritificate Failed",
                "data" => null,
            ],
            400
        );
    }
}
