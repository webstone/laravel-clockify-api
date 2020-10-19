<?php

namespace Sourceboat\LaravelClockifyApi\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Sourceboat\LaravelClockifyApi\Repositories\ClockifyRepository;
use Sourceboat\LaravelClockifyApi\Tests\TestCase;

class SummaryReportTest extends TestCase
{

    private array $userIds = [1, 2, 3];

    public function test(): void
    {
        Http::fake();

        ClockifyRepository::makeSummaryReport()
            ->users($this->userIds)
            ->get();

        Http::assertSent(function ($request) {
            return count($request['users']['ids']) === count($this->userIds);
        });
    }

}
