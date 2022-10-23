<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElderRate extends Model
{
    use HasFactory;

    protected $fillable = [
        "elder_info_id",
        "rating",
    ];
}
