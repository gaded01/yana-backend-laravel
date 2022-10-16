<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElderlyTestResult extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'total_score',
        'abuse_level_id',
    ];


    public function testAbuseLevel()
    {
        return $this->hasOne(AbuseLevel::class, 'id', 'abuse_level_id');
    }
}
