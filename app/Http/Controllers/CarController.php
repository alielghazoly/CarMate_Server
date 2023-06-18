<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Device;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function create(Request $request) { 
        try {
            $car = new Car();
            $car_topic = $this->constructCarTopic($request->device_id, $car);
            $rslt = $device->save();
            if(!$rslt) throw new \Exception("Device Creation Failed", 401);
            return $this->success("Device Created Successfully", $device);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }      
    }

    protected function constructCarTopic($device_id, $car){
            $device = Device::where('device_random_id', $device_id)->first();
            if (!$device) throw new \Exception("Device Creation Failed", 401);
            $car = $device->device_mqtt_topic . strtoupper(bin2hex(sprintf('%04s', $car->getNextId()))) . 
            return $bytes;
    }
}
