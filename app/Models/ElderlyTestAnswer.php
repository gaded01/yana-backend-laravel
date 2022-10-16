<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElderlyTestAnswer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "test_take_id",
        "elderly_test_question_id",
        "elderly_test_option_id",
    ];

    public function elderlyTestQuestion()
    {
        return $this->hasOne(ElderlyTestQuestion::class, "id", "elderly_test_question_id");
    }

    public function elderlyTestOption()
    {
        return $this->hasOne(ElderlyTestOption::class, "id", "elderly_test_option_id");
    }

}
