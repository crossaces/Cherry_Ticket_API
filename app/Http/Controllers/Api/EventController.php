<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\FormPendaftaran;
use App\Models\FormEvaluasi;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response, File;
use Illuminate\Support\Str;

class EventController extends Controller
{
    //



    public function store(Request $request)
    {
        $storeData = $request->all();     
        

        $validate = Validator::make($storeData, [        
            "id_eo" => "required",     
            "with_evaluasi" => "required",     
            "qna" => "required",     
            "with_sertifikat" => "required",     
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

       
        $Event = Event::create([
            "EVENT_TAB" => "Draft",
            "QRCODE" => Str::random(25),
            "TOKEN" => Str::random(6),
            "QNA" => $storeData['qna'],
            "SERTIFIKAT" => $storeData['with_sertifikat'],
            "EVALUASI" => $storeData['with_evaluasi'],
            "ID_EO" => $storeData['id_eo']
        ]);

        
      
        $FormEvaluasi = FormEvaluasi::create([
            "ID_EVENT" => $Event['ID_EVENT']        
        ]);
        

       
        $Seritfikat = Sertifikat::create([
            "ID_EVENT" => $Event['ID_EVENT']        
        ]);
        
      

        $FormPendaftaran = FormPendaftaran::create([
            "ID_EVENT" => $Event['ID_EVENT']        
        ]);

        return response(
            [
                "message" => "Add Event Success",
                "data" => $Event,
            ],
            200
        );

        return response(
            [
                "message" => "Add Event Failed",
            ],
            406
        );
    }
  
    public function getAll()
    {
        $Event['Draft'] = Event::with('tiket','jenisacara','kota','genre')->where("EVENT_TAB","=","Publish")->get();
        $Event['Active'] = Event::with('tiket','jenisacara','kota','genre','eo.user')->where("EVENT_TAB", "=", "Active")->get();
        $Event['Over'] = Event::with('tiket','jenisacara','kota','genre')->where("EVENT_TAB", "=", "Over")->get();
        if (!is_null($Event)) {
            return response(
                [
                    "message" => "Retrieve All Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Event Not Found",
                "data" => null,
            ],
            404
        );
    }


    public function getFCMToken($id)
    {
        $Token =DB::table("pendaftaran_peserta")
                ->join('peserta', 'peserta.ID_PESERTA', '=', 'pendaftaran_peserta.ID_PESERTA')                        
                ->select(
                    "TOKEN",                   
                )->where('pendaftaran_peserta.ID_EVENT',$id)->pluck('TOKEN');
        
        
        if (!is_null($Token)) {
            return response(
                [
                    "message" => "Retrieve All Token Success",
                    "data" => $Token,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Token Not Found",
                "data" => null,
            ],
            404
        );
    }



    public function getAllEventEO($id)
    {
        $Event['Draft'] = Event::with('tiket','jenisacara','kota','genre')->where("EVENT_TAB", "=", "Draft")->where("ID_EO", "=", $id)->orWhere("EVENT_TAB","=","Publish")->where("ID_EO", "=", $id)->orWhere("EVENT_TAB","=","Rejected")->where("ID_EO", "=", $id)->get();
        $Event['Active'] = Event::with('tiket','jenisacara','kota','genre','eo')->where("EVENT_TAB", "=", "Active")->where("ID_EO", "=", $id)->get();
        $Event['Over'] = Event::with('tiket','jenisacara','kota','genre')->where("EVENT_TAB", "=", "Over")->where("ID_EO", "=", $id)->get();
        if (!is_null($Event)) {
            return response(
                [
                    "message" => "Retrieve All Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Event = Event::with('tiket','jenisacara','kota','genre')->where("ID_EVENT", "=", $id)->first();

        if (!is_null($Event)) {
            return response(
                [
                    "message" => "Retrieve All Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Event Not Found",
                "data" => null,
            ],
            404
        );
    }


    public function update(Request $request, $id)
    {
        $Event = Event::find($id);
        $gambar = $Event->GAMBAR_EVENT;
        if (is_null($Event)) {
            return response(
                [
                    "message" => "Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
         if ($files = $request->file("gambar_event")) {
            $validate = Validator::make($updateData, [
                "nama_event" => "required",
                "tgl_mulai" => "required|date_format:Y-m-d",
                "tgl_selesai" => "required|date_format:Y-m-d",              
                "tgl_acara_mulai" => "required|date_format:Y-m-d",    
                "waktu_selesai" => "required",
                "waktu_mulai" => "required",             
                "gambar_event" => "required|image|mimes:jpeg,png,jpg|max:1048",
                "mode_event" => "required",
                "visible_event" => "required",
                "nama_lokasi" => "required",                   
                "address" => "nullable",
                "batas_tiket" => "required",        
                "id_kota" => "required",                             
                "id_jenis_acara" => "required",       
                "id_genre" => "required",        
                "with_evaluasi" => "required",     
                "qna" => "required",     
                "with_sertifikat" => "required",                                                      
            ]);
        }
        else{
              $validate = Validator::make($updateData, [
                "nama_event" => "required",
                "tgl_mulai" => "required|date_format:Y-m-d",
                "tgl_selesai" => "required|date_format:Y-m-d",
                "waktu_selesai" => "required",
                "waktu_mulai" => "required",                     
                "tgl_acara_mulai" => "required|date_format:Y-m-d",                            
                "mode_event" => "required",
                "visible_event" => "required",
                "nama_lokasi" => "required",     
                "batas_transaksi" => "required",                              
                "batas_tiket" => "required",                 
                "address" => "nullable",                    
                "id_jenis_acara" => "required",       
                "id_kota" => "required",
                "id_genre" => "required",         
                "with_evaluasi" => "required",     
                "qna" => "required",     
                "with_sertifikat" => "required",                      
            ]);
        }
                

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar_event")) {
            $imageName =
                time() . "Event" . "." . $request->gambar_event->extension();
            $request->gambar_event->move(
                public_path("GambarEvent"),
                $imageName
            );
        }
        else{
            $imageName = $gambar; 
        }

            $Event->NAMA_EVENT = $updateData["nama_event"];
            $Event->TGL_MULAI = $updateData["tgl_mulai"];
            $Event->TGL_SELESAI = $updateData["tgl_selesai"];        
            if($updateData["tgl_acara_selesai"]!="kosong"){
                $Event->TGL_ACARA_SELESAI = $updateData["tgl_acara_selesai"];
            }            
            $Event->TGL_ACARA_MULAI = $updateData["tgl_acara_mulai"];   
            $Event->WAKTU_MULAI = $updateData["waktu_mulai"];
            $Event->WAKTU_SELESAI = $updateData["waktu_selesai"];            
            $Event->MODE_EVENT = $updateData["mode_event"];
            $Event->VISIBLE_EVENT = $updateData["visible_event"];
            $Event->GAMBAR_EVENT = $imageName;
            $Event->NAMA_LOKASI = $updateData["nama_lokasi"];   
            $Event->BATAS_TRANSAKSI = $updateData["batas_transaksi"];   
            $Event->ADDRESS = $updateData["address"];   
            
            if($updateData["deskripsi"]!="kosong"){
               $Event->DESKRIPSI = $updateData["deskripsi"];
            }    

            if($updateData["syarat"]!="kosong"){
                $Event->SYARAT = $updateData["syarat"];     
            } 
    
            $Event->BATAS_TIKET = $updateData["batas_tiket"];  
            $Event->ID_JENIS_ACARA = $updateData["id_jenis_acara"];  
            $Event->ID_KOTA = $updateData["id_kota"];  
            $Event->ID_GENRE = $updateData["id_genre"];         
            $Event->SERTIFIKAT = $updateData["with_sertifikat"]; 
            $Event->QNA = $updateData["qna"]; 
            $Event->EVALUASI = $updateData["with_evaluasi"]; 
            $Event->URL = $updateData["url"];  
            if ($updateData["mode_event"] == "Offline" ||$updateData["mode_event"] == "Hybrid"
            ){
                $Event->LAT = $updateData["lat"];  
                $Event->LNG = $updateData["lng"];  
            }
           

        if ($Event->save()) {
            if ($gambar != null && $files = $request->file("gambar_event")) {
                File::delete(public_path() . "/GambarEvent/" . $gambar);
            }
            return response(
                [
                    "message" => "Update Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Failed",
                "data" => null,
            ],
            400
        );
    }


    public function updateStatus(Request $request, $id)
    {
        $Event = Event::find($id);      
        if (is_null($Event)) {
            return response(
                [
                    "message" => "Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
       
            $validate = Validator::make($updateData, [
                "status_event" => "required",                                    
            ]);
                

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }       

            $Event->STATUS_EVENT = $updateData["status_event"];        
            if($updateData["status_event"]=="Finish")  {
                $Event->EVENT_TAB = "Over";       
            }

        if ($Event->save()) {           
            return response(
                [
                    "message" => "Update Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Failed",
                "data" => null,
            ],
            400
        );
    }

    public function updateTab(Request $request, $id)
    {
        $Event = Event::find($id);      
        if (is_null($Event)) {
            return response(
                [
                    "message" => "Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
       
            $validate = Validator::make($updateData, [
                "event_tab" => "required",                                    
            ]);
                

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }       

            $Event->EVENT_TAB = $updateData["event_tab"];        
            if($updateData['event_tab']=='Publish')  {
              $Event->KOMENTAR = null;
            }

        if ($Event->save()) {           
            return response(
                [
                    "message" => "Update Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Failed",
                "data" => null,
            ],
            400
        );
    }


     public function updateTabReject(Request $request, $id)
    {
        $Event = Event::find($id);      
        if (is_null($Event)) {
            return response(
                [
                    "message" => "Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
       
            $validate = Validator::make($updateData, [
                "event_tab" => "required",  
                "komentar" => "required",                                          
            ]);
                

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }       

            $Event->EVENT_TAB = $updateData["event_tab"];       
            $Event->KOMENTAR = $updateData["komentar"];             

        if ($Event->save()) {           
            return response(
                [
                    "message" => "Update Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Failed",
                "data" => null,
            ],
            400
        );
    }


    public function updateToken(Request $request, $id)
    {
        $Event = Event::find($id);      
        if (is_null($Event)) {
            return response(
                [
                    "message" => "Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
       
        $validate = Validator::make($updateData, [
            "token" => "required|unique:event,TOKEN," . $id .",ID_EVENT,deleted_at,NULL",                            
        ]);
                

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }       

        $Event->TOKEN = $updateData["token"];          

        if ($Event->save()) {           
            return response(
                [
                    "message" => "Update Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $Event = Event::find($id);
        if (is_null($Event)) {
            return response(
                [
                    "message" => "Event Not Found",
                    "data" => null,
                ],
                404
            );
        }

        if ($Event->delete()) {
            return response(
                [
                    "message" => "Delete Event Success",
                    "data" => $Event,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete Event Failed",
                "data" => null,
            ],
            400
        );
    }



}
