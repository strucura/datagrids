<?php

namespace Strucura\DataGrid\Tests\Normalizers;

use Illuminate\Support\Carbon;
use Strucura\DataGrid\Normalizers\TimezoneNormalizer;
use Strucura\DataGrid\Tests\TestCase;

class TimezoneNormalizerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.timezone' => 'UTC']);
    }

    public function test_converts_iso_8601_to_app_timezone()
    {
        $normalizer = new TimezoneNormalizer;
        $next = function ($value) {
            return $value;
        };

        $isoDate = '2023-10-01T12:00:00Z';
        $expectedDate = Carbon::parse($isoDate)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');

        $result = $normalizer->handle($isoDate, $next);

        $this->assertEquals($expectedDate, $result);
    }

    public function test_does_not_convert_non_iso_8601_dates()
    {
        $normalizer = new TimezoneNormalizer;
        $next = function ($value) {
            return $value;
        };

        $nonIsoDate = '10/01/2023 12:00:00';
        $result = $normalizer->handle($nonIsoDate, $next);

        $this->assertEquals($nonIsoDate, $result);
    }

    public function test_does_not_convert_invalid_dates()
    {
        $normalizer = new TimezoneNormalizer;
        $next = function ($value) {
            return $value;
        };

        $invalidDate = 'invalid-date';
        $result = $normalizer->handle($invalidDate, $next);

        $this->assertEquals($invalidDate, $result);
    }
}
