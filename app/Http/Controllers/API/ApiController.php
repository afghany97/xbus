<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Service;

class ApiController extends Controller
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * ApiController constructor.
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
