<?php

namespace App\Services\Response\Traits;

use App\Services\Response\ResponseService;
use Illuminate\Support\Facades\App;

trait Responsible
{
    /**
     */
    protected function response(): ResponseService
    {
        return App::make(ResponseService::class);
    }
}
