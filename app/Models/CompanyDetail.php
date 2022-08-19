<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyDetail extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_detail';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'id', 'ticker', 'name', 'lei', 'legal_name', 'sic', 'stock_exchange', 'short_description',
        'long_description', 'ceo', 'company_url', 'business_address', 'mailing_address', 'business_phone_no',
        'hq_address1', 'hq_address2', 'hq_address_city', 'hq_address_postal_code', 'entity_legal_form', 'cik',
        'latest_filing_date', 'hq_state', 'hq_country', 'inc_state', 'inc_country', 'employees', 'entity_status',
        'sector', 'industry_category', 'industry_group', 'template', 'standardized_active', 'first_fundamental_date',
        'last_fundamental_date', 'first_stock_price_date', 'last_stock_price_date', 'thea_enabled'
    ];

    public $timestamps = true;
}
