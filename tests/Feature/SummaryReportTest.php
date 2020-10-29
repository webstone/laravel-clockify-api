<?php

namespace Sourceboat\LaravelClockifyApi\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Sourceboat\LaravelClockifyApi\Repositories\ClockifyRepository;
use Sourceboat\LaravelClockifyApi\Tests\TestCase;

class SummaryReportTest extends TestCase
{

    /**
     * @dataProvider provider
     */
    public function test(array $requestAtt, $expected): void
    {
        Http::fake();

        $summaryReport = ClockifyRepository::makeSummaryReport();

        // add attributes to request by calling its function (defined by keys)
        collect($requestAtt)->each(function ($value, $attribute) use ($summaryReport) {
            $summaryReport->{$attribute}($value);
        });

        $summaryReport->get();

        Http::assertSent(function ($request) use ($expected) {
            return $request->body() === json_encode($expected);
        });
    }

    public function provider()
    {
        $users = [1, 2, 3];
        $tasks = [4, 5, 6];
        $tagIds = [7, 8, 9];
        $defaultFilterGroups = [
            0 => 'USER',
            1 => 'PROJECT',
            2 => 'TIMEENTRY',
        ];
        $customFilterGroups =  [
            0 => 'USER',
            1 => 'TASK',
            2 => 'TAG'
        ];
        $defaultStart = now()->startOfYear()->toISOString();
        $defaultEnd = now()->endOfYear()->toISOString();
        $from = now();
        $to = now()->addWeek();

        return [
            'Users' => [
                [
                    'users' => $users,
                ],
                [
                    'dateRangeStart' => $defaultStart,
                    'dateRangeEnd' => $defaultEnd,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                ]
            ],
            'User, tasks' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                ],
                [
                    'dateRangeStart' => $defaultStart,
                    'dateRangeEnd' => $defaultEnd,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
            'Users, tasks, sortOrder' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                    'sortOrder' => 'ASCENDING'
                ],
                [
                    'dateRangeStart' => $defaultStart,
                    'dateRangeEnd' => $defaultEnd,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'sortOrder' => 'ASCENDING',
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
            'Users, tasks, sortOrder, from' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                    'sortOrder' => 'ASCENDING',
                    'from' => $from
                ],
                [
                    'dateRangeStart' => $from,
                    'dateRangeEnd' => $defaultEnd,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'sortOrder' => 'ASCENDING',
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
            'Users, tasks, sortOrder, from, to' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                    'sortOrder' => 'ASCENDING',
                    'from' => $from,
                    'to' => $to
                ],
                [
                    'dateRangeStart' => $from,
                    'dateRangeEnd' => $to,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'sortOrder' => 'ASCENDING',
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
            'Users, tasks, sortOrder, from, to, containsTags' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                    'sortOrder' => 'ASCENDING',
                    'from' => $from,
                    'to' => $to,
                    'containsTags' => $tagIds,
                ],
                [
                    'dateRangeStart' => $from,
                    'dateRangeEnd' => $to,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'sortOrder' => 'ASCENDING',
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tags' => [
                        'ids' => $tagIds,
                        'containedInTimeentry' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
            'Users, tasks, sortOrder, from, to, containsOnlyTags' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                    'sortOrder' => 'ASCENDING',
                    'from' => $from,
                    'to' => $to,
                    'containsOnlyTags' => $tagIds,
                ],
                [
                    'dateRangeStart' => $from,
                    'dateRangeEnd' => $to,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'sortOrder' => 'ASCENDING',
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tags' => [
                        'ids' => $tagIds,
                        'containedInTimeentry' => 'CONTAINS_ONLY',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
            'Users, tasks, sortOrder, from, to, doesNotContainTags' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                    'sortOrder' => 'ASCENDING',
                    'from' => $from,
                    'to' => $to,
                    'doesNotContainTags' => $tagIds,
                ],
                [
                    'dateRangeStart' => $from,
                    'dateRangeEnd' => $to,
                    'summaryFilter' => [
                        'groups' => $defaultFilterGroups,
                    ],
                    'sortOrder' => 'ASCENDING',
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tags' => [
                        'ids' => $tagIds,
                        'containedInTimeentry' => 'DOES_NOT_CONTAIN',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
            'Users, tasks, sortOrder, from, to, containsTags, custom filterGroups' => [
                [
                    'users' => $users,
                    'tasks' => $tasks,
                    'sortOrder' => 'ASCENDING',
                    'from' => $from,
                    'to' => $to,
                    'containsTags' => $tagIds,
                    'filterGroups' => $customFilterGroups,
                ],
                [
                    'dateRangeStart' => $from,
                    'dateRangeEnd' => $to,
                    'summaryFilter' => [
                        'groups' => $customFilterGroups,
                    ],
                    'sortOrder' => 'ASCENDING',
                    'users' => [
                        'ids' => $users,
                        'contains' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tags' => [
                        'ids' => $tagIds,
                        'containedInTimeentry' => 'CONTAINS',
                        'status' => 'ALL',
                    ],
                    'tasks' => [
                        'ids' => $tasks,
                        'status' => 'ALL',
                    ],
                ]
            ],
        ];
    }

}
