<?php

namespace Tests\Unit;

use App\Services\FunctionService;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_convert_usd_to_eur_successful()
    {
        $this->assertEquals(98, (new FunctionService)->convert(100, 'usd', 'eur'));
    }

    public function test_convert_usd_to_gbp_returnz_zero()
    {
        $this->assertEquals(0, (new FunctionService)->convert(100, 'usd', 'gpd'));
    }
}
