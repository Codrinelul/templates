<?php
namespace Modules\Templates\Helpers\RemoteApi;

use App\Services\CacheService as Base;

class CacheService extends Base
{
    public function __construct($prefix = '')
    {
        parent::__construct('api', $prefix);
    }

}
