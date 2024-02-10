<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoMail extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'report', 'active' , 'crt_user'];

  
}
