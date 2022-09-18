<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EO;
use App\Models\Peserta;
use App\Models\Kota;
use App\Models\Event;
use App\Models\Check;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response, File;

class CustomController extends Controller
{
    //te
    public function getData(Request $request)
    {
        $data['eo']= EO::count();
        $data['peserta']= Peserta::count();
        $data['kota']= Kota::count();
        $data['event']= Event::count();      
        if (!is_null($data)) {
            return response( 
                [
                    "message" => "Retrieve All Success",
                    "data" => $data,
                ],
                200 
            );
        }
        return response(
            [
                "data" => null,
            ],
            404
        );
    }

    public function getDashboard(Request $request, $id)
    {   
        $tempactive=Event::all()->where("EVENT_TAB", "=", "Active")->where("ID_EO", "=", $id);
        $data['event_active']= count($tempactive);       
        $tempdraft=Event::all()->where("EVENT_TAB", "=", "Draft")->where("ID_EO", "=", $id);
        $data['event_draft']= count($tempdraft);
        $temptransaksi = DB::table('transaksi')
                                ->join('event', 'transaksi.ID_EVENT', '=', 'event.ID_EVENT')
                                ->join('eo', 'eo.ID_EO', '=', 'event.ID_EO')
                                ->get();
        $data['total_transaksi']=count($temptransaksi);
      
        if (!is_null($data)) {
            return response( 
                [
                    "message" => "Retrieve All Success",
                    "data" => $data,
                ],
                200 
            );
        }
        return response(
            [
                "data" => null,
            ],
            404
        );
    }

    //
    public function checkin(Request $request)
    {

        $storeData = $request->all();
        $validate = Validator::make($storeData, [                            
            "id_peserta" => "required",     
            "id_pendaftaran" => "required",     
        ]);

        
        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }
       
        $check = Check::where('TGL_CHECK','=',date("Y-m-d"))->where('STATUS_CHECK','=','Check-In')->where('ID_PENDAFTARAN','=',$storeData["id_pendaftaran"])->get();

        if (count($check)>0) {
            return response( 
                [
                    "message" => "Participant Already Check-In",
                    "data" => $check,
                ],
                400 
            );
        }else{
            $Checkin = Check::create([
                "ID_PENDAFTARAN" => $storeData["id_pendaftaran"],
                "ID_PESERTA" => $storeData["id_peserta"],      
                "TGL_CHECK" => date("Y-m-d"),          
                "STATUS_CHECK" => "Check-In"
            ]);
            return response(
                [
                    "message" => "Check-In Successfully",
                    "data" => $Checkin,
                ],
                200
            );
        }


        return response(
            [
                "message" => "Check-In Failed",
                "data" => null,
            ],
            400
        );
       
    }


    public function checkout(Request $request)
    {

        $storeData = $request->all();
        $validate = Validator::make($storeData, [                            
            "id_peserta" => "required",     
            "id_pendaftaran" => "required",     
        ]);

        
        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }
       
        $check = Check::where('TGL_CHECK','=',date("Y-m-d"))->where('STATUS_CHECK','=','Check-Out')->where('ID_PENDAFTARAN','=',$storeData["id_pendaftaran"])->get();

        if (count($check)>0) {
            return response( 
                [
                    "message" => "Participant Already Check-Out",
                    "data" => $check,
                ],
                400 
            );
        }else{
            $Checkout = Check::create([
                "ID_PENDAFTARAN" => $storeData["id_pendaftaran"],
                "ID_PESERTA" => $storeData["id_peserta"],      
                "TGL_CHECK" => date("Y-m-d"),          
                "STATUS_CHECK" => "Check-Out"
            ]);
            return response(
                [
                    "message" => "Check-Out Successfully",
                    "data" => $Checkout,
                ],
                200
            );
        }


        return response(
            [
                "message" => "Check-In Failed",
                "data" => null,
            ],
            400
        );
       
    }
}
