<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KotaController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\JenisAcaraController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EvaluasiController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\FormPendaftaranController;
use App\Http\Controllers\Api\FormEvaluasiController;
use App\Http\Controllers\Api\QnaController;
use App\Http\Controllers\Api\PendaftaranPesertaController;
use App\Http\Controllers\Api\TiketController;
use App\Http\Controllers\Api\CustomController;
use App\Http\Controllers\Api\SertifikatController;
use App\Http\Controllers\VerificationApiController;
use App\Http\Controllers\Api\TransaksiController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Ambil Data Table
Route::get("datahome", [CustomController::class,"getData",]); //custom
Route::get("laporanpendaftaran/{id}", [CustomController::class,"laporanpendaftaran",]); //laporanpendaftaran
Route::get("laporanevaluasi/{id}", [CustomController::class,"laporanevaluasi",]); //laporanevaluasi
Route::get("laporancheck/{id}", [CustomController::class,"laporancheck",]); //laporacheckincheckout
Route::get("laporantransaksi/{id}", [CustomController::class,"laporantransaksi",]); //laporacheckincheckout
Route::get("test/{id}", [CustomController::class,"test",]); //custom

//Password Reset
Route::post("password/email", [ForgotPasswordController::class,"sendResetLinkEmail",]); //sendforgotpassword
Route::post("password/reset", [ResetPasswordController::class, "reset"]); //resetpassword

//Email
Route::get("email/verify/{id}", [VerificationApiController::class,"verify", ])->name("verificationapi.verify");//Email Verification
Route::post("email/resend", [VerificationApiController::class, "resend"])->name("verificationapi.resend");//Resend Email Verification

//Register
Route::controller(AuthController::class)->group(function () {
    Route::post("pregister", "RegistrationPeserta"); //register peserta
    Route::post("eoregister", "RegistrationEventOrganizer"); //register event organizer
    Route::post("login", "login"); //register event organizer
});

 Route::controller(SertifikatController::class)->group(function () {
        Route::get("generate/{id}/{nama}", "generate"); //       
         Route::get("generateEO/{id}/{nama}", "generateEO"); // 
 });


