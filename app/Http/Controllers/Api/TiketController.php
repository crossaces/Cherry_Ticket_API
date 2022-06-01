<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Event;
use Validator;

class TiketController extends Controller
{
    //
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "nama_tiket" => "required|unique:tiket,NAMA_TIKET,NULL,NULL,deleted_at,NULL,ID_EVENT,". $storeData['id_event'] ,
            "fasilitas" => "required",
            "id_event" => "required",
            "tgl_mulai" => "required|date_format:Y-m-d",
            "tgl_selesai" => "required|date_format:Y-m-d",
            "harga" => "required",
            "stok" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Ticket = Tiket::create([
            "NAMA_TIKET" => $storeData["nama_tiket"],
            "FASILITAS" => $storeData["fasilitas"],
            "ID_EVENT" => $storeData["id_event"],
            "HARGA" => $storeData["harga"],
            "STOK" => $storeData["stok"],
            "TGL_MULAI_PENJUALAN" => $storeData["tgl_mulai"],
            "TGL_SELESAI_PENJUALAN" => $storeData["tgl_selesai"],
        ]);


        $Event = Event::find($storeData["id_event"]);
        $Event->TOTAL_TIKET_BEREDAR += $storeData["stok"];
        $Event->save();
        return response(
            [
                "message" => "Add Ticket Event Success",
                "data" => $Ticket,
            ],
            200
        );

        return response(
            [
                "message" => "Add Ticket Event Failed",
            ],
            406
        );
    }

    public function getAll($id)
    {
        $Ticket = Tiket::all()
            ->where("TGL_MULAI", "<=", date("Y-m-d"))
            ->where("TGL_SELESAI", ">=", date("Y-m-d")->where("ID_EVENT", $id));

        if (!is_null($Ticket)) {
            return response(
                [
                    "message" => "Retrieve All Ticket Event Success",
                    "data" => $Ticket,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Ticket Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Ticket = Tiket::find($id);

        if (!is_null($Ticket)) {
            return response(
                [
                    "message" => "Retrieve All Ticket Event Success",
                    "data" => $Ticket,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Ticket Event Not Found",
                "data" => null,
            ],
            404
        );
    }

        public function update(Request $request, $id)
        {
            $Ticket = Tiket::find($id);
            if (is_null($Ticket)) {
                return response(
                    [
                        "message" => "Ticket Event Not Found",
                        "data" => null,
                    ],
                    404
                );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "id_event" => "required",
            "nama_tiket" => "required|unique:tiket,NAMA_TIKET," . $id .",ID_TIKET,deleted_at,NULL,ID_EVENT,". $updateData['id_event'] ,  
            "fasilitas" => "required",          
            "tgl_mulai" => "required|date_format:Y-m-d",
            "tgl_selesai" => "required|date_format:Y-m-d",
            "harga" => "required",
            "stok" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Event = Event::find($updateData["id_event"]);
        
        if($Ticket['STOK']>$updateData["stok"])
        {
            $temp =$Ticket['STOK'] - $updateData['stok'];
            $Event->TOTAL_TIKET_BEREDAR -= $temp;
        }
        else{
            $temp = $updateData['stok'] - $Ticket['STOK'];
            $Event->TOTAL_TIKET_BEREDAR += $temp;   
        }
         
        $Event->save();

        $Ticket->NAMA_TIKET = $updateData["nama_tiket"];
        $Ticket->FASILITAS = $updateData["fasilitas"];       
        $Ticket->HARGA = $updateData["harga"];
        $Ticket->STOK = $updateData["stok"];
        $Ticket->TGL_MULAI_PENJUALAN = $updateData["tgl_mulai"];
        $Ticket->TGL_SELESAI_PENJUALAN = $updateData["tgl_selesai"];

        if ($Ticket->save()) {
            return response(
                [
                    "message" => "Update Ticket Event Success",
                    "data" => $Ticket,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Update Ticket Event Failed",
                "data" => null,
            ],
            400
        );
    }

    public function destroy($id)
    {
        $Ticket = Tiket::find($id);
        if (is_null($Ticket)) {
            return response(
                [
                    "message" => "Ticket Event Not Found",
                    "data" => null,
                ],
                404
            );
        }


        $Event = Event::find($Ticket["ID_EVENT"]);
        $Event->TOTAL_TIKET_BEREDAR -= $Ticket["STOK"];
        $Event->save();

        if ($Ticket->delete()) {
            return response(
                [
                    "message" => "Delete Ticket Event Success",
                    "data" => $Ticket,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete Ticket Event Failed",
                "data" => null,
            ],
            400
        );
    }
}
