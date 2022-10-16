<?php

namespace Database\Seeders;

use App\Models\ElderlyAbuseTestOption;
use App\Models\ElderlyTestOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElderlyTestOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            [
                "option" => "More than once",
                "score" => "3"
            ],
            [
                "option" => "Once",
                "score" => "2"
            ],
            [
                "option" => "Never",
                "score" => "1"
            ],
        ];

        foreach($options as $option) {
            ElderlyTestOption::create($option);
        };
    }
}
