<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\BrandCreateRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ResponseAPI;
    /**
     * Display a listing of the resource.
     */
    public function getAllBrands()
    {
        try {
            $brands = BrandResource::collection(Brand::all());
            return $this->success("Brands retrived successfully", $brands);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandCreateRequest $request)
    {
        try {
            $brand = new Brand();
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('Brands', $fileName, 'public');
            $brand->brand_image = '/storage/' . $filePath;
            $brand->brand_name = $request->name;
            $rslt = $brand->save();
            if(!$rslt) throw new \Exception("Brand Creation Failed", 401);
            return $this->success("Brand Created successfully", $brand);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

}
