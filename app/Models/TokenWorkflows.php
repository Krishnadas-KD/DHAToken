<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenWorkflows extends Model
{
    use HasFactory;

    protected $fillable = ['token_name', 'token_id','service_name', 'service_time','counter_name','counter_number','section','status','comment','is_closed','created_user'];
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
