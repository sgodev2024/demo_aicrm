<?php

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

function saveImages($request, string $inputName, string $directory = 'images', $width = 150, $height = 150, $isArray = false)
{
    $paths = [];

    // Kiểm tra xem có file không
    if ($request->hasFile($inputName)) {

        // Lấy tất cả các file hình ảnh
        $images = $request->file($inputName);

        if (!is_array($images)) {
            $images = [$images]; // Đưa vào mảng nếu chỉ có 1 ảnh
        }

        // Tạo instance của ImageManager
        $manager = new ImageManager(new Driver());

        foreach ($images as $key => $image) {

            // Đọc hình ảnh từ đường dẫn thực
            $img = $manager->read($image->getPathName());

            // Thay đổi kích thước
            $img->resize($width, $height);

            // Tạo tên file duy nhất
            $filename = time() . uniqid() . '.' . $image->getClientOriginalExtension();

            // Lưu hình ảnh đã được thay đổi kích thước vào storage
            Storage::disk('public')->put($directory . '/' . $filename, $img->encode());

            // Lưu đường dẫn vào mảng
            $paths[$key] = $directory . '/' . $filename;
        }

        // Trả về danh sách các đường dẫn
        return $isArray ? $paths : $paths[0];
    }

    return null;
}

if (!function_exists('showImage')) {
    function showImage($image)
    {
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk('public');

        if ($image && $storage->exists($image)) {
            return $storage->url($image);
        }

        return asset('images/default.jpg');
    }
}

function deleteImage($path)
{
    if ($path && Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
    }
}

function formatPrice($price)
{
    if (!empty($price)) {
        // Làm tròn đến 0 hoặc 1 chữ số thập phân tuỳ giá trị
        $float = (float) $price;

        // Nếu là số nguyên → format không có phần thập phân
        if (floor($float) == $float) {
            return number_format($float, 0, '', '.');
        }

        // Nếu có phần thập phân → format với 1–2 số sau dấu phẩy
        return number_format($float, 2, ',', '.');
    }

    return '0';
}

if (!function_exists('transaction')) {
    function transaction($callback, $onError = null)
    {
        DB::beginTransaction();
        try {
            $result = $callback();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();

            if ($onError && is_callable($onError)) {
                $onError($e);
            }

            Log::error('Exception Details:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return errorResponse('Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }
}

if (!function_exists('successResponse')) {
    function successResponse($message = 'call api successful', $data = null, $code = 200, bool $isResponse = true, bool $isToastr = true)
    {
        $response = ['success' => true, 'message' => $message, 'data' => $data, 'code' => $code];

        if ($isToastr) session()->flash('success', $message);

        return $isResponse ? response()->json($response, $code) : $response;
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(string $message, $code = 500, bool $isResponse = true)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'code' => $code
        ];
        return $isResponse ? response()->json($response, $code) : $response;
    }
}
