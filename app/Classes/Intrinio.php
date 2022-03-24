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
        dd($request);
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
        dd($request);
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