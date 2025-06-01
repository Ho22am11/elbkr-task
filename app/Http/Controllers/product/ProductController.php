<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\product;
use App\Models\ProductAttechment;
use App\Services\ProductService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    protected $productservice;

    public function __construct(ProductService $productservice)
    {
        $this->productservice = $productservice;
    }

    public function index()
    {
       // $products = Product::all();
    }

 
    public function store(ProductRequest $request)
    {
        $product = $this->productservice->storeProduct($request);

        return $this->ApiResponse(new ProductResource($product), 'Product stored successfully' , 201);
    

    }


    public function show(string $id)
    {
        $product = Product::find($id);
        return $this->ApiResponse(new ProductResource($product), 'Product retrieved successfully' , 200);
    }


    public function update(ProductRequest $request,  $id)
    {
         $product = $this->productservice->updateProduct($request , $id);
         return $this->ApiResponse(new ProductResource($product), 'Product updated successfully' , 200);
    }

    
    public function destroy($id)
    {
        $this->productservice->deleteProduct($id);
        return $this->ApiResponse(null, 'Product deleted successfully' , 200);

    }
}
