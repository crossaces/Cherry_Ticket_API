<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdraw;
use Validator;

class WithdrawController extends Controller
{
    //
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [            
            "jumlah_withdraw" => "required",
            "income_admin" => "required",  
            "total_withdraw" => "required",                           
            "ideo" => "required",
            "method_payment" => "required",                       
            "nomor_transaksi" => "required",
            "nama_tujuan" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Withdraw = Withdraw::create([
            "JUMLAH_WITHDRAW" => $storeData["jumlah_withdraw"],
            "INCOME_ADMIN" => $storeData["income_admin"],
            "ID_EO" => $storeData["ideo"],
            "TGL_WITHDRAW" => date("Y-m-d"),   
            "TOTAL_WITHDRAW" => $storeData["income_admin"],  
            
            "METHOD_PAYMENT" => $storeData["method_payment"],
            "NOMOR_TRANSAKSI" => $storeData["nomor_transaksi"],
            "NAMA_TUJUAN" => $storeData["nama_tujuan"],       
        ]);

           
        return response(
            [
                "message" => "Withdraw Event Success",
                "data" => $Withdraw,
            ],
            200
        );

        return response(
            [
                "message" => "Withdraw Event Failed",
            ],
            406
        );
    }

    public function getAll()
    {
        $Withdraw = Withdraw::with('eo')->where("ID_EO", $id)->get();           
        if (!is_null($Withdraw)) {
            return response(
                [
                    "message" => "Retrieve All Withdraw Event Success",
                    "data" => $Withdraw,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Withdraw Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function get($id)
    {
        $Withdraw = Withdraw::all()->where("ID_EO", $id);

        if (!is_null($Withdraw)) {
            return response(
                [
                    "message" => "Retrieve All Withdraw Event Success",
                    "data" => $Withdraw,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Withdraw Event Not Found",
                "data" => null,
            ],
            404
        );
    }

    public function changeStatusWithdraw(Request $request,$id)
    {
        $Withdraw = Withdraw::find($id);
        if (is_null($Withdraw)) {
            return response(
            [
                "message" => "Withdraw Not Found",
                "data" => null,
            ],
            404
        );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "status" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        $Withdraw->STATUS_WITHDRAW = $updateData["status"];                      

        if ($Withdraw->save()) {          
            return response(
                [
                    "message" => "Update Withdraw Successfully",
                    "data" => $Temp,
                ],
                200
            );
        }
        
        return response(
            [
                "message" => "Update Withdraw Failed",
                "data" => null,
            ],
            400
        );
     
    }

    public function destroy($id)
    {
        $Withdraw = Withdraw::find($id);
        if (is_null($Withdraw)) {
            return response(
                [
                    "message" => "Withdraw Event Not Found",
                    "data" => null,
                ],
                404
            );
        }


        $Event = Event::find($Withdraw["ID_EVENT"]);
        $Event->TOTAL_TIKET_BEREDAR -= $Withdraw["STOK"];
        $Event->save();

        if ($Withdraw->delete()) {
            return response(
                [
                    "message" => "Delete Withdraw Event Success",
                    "data" => $Withdraw,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Delete Withdraw Event Failed",
                "data" => null,
            ],
            400
        );
    }
}
