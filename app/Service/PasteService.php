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

    public static function complaint($pasteHash, $complaint)
    {
        $paste = Paste::findOrFail($pasteHash);
        $paste->complaint_message = $complaint;
        $paste->save();

        return $paste;
    }

    public static function expirationTime($stringTime): ?Carbon
    {
        $addTime = explode(' ', $stringTime);

        return $stringTime == ExpirationTime::INFINITELY ? null
            : Carbon::now()->add(trans('timeIntervals.' . $addTime[1]), $addTime[0]);
    }

    public static function checkDetail($paste, $userId)
    {
        if ($paste->expiration_time < Carbon::now() && $paste->expiration_time != null) {
            abort(404);
        }

        if ($paste->access == Access::PRIVATE) {
            if (!$userId || $userId != $paste->created_by_id) {
                abort(404);
            }
        }
    }
}
