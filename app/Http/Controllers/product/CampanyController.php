<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampanyRequest;
use App\Models\campany;
use App\Services\CampanyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CampanyController extends Controller
{
    use ApiResponseTrait ;
    protected $campanyService;

    public function __construct(CampanyService $campanyService)
    {
        $this->campanyService = $campanyService;
    }

    public function index()
    {
        $campany = campany::all();
        return $this->ApiResponse($campany , 'Categories retrieved successfully.' , 200);

    }

    
    public function store(StoreCampanyRequest $request, CampanyService $campany)
    {
        $campany_data = $this->campanyService->store($request);
        
        return $this->ApiResponse($campany_data , 'Category stored successfully' , 201);
        
    }

    public function update(StoreCampanyRequest $request, $id , CampanyService $service)
    {

        $updatedCampany = $this->campanyService->update($request, $id);
        
        return $this->ApiResponse($updatedCampany, 'Category updated successfully', 200);
    }
    

    public function destroy($id)
    {
       $this->campanyService->delete($id);
        return $this->ApiResponse(null, 'Category deleted successfully', 200);

    }
}
