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

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','id', 'ticker', 'name','lei','cik','FCF','DCF','EPV','TB','GRAHAM','PL','type','type_last_updated','financial_rating','marketcap','close_price',
        'financial_rating', 'FCF_last_updated', 'DCF_last_updated', 'EPV_last_updated', 'TB_last_updated', 'GRAHAM_last_updated',
        'PL_last_updated', 'FRating_last_updated', 'marketcap_last_updated', 'close_price_last_updated','details_saved','ebit_rating',
        'operating_income_rating','opinc_per_liab_rating',
        'quick_ratio_rating','DtoE_rating','freecashflow_rating'
    ];

    public $timestamps = true;
}
