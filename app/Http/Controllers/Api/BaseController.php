<?php

namespace App\Http\Controllers\Api;


use App\Service\BookService;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $service;

    public function __construct(BookService $service) {
        $this->service = $service;
    }
}
