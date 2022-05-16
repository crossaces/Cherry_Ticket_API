<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\EO;
use App\Models\Admin;
use Auth;
use App\Models\Peserta;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response, File;

class AuthController extends Controller
{
    //Evebt Organizer
    public function RegistrationEventOrganizer(Request $request)
    {
        $register = $request->all();

        if ($register["role"] == "EO") {
            $validate = Validator::make($register, [
                "nama_eo" => "required",
                "email" => "required|email|unique:users",
                "password" => "required|min:8",
                "cpassword" => "required",
                "no_hp" =>
                    "required|digits_between:10,13|numeric|starts_with:08",
                "role" => "required",
            ]);

            if ($validate->fails()) {
                return response(["message" => $validate->errors()], 400);
            }

            if ($register["password"] == $register["cpassword"]) {
                $register["password"] = Hash::make($request->password);
                $User = User::create([
                    "email" => $register["email"],
                    "password" => $register["password"],
                    "no_hp" => $register["no_hp"],
                    "role" => $register["role"],
                ]);
                $User->sendApiEmailVerificationNotification();
                $EO = EO::create([
                    "ID_USER" => $User["id"],
                    "NAMA_EO" => $register["nama_eo"],
                ]);

                return response(
                    [
                        "message" => "Registered Successfully",
                        "user" => $User,
                        "eo" => $EO,
                    ],
                    200
                );
            } else {
                return response(
                    [
                        "message" =>
                            "The password and confirmation password do not match.",
                    ],
                    401
                );
            }

            return response(
                [
                    "message" => "Registered Failed",
                ],
                406
            );
        }
    }

