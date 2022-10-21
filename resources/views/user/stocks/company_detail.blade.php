
@extends('layouts.user.dapp')
@section('content')
    <style>
        #space{
            width: 64px;
            height: 12px;
            background: white;
            z-index: 9;
            position: absolute;
            bottom: 2px;
            left: 16px;
        }

        .mattric{
            color: gray;
            font-family: "Arial Narrow", Arial, sans-serif;
            font-size: 16px;
            font-weight: 900;
        }

    </style>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="card card-statistics pt-0 pb-0 h-100 mb-0">
                <div class="card-body">
                    <div class="BySetorWrapper">
                        <div class="SMCapDetail">
                            <h4>{{$detail->name}} ({{$detail->ticker}})</h4>
                            <div class="row" style="margin: 20px 0">
                                <div class="col-lg-4" style="margin: 20px 0">
                                    <ul>
                                        <li style="font-weight: 400;"><strong>Ticker: </strong><span >{{$detail->ticker}}</span></li>
                                        <li style="font-weight: 400;"><strong>Name: </strong><span >{{$detail->name}}</span></li>
                                        <li style="font-weight: 400;"><strong>Legal Name: </strong><span >{{$detail->legal_name}}</span></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4" style="margin: 20px 0">
                                    <ul>
                                        <li style="font-weight: 400;"><strong>Stock Exchange: </strong><span >{{$detail->stock_exchange}}</span></li>
                                        <li style="font-weight: 400;"><strong>Market Cap: </strong><span >${{$detail->marketcap}} Million</span></li>
                                        <li style="font-weight: 400;"><strong>Close Price: </strong><span >${{$detail->close_price}} USD per share</span></li>
                                    </ul>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-4 CapDetailFirst">
                                    <ul>
                                        <li><strong>FINANCIALS</strong>
                                            @php $detail->financial_rating = round($detail->financial_rating); @endphp
                                            @if($detail->financial_rating == 0)
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->financial_rating == 1)
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->financial_rating == 2)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->financial_rating == 3)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->financial_rating == 4)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                            @elseif($detail->financial_rating == 5)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                            @endif

                                        </li>
                                        <li><strong>PRICE HISTORY</strong>
                                            @if($per > 120)
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($per > 109 && $per < 121)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($per > 100 && $per < 110)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($per > 90 && $per < 101)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                            @elseif($per > 80 && $per < 91)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                            @elseif($per < 81)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                            @endif
                                        </li>
                                        @php
                                            $avg = ($detail->EPV+$detail->TB+$detail->GRAHAM+$detail->DCF+$detail->FCF+$detail->PL)/6;
                                        @endphp
                                        <li style="font-weight: bold;">INTRINSIC VALUE AVG: &nbsp;<strong style="color:green"> $ {{round($avg,2)}}</strong> </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 CapDetailSecound">
                                    <ul>

                                        <li><span class="PurpleCo"></span> <strong class="mattric">$ {{$detail->EPV}}</strong> </li>
                                        <li><span class="YellowCo"></span> <strong class="mattric">$ {{$detail->TB}}</strong> </li>
                                        <li><span class="BlueCo"></span> <strong class="mattric">$ {{$detail->GRAHAM}}</strong> </li>
                                        <li><span class="GreenCo"></span> <strong class="mattric">$ {{$detail->DCF}}</strong> </li>
                                        <li><span class="RedCo"></span> <strong class="mattric">$ {{$detail->FCF}}</strong> </li>
                                        <li><span class="OrangeCo"></span> <strong class="mattric">$ {{$detail->PL}}</strong> </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <div id="exxon" style="height: 300px; width: 100%;border: 1px solid;float:right;">
                                        <p></p>
                                    </div>
                                    <div id="space" >
                                    </div>
                                </div>
                                <div class="col-lg-12" >
                                    <ul>
                                        <li style="font-weight: 400;"><strong>Description: </strong><br>{{$detail->short_description}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


