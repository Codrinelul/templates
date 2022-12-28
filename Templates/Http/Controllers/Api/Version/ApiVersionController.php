<?php

namespace Modules\Templates\Http\Controllers\Api\Version;

use JulioMotol\Lapiv\GatewayController;
use Modules\Templates\Http\Controllers\Api\ApiController;

class ApiVersionController extends GatewayController
{
    protected $apiControllers = [
        ApiController::class, // The first version of you API endpoint.
        // Preceeding version implementations...
    ];
}