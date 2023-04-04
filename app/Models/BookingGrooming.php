<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BookingGrooming extends Model implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'code_booking', 'pets_name','pets_type','service_type','service_category','pets_weight',
    ];





    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

}
