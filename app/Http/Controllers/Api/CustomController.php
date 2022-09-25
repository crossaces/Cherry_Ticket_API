<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EO;
use App\Models\Peserta;
use App\Models\Kota;
use App\Models\Event;
use App\Models\User;
use App\Models\Check;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response, File;
use Excel;
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
    //
    public function getDashboard(Request $request, $id)
    {   
        
        $data['event_active']= count(Event::all()->where("EVENT_TAB", "=", "Active")->where("ID_EO", "=", $id));           
        $data['event_draft']= count(Event::all()->where("EVENT_TAB", "=", "Draft")->where("ID_EO", "=", $id));    
        $data['total_transaksi']=count(DB::table('transaksi')
                                ->join('event', 'transaksi.ID_EVENT', '=', 'event.ID_EVENT')
                                ->join('eo', 'eo.ID_EO', '=', 'event.ID_EO')
                                ->where("eo.ID_EO", "=", $id)
                                ->get());

         $data['tiket_terjual'] = DB::table('order')                              
                                ->join('tiket', 'tiket.ID_TIKET', '=', 'order.ID_TIKET')
                                ->join('event', 'tiket.ID_EVENT', '=', 'event.ID_EVENT')                                
                                ->join('eo', 'eo.ID_EO', '=', 'event.ID_EO')
                                ->where("eo.ID_EO", "=", $id)
                                ->sum('order.JUMLAH');
        
        $data['total_income']= DB::table('transaksi')
                                ->join('event', 'transaksi.ID_EVENT', '=', 'event.ID_EVENT')
                                ->join('eo', 'eo.ID_EO', '=', 'event.ID_EO')
                                ->where("eo.ID_EO", "=", $id)
                                ->sum('transaksi.TOTAL_HARGA');

        $data['total_visitor']=count(DB::table('pendaftaran_peserta')
                                ->join('event', 'pendaftaran_peserta.ID_EVENT', '=', 'event.ID_EVENT')
                                ->join('eo', 'eo.ID_EO', '=', 'event.ID_EO')
                                ->where("eo.ID_EO", "=", $id)
                                ->get());         
                                
                                
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


    public function getProfile(Request $request, $id)
    {   
        $data['total_income']= DB::table('transaksi')
                                ->join('event', 'transaksi.ID_EVENT', '=', 'event.ID_EVENT')                                
                                ->where("event.ID_EVENT", "=", $id)
                                ->sum('transaksi.TOTAL_HARGA');    
                                
        $data['tiket_tersisa'] = DB::table('tiket')                                                                
                                ->join('event', 'tiket.ID_EVENT', '=', 'event.ID_EVENT')                                                                
                                ->where("event.ID_EVENT", "=", $id)
                                ->sum('tiket.STOK');
           //
        $data['total_transaksi']=count(DB::table('transaksi')                                                            
                                ->where("ID_EVENT", "=", $id)
                                ->get());         
                                
        $data['total_visitor']=count(DB::table('pendaftaran_peserta')
                                ->join('event', 'pendaftaran_peserta.ID_EVENT', '=', 'event.ID_EVENT')                               
                                ->where("event.ID_EVENT", "=", $id)
                                ->get());         
                                
                                
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

    public function xlsx()
    {
 
        $users = User::all();
 
        // Generate and return the spreadsheet
        Excel::create('users', function ($excel) use ($users) {
 
            // Build the spreadsheet, passing in the users array
            $excel->sheet('sheet1', function ($sheet) use ($users) {
                $sheet->fromArray($users);
            });
 
        })->download('xlsx');
    }
}
