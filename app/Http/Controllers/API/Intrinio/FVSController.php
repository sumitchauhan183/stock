<?php

namespace App\Http\Controllers\API\Intrinio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Utils;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class FVSController extends Controller
{
    Private $key, $endpoint;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->key = env("INTRINIO_KEY");
        $this->endpoint = env("INTRINIO_ENDPOINT");

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function companies($sector)
    {
        $uri = $this->endpoint."companies?industry_group=$sector&api_key=$this->key";
        $request = Utils::curlRequest($uri);
        dd($request);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function companyDetail($id)
    {
        $uri = $this->endpoint."companies/$id?api_key=$this->key";
        $request = Utils::curlRequest($uri);
        dd($request);
    }
}