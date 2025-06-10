<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use ApiResponseTrait ;
    public function index()
    {
        $offer = Offer::latest()
        ->get();

         return $this->ApiResponse(  OfferResource::collection($offer) , 'offer retrive successfully', 200);


    }


    public function store(OfferRequest $request)
    {
         $offer = Offer::create($request->all());


        return $this->ApiResponse( new OfferResource($offer) , 'offer stored successfully', 201);

    }


    public function show(string $id)
    {
         $offer = Offer::find($id);
        return $this->ApiResponse( new OfferResource($offer) , 'offer retrive successfully', 201);


    }



    public function update(OfferRequest $request,  $id)
    {
        $offer = Offer::find($id);
        $offer->update($request->all());
        return $this->ApiResponse( new OfferResource($offer) , 'offer updated successfully', 201);

    }


    public function destroy(string $id)
    {
        Offer::destroy($id);
         return $this->ApiResponse(null , 'offer deleted successfully', 201);

    }
}
