<?php

namespace App\Http\Controllers;

use App\Models\Model;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCarBrandModels($brand_id)
    {
        try {
            $models = Model::where('brand_id',$brand_id);
            return $this->success("Models retrived successfully", $models);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
