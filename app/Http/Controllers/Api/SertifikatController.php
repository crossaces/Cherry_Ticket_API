<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Carbon\Carbon;
use GDText\Box;
use GDText\Color;
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
            "red" => "required",   
            "blue" => "required",   
            "green" => "required", 
            "font_size" => "required",     
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
            "RED" => $storeData["red"],
            "BLUE" => $storeData["blue"],
            "GREEN" => $storeData["green"],
            "FONT_SIZE" => $storeData["font_size"],
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

     public function generate($id,$nama){
        $Sertifikat = Sertifikat::find($id);
        $path = public_path().'/GambarSertifikat/'.$Sertifikat->BACKGROUND;

        $im = imagecreatefromjpeg($path);
        $font_family = public_path('/fonts/Roboto-Regular.ttf');
        $box = new Box($im);
        $box->setFontFace($font_family);
        $box->setFontColor(new Color($Sertifikat->RED, $Sertifikat->BLUE, $Sertifikat->GREEN));
        $box->setFontSize($Sertifikat->FONT_SIZE);
        $box->setBox(
            $Sertifikat->X,
            $Sertifikat->Y,
            imagesx($im),
            imagesy($im)
        );
        $box->setTextAlign('center','center');
        $box->draw($nama);
        header("content-type: image/jpeg");
        imagejpeg($im,$filename='Sertifikat'.$id.'.jpeg',$quality = 500);
        


        // $image = imagecreatefromjpeg($path);

        // $color = imagecolorallocate($image, 0, 0, 0);
        // $string = 'William Lourensius';
        // $fontSize = 2000;
        // $x = 300;
        // $y = 400;

        // // write on the image
        // imagestring($image, $fontSize, $x, $y, $string, $color);
        
        // // save the image
        // imagejpeg($image, 'Test.jpeg', $quality = 200);
        return Response::download(public_path().'/Sertifikat'.$id.'.jpeg');   
    }



     public function generateEO($id,$nama){
        $Sertifikat = Sertifikat::find($id);
        $path = public_path().'/GambarSertifikat/'.$Sertifikat->BACKGROUND;

        $im = imagecreatefromjpeg($path);
        $font_family = public_path('/fonts/Roboto-Regular.ttf');
        $box = new Box($im);
        $box->setFontFace($font_family);
        $box->setFontColor(new Color($Sertifikat->RED, $Sertifikat->BLUE, $Sertifikat->GREEN));
        $box->setFontSize($Sertifikat->FONT_SIZE);
        $box->setBox(
            $Sertifikat->X,
            $Sertifikat->Y,
            imagesx($im),
            imagesy($im)
        );
        $box->setTextAlign('center','center');
        $box->draw($nama);
        header("content-type: image/jpeg");
        imagejpeg($im,$filename='Sertifikat'.$id.'.jpeg',$quality = 500);      
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
        if ($files = $request->file("background")) {
            $validate = Validator::make($updateData, [
                "background" => "required|image|mimes:jpeg,png,jpg|max:1048",
                "red" => "required",   
                "blue" => "required",   
                "green" => "required", 
                "font_size" => "required",     
                "x" => "required", 
                "y" => "required",     
            ]);
        }
        else{
             $validate = Validator::make($updateData, [
                "red" => "required",   
                "blue" => "required",   
                "green" => "required", 
                "font_size" => "required",    
                "x" => "required", 
                "y" => "required",              
            ]);
        }
       
        

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("background")) {
            $imageName =
                time() . "Sertifikat" . "." . $request->background->extension();
            $request->background->move(public_path("GambarSertifikat"), $imageName);
        }else{
            $imageName = $gambar;
        }

        
        $Sertifikat->BACKGROUND = $imageName;
        $Sertifikat->RED = $updateData['red'];
        $Sertifikat->BLUE = $updateData['blue'];
        $Sertifikat->GREEN = $updateData['green'];
        $Sertifikat->FONT_SIZE = $updateData['font_size'];
        $Sertifikat->X = $updateData['x'];
        $Sertifikat->Y = $updateData['y'];

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
