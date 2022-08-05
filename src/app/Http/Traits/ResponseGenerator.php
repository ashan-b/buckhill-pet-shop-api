<?php

namespace App\Http\Traits;

use Response;

trait ResponseGenerator
{
    public function sendSuccess($data, $extra = [])
    {
        return Response::json(
            [
                'success' => 1,
                'data' => $data,
                "error" => null,
                "errors" => [],
                "extra" => $extra,
            ],
            200
        );
    }

    public function sendError($error, $errors, $trace, $httpStatusCode = 200)
    {
        return Response::json(
            [
                'success' => 0,
                'data' => [],
                "error" => $error,
                "errors" => $errors,
                "trace" => $trace
            ],
            $httpStatusCode
        );
    }
}
