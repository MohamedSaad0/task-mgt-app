<?php

namespace App\Traits;

trait HttpResponses
{
    protected function sucess($data, $message = null, $code = 200)
    {
        return response()->json([
            "status" => "Successful Request",
            "message" => $message,
            "data" => $data
        ], $code);
    }

    protected function error($data, $message = null, $code)
    {
        return response()->json([
            "status" => "Bad Request",
            "message" => $message,
            "data" => $data
        ], $code);
    }
}
