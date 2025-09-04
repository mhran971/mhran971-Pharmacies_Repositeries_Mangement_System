<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Pharmacy\Operations\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function demand_Order(OrderRequest $request)
    {
//        $data = $request->validated();

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;


        $order = Order::create([
            'user_id' => $user->id,
            'pharmacy_id' => $pharmacyId,
            'repository_id' => $request['repository_id'],
            'status' => 'pending',
            'order_num' => random_int(10000, 99999),
            'total_price' => collect($request['items'])->sum(fn($item) => $item['quantity'] * ($item['price'] ?? 0)),
        ]);

        foreach ($request['items'] as $item) {
            $order->items()->create($item);
        }

        return response()->json($order->load('items'), 201);
    }

    public function updateOrderStatus(Request $request,  $order_id)
    {
        $request->validate([
            'status' => 'required|in:canceled'
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

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacies?->id;

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
    public function get_order_status_perId($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacies?->id;

        $query = Order::where('pharmacy_id', $pharmacyId)->value('status');


        return response()->json($query);
    }

 public function delete_order($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pharmacyId = $user->pharmacy_owner?->id ?? $user->pharmacy?->id;

        $order = Order::with('items')->findOrFail($id);
        $order->items()->delete();
        $order->delete();


        return response()->json(['order has deleted successfully ' => true]);
    }

}
