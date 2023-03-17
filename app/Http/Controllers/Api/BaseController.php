<?php

namespace App\Http\Controllers\Api;


use App\Service\PasteService;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $service;

    public function __construct(PasteService $service) {
        $this->service = $service;
    }
}
