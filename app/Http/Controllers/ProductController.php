<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Exception;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Products/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'productName' => 'required | max:255',
            'categories' => 'required | max:255',
            'description' => 'required | max:255',
            'date' => 'required | date',
            'time' => 'required',
            'images' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $productID = DB::table('products')
                ->insertGetId(
                    [
                        'name' => $request->productName,
                        'category' => $request->categories,
                        'description' => $request->description,
                        'date' => $request->date,
                        'time' => $request->time,
                    ]
                );

            foreach ($request->images as  $key => $image) :

                $imageName = $key . '-' . $image->getClientOriginalName() . time() . '.' . $image->extension();
                $imagePath = $image->move(public_path('images'), $imageName);

                DB::table('photos')
                    ->insert([
                        'product_id' => $productID,
                        'images_path' => $imageName
                    ]);
            endforeach;

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'product has been inserted'], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Products/edit', ['paramsID' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'productName' => 'required | max:255',
            'categories' => 'required | max:255',
            'description' => 'required | max:255',
            'date' => 'required | date',
            'time' => 'required'
        ]);

        try {
            DB::beginTransaction();

            DB::table('products')
                ->where('id', $id)
                ->update(
                    [
                        'name' => $request->productName,
                        'category' => $request->categories,
                        'description' => $request->description,
                        'date' => $request->date,
                        'time' => $request->time,
                    ]
                );

            if ($request->images && count($request->images) > 0) {
                foreach ($request->images as  $key => $image) :
                    // DELETE THE PREVIOUS PHOTO FIRST
                    $product = Product::findOrFail($id);

                    $product->photos()->get(['images_path'])->each(function ($photo) {

                        File::delete(public_path('images/' . $photo->images_path));
                    });

                    $product->photos()->delete();

                    $imageName = $key . '-' . $image->getClientOriginalName() . time() . '.' . $image->extension();
                    $image->move(public_path('images'), $imageName);

                    Photo::updateOrInsert(
                        ['product_id' => $id],
                        ['images_path' => $imageName]
                    );
                endforeach;
            }


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'product has been updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {

            DB::beginTransaction();

            $product = Product::findOrFail($id);

            $product->photos()->get(['images_path'])->each(function ($photo) {

                File::delete(public_path('images/' . $photo->images_path));
            });

            $product->photos()->delete();
            $product->delete();

            DB::commit();
            return response()->json(['message' => 'Product has been deleted']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
