<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenSeries extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['type', 'abbr','section', 'current_sq'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
