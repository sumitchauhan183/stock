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
        $uri = str_replace(" ","%20",$endpoint."companies?sector=$sector&api_key=$key");
        $request = Utils::curlRequest($uri);
        return $request->companies;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * https://api-v2.intrinio.com/companies/META/historical_data/adjbasiceps?
     * frequency=quarterly&start_date=2016-05-31&end_date=2022-05-31&api_key=
     */
    public static function data_tag_quarterly($id,$tag)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=quarterly&api_key=$key";
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
    public static function companies_asset($asset='Lodging')
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = str_replace(" ","%20",$endpoint."companies?industry_category=$asset&api_key=$key");
        $request = Utils::curlRequest($uri);
        return $request->companies;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function getAllCompanies($size,$next='')
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies?page_size=$size&next_page=$next&api_key=$key";
        $request = Utils::curlRequest($uri);
        return $request;
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
    public static function companDetail($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id?api_key=$key";
        $request = Utils::curlRequest($uri);
        return $request;
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
        $uri = $endpoint."companies?api_key=$key";
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
     * Show the application dashboard.atingm
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
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        // dd($uri);
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
    public static function data_tag_common($id,$tag)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=quarterly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        // dd($uri);
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
    public static function data_tag_qtr($id,$tag)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?type=QTR&start_date=$start&end_date=$end&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        // dd($uri);
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
    public static function data_tag_qtr_year_wise_avg($id,$tag,$start,$end,$latest)
    {
        //$end   = date('Y-m-d');
        //$start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            if($latest!=""):
                $latest = date('m-d',strtotime($latest));
                $data = $request->historical_data;
                foreach ($data as $d):
                    if(strpos($d->date,$latest)):
                        return $d->value/1000000;
                    endif;
                endforeach;
            else:
                $data = $request->historical_data;
                if(count($data)>0):
                    return $data[0]->value/1000000;
                else:
                    return 0;
                endif;

            endif;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function data_tag_qtr_year_wise_avg_latest_date($id,$tag,$start,$end)
    {
        //$end   = date('Y-m-d');
        //$start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            if(count($data)>0):
                return $data[0]->date;
            else:
                return $start;
            endif;

        endif;
    }

    public static function data_tag_qtr_year_wise_avg_per($id,$tag,$start,$end,$latest)
    {
        //$end   = date('Y-m-d');
        //$start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            if($latest!=""):
                $latest = date('m-d',strtotime($latest));
                $data = $request->historical_data;
                foreach ($data as $d):
                    if(strpos($d->date,$latest)):
                        return $d->value;
                    endif;
                endforeach;
            else:
                $data = $request->historical_data;
                return $data[0]->value;
            endif;
        endif;
    }

    public static function data_tag_yearly($id,$tag)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=2016-05-31&end_date=2022-05-31&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data;
        endif;
    }

    public static function data_tag_quarterly_new($id,$tag)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = [];
            foreach($request->historical_data as $d):
                if(strpos($d->date,'-03-')):
                    array_push($data,$d);
                endif;
            endforeach;
            return $data;
        endif;
    }

    public static function stockpricedata($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."securities/$id/prices?frequency=yearly&start_date=2016-05-31&end_date=2022-05-31&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        // dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->stock_prices;
        endif;
    }

    public static function data_tag_avg_yearly($id,$tag)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=2016-05-31&end_date=2022-05-31&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        // dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $count = 0;
            $ebm = 0;
            $data = $request->historical_data;
            foreach($data as $d):
                $count++;
                $ebm += $d->value;
            endforeach;
            if($count > 0):
                return $ebm/$count;
            else:
                return 0;
            endif;

        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function current_sales($id)
    {

        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        $uri = $endpoint."companies/$id/historical_data/revenueqoqgrowth?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data[0]->value;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function ebit_margin_five_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/ebitmargin?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $ebm = 0;
            $data = $request->historical_data;
            foreach($data as $d):
                $ebm += $d->value;
            endforeach;

            return $ebm/5;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function CAPEXArray($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/capex?type=QTR&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $cpex = 0;
            $data = $request->historical_data;

            //return $cpex/20;
            return $data;
        endif;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgFiveYearincomeGrowthRate($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/netincomegrowth?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $incg = 0;
            $data = $request->historical_data;
            foreach($data as $d):
                $incg += $d->value;
            endforeach;

            return $incg/20;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function netppeArray($id)
    {

        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/netppe?type=QTR&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $incg = 0;
            $data = $request->historical_data;

            return $data;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgFiveYearrevenueGrowth($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/revenuegrowth?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $incg = 0;
            $data = $request->historical_data;
            foreach($data as $d):
                $incg += $d->value;
            endforeach;

            return $incg/20;
        endif;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function dilshros_five_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/weightedavedilutedsharesos?type=QTR&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                $x++;
                $dsos += $d->value;
            endforeach;
            return $dsos/$x;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function getTreasuryRate()
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint.'indices/economic/$DGS10/data_point/level/number?&api_key='.$key;
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request;
        endif;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgdebt_five_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/debt?frequency=quarterly&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                $x++;
                $dsos += $d->value;
            endforeach;

            return $dsos/$x;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgdebt_two_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -2 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/debt?frequency=yearly&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $data = $request->historical_data;
            foreach($data as $d):
                $dsos += $d->value;
            endforeach;
            $dsos += $data[0]->value;
            $dsos += $data[1]->value;

            return $dsos/2;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function risk_free_rate($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -2 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint.'indices/economic/$DGS10/historical_data/level?api_key='.$key;
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data[0]->value;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avg_two_year_taxrate($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -2 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint."companies/$id/historical_data/efftaxrate?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $taxrate = 0;
            foreach($request->historical_data as $t):
                $taxrate += $t->value;
            endforeach;
            $taxrate = $taxrate/2;
            return $taxrate;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function total_assets($id)
    {

        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint."companies/$id/historical_data/totalassets?api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            if($request->historical_data[0]->value):
                return $request->historical_data[0]->value;
            else:
                return 0;
            endif;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function current_assets($id)
    {

        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint."companies/$id/historical_data/totalcurrentassets?api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            if($request->historical_data[0]->value):
                return $request->historical_data[0]->value;
            else:
                return 0;
            endif;
        endif;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function long_term_liabilities($id)
    {

        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint."companies/$id/historical_data/otherlongtermliabilities?api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            if($request->historical_data[0]->value):
                return $request->historical_data[0]->value;
            else:
                return 0;
            endif;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function current_liabilities($id)
    {

        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint."companies/$id/historical_data/totalcurrentliabilities?api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            if($request->historical_data[0]->value):
                return $request->historical_data[0]->value;
            else:
                return 0;
            endif;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function one_year_beta_investment($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint."companies/$id/historical_data/one_year_beta?api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data[0]->value;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function ten_year_beta_investment($id)
    {
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");

        $uri = $endpoint."companies/$id/historical_data/ten_year_beta?api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);

        if(isset($request->error)):
            return [];
        else:
            return $request->historical_data[0]->value;
        endif;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function intexpe_five_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/totalinterestexpense?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $data = $request->historical_data;
            foreach($data as $d):
                $dsos += $d->value;
            endforeach;

            return $dsos/5;
        endif;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function nopat_five_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/nopat?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $npt = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                $x++;
                $npt += $d->value;
            endforeach;

            return $npt/$x;
        endif;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function efactivetaxrate_five_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/efftaxrate?type=QTR&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $etr = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                $x++;
                $etr += $d->value;
            endforeach;

            return $etr/$x;
        endif;
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function depletion_five_year($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/depletionexpense?frequency=quarterly&start_date=$start&end_date=$end&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $acdep = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                $x++;
                $acdep += $d->value;
            endforeach;

            return $acdep/$x;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function capitalLeaseObligation($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        // $uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/capitalleaseobligations?type=QTR&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            if(count($data)>0):
                $dsos = 0;
                $x=0;

                foreach($data as $d):
                    $x++;
                    $dsos += $d->value;
                endforeach;
                return $dsos/$x;
            endif;
            return 0;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgFiveYearEbitMargin($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/ebitmargin?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x = 0;
            $data = $request->historical_data;
            foreach($data as $d):
                $x++;
                $dsos += $d->value;
            endforeach;
            return ($dsos/$x)*4;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function currentOperatingRevenue($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/operatingrevenue?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            return $data[0]->value;
        endif;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function revenueArray($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/operatingrevenue?type=QTR&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $data = $request->historical_data;
            return $data;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgFiveYearDDA($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/depreciationandamortization?type=QTR&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            if(count($data)>0):
                $dsos = 0;
                $x=0;

                foreach($data as $d):
                    $x++;
                    $dsos += $d->value;
                endforeach;
                return $dsos/$x;
            endif;
            return 0;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgSustainableRevenue($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/operatingrevenue?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            if(count($data)>0):
                $dsos = 0;
                $x=0;

                foreach($data as $d):
                    $x++;
                    $dsos += $d->value;
                endforeach;
                return $dsos/$x;
            endif;
            return 0;
        endif;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgFiveYearSGA($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/sgaexpense?type=QTR&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            if(count($data)>0):
                $dsos = 0;
                $x=0;

                foreach($data as $d):
                    $x++;
                    $dsos += $d->value;
                endforeach;
                return $dsos/$x;
            endif;
            return 0;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgFiveYearOperatingMargin($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -6 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/operatingmargin?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";
        //dd($uri);
        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            if(count($data)>0):
                $dsos = 0;
                $x=0;

                foreach($data as $d):
                    $x++;
                    $dsos += $d->value;
                endforeach;
                return $dsos/$x;
            endif;
            return 0;
        endif;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function avgFiveYearTaxRate($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/efftaxrate?type=QTR&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $data = $request->historical_data;
            if(count($data)>0):
                $dsos = 0;
                $x=0;
                foreach($data as $d):
                    if($d->value!=null):
                        $x++;
                        $dsos += $d->value;
                    endif;
                endforeach;
                if($x>0):
                    return $dsos/$x;
                endif;
            endif;
            return 0;
        endif;
    }

    public static function avgFiveYearTotalEquity($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/totalequity?type=QTR&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/totalequity?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/totalequity?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                if($d->value==null):
                    $d->value = 0;
                endif;
                $x++;
                $dsos += $d->value;
            endforeach;
            return $dsos/$x;
        endif;
    }

    public static function avgFiveYearTotalPreferedEquity($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/totalpreferredequity?type=QTR&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/totalpreferredequity?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/totalpreferredequity?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                if($d->value==null):
                    $d->value = 0;
                endif;
                $x++;
                $dsos += $d->value;
            endforeach;
            return $dsos/$x;
        endif;
    }

    public static function avgFiveYearIntengibleAssets($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/intangibleassets?type=QTR&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/intangibleassets?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/intangibleassets?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                if($d->value==null):
                    $d->value = 0;
                endif;
                $x++;
                $dsos += $d->value;
            endforeach;
            return $dsos/$x;
        endif;
    }

    public static function avgFiveYearGoodWill($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/goodwill?type=QTR&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/goodwill?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/goodwill?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                if($d->value==null):
                    $d->value = 0;
                endif;
                $x++;
                $dsos += $d->value;
            endforeach;
            return $dsos/$x;
        endif;
    }

    public static function avgFiveYearSharesOutstanding($id)
    {
        $end   = date('Y-m-d');
        $start = date('Y-m-d', strtotime("$end -5 year"));
        $key = env("INTRINIO_KEY");
        $endpoint = env("INTRINIO_ENDPOINT");
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/$tag?frequency=yearly&start_date=$start&end_date=$end&api_key=$key";

        $uri = $endpoint."companies/$id/historical_data/weightedavedilutedsharesos?type=QTR&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/weightedavedilutedsharesos?frequency=yearly&api_key=$key";
        //$uri = $endpoint."companies/$id/historical_data/weightedavedilutedsharesos?frequency=quarterly&api_key=$key";

        $request = Utils::curlRequest($uri);
        if(isset($request->error)):
            return [];
        else:
            $dsos = 0;
            $x=0;
            $data = $request->historical_data;
            foreach($data as $d):
                if($d->value==null):
                    $d->value = 0;
                endif;
                $x++;
                $dsos += $d->value;
            endforeach;
            return $dsos/$x;
        endif;
    }
}
