<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tools extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_tools';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'tool_id','user_id', 'tool_name', 'purchase_date','expiry_date',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
