<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'product_id' => 'required|integer',
            'product_color' => 'nullable|string|max:255',
            'product_memory' => 'nullable|string|max:255',
            'product_description' => 'nullable|string',
        ]);

        $order = Order::create($request->all());

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order], 201);
    }
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    // OrderController.php
    public function updateProcessedStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->processed = $request->processed;
        $order->save();

        return response()->json(['message' => 'Статус заказа обновлен', 'order' => $order]);
    }
}
