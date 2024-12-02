<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Events\AdminLoggedIn;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class LoginController extends Controller
{
    protected $otpLength;

    public function __construct()
    {
        $this->otpLength = config('auth.otp_length', 6); // Default to 6 if not set in config
    }


    public function setup(){

        $user = User::where('email',  "susheel3010@gmail.com")->first();

        $user->assignRole('guide');
        
        $user->save();
        Role::create(['name' => 'student']);
        Role::create(['name' => 'auth']);
        Role::create(['name' => 'guide']);



    }
    public function showLoginForm()
    {
        return view('welcome');
    }

    public function adminSendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $otp =  $this->generateOtp();
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10));

        $this->sendOtpEmail($request->email, $otp);

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function adminVerifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        if ($this->isValidOtp($request->email, $request->otp)) {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['message' => 'Invalid Email'], 401);
            }

            Auth::loginUsingId($user->id);
          event(new UserLoggedIn($user ));
            event(new AdminLoggedIn($user ));

            $user->update(['last_login_at' => now()]);

            
            return response()->json([
                'message' => 'Login successful',
                'role' => $user->getRoleNames() ,
            ]);
        }

        return response()->json(['message' => 'Invalid OTP'], 401);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $otp = $this->generateOtp();
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10));

        $this->sendOtpEmail($request->email, $otp);

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        if ($this->isValidOtp($request->email, $request->otp)) {
            $user = User::firstOrCreate(
                ['email' => $request->email],
                ['name' => $request->email, 'password' => bcrypt(Str::random(8))]
            );

            Auth::loginUsingId($user->id);
            event(new UserLoggedIn($user));

            $user->update(['last_login_at' => now()]);
          

            
            return response()->json(['message' => 'Login successful', 'user' => $user, 'role' => $user->getRoleNames() ]);


        }

        return response()->json(['message' => 'Invalid OTP'], 401);
    }

    public function verifyGuestOtp(Request $request)
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
                'password' => bcrypt(Str::random(8))
                ]);

                $user->assignRole('student');

                $user->assignRole('auth');

                }
                

            Auth::loginUsingId($user->id);
            event(new UserLoggedIn($user ));

       $user->update(['last_login_at' => now()]);



            return response()->json(['message' => 'Login successful', 'user' => $user, 'role' => $user->getRoleNames() ]);
        }

        return response()->json(['message' => 'Invalid OTP'], 401);
    }

    

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    private function generateOtp()
    {
        return 121212; // rand(100000, 999999); // You can customize this to use the $this->otpLength
    }

    private function sendOtpEmail($email, $otp)
    {
        Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Your OTP Code');
        });
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
