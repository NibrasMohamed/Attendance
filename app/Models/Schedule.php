<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = "schedule";
    protected $fillable = [
        'employee_id',
        'shift_id',
        'location_id',
        'date',
    ];
}
