<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Branch;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $title = "Danh sách chi nhánh";
            $search = $request->input('search');

            $query = Branch::query();

            // if ($search) {
            //     $query->where(function ($q) use ($search) {
            //         $q->where('phone', $search)
            //             ->orWhere('name', 'like', '%' . $search . '%')
            //             ->orWhere('email', 'like', '%' . $search . '%');
            //     });
            // }

            $user = $query->orderByDesc('created_at')
                ->paginate(10)
                ->appends($request->query());

            return view('admin.branch.index', compact('user', 'title'));
        } catch (Exception $e) {
            Log::error('Failed to fetch user: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch user', 500);
        }
    }
    public function addForm()
    {
        $title = 'Thêm chi nhánh';
        return view('admin.branch.add', compact('title'));
    }
    public function edit($id)
    {
        $title = "Sửa chi nhánh";
        try {
            $branch = Branch::find($id);
            return view('admin.branch.edit', compact('title', 'branch'));
        } catch (Exception $e) {
            Log::error('Failed to find user: ' . $e->getMessage());
            return ApiResponse::error('Failed to find user', 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // Validate dữ liệu
            $validator = Validator::make($request->all(), [
                'name'   => 'required|string|max:255',
                'status' => 'required|in:0,1',
            ], [
                'name.required' => 'Tên chi nhánh là bắt buộc.',
                'name.max'      => 'Tên chi nhánh không được vượt quá 255 ký tự.',
                'status.required' => 'Trạng thái là bắt buộc.',
                'status.in' => 'Trạng thái không hợp lệ.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Tìm chi nhánh cần update
            $branch = Branch::findOrFail($id);

            // Nếu status = 1 thì set tất cả chi nhánh khác về 0
            if ($request->status == 1) {
                Branch::where('id', '!=', $branch->id)->update(['status' => 0]);
            }

            // Cập nhật chi nhánh
            $branch->update([
                'name'   => $request->name,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.branch.store')->with('success', 'Cập nhật chi nhánh thành công');
        } catch (Exception $e) {
            Log::error('Failed to update branch: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật chi nhánh.');
        }
    }
    public function add(Request $request)
    {
        try {
            // Validate dữ liệu
            $validator = Validator::make($request->all(), [
                'name'   => 'required|string|max:255',
                'status' => 'required|in:0,1',
            ], [
                'name.required' => 'Tên chi nhánh là bắt buộc.',
                'name.max'      => 'Tên chi nhánh không được vượt quá 255 ký tự.',
                'status.required' => 'Trạng thái là bắt buộc.',
                'status.in' => 'Trạng thái không hợp lệ.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Nếu status = 1 thì update tất cả bản ghi khác về 0
            if ($request->status == 1) {
                Branch::where('status', 1)->update(['status' => 0]);
            }

            // Tạo mới chi nhánh
            Branch::create([
                // 'shop_id' => auth()->user()->shop_id ?? 1, // tuỳ bạn, hoặc lấy từ request
                'name'    => $request->name,
                'status'  => $request->status,
                // 'unit_code' => uniqid('BR_'), // nếu cần sinh tự động
                // 'subdomain' => strtolower(str_replace(' ', '', $request->name)) . '.yourdomain.com',
            ]);
            return redirect()->route('admin.branch.store')->with('success', 'Thêm chi nhánh thành công');
        } catch (Exception $e) {
            Log::error('Failed to add staff: ' . $e->getMessage());
            return ApiResponse::error('Failed to add staff:', 500);
        }
    }
     public function deleteStaff(int $id): void
    {
        DB::beginTransaction();
        try {
             $branch = Branch::find($id);
            $branch->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete staff: {$e->getMessage()}");
            throw new Exception('Failed to delete staff');
        }
    }
     public function delete($id)
    {
        try {
            $this->deleteStaff($id);
            $user = Branch::orderByDesc('created_at')->paginate(10); // Adjust this if you have specific filtering
            $table = view('admin.branch.table', compact('user'))->render();
            $pagination = $user->links('vendor.pagination.custom')->render();

            return response()->json([
                'success' => true,
                'message' => 'Xóa chi nhánh thành công',
                'table' => $table,
                'pagination' => $pagination
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete staff: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa chi nhánh'
            ]);
        }
    }
}
