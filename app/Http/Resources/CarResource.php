<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array
    {
        return [
            'car_id' => $this->car_id,
            'car_topic' => $this->car_topic,
            "car_image" => $this->car_image,
            "car_sim" => $this->car_sim,
            "car_year" => $this->car_year,
            "car_color" => $this->car_color,
            "model_id" => $this->model_id,
            "device_id" => $this->device_id,
        ];
    }
}
