<?php

namespace App\Http\Controllers;

use App\Events\AdminLoggedIn;
use App\Events\UserLoggedIn;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function __construct()
    {

    }

    public function sendAdminOTP(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $otp = $this->generateOtp();
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10));

        $this->sendOtpEmail($request->email, $otp);

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyAdminOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        // add role check here too
        if ($this->isValidOtp($request->email, $request->otp)) {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['message' => 'Invalid Email'], 401);
            }

            Auth::loginUsingId($user->id);
            event(new UserLoggedIn($user));
            event(new AdminLoggedIn($user));

            return response()->json([
                'message' => 'Login successful',
                'role' => $user->getRoleNames(),
            ]);
        }

        return response()->json(['message' => 'Invalid OTP'], 401);
    }

    public function sendAuthOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $otp = $this->generateOtp();
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10));

        $this->sendOtpEmail($request->email, $otp);

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyAuthOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        if ($this->isValidOtp($request->email, $request->otp)) {

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $request->email,
                    'name' => $request->email,
                    'password' => bcrypt(Str::random(8)),
                ]);

                $user->assignRole('student');

                $user->assignRole('auth');

            }

            Auth::loginUsingId($user->id);
            event(new UserLoggedIn($user));

            return response()->json(['message' => 'Login successful', 'user' => $user, 'role' => $user->getRoleNames()]);
        }

        return response()->json(['message' => 'Invalid OTP'], 401);
    }

    public function verifyGuideOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        if ($this->isValidOtp($request->email, $request->otp)) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                Auth::loginUsingId($user->id);
                event(new UserLoggedIn($user));

                return response()->json(['message' => 'Login successful', 'user' => $user, 'role' => $user->getRoleNames()]);
            }
        }

        return response()->json(['message' => 'Invalid OTP or you are not registered'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    private function generateOtp()
    {
        return rand(100000, 999999);
    }

    private function sendOtpEmail($email, $otp)
    {

        Mail::to($email)->send(new OTPMail('Your OTP Code', "Your OTP is: $otp"));

    }

    private function isValidOtp($email, $otp)
    {
        $cachedOtp = Cache::get('otp_' . $email);
        if ($cachedOtp && $cachedOtp == $otp) {
            Cache::forget('otp_' . $email);
            return true;
        }
        return false;
    }

}
