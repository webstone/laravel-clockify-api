<?php

namespace Sourceboat\LaravelClockifyApi\Repositories;

use App\Clockify\Reports\ClockifyDetailedReport;
use App\Clockify\Reports\ClockifySummaryReport;

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
