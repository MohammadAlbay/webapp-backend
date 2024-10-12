<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Specializations extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Specialization::create(["name" => "سباكة"]);
        Specialization::create(["name" => "لحام"]);
        Specialization::create(["name" => "تكييف وتبريد"]);
        Specialization::create(["name" => "نجارة"]);
        Specialization::create(["name" => "هندسة مدنية"]);
        Specialization::create(["name" => "كهرباء منازل"]);
        Specialization::create(["name" => "كهرباء سيارات"]);
        Specialization::create(["name" => "ميكانيكا عامه"]);
        Specialization::create(["name" => "صيانة مولدات"]);
        Specialization::create(["name" => "بناء"]);
        Specialization::create(["name" => "زراعة"]);
    }
}
