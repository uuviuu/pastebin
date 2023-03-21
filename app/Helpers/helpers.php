<?php

use App\Http\Responses\ApiJsonResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Arrayable;

if (!function_exists('apiResponse')) {
    /**
     * @return Application|mixed
     */
    function apiResponse()
    {
        return app(ApiJsonResponse::class);
    }
}

if (!function_exists('br2nl')) {
    /**
     * @param $string
     * @return array|string|string[]|null
     */
    function br2nl($string)
    {
        return preg_replace("/\<br(\s*)?\/?\>/i", "", $string);
    }
}

if (!function_exists('translateToCamelCase')) {
    /**
     * @param $jsonData
     * @return array
     */
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
    /**
     * Transforms all keys in json object with transform function
     * Values are returned as is
     *
     * @param $jsonData
     * @param callable $transformFunction
     * @return array
     */
    function translateJsonCase($jsonData, callable $transformFunction): array
    {
        if ($jsonData instanceof Arrayable) {
            $jsonData = $jsonData->toArray();
        }
        if (is_array($jsonData)) {
            $res = array();
            foreach ($jsonData as $key => $value) {
                $key = $transformFunction($key);

                if ($value instanceof Arrayable || is_array($value)) {
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