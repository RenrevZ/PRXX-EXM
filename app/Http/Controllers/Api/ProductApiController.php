<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    public function getAllproduct(): JsonResponse
    {
        try {
            $products = Product::paginate(10);

            return response()->json(['products' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getSingleCategory(Request $request): JsonResponse
    {
        $requestData = Validator::make($request->only('category'), [
            'category' => 'required'
        ]);

        if ($requestData->fails()) {
            return response()->json(['error' => $requestData], 500);
        }

        try {
            $products =  Product::where('category', $request->only('category'))
                ->paginate(10);

            return response()->json(['products' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getAllCategories(): JsonResponse
    {
        try {
            $products =  Product::distinct()->pluck('category');

            return response()->json(['category' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function searchProduct(string $search): JsonResponse
    {
        // $requestData = Validator::make($request->only('search'), [
        //     'search' => 'required | max:255 | regex:/^[A-Za-z. ]+$/'
        // ]);

        // if ($requestData->fails()) {
        //     return response()->json(['error' => $requestData->errors()], 500);
        // }

        try {
            $products =  Product::where('description', $search)
                ->orWhere('name', $search)
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->paginate(10);

            return response()->json(['product' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getProductWithPhoto(string $id): JsonResponse
    {

        try {
            $products = Product::where('id', $id)
                ->with('photos')->first();

            return response()->json(['product' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
