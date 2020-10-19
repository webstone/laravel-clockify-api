<?php

namespace Sourceboat\LaravelClockifyApi\Reports;

class ClockifySummaryReport extends ClockifyReport
{

    protected string $reportEndpoint = '/summary';

    private array $filterGroups = [
        'USER',
        'PROJECT',
        'TIMEENTRY',
    ];

    public function get()
    {
        return json_decode($this->executeApiCall()->body());
    }

    protected function requestData()
    {
        return $this->filter((array) [
            'dateRangeStart' => $this->dateRangeStart,
            'dateRangeEnd' => $this->dateRangeEnd,
            'summaryFilter' => [
                'groups' => $this->filterGroups,
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
                    'containedInTimeentry' => 'CONTAINS',
                    'status' => 'ALL',
                ],
            ]),
        ]);
    }

    public function filterGroups(array $filterGroups)
    {
        $this->filterGroups = $filterGroups;
        return $this;
    }

    public static function make()
    {
        return new static;
    }

}
