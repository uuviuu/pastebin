<?php

namespace App\Http\Controllers;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use App\Http\Requests\CreatePasteRequest;
use App\Models\Paste;
use App\Service\PasteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PasteController extends Controller
{
    public function pastes()
    {
        return view('pastes', [
            'access' => Access::getValues(),
            'expirationTime' => ExpirationTime::getValues(),
            'lastPastes' => PasteService::lastPastes(),
        ]);
    }

    public function detail(Paste $paste)
    {
        if ($paste->access == Access::PRIVATE) {
            $authUserId = Auth::user()['id'] ?? null;
            if (!$authUserId || $authUserId != $paste->created_by_id)
                return redirect()->route('pastes');
        }

        return view('paste_detail', [
            'paste' => $paste,
        ]);
    }

    public function create(CreatePasteRequest $request): RedirectResponse
    {
        $data = [
            'created_by_id' => Auth::user()['id'] ?? null,
            'paste' => $request->input('paste'),
            'locale_lang' => $request->input('locale'),
            'paste_hash' => Str::random(),
            'access' => $request->input('access'),
        ];

        $expirationTime = $request->input('expirationTime') == ExpirationTime::INFINITELY ? null : $request->input('expirationTime');

        $paste = PasteService::create($data, $expirationTime);

        return redirect()->route('pastes.detail', $paste);
    }
}
