<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Researcher;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ResearcherController extends Controller
{
   public function register(Request $request){

       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:researchers',
           'phone' => 'nullable|string|max:20',
           'password' => 'required|string|min:8|confirmed',
       ]);  

       $otp = rand(100000, 999999);

      DB::beginTransaction();
        try {
    // Create researcher first
            $researcher = Researcher::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => bcrypt($validated['password']),
                'is_verified' => false,
                'is_active' => true,
           
            ]);
    // Store OTP
        Otp::create([
            'researcher_id' => $researcher->id,
            'code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
       
         ]);

    // Commit the transaction
        DB::commit();

    // Send OTP mail
        Mail::to($researcher->email)->send(new OtpMail($otp));

 } catch (\Exception $e) {
        // If anything fails, delete the researcher (rollback)
       DB::rollBack();

         return response()->json([
            'error' => 'Registration failed',
            'details' => $e->getMessage(),
        ], 500);
    }
    
        return response()->json([
            'message' => 'Registered. Check your email for OTP.',
            'researcher' => $researcher,
        ], 201);       
}

public function verifyOtp(Request $request , $researcherId){

    $validated = $request->validate([
        'otp' => 'required|digits:6',
    ]);
    $researcher = Researcher::find($researcherId);

    $otpRecord = Otp::where('researcher_id', $researcher->id)
                    ->where('code', $validated['otp'])
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

    if(!$otpRecord){
        return response()->json(['error' => 'Invalid or expired OTP'], 400);
    }

    // Mark researcher as verified
    $researcher->is_verified = true;
    $researcher->save();

    // Delete used OTP
    $otpRecord->delete();

    return response()->json(['message' => 'Email verified successfully',
'researcher' => $researcher
], 200);
}

public function resendOtp($researcherId){

    $researcher = Researcher::find($researcherId);
    if(!$researcher){
        return response()->json(['error' => 'Researcher not found'], 404);
    }
    // Generate new OTP
    $otp = rand(100000, 999999);
    // Store new OTP
    Otp::updateOrCreate(
        ['researcher_id' => $researcher->id],
        ['code' => $otp, 'expires_at' => Carbon::now()->addMinutes(10)]
    );
    // Send OTP mail
    Mail::to($researcher->email)->send(new OtpMail($otp));

    return response()->json(['message' => 'OTP resent. Check your email.'], 200);
}

public function login(Request $request){

    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);
    $researcher = Researcher::where('email', $credentials['email'])->first();

    if(!$researcher || !password_verify($credentials['password'], $researcher->password)){
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
     if (!$researcher->is_active) {
        return response()->json([
            'error' => 'Your account is inactive. Please contact support.'
        ], 403);
    }
    if(!$researcher->is_verified){
        return response()->json(['error' => 'Email not verified'], 403);
    }
    // Generate token (for simplicity, using a dummy token here)
     $token = $researcher->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'researcher' => $researcher
    ], 200);
}

public function getProfile(){
    $researcher = auth()->user();
    if(!$researcher){
        return response()->json(['error' => 'Researcher not found'], 404);
    }

    return response()->json(['researcher' => $researcher], 200);
}

public function updateProfile(Request $request){
    $researcher = auth()->user();
    if(!$researcher){
        return response()->json(['error' => 'Researcher not found'], 404);
    }

    $validated = $request->validate([
        'name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:8|confirmed',
    ]);
    if(isset($validated['name'])){
        $researcher->name = $validated['name'];
    }
    if(isset($validated['phone'])){
        $researcher->phone = $validated['phone'];
    }
    if(isset($validated['password'])){
        $researcher->password = bcrypt($validated['password']);
    }
    $researcher->save();

    return response()->json([
        'message' => 'Profile updated successfully',
        'researcher' => $researcher
    ], 200);
}

public function forgotPassword(Request $request){

    $validated = $request->validate([
        'email' => 'required|string|email',
    ]);

    $researcher = Researcher::where('email', $validated['email'])->first();

    if(!$researcher){
        return response()->json(['error' => 'Researcher not found'], 404);
    }

    // Generate OTP
    $otp = rand(100000, 999999);

    // Store OTP
    Otp::updateOrCreate(
        ['researcher_id' => $researcher->id],
        ['code' => $otp, 'expires_at' => Carbon::now()->addMinutes(10)]
    );

    // Send OTP mail
    Mail::to($researcher->email)->send(new OtpMail($otp));

    return response()->json(['message' => 'OTP sent to your email'], 200);
}
public function resetPassword(Request $request, $researcherId){
    
    $validated = $request->validate([
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $researcher = Researcher::find($researcherId);

    if(!$researcher){
        return response()->json(['error' => 'Researcher not found'], 404);
    }
    // Update password
    $researcher->password = bcrypt($validated['new_password']);
    $researcher->save();


    return response()->json(['message' => 'Password reset successfully'], 200);
}
}