<?php

namespace App\Traits;

trait ResponseAPI
{

    public function coreResponse($message, $data = null, $statusCode, $isSuccess = true)
    {
        if(!$message) return response()->json(['message' => 'Message is required'], 500);
        if($isSuccess) {
            return response()->json([
                'message' => $message,
                'isSuccess' => false,
                'statusCode' => $statusCode,
                'data' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'isSuccess' => true,
                'statusCode' => $statusCode,
            ], $statusCode);
        }
    }

 
    public function success($message, $data, $statusCode = 200, $token = null)
    {
        return $this->coreResponse($message, $data, $statusCode);
    }

   
    public function error($message, $statusCode = 500)
    {
        return $this->coreResponse($message, null, $statusCode, false);
    }
}