<?php

namespace Sourceboat\LaravelClockifyApi\Reports;

class ClockifyDetailedReport extends ClockifyReport
{

    protected string $reportEndpoint = '/detailed';

    private int $page = 1;

    private int $pageSize = 50;

    public function get()
    {
        return json_decode($this->executeApiCall()->body());
    }

    public function page(int $page)
    {
        $this->page = $page;
        return $this;
    }

    public function pageSize(int $pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    protected function requestData()
    {
        return $this->filter((array) [
            'dateRangeStart' => $this->dateRangeStart,
            'dateRangeEnd' => $this->dateRangeEnd,
            'detailedFilter' => [
                'page' => $this->page,
                'pageSize' => $this->pageSize,
                'sortColumn' => 'DATE',
            ],
            $this->mergeWhen($this->sortOrder !== '', [
                'sortOrder' => $this->sortOrder,
            ]),
            $this->mergeWhen(!is_null($this->userIds), [
                'users' => [
                    'ids' => $this->userIds,
                    'contains' => 'CONTAINS',
                    'status' => 'ALL',
                ],
            ]),
            $this->mergeWhen(!is_null($this->tagIds), [
                'tags' => [
                    'ids' => $this->tagIds,
                    'containedInTimeentry' => $this->tagsContainedInTimeentry,
                    'status' => 'ALL',
                ],
            ]),
            $this->mergeWhen(!is_null($this->taskIds), [
                'tasks' => [
                    'ids' => $this->taskIds,
                    'status' => 'ALL',
                ],
            ]),
        ]);
    }

    public static function make()
    {
        return new static;
    }

}
