<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductAttachement;
use App\Models\ProductAttechment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService
{
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