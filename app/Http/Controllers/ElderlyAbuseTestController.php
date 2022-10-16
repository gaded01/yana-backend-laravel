<?php

namespace App\Http\Controllers;

use App\Models\ElderlyAbuseTestResult;
use App\Models\ElderlyTestAnswer;
use App\Models\ElderlyTestOption;
use App\Models\ElderlyTestQuestion;
use App\Models\ElderlyTestResult;
use App\Models\TestTake;
use Illuminate\Http\Request;

class ElderlyAbuseTestController extends Controller
{
   public function getTestQuestion(Request $request)
   {

      $testQuestion = ElderlyTestQuestion::where('id', $request->id)->first();

      return $testQuestion;
   }

   public function getTestOption()
   {

      return ElderlyTestOption::all();
   }

   public function countTestAnswer(Request $request)
   {
      $testTake = TestTake::where('user_id', $request->user()->id)->where('type', "1")->orderBy('take', 'desc')->first();
      if ($testTake !== null) {
         $getTestAnswer = ElderlyTestAnswer::where('test_take_id', $testTake->id)->get();
         $countItem = $getTestAnswer->count();
         if ($countItem >= 42) {
            return 1;
         } else {
            return $countItem + 1;
         }
      } else {
         return 1;
      }
   }

   public function testAnswer(Request $request)
   {
      $testTake = TestTake::where('user_id', $request->user()->id)->where('type', "1")->orderBy('take', 'desc')->first();
      if ($testTake !== null) {
         $getTestAnswer = ElderlyTestAnswer::where('test_take_id', $testTake->id)->get();
         $testAnswerCount = $getTestAnswer ? $getTestAnswer->count() + 1 : 1;
         if ($testAnswerCount == 41) {
            TestTake::where('id', $testTake->id)->update(["status" => "1"]);
         }
         if ($testAnswerCount >= 42) {
            TestTake::create([
               'user_id' => $request->user()->id,
               'type' => "1",
               'take' => $testTake->take += 1,
            ]);
         }
      } else {
         $noTest = TestTake::create([
            'user_id' => $request->user()->id,
            'type' => "1",
            'take' => 1,
         ]);
      }
      $testAnswer = ElderlyTestAnswer::create([
         'test_take_id' => $testTake ? $testTake->id : $noTest->id,
         'elderly_test_question_id' => $request->eldery_test_question_id,
         'elderly_test_option_id' => $request->eldery_test_option_id
      ]);

      return $testAnswer;
   }

   public function testResult(Request $request)
   {  
      $testTake = TestTake::where('user_id', $request->user()->id)->where('type', '1')->orderBy('take', 'desc')->first();
      if($testTake === null) {
         return false;
      }
      $testResultValue = ElderlyTestAnswer::where('test_take_id', $testTake->id)->join('elderly_test_options', 'elderly_test_answers.elderly_test_option_id' ,'=' , 'elderly_test_options.id')->sum('score');
      
      $abuseLevel = null;
      if($testResultValue <= 30) {
         $abuseLevel = 1;
      };
      if($testResultValue >= 31 && $testResultValue <= 50 ) {
         $abuseLevel = 2;
      }
      if($testResultValue >= 51 && $testResultValue <= 100 ) {
         $abuseLevel = 3;
      }
      if($testResultValue >= 101 && $testResultValue <= 150 ) {
         $abuseLevel = 4;
      }
      
      ElderlyTestResult::create([
         'user_id' => $request->user()->id,
         'total_score' => $testResultValue,
         'abuse_level_id' => $abuseLevel
      ]);
      return ElderlyTestResult::where('user_id' , $request->user()->id)->with('abuseLevels')->latest('created_at')->first();
   }
}
