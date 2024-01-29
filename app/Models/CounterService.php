<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterService extends Model
{
    use HasFactory;

    protected $fillable = ['counter_id', 'service_id', 'crt_user'];
}
