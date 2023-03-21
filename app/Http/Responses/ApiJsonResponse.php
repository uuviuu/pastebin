<?php

namespace App\Http\Responses;

use App\Exceptions\CustomException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiJsonResponse
{
    protected $statusCode;

    /**
     * @param string $data
     * @return JsonResponse
     */
    public function success(string $data = ''): JsonResponse
    {
        $responseJsonData = [
            'status' => 'success',
            'data' => $data
        ];

        $this->statusCode = 200;

        return response()->json(translateToCamelCase($responseJsonData), $this->statusCode);
    }

    /**
     * @param string $message
     * @param $code
     * @param $exception
     * @param array $info
     * @return JsonResponse
     */
    public function error(string $message = '', $code = null, $exception = null, array $info = []): JsonResponse
    {
        $headers = [];
        $responseJsonData = [
            'status' => 'error',
            'data' => array_merge([
                'message' => $message,
            ], $info)
        ];
        if ($exception) {
            $responseJsonData['data']['exception'] = $exception;
        }

        if ($message instanceof ValidationException) {
            $responseJsonData['data'] = array_merge([
                'message' => $message->validator->errors()->first(),
                'debugInfo' => $message->getMessage(),
                'exception' => (new \ReflectionClass($message))->getShortName()
            ], $info);
        } elseif ($message instanceof CustomException) {
            $headers = $message->getHeaders();
            if (is_null($code))
                $code = $message->getStatusCode();
            $responseJsonData['data'] = array_merge([
                'message' => $message->getText(),
                'debugInfo' => $message->getDebugInfo(),
                'exception' => (new \ReflectionClass($message))->getShortName()
            ], $info);
        } elseif ($message instanceof Exception) {
            $responseJsonData['data'] = array_merge([
                'message' => $message->getMessage(),
                'exception' => (new \ReflectionClass($message))->getShortName()
            ], $info);
        }

        return response()->json(translateToCamelCase($responseJsonData), $code ?? 400, $headers);
    }
}