<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Car;
use App\Models\CarUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Traits\ResponseAPI;

class AuthController extends Controller
{

    use ResponseAPI;

    public function login(UserLoginRequest $request)
    {
        try {
            $user = User::where('user_phone', $request->user_phone)->first();
            if (!$user) {
                $user = new User();
                $user->user_name = $request->user_name;
                $user->user_phone = $request->user_phone;
                $user->user_fcm_token = [$request->user_fcm_token];
                $rslt = $user->save();
                if(!$rslt) throw new \Exception("user Creation Failed", 401);
            }
            $token = Auth::login($user);
            return $this->success("User logged in successfully", ["token" => $token]);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updateFcmToken(UserUpdateRequest $request)
    {
        try {
            $user = User::find(Auth::id());
            if (!$user) {
               throw new \Exception("User Not Found", 404);
            }
            $arrFCMToken = array_diff($user->user_fcm_token, [$request->old_fcm_token]);
            array_push($arrFCMToken,$request->new_fcm_token);
            $user->user_fcm_token = $arrFCMToken;
            $rslt = $user->save();
            if (!$rslt) {
                throw new \Exception("FCM Token Update Failed", 404);
             }
            return $this->success("FCM Token Updated Successfully", []);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updateUserPhone(Request $request){
        try {
            $carIDs = Car::whereIn('car_topic', $request->car_topics)->get('car_id');
            if (empty($carIDs)) throw new \Exception("wrong car topics", 401);
            $userCarsByCarTopic = CarUser::whereIn('car_id', $carIDs)->where('user_id',Auth::id())->get();
            $userCarsByUserID = CarUser::where('user_id',Auth::id())->get();
            $countOfUserCarsByCarTopics = count($userCarsByCarTopic);
            $countOfUserCarsByUserID = count($userCarsByUserID);
            $countUnAttachedCars = $countOfUserCarsByUserID - $countOfUserCarsByCarTopics;
            if (count($userCarsByCarTopic) == 0) {
                $user = User::where('user_phone', $request->user_phone)->first();
                if(!$user){
                    $user = User::where('user_id', Auth::id())->first();
                    $user->user_phone = $request->user_phone;
                    $rslt = $user->save();
                    if(!$rslt) throw new \Exception("Failed to updated Phone", 401);
                    $token = Auth::login($user);
                    return $this->success("Phone updated successfully",["token" => $token]);
                }
            };
            if (count($userCarsByUserID) == count($request->car_topics)){
                $user = User::where('user_phone', $request->user_phone)->first();
                if(!$user){
                    $user = User::where('user_id', Auth::id())->first();
                    $user->user_phone = $request->user_phone;
                    $rslt = $user->save();
                    if(!$rslt) throw new \Exception("Failed to updated Phone", 401);
                    $token = Auth::login($user);
                    return $this->success("Phone updated successfully",["token" => $token]);
                }
                CarUser::whereIn('car_id', $carIDs)->update([
                    "user_id" => $user->user_id
                ]);
                $token = Auth::login($user);
                return $this->success("All Cars Attached to an existing user", ["token" => $token]);
            }
            $user = User::where('user_phone', $request->user_phone)->first();
            if(!$user){
                $newUser = new User();
                $newUser->user_name = $request->user_name;
                $newUser->user_phone = $request->user_phone;
                $newUser->user_fcm_token = [$request->user_fcm_token];
                $rslt = $newUser->save();
                if(!$rslt) throw new \Exception("user Creation Failed", 401);
                CarUser::whereIn('car_id', $carIDs)->update([
                    "user_id" => $newUser->user_id
                ]);
                $token = Auth::login($newUser);
                return $this->success("New User Created and attached some cars to him, old user has $countUnAttachedCars unattched cars", ["token" => $token]);
            }
            CarUser::whereIn('car_id', $carIDs)->update([
                "user_id" => $user->user_id
            ]);
            $token = Auth::login($user);
            return $this->success("some Cars Attached to an existing user, old user has $countUnAttachedCars unattched cars", ["token" => $token]);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }      
    }
}