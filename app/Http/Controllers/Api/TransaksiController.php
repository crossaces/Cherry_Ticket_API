<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Transaksi;
use App\Models\Order;
use App\Models\Tiket;
use App\Models\PendaftaranPeserta;
use Illuminate\Support\Facades\DB;
use Validator;
class TransaksiController extends Controller
{
    //
     public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            "method" => "required",
            "jawaban" => "required",
            "order" => "required",   
            "idpeserta" => "required",              
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        foreach ($storeData['jawaban'] as $data){ 
            $IDEVENT=$data['IDEVENT'];
            $Peserta = Peserta::find($data['IDPESERTA']);
            $Pendaftaran = DB::table("pendaftaran_peserta")                    
                    ->select(
                       "*"
                    )
                    ->where("ID_PESERTA", $data['IDPESERTA'])
                    ->where("ID_EVENT", $data['IDEVENT'])
                    ->first();
            if (is_null($Peserta)) {
                return response(
                    [
                        "message" => "Participant Id ". $data['IDPESERTA'] . " Not Valid  " ,                        
                    ],
                    406
                );
               
            }        
            // if (!is_null($Pendaftaran)) {
            //     return response(
            //         [
            //             "message" => "Participant Id ". $data['IDPESERTA'] . " Already Buy Ticket " ,                                         
            //         ],
            //         406
            //     );
            
            // }            
        }
        $date = date("Y-m-d H:i:s");
        $total=0;
        $Form = DB::table("form_pendaftaran")                    
                    ->select(
                       "*"
                    )                    
                    ->where("ID_EVENT", $IDEVENT)
                    ->first();
                 
       
        foreach ($storeData['order'] as $data){ 
            $total+=$data['SUBTOTAL'];             
        }
        
        $Transaksi=Transaksi::create([
                "TGL_TRANSAKSI" => $date,
                "STATUS_TRANSAKSI" => "Pending",
                "METODE_PEMBAYARAN" => $storeData['method'],
                "ID_PESERTA" => $storeData['idpeserta'],
                "ID_EVENT" => $IDEVENT,
                "TOTAL_HARGA" => $total,
                ]);
       
        foreach ($storeData['order'] as $data){ 
           $order=Order::create([
                "JUMLAH" => $data['JUMLAH'],
                "SUBTOTAL" => $data['SUBTOTAL'],
                "ID_TIKET" => $data['ID_TIKET'],
                "ID_TRANSAKSI" => $Transaksi->ID_TRANSAKSI,
            ]);             

            $Ticket=Tiket::find($data['ID_TIKET']);                
            $Ticket->STOK-= $data['JUMLAH'];
            $Ticket->save();
            
            
              foreach ($storeData['jawaban'] as $datajawaban){                       
                if($data['ID_TIKET'] == $datajawaban['IDTIKET']){                    
                    PendaftaranPeserta::create([
                        "DATA_PERTANYAAN" =>json_encode($datajawaban['JAWABAN']),
                        "ID_ORDER" => $order->ID_ORDER,
                        "ID_PESERTA" =>  $datajawaban['IDPESERTA'],
                        "ID_EVENT" =>  $IDEVENT,
                        "ID_TIKET" => $datajawaban['IDTIKET'],
                        "STATUS_PENDAFTARAN" => "Pending",
                        "ID_FORM_PENDAFTARAN" => $Form->ID_FORM_PENDAFTARAN,
                    ]);
                }                                      
            }
        }

        
        return response(
            [
                "message" => "Create Transaction Success",            
                "data" => $Transaksi,    
            ],
            200
        );

    }

    public function uploadTransaksi(Request $request, $id)
    {
        $Transaksi = Transaksi::find($id);
        $gambar = $Transaksi->GAMBAR;
        if (is_null($Transaksi)) {
            return response(
                [
                    "message" => "Transaksi Organizer Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "gambar" => "required|image|mimes:jpeg,png,jpg",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar")) {
            $imageName = time() . "Transaksi" . "." . $request->gambar->extension();
            $request->gambar->move(public_path("GambarTransaksi"), $imageName);
        }

        $Transaksi->BUKTI_PEMBAYARAN = $imageName;

        if ($Transaksi->save()) {
            if ($gambar != null) {
                File::delete(public_path() . "/GambarTransaksi/" . $gambar);
            }
            return response(
                [
                    "message" => "Upload Picture Successfull",
                    "data" => $Transaksi,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Upload Picture Failed",
                "data" => null,
            ],
            400
        );
    }

    public function getDataTransaksiPeserta($id)
    {
        $Transaksi = Transaksi::with('order.tiket','event.jenisacara','event.genre','event.kota','event.tiket')->where("ID_PESERTA", "=", $id)->orderBy('ID_TRANSAKSI', 'DESC')->get();    
        if (!is_null($Transaksi)) {
            return response(
                [
                    "message" => "Retrieve All Transaksi Success",
                    "data" => $Transaksi,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Transaksi Not Found",
                "data" => null,
            ],
            404
        );
    }

}
