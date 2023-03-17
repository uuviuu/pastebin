<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePasteRequest;
use App\Orchid\Screens\PlatformScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PasteController extends PlatformScreen
{
//    public function pastes()
//    {
//        $this->layout();
//        return view('include.pastes');
//    }

//    public function send_form(Request $request) {
//        $postArray = array(
//            "name"  =>  $request->name,
//            "number"  =>  $request->number,
//            "email" => $request->email,
//            "message" => $request->message,
//        );
//        Mail::to($postArray["email"])->send(new FormMessageToEmail($postArray));
//        Form::create($postArray);
//        return back();
//
//    }

    public function create(CreatePasteRequest $request): RedirectResponse
    {
        log::info('', $request->toArray());
//        throw new WhiteListRegisterIpNotFound($request->input('id'));
//        if (Auth::user()) {
//
//        }
        return redirect()->back();
    }
}
