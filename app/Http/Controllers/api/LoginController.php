<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Schools;
use App\Models\SISUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class LoginController extends Controller
{

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'emis_code' => 'required|string',
            'password' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        // Check email exist
        $user = SISUser::where('u_username', $request->emis_code)->first();

        // Check password
        if(!$user || !Hash::check($request->password, $user->u_password)) {
            return response()->json([
                'status' => 'false',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $data['token'] = $user->createToken($request->emis_code)->plainTextToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display a form of the login.
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the email exists in the database
        $user = SISUser::where('u_email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'false','message' => 'Email not found'], 404);
        }

        // Generate a random OTP
        $otp = mt_rand(100000, 999999);

        // Store the OTP in the user's record (you may have an otp column in your users table)
        $user->otp = Hash::make($otp);
        $user->save();

        // Send the OTP to the user's email
        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->u_email)->subject('One Time Password (OTP)');
        });
        $response = [
            'status' => 'success',
            'message' => 'OTP sent successfully on Email.',
        ];

        return response()->json($response, 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric', // Assuming OTP is numeric
        ]);

        // Find the user by email
        $user = SISUser::where('u_email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'false','message' => 'User not found'], 404);
        }

        // Check if the provided OTP matches the stored OTP
        if (!Hash::check($request->otp, $user->otp)) {
            return response()->json(['status' => 'false','message' => 'Invalid OTP'], 400);
        }

        return response()->json(['status' => 'success', 'message' => 'OTP verified successfully'], 200);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required', // Assuming minimum password length is 8 characters
            'otp' => 'required|numeric', // Assuming OTP is numeric
        ]);

        // Find the user by email
        $user = SISUser::where('u_email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'false','message' => 'User not found'], 404);
        }

        // Check if the provided OTP matches the stored OTP
        if (!Hash::check($request->otp, $user->otp)) {
            return response()->json(['status' => 'false','message' => 'Invalid OTP'], 400);
        }

        // Clear the OTP from the user's record (optional)
        $user->otp = null;
        $user->save();

        // Update the user's password
        $user->u_password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Password updated successfully'], 200);
    }

    /**
     * Display a form of the login.
     */
    public function logout()
    {
        Session::forget('email');

        return redirect()->intended('/'); // Change to your desired redirect route
    }
}
