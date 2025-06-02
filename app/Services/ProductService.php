<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductAttachement;
use App\Models\ProductAttechment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    
        public function getFilteredProducts(Request $request)
    {
        $products = Product::with('attachements')
        ->withAvg('rates', 'rating')
        ->when($request->filled('campany_id'), function ($query) use ($request) {
            $query->where('campany_id', $request->campany_id);
        })
        ->when($request->filled('category_id'), function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        })
        ->when($request->filled('sort_by'), function ($query) use ($request) {
            $allowedSorts = ['name', 'price', 'id', 'rating'];
            $sortField = in_array($request->sort_by, $allowedSorts) ? $request->sort_by : 'id';
            $sortDir = $request->get('sort_dir', 'asc');

            if ($sortField === 'rating') {
                $query->orderBy('rates_avg_rating', $sortDir);
            } else {
                $query->orderBy($sortField, $sortDir);
            }
        })
        ->paginate(10);

        return [
            'products' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'total_pages'  => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total_items'  => $products->total(),
            ]
        ];
    }
    


    public function storeProduct(Request $request): Product
    {
        $product = Product::create($request->only([
            'name', 'description', 'price', 'campany_id', 'category_id'
        ]));

        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $file) {
                $path = $file->store('product_attachments', 'public');
                ProductAttechment::create([
                    'product_id' => $product->id,
                    'img'        => $path
                ]);
            }
        }

        return $product->load('attachements');
    }

    public function updateProduct(Request $request, string $id)
    {

        $product = Product::find($id);

        $product->update($request->only([
            'name', 'description', 'price', 'campany_id', 'category_id'
        ]));
        
        if ($request->hasFile('img')) {
            foreach ($product->attachements as $attachment) {
            if (Storage::disk('public')->exists($attachment->img)) {
                Storage::disk('public')->delete($attachment->img);
            }
            $attachment->delete();
        }
        
        foreach ($request->file('img') as $file) {
            $path = $file->store('product_attachments', 'public');
            ProductAttechment::create([
                'product_id' => $product->id,
                'img'        => $path
            ]);
        }
        }
    
         return $product->load('attachements');
    
    }



    public function deleteProduct(string $id)
    {
        $product = Product::find($id);

        foreach ($product->attachements as $attachment) {
            if (Storage::disk('public')->exists($attachment->img)) {
                Storage::disk('public')->delete($attachment->img);
            }
            $attachment->delete();
        }
        
        $product->delete();
    }
    
}