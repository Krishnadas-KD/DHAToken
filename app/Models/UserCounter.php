<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCounter extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'counter_id', 'crt_user'];
}
