<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_name', 'series_abbr', 'service_time', 'crt_user'];

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}
