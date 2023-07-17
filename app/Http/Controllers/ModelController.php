<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModelResource;
use App\Models\CarModel;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    
    use ResponseAPI;

    public function getCarBrandModels(Request $request)
    {
        try {
            $models = [];
            if (isset($request->brand_id)) {
                $models = ModelResource::collection(CarModel::where('brand_id',$request->brand_id)->get());
            }
            if (count($models) == 0) {
                return $this->success("There is no models for this brand id",[]);
            }
            return $this->success("Models retrived successfully", $models);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
