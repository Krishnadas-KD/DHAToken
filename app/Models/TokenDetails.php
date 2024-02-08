<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenDetails extends Model
{
    use HasFactory;

    protected $fillable = ['type','section','post_date', 'token_name', 'crt_user','is_printed','print_count','last_print','token_status','colsed'];
    
    protected static function boot()
    {
        parent::boot();

        // Listen for the creating event and set the created_date attribute
        static::creating(function ($tokenDetails) {
            $tokenDetails->token_status = 'Pending Registration';
            $tokenDetails->post_date = now()->addHours(0)->toDateString(); 
        });
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
