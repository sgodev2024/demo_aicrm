<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $orderService;
    protected $order;
    public function __construct(OrderService $orderService, Order $order)
    {
        $this->orderService = $orderService;
        $this->order = $order;
    }
    public function index(Request $request)
    {
        $title = 'Đơn hàng';
        $phone = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        try {
            $query = Order::query();

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            if ($phone) {
                $query->whereHas('client', function ($query) use ($phone) {
                    $query->where(function ($q) use ($phone) {
                        $q->where('phone', $phone)
                            ->orWhere('name', 'like', '%' . $phone . '%')
                            ->orWhere('email', 'like', '%' . $phone . '%');
                    });
                });
            }

            $orders = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

            return view('admin.order.index', compact('orders', 'title'));
        } catch (Exception $e) {
            Log::error('Failed to fetch orders: ' . $e->getMessage());
            return redirect()->route('admin.order.index')->with('error', 'Đã có lỗi khi tải đơn hàng');
        }
    }



    public function detail($id)
    {
        $title = 'Chi tiết đơn hàng';
        try {
            $order = $this->orderService->getOrderbyID($id);
            if ($order->notification == 1) {
                $order->notification = 0;
                $order->save();
            }
            return view('admin.order.detail', compact('order', 'title'));
        } catch (\Exception $e) {
            Log::error('Failed to find order');
        }
    }
}
