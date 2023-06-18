<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\AccountStoreRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Models\Account;
use App\Models\User;
use App\Traits\ResponseAPI;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use ResponseAPI;
    
    public function login(AccountStoreRequest $request)
    {
        try {
            $account = Account::where('account_user_name', $request->name)->first();
            if (!$account) {
                $account = new Account();
                $account->account_user_name = $request->name;
                $account->account_phone_number = $request->phone;
                $account->account_fcm_token = [$request->fcm_token];
                $rslt = $account->save();
                if(!$rslt) throw new \Exception("Account Creation Failed", 401);
            }
            $jwt = JWT::encode((array)$account, env("JWT_SECRET"), 'HS256');
            $account->token = $jwt;
            return $this->success("Account Created successfully", $account);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, $id)
    {
        try {
            $account = Account::find($id);
            if (!$account) {
               throw new \Exception("Account Not Found", 404);
            }
            $rslt = array_search($request->old_fcm_token,$account->account_fcm_token);
            if ($rslt === false) {
                throw new \Exception("Old FCM Token Wrong", 404);
             }
            $arrFCMToken = array_diff($account->account_fcm_token, [$request->old_fcm_token]);
            array_push($arrFCMToken,$request->new_fcm_token);
            $account->account_fcm_token = $arrFCMToken;
            $rslt = $account->save();
            if (!$rslt) {
                throw new \Exception("FCM Token Update Failed", 404);
             }
            return $this->success("FCM Token Updated Successfully", $account);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

  
}
