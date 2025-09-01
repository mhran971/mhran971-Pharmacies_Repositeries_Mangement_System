<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Operations\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function demand_Order(OrderRequest $request)
    {
//        $data = $request->validated();

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;


        $order = Order::create([
            'pharmacy_id'   => $pharmacyId,
            'repository_id' => $request['repository_id'],
            'status'        => 'pending',
            'total_price'   => collect($request['items'])->sum(fn($item) => $item['quantity'] * ($item['price'] ?? 0)),
        ]);

        foreach ($request['items'] as $item) {
            $order->items()->create($item);
        }

        return response()->json($order->load('items'), 201);
    }

    public function updateOrderStatus(Request $request,  $order_id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected ,delivered,canceled'
        ]);
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;
        $order = Order::where('pharmacy_id', $pharmacyId)->where('id', $order_id)->first();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->update(['status' => $request->status]);

        return response()->json($order);
    }
    public function myOrder()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $query = Order::with('items.medicine');
        $query->where('pharmacy_id', $pharmacyId);



        return response()->json($query->latest()->get());
    }
    public function get_order_perId($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $query = OrderItem::where('order_id',$id)->get();



        return response()->json($query);
    }

}
