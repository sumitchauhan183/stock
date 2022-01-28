<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'country',
        'city',
        'state',
        'zipcode',
        'username',
        'password',
        'status',
        'email',
        'email_verified',
        'login_token'
    ];


    public $timestamps = true;



    /**
     * Get the phone associated with the user.
     */
    public function tools()
    {
        return $this->hasMany(Tools::class,'user_id');
    }

    /**
     * Get the phone associated with the user.
     */
    public function cards()
    {
        return $this->hasMany(Card::class,'user_id');
    }

    /**
     * Get the phone associated with the user.
     */
    public function payment()
    {
        return $this->hasMany(Payment::class,'user_id');
    }
}
