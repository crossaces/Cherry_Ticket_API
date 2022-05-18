<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\KotaController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\JenisAcaraController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\CustomController;
use App\Http\Controllers\VerificationApiController;
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

Route::group(["middleware" => "auth:api"], function () {
    //All User Function
    Route::controller(AuthController::class)->group(function () {
        Route::put("changepass/{id}", "changePassword"); //change password id use ID_USER
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
        Route::post("eorganizer/{id}", "updateEventOrganizer"); //edit event organizer id use ID_USER
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
        Route::get("genre/{id}", "get"); //
        Route::put("genre/{id}", "update"); //
        Route::delete("genre/{id}", "destroy"); //
    });

    //Jenis Acara Function
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
});
//
Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});
