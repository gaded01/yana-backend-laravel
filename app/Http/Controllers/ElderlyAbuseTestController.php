<?php

namespace App\Http\Controllers;

use App\Models\ElderInfo;
use App\Models\ElderlyAbuseTestResult;
use App\Models\ElderlyTestAnswer;
use App\Models\ElderlyTestOption;
use App\Models\ElderlyTestQuestion;
use App\Models\ElderlyTestResult;
use App\Models\ElderRate;
use App\Models\TestTake;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
      $testTake = TestTake::where('user_id', $request->user()->id)
         ->where('elder_info_id', $request->elder_info_id)
         ->orderBy('take', 'desc')->first();
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
      $testTake = TestTake::where('user_id', $request->user()->id)
         ->where('elder_info_id', $request->elder_info_id)
         ->orderBy('take', 'desc')->first();
      if ($testTake !== null) {
         $getTestAnswer = ElderlyTestAnswer::where('test_take_id', $testTake->id)->get();
         $testAnswerCount = $getTestAnswer ? $getTestAnswer->count() + 1 : 1;
         if ($testAnswerCount == 41) {
            TestTake::where('id', $testTake->id)->update(["status" => "1"]);
         }
         if ($testAnswerCount >= 42) {
            TestTake::create([
               'user_id' => $request->user()->id,
               'take' => $testTake->take += 1,
            ]);
         }
      } else {
         $noTest = TestTake::create([
            'user_id' => $request->user()->id,
            'elder_info_id' => $request->elder_info_id,
            'take' => 1,
         ]);
      }
      $testAnswer = ElderlyTestAnswer::create([
         'test_take_id' => $testTake ? $testTake->id : $noTest->id,
         'elderly_test_question_id' => $request->elderly_test_question_id,
         'elderly_test_option_id' => $request->elderly_test_option_id
      ]);

      return $testAnswer;
   }

   public function removeAnswer(Request $request)
   {
      $testTake = TestTake::where('user_id', $request->user()->id)
         ->where('elder_info_id', $request->elder_info_id)
         ->orderBy('take', 'desc')->first();
      $testAnswer = ElderlyTestAnswer::where('test_take_id', $testTake->id)->get();

      ElderlyTestAnswer::where('test_take_id', $testTake->id)->orderBy('id', 'desc')->first()->delete();

      if ($testAnswer->count() == 1) {
         $testTake->delete();
      }
      return;
   }

   public function testResult(Request $request)
   {
      $testTake = TestTake::where('user_id', $request->user()->id)
         ->where('elder_info_id', $request->elder_info_id)
         ->orderBy('take', 'desc')->first();

      if ($testTake === null) {
         return false;
      }
      $testResultValue = ElderlyTestAnswer::where('test_take_id', $testTake->id)->join('elderly_test_options', 'elderly_test_answers.elderly_test_option_id', '=', 'elderly_test_options.id')->sum('score');

      $abuseLevel = null;
      if ($testResultValue <= 69) {
         $abuseLevel = 1;
      };
      if ($testResultValue >= 70 && $testResultValue <= 97) {
         $abuseLevel = 2;
      }
      if ($testResultValue >= 98 && $testResultValue <= 126) {
         $abuseLevel = 3;
      }

     $result = ElderlyTestResult::create([
         'elder_info_id' => $request->elder_info_id,
         'total_score' => $testResultValue,
         'abuse_level_id' => $abuseLevel,
      ]);

      return ElderlyTestResult::where('elder_info_id', $result->elder_info_id )->with('testAbuseLevel')->latest('created_at')->first();
   }


   public function getTestAnswer(Request $request)
   {
      $testTake = TestTake::where('user_id', $request->user()->id)
         ->where('elder_info_id', $request->elder_info_id)
         ->orderBy('take', 'desc')->first();

      $testAnswers = ElderlyTestAnswer::where('test_take_id', $testTake->id)->with(['elderlyTestQuestion', 'elderlyTestOption'])->get();

      $testResult = ElderlyTestResult::where('elder_info_id', $request->elder_info_id)->with('testAbuseLevel')->latest('created_at')->first();

      return response()->json([
         'answers' => $testAnswers,
         'result' => $testResult
      ]);
   }

   public function addElderInfo(Request $request)
   {  
      $type = $request->type;
      $elder = ElderInfo::where('first_name', $request->first_name)
      ->where('last_name', $request->last_name)
      ->first();

      if($elder != null){  
         if($type == "rate"){
            $userRate = ElderRate::where('elder_info_id', $elder->id)->orderBy('id', 'desc')->first();
            if($userRate !== null){
               if (Carbon::now() < Carbon::parse($userRate->updated_at)->addDays(3)){
                  return response()->json([
                     'elder_rate' => $userRate,
                     'status' => 'done',
                     'message' => 'You can rate again after 3 days.',
                  ]);
               }
            }
         }
         if($type == "test"){
            $userTest = TestTake::where('user_id', $request->user()->id)
            ->where('elder_info_id', $elder->id)
            ->orderBy('id', 'desc')
            ->first();

            if ($userTest !== null) {
               if ($userTest->status == "1") {
                  if (Carbon::now() < Carbon::parse($userTest->updated_at)->addDays(3)) {
                     return response()->json([
                        'status' => 'done',
                        'message' => 'Test not available for 3 days after you take the test.',
                     ]);
                  }
               }
            }
         }
         return response()->json([
            'status' => 'exists',
            'elder_info' => $elder,
         ]);
      }
      else{
         $elder_info = ElderInfo::create([
            'user_id' => $request->user()->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthdate' => Carbon::parse($request->birthdate),
            'address' => $request->address,
         ]);

         return response()->json([
            'status' => 'success',
            'elder_info' => $elder_info,
         ]);
      }
   }


   public function elderRate(Request $request)
   {
      return ElderRate::create([
         'elder_info_id' => $request->elder_info_id,
         'rating' => $request->rating
      ]);
   }

   public function printPdf(Request $request)
   {
      $testTake = TestTake::where('user_id', $request->user()->id)->orderBy('take', 'desc')->first();
      $testAnswers = ElderlyTestAnswer::where('test_take_id', $testTake->id)->with(['elderlyTestQuestion', 'elderlyTestOption'])->get();

      $data = [
         'total_score' => $request->total_score,
         'result' => $request->result,
         'answers' => $testAnswers,

      ];

      $pdf = PDF::loadView('result', $data);
      return $pdf->download('result.pdf');
   }
}
