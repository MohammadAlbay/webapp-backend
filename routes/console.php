<?php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//Scorched prepaid cards
Artisan::command('spc', function() {

})->purpose('Deactivates outdated prepaid cards')->weekly();

Schedule::job(function() {

})->weekly();