<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Config;
use App\Models\User;
use App\Services\ConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function index()
    {
        $title = 'Thông tin cửa hàng';
        try {
            $data = Config::where('user_id', Auth::user()->id)->first();
            // dd($data);
            $bank = Bank::get();
            return view('admin.configuration.config', compact('data', 'bank', 'title'));
        } catch (\Exception $e) {
            Log::error('Failed to get configuration: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to get configuration');
        }
    }


    public function updateConfig(Request $request)
    {
        try {
            // Lấy user hiện tại
            $user = Auth::user();

            // Lấy hoặc tạo Config theo user_id
            $config = Config::firstOrCreate(['user_id' => $user->id]);

            // Validate request (nếu cần)
            $data = $request->validate([
                'receiver' => 'nullable|string',
                'store_name' => 'nullable|string',
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
                'address' => 'nullable|string',
                'company_name' => 'nullable|string',
                'bank_account' => 'nullable|string',
                'bank' => 'nullable|exists:banks,id',
                'logo' => 'nullable|image|max:2048', // validate logo file nếu cần
            ]);

            // Cập nhật Config
            $config->receiver = $data['receiver'] ?? $config->receiver;
            $config->user_id = $user->id;

            if (!empty($data['bank_account']) && !empty($data['bank'])) {
                $bank = Bank::find($data['bank']);
                if ($bank) {
                    $config->bank_account = $data['bank_account'];
                    $config->bank_id = $bank->id;
                    $config->qr = "https://img.vietqr.io/image/{$bank->code}-{$data['bank_account']}-compact.jpg";
                }
            }

            // Xử lý upload logo (nếu có)
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoFileName = 'image_' . time() . '_' . $logo->getClientOriginalName();
                $logoFilePath = $logo->storeAs('public/config', $logoFileName);
                $config->logo = str_replace('public/', 'storage/', $logoFilePath);
            }

            $config->save();

            // Cập nhật User
            $user->store_name = $data['store_name'] ?? $user->store_name;
            $user->phone = $data['phone'] ?? $user->phone;
            $user->email = $data['email'] ?? $user->email;
            $user->address = $data['address'] ?? $user->address;
            $user->company_name = $data['company_name'] ?? $user->company_name;
            $user->save();

            session()->flash('success', 'Thay đổi thông tin thành công');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Failed to update configuration: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi cập nhật thông tin!');
        }
    }

}
