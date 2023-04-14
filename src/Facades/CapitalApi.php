<?php


namespace OtoKapanadze\CapitalApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void authenticate()
 * @method static array ping()
 * @method static array serverTime()
 * @method static array createPosition(string $epic, string $direction, int $size, array $options = [])
 * @method static array getAllPositions()
 *
 * @see \OtoKapanadze\CapitalApi\CapitalApiService
 */
class CapitalApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'capital-api-service';
    }
}
