# Laravel Clockify API WIP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sourceboat/laravel-clockify-api.svg?style=flat-square)](https://packagist.org/packages/sourceboat/laravel-clockify-api)
[![Build Status](https://img.shields.io/travis/sourceboat/laravel-clockify-api/develop.svg?style=flat-square)](https://travis-ci.org/sourceboat/laravel-clockify-api)
[![Total Downloads](https://img.shields.io/packagist/dt/sourceboat/laravel-clockify-api.svg?style=flat-square)](https://packagist.org/packages/sourceboat/laravel-clockify-api)

Laravel repository to fetch reports from the Clockify.me reports API.

Official clockify API: https://clockify.me/developers-api

## Installation

1. You can install the package via composer: 

    `composer require sourceboat/laravel-clockify-api`

    Optional: The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:

    ```
    'providers' => [
        // ...
        Sourceboat\LaravelClockifyApi\LaravelClockifyApiServiceProvider::class,
    ];
    ```

2. You should publish the config/clockify.php config file with:

    `php artisan vendor:publish --provider="Sourceboat\LaravelClockifyApi\LaravelClockifyApiServiceProvider"`

3. Configure `.env` 

    Add your clockify attributes to your `.env`
    ```
    CLOCKIFY_API_KEY=1234567890
    CLOCKIFY_WORKSPACE_ID=1234567890
    ```

## Usage

### Basically 

You can get a report by creating a report and calling the `get()` function.

```
$summaryResponseBody = ClockifyRepository::makeSummaryReport()->get();
$detailedResponseBody = ClockifyRepository::makeDetailedReport()->get();
```

### Specialized usage

You can further specify the request data by calling the corresponding functions.

The order of the function calls does not matter, except the `get()`-function call. This function has to be the last function which gets called. It represents the executer function and executes the request itself.

#### Example

The following example requests an summary report for user USER_ID_1 and USER_ID_2, from two days ago until today. The results will be sorted ascending. 

```
$summaryResponseBody = ClockifyRepository::makeSummaryReport()
    ->users([USER_ID_1, USER_ID_2])
    ->from(now()->subDays(2))
    ->to(now())
    ->sortOrder('ASCENDING')
    ->get();
```

### Attributes to specify a request

| Attribute | function | default behaviour or `value` <br>(when not set)| possible for reports |
|---|---|---|---|
| `users` | `users(array $userIds)` | all | ALL |
| `containsTags` | `containsTags(array $tagIds)` | `CONTAINS` | ALL |
| `containsOnlyTags` | `containsOnlyTags(array $tagIds)` | `CONTAINS` | ALL |
| `doesNotContainTags` | `doesNotContainTags(array $tagIds)` | `CONTAINS` | ALL || `tasks` | `tasks(array $taskIds)` | all | ALL |
| `from` | `from(Carbon $fromDate)` | start of current year | ALL |
| `to` | `to(Carbon $endDate)` | end of current year | ALL |
| `sortOrder` | `sortOrder(string $sortOrder)` | `DESCENDING` | ALL |
| `filterGroups` | `filterGroups(array $filterGroups)` | `['USER', 'PROJECT', 'TIMEENTRY']` | ClockifySummaryReport |
| `page` | `page(int $page)`| 1 | ClockifyDetailedReport |  
| `pageSize` | `pageSize(int $pageSize)`| 50 | ClockifyDetailedReport |



## Changelog

Check [releases](https://github.com/sourceboat/laravel-clockify-api/releases) for all notable changes.

## Credits

- [Sebastian Müller](https://github.com/SebastianMueller87)
- [Simon Hansen](https://github.com/krns)
- [All Contributors](https://github.com/sourceboat/laravel-clockify-api/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

