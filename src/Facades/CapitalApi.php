<?php


namespace OtoKapanadze\CapitalApi\Facades;

use Illuminate\Support\Facades\Facade;

class CapitalApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'capital-api-service';
    }
}
