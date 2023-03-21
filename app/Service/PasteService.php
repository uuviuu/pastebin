<?php

namespace App\Service;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use App\Http\Requests\CreatePasteRequest;
use App\Models\Paste;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PasteService
{
    /**
     * @return Collection
     */
    public static function lastPastes(): Collection
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

    /**
     * @param array $data
     * @param string|null $expirationTime
     * @return Paste|null
     */
    public static function create(array $data, string $expirationTime=null): ?Paste
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

    /**
     * @param CreatePasteRequest $request
     * @param int|null $user_id
     * @return array
     */
    public static function createData(CreatePasteRequest $request, int $user_id=null): array
    {
        return [
            'created_by_id' => $user_id,
            'paste' => nl2br($request->input('paste')),
            'lang' => $request->input('lang'),
            'paste_hash' => Str::random(),
            'access' => $request->input('access'),
        ];
    }

    /**
     * @param string $pasteHash
     * @param string $complaint
     * @return Paste
     */
    public static function complaint(string $pasteHash, string $complaint): Paste
    {
        $paste = Paste::findOrFail($pasteHash);
        $paste->complaint_message = $complaint;
        $paste->save();

        return $paste;
    }

    /**
     * @param string $stringTime
     * @return Carbon|null
     */
    public static function expirationTime(string $stringTime): ?Carbon
    {
        $addTime = explode(' ', $stringTime);

        return $stringTime == ExpirationTime::INFINITELY ? null
            : Carbon::now()->add(trans('timeIntervals.' . $addTime[1]), (int) $addTime[0]);
    }

    /**
     * @param Paste $paste
     * @param int $userId
     * @return void
     */
    public static function checkDetail(Paste $paste, int $userId): void
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
