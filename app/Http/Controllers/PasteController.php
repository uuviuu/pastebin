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
        $access = Access::getValues();

        if (!Auth::user()) {
            $access = array_diff($access, [Access::PRIVATE]);
        }

        return view('pastes', [
            'langs' => ['PHP','C','C++','C#','Python','JS'],
            'access' => $access,
            'expirationTime' => ExpirationTime::getValues(),
            'lastPastes' => PasteService::lastPastes(),
        ]);
    }

    public function detail(Paste $paste)
    {
        PasteService::checkDetail($paste, Auth::user()['id'] ?? null);
        $paste->paste = br2nl($paste->paste);

        return view('paste_detail', [
            'paste' => $paste,
        ]);
    }

    public function create(CreatePasteRequest $request): RedirectResponse
    {
        $data = [
            'created_by_id' => Auth::user()['id'] ?? null,
            'paste' => nl2br($request->input('paste')),
            'lang' => $request->input('lang'),
            'paste_hash' => Str::random(),
            'access' => $request->input('access'),
        ];

        $expirationTime = $request->input('expirationTime') == ExpirationTime::INFINITELY ? null : $request->input('expirationTime');

        $paste = PasteService::create($data, $expirationTime);

        if (!$paste) {
            return redirect('', 500);
        }

        return redirect()->route('pastes.detail', $paste->paste_hash);
    }
}
