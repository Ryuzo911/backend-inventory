<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {   
        \Log::info($request->all());
        \Log::info($request->file('image'));
            
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product', 'public');
            $validated["image_url"] = url(Storage::url($path));
        }

        $product = Product::create($validated);

        return response()->json($product->load('category'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product)
    {
        $this->authorize('view', $product);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        \Log::info('Update Request All', $request->all());
        \Log::info('hasImage? ', ['has' => $request->hasFile('image')]);

         $validated = $request->validated();

         if ($request->hasFile('image')) {
             $file = $request->file('image');

             // optional: delete old image
             if ($product->image_url) {
                 $publicPath = str_replace('/storage/', '', parse_url($product->image_url, PHP_URL_PATH));
                 if (Storage::disk('public')->exists($publicPath)) {
                     Storage::disk('public')->delete($publicPath);
                 }
             }
         
             $path = $file->store('product', 'public');
             $validated['image_url'] = url(Storage::url($path));
         }

             $product->update($validated);
             return response()->json($product->load('category'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
