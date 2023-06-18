<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("car_brands.json");
        $brands = json_decode($json);
        foreach ($brands as $key => $value) {
            Brand::create([
                "brand_id" => $value->Make_id,
                "brand_name" => $value->Make_Name,
                "brand_image" => '/storage/Brands/' . $value->url
            ]);
        }
    }
}