Route::group(["middleware" => "auth:api"], function () {
    //All User Function
    Route::controller(AuthController::class)->group(function () {
        Route::put("changepass/{id}", "changePassword"); //change password id use ID_USER
    });
    
    //CheckIn and Out
     Route::controller(CustomController::class)->group(function () {
        Route::post("event/in", "checkin"); //
        Route::post("event/out", "checkout"); //
        Route::get("dashboard/{id}", "getDashboard"); //
        Route::get("profilevent/{id}", "getProfile");      
    });
     

    //Admin Function
    Route::controller(AuthController::class)->group(function () {
        Route::get("getuser/{id}", "getwithUser"); //createAdmin
        Route::post("admin", "CreateAdmin"); //createAdmin
        Route::put("admin/{id}", "updateAdmin"); //editadmin use ID_USER
        Route::get("admin", "getAllAdmin"); //getAllAdmin
        Route::get("admin/{id}", "getAdmin"); //getAdmin use ID_ADMIN
        Route::put("admin/status/{id}", "updateStatusAdmin"); //getAdmin use ID_ADMIN
    });
    

    //Event Organizer Function
    Route::controller(AuthController::class)->group(function () {
        Route::put("eorganizer/{id}", "updateEventOrganizer"); //edit event organizer id use ID_USER
        Route::post("eogambar/{id}", "updateGambarEO"); //edit event organizer id use ID_EO
        Route::get("eorganizer/{id}", "getEO"); //getEO use ID_EO
        Route::get("eorganizer", "getAllEO"); //getAllEO        
        Route::get("eorganizerimage/{id}", "getImageEO");//ID_EO
        Route::put("eorganizer/status/{id}", "updateStatusEO"); //getAdmin use ID_EO
    });

    //Peserta Function
    Route::controller(AuthController::class)->group(function () {
        Route::put("peserta/{id}", "updatePeserta"); //editadmin use ID_USER
        Route::post("pgambar/{id}", "updateGambarPeserta"); //edit peserta id use ID_Peserta
        Route::put("ptoken/{id}", "updateTokenPeserta"); //edit peserta id use ID_Peserta
        Route::get("peserta/{id}", "getPeserta"); //getEO use ID_Peserta
        Route::get("pesertaimage/{id}", "getImagePeserta");//ID_PESERTA
    });

    //Berita Function
    Route::controller(BeritaController::class)->group(function () {
        Route::post("berita", "store"); //
        Route::get("berita", "getAll"); //
        Route::get("beritaadmin", "getAllAdmin"); //
        Route::get("berita/{id}", "get"); //
        Route::post("berita/{id}", "update"); //
        Route::delete("berita/{id}", "destroy"); //
    });

      //Genre Fuction
    Route::controller(GenreController::class)->group(function () {
        Route::post("genre", "store"); //
        Route::get("genre", "getAll"); //
        Route::get("genremobile", "getAllMobile"); //
        Route::get("genre/{id}", "get"); //
        Route::post("genre/{id}", "update"); //
        Route::delete("genre/{id}", "destroy"); //
    });

    //Jenis Acara Function
    Route::controller(QnaController::class)->group(function () {
        Route::post("qna", "store"); //
        Route::get("qna", "getAll"); //
        Route::get("qna/{id}", "get"); //
        Route::get("qnaevent/{id}", "getAllEvent"); //
        Route::put("qna/{id}", "update"); //
        Route::put("qnastatus/{id}", "updateStatus"); //
        Route::delete("jenisacara/{id}", "destroy"); //
    });

    Route::controller(JenisAcaraController::class)->group(function () {
        Route::post("jenisacara", "store"); //
        Route::get("jenisacara", "getAll"); //
        Route::get("jenisacara/{id}", "get"); //
        Route::get("jenisacaraimage/{id}", "getImage"); //
        Route::post("jenisacara/{id}", "update"); //
        Route::delete("jenisacara/{id}", "destroy"); //
    });

    //Kota Function
    Route::controller(KotaController::class)->group(function () {
        Route::post("kota", "store"); //
        Route::get("kota", "getAll"); //
        Route::get("kota/{id}", "get"); //
        Route::get("kotaimage/{id}", "getImage"); //
        Route::post("kota/{id}", "update"); //
        Route::delete("kota/{id}", "destroy"); //
    });

    Route::controller(TiketController::class)->group(function () {
        Route::post("ticket", "store"); //
        Route::get("ticket", "getAll"); //
        Route::get("ticket/{id}", "get"); //
        Route::get("ticketimage/{id}", "getImage"); //
        Route::put("ticket/{id}", "update"); //
        Route::delete("ticket/{id}", "destroy"); //
    });


    Route::controller(EventController::class)->group(function () {
        Route::post("event", "store"); //
        Route::get("event", "getAll"); //getALL
        Route::get("eventEO/{id}", "getAllEventEO"); //
        Route::get("event/{id}", "get"); //        
        Route::put("eventstatus/{id}", "updateStatus"); //
        Route::get("fcm/{id}", "getFCMToken"); //getFCMTOKEN
        Route::put("eventtoken/{id}", "updateToken"); //
        Route::post("event/{id}", "update"); //    
        Route::put("eventtab/{id}", "updateTab"); //
        Route::put("eventreject/{id}", "updateTabReject"); //
        Route::put("eventtoken/{id}", "updateToken"); //
        Route::delete("event/{id}", "destroy"); //
    });


    Route::controller(FormPendaftaranController::class)->group(function () {
      
        Route::put("fpendaftaran/{id}", "update");
        Route::get("fpendaftaran/{id}", "get");//id_event
    });


    Route::controller(FormEvaluasiController::class)->group(function () {
      
        Route::put("fevaluasi/{id}", "update");
        Route::get("fevaluasi/{id}", "get");//id_event
    });


    Route::controller(PendaftaranPesertaController::class)->group(function () {      
        Route::put("pendaftaranupdate/{id}", "update");     
        Route::get("pendaftaranp/{id}", "getDataPendaftaranPeserta");//getDataPendaftaranPeserta
        Route::get("pendaftarane/{id}", "getDataPendaftaranEvent"); //getDataPendaftaranEvent                          
    });


    Route::controller(EvaluasiController::class)->group(function () {      
        Route::post("evaluasi", "store");     
        Route::get("evaluasip/{id}", "getDataEvaluasiPeserta");//getDataEvaluasiPeserta
        Route::get("evaluasie/{id}", "getDataEvaluasiEvent"); //getDataEvaluasiEvent                          
    });

    Route::controller(TransaksiController::class)->group(function () {    
        Route::post("transaksi", "store"); //createTransaksi
        Route::post("uploadt/{id}", "uploadTransaksi"); //upload gambar untuk transaksi
        Route::get("pesertat/{id}", "getDataTransaksiPeserta");//getDataTransaksiPeserta
        Route::get("transaksievent/{id}", "getDataTransaksiEvent"); //getDataTransaksiEvent
        Route::put("changest/{id}", "changeStatusTransaksi"); //createTransaksi                   
    });

    //Seritifkat
    Route::controller(SertifikatController::class)->group(function () {
        Route::post("sertifikat", "store"); //
        Route::get("sertifikat", "getAll"); //
        Route::get("sertifikat/{id}", "get"); //    
        Route::get("sertifikatimage/{id}", "getImage"); //
        Route::post("sertifikat/{id}", "update"); //
        Route::delete("sertifikat/{id}", "destroy"); //
    });
});



//
Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});
