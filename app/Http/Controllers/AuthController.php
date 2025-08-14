<?php

namespace App\Http\Controllers;

use App\Events\CustomerLogin;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\OTP;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        return transaction(function () use ($credentials, $request) {

            $remember = $request->filled('remember');

            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();

                return match ($user->role_id) {
                    1 => redirect()->route('admin.dashboard'),
                    2 => redirect()->route('staff.index'),
                    3 => redirect()->route('sa.store.index'),
                    default =>  redirect()->route('dashboard')
                };

            }

            return errorResponse("Mật khẩu không chính xác!", 404);
        });
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
