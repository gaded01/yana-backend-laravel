<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestTake extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'elder_info_id',
        'take'
    ];
}
