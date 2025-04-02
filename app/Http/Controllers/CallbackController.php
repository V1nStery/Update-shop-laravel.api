<?php

namespace App\Http\Controllers;

use App\Models\Callback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CallbackController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $callback = Callback::create($request->all());

        return response()->json($callback, 201);
    }

    public function index()
    {
        $callbacks = Callback::all();
        return response()->json($callbacks);
    }

    public function updateProcessedStatus(Request $request, $id)
    {
        $callback = Callback::findOrFail($id);
        $callback->processed = $request->processed;
        $callback->save();

        return response()->json(['message' => 'Статус обратного звонка обновлен', 'callback' => $callback]);
    }
}
