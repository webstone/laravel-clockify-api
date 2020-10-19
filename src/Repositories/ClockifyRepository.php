<?php

namespace Sourceboat\LaravelClockifyApi\Repositories;

use Sourceboat\LaravelClockifyApi\Reports\ClockifyDetailedReport;
use Sourceboat\LaravelClockifyApi\Reports\ClockifySummaryReport;

class ClockifyRepository
{

    public static function makeSummaryReport()
    {
        return ClockifySummaryReport::make();
    }

    public static function makeDetailedReport()
    {
        return ClockifyDetailedReport::make();
    }

}
