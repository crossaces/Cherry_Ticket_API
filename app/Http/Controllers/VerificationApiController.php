<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\VerifiesEmails;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\Verified;

class VerificationApiController extends Controller
{
    use VerifiesEmails;

    /**

* Show the email verification notice.

*

*/

    public function show()
    {
        //
    }

    /**

* Mark the authenticated user’s email address as verified.

*

* @param \Illuminate\Http\Request $request

* @return \Illuminate\Http\Response

*/

    public function verify(Request $request)
    {
        $userID = $request["id"];
        $path = env('APP_URL');
        $user = User::findOrFail($userID);

        if ($user->email_verified_at == null) {
            $date = date("Y-m-d H:i:s");

            $user->email_verified_at = $date; // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature

            $user->save();
            return redirect($path."verified");
        } else {
            return redirect($path."verified");
        }
    }

    /**

* Resend the email verification notification.

*

* @param \Illuminate\Http\Request $request

* @return \Illuminate\Http\Response

*/

    public function resend(Request $request)
    {
        $userID = $request["id"];

        $user = User::findOrFail($userID);

        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "User already have verified email"], 200);
            // return redirect($this->redirectPath());
        }

        $user->sendApiEmailVerificationNotification();
       
        return response()->json(["message" => "The notification has been resubmitted"], 200);

        // return back()->with(‘resent’, true);
    }
}
