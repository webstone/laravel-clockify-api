<?php

namespace Sourceboat\LaravelClockifyApi\Reports;

use Carbon\Carbon;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Support\Facades\Http;

abstract class ClockifyReport
{

    use ConditionallyLoadsAttributes;

    private const REPORTS_ENDPOINT = 'https://reports.api.clockify.me/v1';

    protected $userIds = null;

    protected $tagIds = null;

    protected $taskIds = null;

    protected Carbon $dateRangeStart;

    protected Carbon $dateRangeEnd;

    protected string $reportEndpoint = '';

    protected string $sortOrder = '';

    private array $headers = [];

    private string $workspaceId = '';

    abstract public function get();

    abstract protected function requestData();

    /**
     * Create a new resource instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dateRangeStart = now()->startOfYear();
        $this->dateRangeEnd = now()->endOfYear();
        $this->headers = [
            'X-Api-Key' => config('clockify.api_key'),
        ];
        $this->workspaceId = config('clockify.workspace_id');
    }

    public static function make()
    {
        return new static;
    }

    public function executeApiCall()
    {
        $endpoint = '/workspaces/' . $this->workspaceId . '/reports' . $this->reportEndpoint;

        return Http::withHeaders($this->headers)->post(
            self::REPORTS_ENDPOINT . $endpoint,
            $this->requestData(),
        );
    }

    public function users(array $userIds)
    {
        $this->userIds = $userIds;
        return $this;
    }

    public function tags(array $tagIds)
    {
        $this->tagIds = $tagIds;
        return $this;
    }

    public function tasks(array $taskIds)
    {
        $this->taskIds = $taskIds;
        return $this;
    }

    public function from(Carbon $fromDate)
    {
        $this->dateRangeStart = $fromDate;
        return $this;
    }

    public function to(Carbon $endDate)
    {
        $this->dateRangeEnd = $endDate;
        return $this;
    }

    public function sortOrder(string $sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

}
