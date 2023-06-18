<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("car_models.json");
        $models = json_decode($json);
        foreach ($models as $key => $value) {
            Model::create([
                "model_name" => $value->Model_Name,
                "brand_id" => $value->Id
            ]);
        }
    }
    
}
