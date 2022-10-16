<?php

namespace Database\Seeders;

use App\Models\ElderlyAbuseTestQuestion;
use App\Models\ElderlyTestQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElderlyTestQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            ['question'=>'I was forced to work against my will'],		
            ['question'=>'Objects were thrown on me'],		
            ['question'=>'I was slapped and scratched'],		
            ['question'=>'My hair was pulled'],		
            ['question'=>'I was wept with a stick or hard objects'],		
            ['question'=>'I was punched and kicked'],		
            ['question'=>'I was hurt at home'],		
            ['question'=>'My undergarments were intentionally torn'],		
            ['question'=>'I was maliciously touched without my consent'],		
            ['question'=>'I was made to do things I did not want to'],		
            ['question'=>' I was sexually harassed'],		
            ['question'=>'I was forced to perform sexual intercourse'],		
            ['question'=>'I was threatened to hurt people important to me if I refuse to have sexual activities'],		
            ['question'=>'I was forced to replicate sexual behavior from pornographic films and pictures'],		
            ['question'=>'I was maliciously accused of sexual engagement with another man/ woman'],		
            ['question'=>'I was shouted sadistically.'],		
            ['question'=>'I was threatened to get killed'],		
            ['question'=>'Someone caused me emotionally traumatized'],		
            ['question'=>'Somebody hurt my feelings that made me cry'],		
            ['question'=>'Somebody taunted me about my health status'],		
            ['question'=>'I was upset because somebody talked in a way that made me feel shamed and threatened'],		
            ['question'=>'I was excessively insulted and screamed in front of other people/ in public places or in social networking site'],		
            ['question'=>'I felt sad/ shamed/anxious/unhappy that left me upset for long time'],		
            ['question'=>'Somebody made me feel down and helpless'],		
            ['question'=>']Somebody intentionally ignored by not talking and avoiding me'],		
            ['question'=>'Somebody accused me for the things I did not do'],		
            ['question'=>'Somebody spread false rumors about me'],		
            ['question'=>'Many times I feel I was going to get crazy'],		
            ['question'=>'I was threatened to be placed in isolation'],		
            ['question'=>'I was asked by somebody to pay for their debts'],		
            ['question'=>'Somebody constantly asked money from me'],		
            ['question'=>'Somebody did not pay their debts on me'],		
            ['question'=>'I was asked to include their names in my bank account'],		
            ['question'=>'I was asked to sign documents I hardly understand'],		
            ['question'=>'I noticed that my valuables and possessions disappeared'],		
            ['question'=>'Somebody took away things without my knowledge or not asking permission'],		
            ['question'=>'I was bothered by something which lead me to sleeplessness'],		
            ['question'=>'I experienced sleeping at night without taking any meal'],		
            ['question'=>'Nobody asked me about my condition'],		
            ['question'=>'Nobody asked me if I am okay'],		
            ['question'=>'I am left all alone most of the time'],		
            ['question'=>'I am alone most of the time'],		
        ];

        foreach($questions as $question){
            ElderlyTestQuestion::create($question);
        }
    }
}
