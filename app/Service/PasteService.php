<?php

namespace App\Service;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use App\Models\Paste;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PasteService
{
    public static function lastPastes()
    {
        return Paste::where(function ($query) {
                $query->whereNull('expiration_time')
                    ->orWhere('expiration_time', '>=', Carbon::now());
            })
            ->where('access', Access::PUBLIC)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
    }

    public static function create($data, $expirationTime=null)
    {
        $paste = null;
        try {
            if ($expirationTime) {
                $data['expiration_time'] = self::expirationTime($expirationTime);
            }

            $paste = Paste::firstOrCreate($data);

        } catch (\Exception $e) {
            Log::info('Paste update error: ' . $e->getMessage());
        }

        return $paste;
    }

    public static function expirationTime($stringTime): ?Carbon
    {
        $addTime = explode(' ', $stringTime);

        return $stringTime == ExpirationTime::INFINITELY ? null
            : Carbon::now()->add(trans('timeIntervals.' . $addTime[1]), $addTime[0]);
    }
}
