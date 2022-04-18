<?php
namespace App\Classes;

use Exception;

class Intrinio 
{
    
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function companies($sector='Lodging')
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies?industry_group=$sector&api_key=$key";
        $request = Utils::curlRequest($uri);
        return $request->companies;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function companies_asset($asset='Lodging')
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies?industry_category=$asset&api_key=$key";
        $request = Utils::curlRequest($uri);
        return $request->companies;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function companies_search($query='Lodging')
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/search?query=$query&api_key=$key";
        $request = Utils::curlRequest($uri);
        return $request->companies[0];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function companies_all()
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies?active=true&api_key=$key";
        $request = Utils::curlRequest($uri);
        return $request->companies;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function ebit($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/ebit?api_key=$key";
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif; 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function ebit_margin($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/ebitmargin?api_key=$key";
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function revenue($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/operatingrevenue?api_key=$key";
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function ebitda($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/ebitda?api_key=$key";
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif;
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function accumulated_depriciation($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/accumulateddepreciation?api_key=$key";
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif;
    }
    
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function total_depreciation_amortization($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/depreciationandamortization?api_key=$key";
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif;
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function data_tag($id,$tag)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif;
    }
    
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function companyDetail($id)
    {
        $uri = $this->endpoint."companies/$id?api_key=$this->key";
        $request = Utils::curlRequest($uri);
        dd($request);
    }
}