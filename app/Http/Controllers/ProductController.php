<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 




class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $products = $query->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'memory' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        
            $productData = $request->except('image'); // Сохраняем все данные, кроме картинки
        
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $productData['image'] = $imagePath; // Добавляем путь к картинке
            }
        
            $product = Product::create($productData);
            return response()->json($product, 201);
        }


        public function show(Product $product) // Laravel сам найдет товар по ID
        {
            return response()->json($product);
        }

        public function update(Request $request, Product $product)
        {
            $data = $request->all(); // Используем all() для получения всех данных

            // Логируем данные из запроса
            Log::info('Request data:', $data);
            Log::info('Request data:', $request->all());

            $validator = Validator::make($data, [
                'name' => 'sometimes|string|max:255',
                'color' => 'sometimes|string|max:255',
                'memory' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        
            $product->update($request->except('image')); // Обновляем остальные поля, исключая 'image'
        
        
            $product->save(); // Сохраняем изменения в базе
        
            return response()->json(['product' => $product->fresh()], 200);
        }

        public function updateImage(Request $request, Product $product)
        {
            Log::info('Request data for image update:', $request->all());

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::delete('public/' . $product->image);
                }
                $path = $request->file('image')->store('products', 'public');
                $product->image = $path;
                $product->save();
                return response()->json(['message' => 'Image updated'], 200);
            }
            return response()->json(['message' => 'Image not provided'], 400);
        }




    public function destroy(Product $product)
    {
        if ($product->image) {

            Storage::delete($product->image);

        }

        $product->delete(); return response()->json(['message' => 'Product deleted successfully'], 200);


    }

}