<?php

namespace App\Enums;

use Illuminate\Support\Facades\Log;
use ReflectionClass;

abstract class Enum
{
    /**
     * @return array
     */
    public static function getValues(): array
    {
        return array_values(static::getConstants());
    }

    /**
     * @return array
     */
    public static function getConstants(): array
    {
        $constants = [];

        try {
            $rfClass = new ReflectionClass(static::class);
            $constants = $rfClass->getConstants();
        } catch (\Exception $e) {
            Log::info($e->getTraceAsString());
        }

        return $constants;
    }
}