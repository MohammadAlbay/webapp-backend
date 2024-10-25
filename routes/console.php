<?php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


function success($a) {
    Log::info("Process successfuly terminated ($a)");
};

function failure($a) {
    Log::error("Process terminated with error ($a)");
}

Schedule::command('subscriptions:check')
    ->onFailure(fn() => failure("subscriptions:check"))
    ->onSuccess(fn() => success("subscriptions:check"))
    ->everySixHours();

Schedule::command('outdated-prepaidcards:check')
    ->onFailure(fn() => failure("outdated-prepaidcards:check"))
    ->onSuccess(fn() => success("outdated-prepaidcards:check"))
    ->twiceDaily();



Schedule::command('outdated-reservations:check')
    ->onFailure(fn() => failure("outdated-prepaidcards:check"))
    ->onSuccess(fn() => success("outdated-prepaidcards:check"))
    ->daily();