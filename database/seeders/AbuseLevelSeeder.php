<?php

namespace Database\Seeders;

use App\Models\AbuseLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbuseLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abuseLevel = [
            ["abuse_level" => "Prone to abuse"],
            ["abuse_level" => "Moderate abused"],
            ["abuse_level" => "Severely abused"],
        ];
        
        foreach($abuseLevel as $data){
            AbuseLevel::create($data);
        }
    }
}
