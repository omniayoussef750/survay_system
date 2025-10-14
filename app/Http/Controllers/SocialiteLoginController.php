<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;



class SocialiteLoginController extends Controller
{
   public function loginWithGoogle(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Here you would typically verify the token with Google and retrieve user info.
        // For simplicity, let's assume the token is valid and contains user info.

        // Example of user info retrieved from Google
       try {
        $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->userFromToken($request->token);
        
    
        $user = Researcher::firstOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name' => $googleUser->name ?? $googleUser->given_name ?? 'Google User',
                'email' =>$googleUser->getEmail(),
                'password' => bcrypt(str()->random(16)),
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'فشل التحقق من Google token',
            'details' => $e->getMessage(),
        ], 401);
    }
}
public function loginWithFacebook(Request $request){

    $request->validate([
        'access_token' => 'required|string',
    ]);

    $accessToken = $request->access_token;

    // Step 1: Verify token
    $appAccessToken = env('FACEBOOK_APP_ID').'|'.env('FACEBOOK_APP_SECRET');
    $verifyUrl = "https://graph.facebook.com/debug_token";
    
    $verifyResponse = Http::get($verifyUrl, [
        'input_token' => $accessToken,
        'access_token' => $appAccessToken,
    ]);

    $verifyData = $verifyResponse->json();

    if (
        $verifyResponse->failed() ||
        empty($verifyData['data']['is_valid']) ||
        !$verifyData['data']['is_valid']
    ) {
        return response()->json([
            'error' => 'Invalid Facebook token',
            'details' => $verifyData,
        ], 401);
    }

    // Step 2: Get user info
    $userResponse = Http::get('https://graph.facebook.com/me', [
        'fields' => 'id,name,email,picture',
        'access_token' => $accessToken,
    ]);

    $facebookUser = $userResponse->json();

    // Step 3: Create or update user
    $user = Researcher::firstOrCreate([
        'facebook_id' => $facebookUser['id']
    ], [
        'name' => $facebookUser['name'] ?? 'Facebook User',
        'email' => $facebookUser['email'] ?? $facebookUser['id'].'@facebook.com',
        'password' => bcrypt(str()->random(16)),
    ]);

    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}
}