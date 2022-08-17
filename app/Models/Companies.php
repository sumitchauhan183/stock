<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Companies extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','id', 'ticker', 'name','lei','cik','FCF','DCF','EPV','TB','GRAHAM','PL','financial_rating'
    ];

    public $timestamps = true;
}
