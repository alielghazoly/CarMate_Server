<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\CarCreateRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\CarUser;
use App\Models\Device;
use App\Models\User;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    use ResponseAPI;

    const USER_TYPE_OWNER = 'owner';
    

    public function store(CarCreateRequest $request) { 
        try {
            $car = $this->getCarByDeviceID($request->device_id);
            if ($car)  $rslt = $car->delete();
            $car = new Car();
            $car_topic = $this->constructCarTopic($request->device_id, $car);
            $device = $this->getDeviceByRandomlyGeneratedID($request->device_id);
            $car->device_id = $device->device_id;
            $car->car_topic = $car_topic;
            $car->model_id = $request->model_id;
            $car->car_year = $request->car_year;
            $car->car_color = $request->car_color; 
            $car->car_sim = $request->car_sim?? null;
            $file = $request->file('car_image')??null;
            if (isset($file)) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('Cars', $fileName, 'public');
                $car->car_image = '/storage/' . $filePath;
            } else {
                $car->car_image = null;
            }
            $rslt = $car->save();
            if(!$rslt) throw new \Exception("Car Creation Failed", 401);
            $car->users()->attach(Auth::id(),[
                'user_type' => $request->user_type??self::USER_TYPE_OWNER,
                'user_app_id' => $request->user_app_id??null,
            ]);
            return $this->success("Car Created successfully",  $car );
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }      
    }

    public function get(Request $request){
        try {
            if (isset($request->device_id) && !isset($request->car_topic)) {
                $car = $this->getCarByDeviceID($request->device_id);
                if (!$car)  throw new \Exception("Failed to load car", 401);
                return $this->success("Car Retreived successfully", new CarResource($car));
            } elseif(!isset($request->device_id) && isset($request->car_topic) && isset($request->user_app_id)) {
                $car = Car::where('car_topic', $request->car_topic)->first();
                if (!$car)  throw new \Exception("Failed to load car", 401);
                $carUser = CarUser::where('user_app_id', $request->user_app_id)->first();
                if ($carUser) {
                    $carUser->user_id = Auth::id();
                    $carUser->save();
                } else {
                    $car->users()->attach(Auth::id(),[
                        'user_type' => $request->user_type??'user',
                        'user_app_id' => $request->user_app_id??null,
                    ]);
                }
                return $this->success("Car Retreived successfully", new CarResource($car));
            }
            throw new \Exception("Failed to load car", 401);

        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }      
    }


    public function updateCarSim(Request $request){
        try {
            if (isset($request->car_sim)) {
                $car = Car::where('car_id', $request->car_id)->first();
                if (!$car)  throw new \Exception("Failed to load car", 401);
                $car->car_sim = $request->car_sim;
                $rslt = $car->save();
                if (!$rslt) throw new \Exception("Failed to update car", 401);
                return $this->success("Car updated successfully", new CarResource($car));
            } 
            throw new \Exception("missing car_sim param", 401);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }      
    }

    
    public function sync(Request $request){
        try {
            $carID = $request->car_id;
            $carUserSync = $request->car_users;
            $userAppIDs = [];
            return $carUserSync;
            foreach($carUserSync as $objCarUser){
                $userAppIDs[$objCarUser->user_app_id] = $objCarUser->user_type;
            }
            $carUserDB = CarUser::where('car_id', $carID)->get();
            foreach($carUserDB as $objCarUser){
                if ($objCarUser->user_type != self::USER_TYPE_OWNER && array_key_exists($objCarUser->user_app_id, $userAppIDs)) {
                    $objCarUser->user_type = $userAppIDs[$objCarUser->user_app_id];
                    $objCarUser->save();
                } else {

                }
            }
         return ;
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }      
    }

    
    protected function getDeviceByRandomlyGeneratedID($device_random_id){
        $device = Device::where('device_random_id', $device_random_id)->first();
        return $device;
    }

    protected function getCarByDeviceID($device_random_id){
        $device = $this->getDeviceByRandomlyGeneratedID($device_random_id);
        $car = Car::where('device_id', $device->device_id)->first();
        if (!$car) return false;
        return $car;
    }

    protected function constructCarTopic($device_random_id, $car){
        $device = $this->getDeviceByRandomlyGeneratedID($device_random_id);
        $car_id = sprintf('%08s',decbin($car->getNextId()));
        $random_bytes = $this->generateRandomHexa(2);
        $device_mqtt_topic = $device->device_mqtt_topic ;
        return $device_mqtt_topic . $car_id . $random_bytes;
    }

    protected function generateRandomHexa($length, $col = null){
        $bytes = random_bytes($length);
        $bytes = strtoupper(bin2hex($bytes));
        if (is_string($col)) {
            $device = Car::where($col, $bytes)->first();
            if ($device) $this->generateRandomHexa($length, $col);
        }
        return $bytes;
    }
}
