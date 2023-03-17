<?php

use App\Http\Responses\ApiJsonResponse;

if (!function_exists('apiResponse')) {
    function apiResponse()
    {
        return app(ApiJsonResponse::class);
    }
}

if (!function_exists('translateToCamelCase')) {
    function translateToCamelCase($jsonData): array
    {
        return translateJsonCase($jsonData, function ($key) {
            return preg_replace_callback("/_+([a-z])/i", function ($matches) {
                return strtoupper($matches[1]);
            }, $key);
        });
    }
}

if (!function_exists('translateJsonCase')) {
    function translateJsonCase($jsonData, callable $transformFunction): array
    {
        if ($jsonData) {
            $jsonData = $jsonData->toArray();
        }
        if (is_array($jsonData)) {
            $res = array();
            foreach ($jsonData as $key => $value) {
                $key = $transformFunction($key);

                if ($value || is_array($value)) {
                    $res[$key] = translateJsonCase($value, $transformFunction);
                } else {
                    $res[$key] = $value;
                }
            }
            return $res;
        } else {
            return $transformFunction($jsonData);
        }
    }
}