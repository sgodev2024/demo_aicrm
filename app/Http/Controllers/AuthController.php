<?php

namespace App\Http\Controllers;

use App\Events\CustomerLogin;
use App\Models\User;
use App\Models\OTP;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function login(Request $request)
    {
        try {
            // Xác định trường dùng để đăng nhập: email hoặc username
            $loginField = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            // Tạo credentials từ request
            $credentials = [
                $loginField => $request->input('username'),
                'password'  => $request->input('password'),
            ];

            $remember = $request->boolean('remember');

            // Tìm người dùng
            $user = User::where($loginField, $credentials[$loginField])->first();

            // Kiểm tra nếu tài khoản không tồn tại
            if (!$user) {
                return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không chính xác!');
                // return back();
            }

            // Kiểm tra nếu tài khoản không được kích hoạt
            if ($user->status !== 'active') {
                // toastr()->error('Tài khoản của bạn chưa được kích hoạt. Vui lòng liên hệ quản trị viên.');
                return back();
            }

            // Xác thực thông tin đăng nhập
            if (auth()->attempt($credentials, $remember)) {
                session()->put('authUser', auth()->user());

                // toastr()->success('Đăng nhập thành công.');

                // Điều hướng theo role_id
                switch (auth()->user()->role_id) {
                    case 1:
                        return redirect()->route('admin.dashboard');
                    case 2:
                        return redirect()->route('staff.index');
                    case 3:
                        return redirect()->route('sa.store.index');
                    default:
                        return redirect()->route('dashboard'); // fallback nếu không khớp
                }
            } else {
                // toastr()->error('Tài khoản hoặc mật khẩu không chính xác!');
                return back();
            }
        } catch (\Exception $e) {
            return $this->handleLoginError($request, $e);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('formlogin');
    }

    protected function handleLoginError($request, \Exception $e)
    {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}
