<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to login using ' . ucfirst($provider) . '. Please try again.');
        }

        // Find existing user by email
        $user = User::where('email', $socialUser->getEmail())->first();

        // If not found, create new user (default role_id = 4 for Applicant)
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'username' => Str::slug($socialUser->getNickname() ?? $socialUser->getName()) . '-' . rand(100, 999),
                'password' => bcrypt(Str::random(16)),
                'role_id' => 4, // Applicant role by default for social signups
                'account_type' => 'main',
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'email_verified_at' => now(),
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        // Same redirect logic as your regular login (AuthenticatedSessionController)
        return redirect()->intended(match ($user->role_id) {
            1 => route('Reviewer.dashboard'),
            2 => route('staff.dashboard'),
            3 => route('Uploader.dashboard'),
            4 => route('Applicant.dashboard'),
            default => '/',
        });
    }
}