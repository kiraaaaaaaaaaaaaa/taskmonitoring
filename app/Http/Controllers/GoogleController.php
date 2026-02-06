<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGooglCallbak()
    {
        try{
            $googleUser = Socialite::driver('google')->user();
            
            // Check 1: Do we have a user with this Google ID?
            $user = User::where('email', $googleUser->getEmail())->first();
           
            if ($user) {

                $user->update([
                   
                    'googleID' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                // If yes, log them in immediately
                Auth::login($user);
                return redirect('/Task');
                
            }


          

        } catch(\Exception $e)
        {
            return redirect('/')->with('error');
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // or /login
    }
}
