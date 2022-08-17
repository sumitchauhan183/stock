<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompaniesSetting;
use App\Models\Companies;
use App\Classes\Intrinio;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $key;
    private $size = 10000;
    public function __construct()
    {
       $this->key = env('CRON_API_KEY');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return "Wrong page";
    }

    public function saveCompanies($key){

        if($key==$this->key):
            $settings = CompaniesSetting::get()->first();
            if($settings):
                $companies = Intrinio::getAllCompanies($this->size,$settings->next_page_id);
                $count = $settings->total_companies_added+$this->saveCompanyDetails($companies->companies);
                $this->saveCompanySettings($count,$settings->next_page_id,$companies->next_page);
            else:
               $companies = Intrinio::getAllCompanies($this->size,'');
               $count = $this->saveCompanyDetails($companies->companies);
               $this->saveCompanySettings($count,'',$companies->next_page);
            endif;
        else:
            dd("Please provide valid API key");
        endif;

    }

    private function saveCompanySettings($count,$last,$next){
        CompaniesSetting::truncate();
        CompaniesSetting::create([
            "total_companies_added"=>$count,
            "last_page_id"=>$last,
            "next_page_id"=>$next
        ]);
    }

    private function saveCompanyDetails($companies){
        $count = 0;
        foreach ($companies as $c):
            $check = Companies::where('id',$c->id)->get()->count();
            if(!$check):
                Companies::create(
                    [
                        "id"     => $c->id,
                        "ticker" => $c->ticker,
                        "name"   => $c->name,
                        "lei"    => $c->lei,
                        "cik"    => $c->cik
                    ]
                );
            $count++;
            endif;
        endforeach;
        return $count;
    }


}