    public function RegistrationPeserta(Request $request)
    {
        $register = $request->all();
        if ($register["role"] == "Peserta") {
            $validate = Validator::make($register, [
                "email" => "required|email|unique:users",
                "password" => "required|min:8",
                "no_hp" =>
                    "required|digits_between:10,13|numeric|starts_with:08",
                "role" => "required",
            ]);

            if ($validate->fails()) {
                return response(["message" => $validate->errors()], 400);
            }

            $register["password"] = Hash::make($request->password);
            $User = User::create([
                "email" => $register["email"],
                "password" => $register["password"],
                "no_hp" => $register["no_hp"],
                "role" => $register["role"],
            ]);
            $User->sendApiEmailVerificationNotification();
            $Peserta = Peserta::create([
                "ID_USER" => $User["id"],
                "NAMA_DEPAN" => $register["nama_depan"],
                "NAMA_BELAKANG" => $register["nama_belakang"],
                "ALAMAT" => $register["alamat"],
                "TOKEN" => $register["token"],
            ]);

            return response(
                [
                    "message" => "Registered Successfully",
                    "user" => $User,
                    "peserta" => $Peserta,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Registered Failed",
            ],
            406
        );
    }

    public function login(Request $request)
    {
        $loginData = $request->only("email", "password");
        $validate = Validator::make($loginData, [
            "email" => "required|email:rfc,dns",
            "password" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if (!Auth::attempt($loginData)) {
            return response(["message" => "Login Failed"], 401);
        }

        $user = Auth::user();
        $token = $user->createToken("Authentication Token")->accessToken;
        if ($user->email_verified_at !== null) {
            if ($user->role == "EO") {
                $user = DB::table("users")
                    ->join("eo", "users.id", "=", "eo.ID_USER")
                    ->select("users.email", "users.no_hp", "users.role", "eo.*")
                    ->first();
            } elseif ($user->role == "Peserta") {
                $user = DB::table("users")
                    ->join("peserta", "users.id", "=", "peserta.ID_USER")
                    ->select(
                        "users.email",
                        "users.no_hp",
                        "users.role",
                        "peserta.*"
                    )
                    ->first();
            } else {
                $user = DB::table("users")
                    ->join("admin", "users.id", "=", "admin.ID_USER")
                    ->select(
                        "users.email",
                        "users.no_hp",
                        "users.role",
                        "admin.*"
                    )
                    ->first();

                if ($user->STATUS != "Active") {
                    return response(
                        [
                            "message" => "Akun Disable",
                        ],
                        401
                    );
                }
            }
            return response([
                "message" => "Login Successfull",
                "user" => $user,
                "token_type" => "Bearer",
                "token" => $token,
            ]);
        } else {
            return response()->json(["message" => "Please Verify Email", "user" => $user,], 401);
        }
    }

    //Admin
    public function CreateAdmin(Request $request)
    {
        $register = $request->all();
        if ($register["role"] == "Admin") {
            $validate = Validator::make($register, [
                "nama_depan" => "required",
                "email" => "required|email|unique:users",
                "password" => "required|min:8",
                "cpassword" => "required",
                "no_hp" =>
                    "required|digits_between:10,13|numeric|starts_with:08",
                "role" => "required",
            ]);

            if ($validate->fails()) {
                return response(["message" => $validate->errors()], 400);
            }

            if ($register["password"] == $register["cpassword"]) {
                $date = date("Y-m-d H:i:s");
                $register["password"] = Hash::make($request->password);
                $User = User::create([
                    "email" => $register["email"],
                    "password" => $register["password"],
                    "no_hp" => $register["no_hp"],
                    "role" => $register["role"],
                    "email_verified_at" => $date,
                ]);
                $Admin = Admin::create([
                    "ID_USER" => $User["id"],
                    "NAMA_DEPAN" => $register["nama_depan"],
                    "NAMA_BELAKANG" => $register["nama_belakang"],
                ]);

                return response(
                    [
                        "message" => "Created Admin Successfully",
                        "user" => $User,
                        "admin" => $Admin,
                    ],
                    200
                );
            } else {
                return response(
                    [
                        "message" =>
                            "The password and confirmation password do not match.",
                    ],
                    401
                );
            }

            return response(
                [
                    "message" => "Created Admin Failed",
                ],
                406
            );
        }
    }

    public function getAllAdmin(Request $request)
    {
        $Admin = DB::table("users")
            ->join("admin", "users.id", "=", "admin.ID_USER")
            ->select("users.email", "users.no_hp", "users.role", "admin.*")
            ->get();
        if (!is_null($Admin)) {
            return response(
                [
                    "message" => "Retrieve All Success",
                    "data" => $Admin,
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

    public function updateAdmin(Request $request, $id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return response(
                [
                    "message" => "Admin Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        if ($updateData["withpassword"] == 0) {
            $validate = Validator::make($updateData, [
                "nama_depan" => "required",
                "email" => "required|email|unique:users,email" . $id,
                "no_hp" =>
                    "required|digits_between:10,13|numeric|starts_with:08",
            ]);
        } else {
            $validate = Validator::make($updateData, [
                "nama_depan" => "required",
                "email" => "required|email|unique:users,email," . $id,
                "password" => "required|min:8",
                "cpassword" => "required",
                "no_hp" =>
                    "required|digits_between:10,13|numeric|starts_with:08",
            ]);
        }

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($updateData["withpassword"] == 1) {
            if ($updateData["password"] == $updateData["cpassword"]) {
                $updateData["password"] = Hash::make($request->password);
                $User->password = $updateData["password"];
            } else {
                return response(
                    [
                        "message" =>
                            "The password and confirmation password do not match.",
                    ],
                    401
                );
            }
        }
        DB::table("admin")
            ->where("ID_USER", $id)
            ->update([
                "NAMA_DEPAN" => $updateData["nama_depan"],
                "NAMA_BELAKANG" => $updateData["nama_belakang"],
            ]);

        $User->no_hp = $updateData["no_hp"];
        $User->email = $updateData["email"];

        if ($User->save()) {
            $User = DB::table("users")
                ->join("admin", "users.id", "=", "admin.ID_USER")
                ->where("ID_USER", $id)
                ->select("users.email", "users.no_hp", "users.role", "admin.*")
                ->first();
            return response(
                [
                    "message" => "Update Admin Successfully",
                    "data" => $User,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update User Failed",
                "data" => null,
            ],
            400
        );
    }

    public function updateStatusAdmin(Request $request, $id)
    {
        $Admin = Admin::find($id);
        if (is_null($Admin)) {
            return response(
                [
                    "message" => "Admin Not Found",
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

        $Admin->STATUS = $updateData["status"];

        if ($Admin->save()) {
            return response(
                [
                    "message" => "Update Admin Successfully",
                    "data" => $Admin,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Admin Failed",
                "data" => null,
            ],
            400
        );
    }

    public function getAdmin($id)
    {
        $Admin = DB::table("users")
            ->join("admin", "users.id", "=", "admin.ID_USER")
            ->select("users.email", "users.no_hp", "users.role", "admin.*")
            ->where("admin.ID_ADMIN", $id)
            ->first();

        if (!is_null($Admin)) {
            return response(
                [
                    "message" => "Retrieve All Admin Success",
                    "data" => $Admin,
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

    public function updateEventOrganizer(Request $request, $id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return response(
                [
                    "message" => "Event Organizer Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            "nama_eo" => "required",
            "email" => "required|email|unique:users,email," . $id,
            "no_hp" => "required|digits_between:10,13|numeric|starts_with:08",
            "alamat" => "required",
            "link_web" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        DB::table("eo")
            ->where("ID_USER", $id)
            ->update([
                "NAMA_EO" => $updateData["nama_eo"],
                "ALAMAT" => $updateData["alamat"],
                "LINK_WEB" => $updateData["link_web"],
            ]);

        $User->no_hp = $updateData["no_hp"];
        $User->email = $updateData["email"];

        if ($User->save()) {
            $User = DB::table("users")
                ->join("eo", "users.id", "=", "eo.ID_USER")
                ->where("eo.ID_USER", $id)
                ->select("users.email", "users.no_hp", "users.role", "eo.*")
                ->first();
            return response(
                [
                    "message" => "Update Event Organizer Successfully",
                    "data" => $User,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Organizer Failed",
                "data" => null,
            ],
            400
        );
    }

    public function changePassword(Request $request, $id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return response(
                [
                    "message" => "Event Organizer Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "lastpassword" => "required",
            "newpassword" => "required",
            "cpassword" => "required",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if (Hash::check($updateData["lastpassword"], $User->password)) {
            if ($updateData["newpassword"] === $updateData["cpassword"]) {
                $User->password = bcrypt($request->newpassword);
            } else {
                return response(
                    [
                        "message" =>
                            "The password and confirmation password do not match.",
                    ],
                    400
                );
            }
        } else {
            return response(
                [
                    "message" => "Wrong Old Password",
                ],
                400
            );
        }

        if ($User->save()) {
            return response(
                [
                    "message" => "Change Password Successfully",
                    "data" => $User,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Change Password Failed",
                "data" => null,
            ],
            400
        );
    }

    public function getEO($id)
    {
        $EO = DB::table("users")
            ->join("eo", "users.id", "=", "eo.ID_USER")
            ->select("users.email", "users.no_hp", "users.role", "eo.*")
            ->where("eo.ID_EO", $id)
            ->first();

        if (!is_null($EO)) {
            return response(
                [
                    "message" => "Retrieve All Admin Success",
                    "data" => $EO,
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

    public function getAllEO(Request $request)
    {
        $EO = DB::table("users")
            ->join("eo", "users.id", "=", "eo.ID_USER")
            ->select("users.email", "users.no_hp", "users.role", "eo.*")
            ->get();
        if (!is_null($EO)) {
            return response(
                [
                    "message" => "Retrieve All Success",
                    "data" => $EO,
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

    public function updateStatusEO(Request $request, $id)
    {
        $EO = EO::find($id);
        if (is_null($EO)) {
            return response(
                [
                    "message" => "Event Organizer Not Found",
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

        $EO->STATUS_EO = $updateData["status"];

        if ($EO->save()) {
            return response(
                [
                    "message" => "Update Event Organizer Successfully",
                    "data" => $EO,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Organizer Failed",
                "data" => null,
            ],
            400
        );
    }

    public function updateGambarEO(Request $request, $id)
    {
        $EO = EO::find($id);
        $gambar = $EO->GAMBAR;
        if (is_null($EO)) {
            return response(
                [
                    "message" => "Event Organizer Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "gambar" => "required|image|mimes:jpeg,png,jpg|max:1048",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar")) {
            $imageName = time() . "EO" . "." . $request->gambar->extension();
            $request->gambar->move(public_path("GambarEO"), $imageName);
        }

        $EO->GAMBAR = $imageName;

        if ($EO->save()) {
            if ($gambar != null) {
                File::delete(public_path() . "/GambarEO/" . $gambar);
            }
            return response(
                [
                    "message" => "Update Event Organizer Successfully",
                    "data" => $EO,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Event Organizer Failed",
                "data" => null,
            ],
            400
        );
    }

    public function updatePeserta(Request $request, $id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return response(
                [
                    "message" => "User Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            "email" => "required|email|unique:users,email," . $id,
            "no_hp" => "required|digits_between:10,13|numeric|starts_with:08",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        DB::table("peserta")
            ->where("ID_USER", $id)
            ->update([
                "NAMA_DEPAN" => $updateData["nama_depan"],
                "ALAMAT" => $updateData["alamat"],
                "NAMA_BELAKANG" => $updateData["nama_belakang"],
            ]);

        $User->no_hp = $updateData["no_hp"];
        $User->email = $updateData["email"];

        if ($User->save()) {
            $User = DB::table("users")
                ->join("peserta", "users.id", "=", "peserta.ID_USER")
                ->where("ID_USER", $id)
                ->select(
                    "users.email",
                    "users.no_hp",
                    "users.role",
                    "peserta.*"
                )
                ->first();
            return response(
                [
                    "message" => "Update User Successfully",
                    "data" => $User,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update User Failed",
                "data" => null,
            ],
            400
        );
    }

    public function updateGambarPeserta(Request $request, $id)
    {
        $Peserta = Peserta::find($id);
        $gambar = $Peserta->GAMBAR;
        if (is_null($Peserta)) {
            return response(
                [
                    "message" => "Event Organizer Not Found",
                    "data" => null,
                ],
                404
            );
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            "gambar" => "required|image|mimes:jpeg,png,jpg|max:1048",
        ]);

        if ($validate->fails()) {
            return response(["message" => $validate->errors()], 400);
        }

        if ($files = $request->file("gambar")) {
            $imageName =
                time() . "Peserta" . "." . $request->gambar->extension();
            $request->gambar->move(public_path("GambarPeserta"), $imageName);
        }

        $Peserta->GAMBAR = $imageName;

        if ($Peserta->save()) {
            if ($gambar != null) {
                File::delete(public_path() . "/GambarPeserta/" . $gambar);
            }
            return response(
                [
                    "message" => "Update Participant Successfully",
                    "data" => $Peserta,
                ],
                200
            );
        }

        return response(
            [
                "message" => "Update Participant Failed",
                "data" => null,
            ],
            400
        );
    }

    public function getPeserta($id)
    {
        $Peserta = DB::table("users")
            ->join("peserta", "users.id", "=", "peserta.ID_USER")
            ->select("users.email", "users.no_hp", "users.role", "peserta.*")
            ->where("peserta.ID_PESERTA", $id)
            ->first();

        if (!is_null($Peserta)) {
            return response(
                [
                    "message" => "Retrieve All Participant Success",
                    "data" => $Peserta,
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
}
