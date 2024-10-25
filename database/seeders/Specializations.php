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
        Specialization::create(["name" => "سباكة", "image" => $this->getImage('سباكة')]);
        Specialization::create(["name" => "ميكانيكي سيارات", "image" => $this->getImage("ميكانيكي سيارات")]);
        Specialization::create(["name" => "تكييف وتبريد", "image" => $this->getImage("تكييف وتبريد")]);
        Specialization::create(["name" => "نجارة", "image" => $this->getImage("نجارة")]);
        Specialization::create(["name" => "هندسة مدنية", "image" => $this->getImage("هندسة مدنية")]);
        Specialization::create(["name" => "كهرباء منازل", "image" => $this->getImage("كهرباء منازل")]);
        Specialization::create(["name" => "كهرباء سيارات", "image" => $this->getImage( "كهرباء سيارات")]);
        Specialization::create(["name" => "ميكانيكا عامه", "image" => $this->getImage("ميكانيكا عامه")]);
        Specialization::create(["name" => "صيانة مولدات", "image" => $this->getImage("صيانة مولدات")]);
        Specialization::create(["name" => "بناء", "image" => $this->getImage("بناء")]);
        Specialization::create(["name" => "زراعة", "image" => $this->getImage("زراعة")]);
    }

    private function getImage($s) {
        $path = public_path()."/specializations/$s.png";
        if(file_exists($path))
            return "$s.png";
        else
            return "general.png";
    }
}
