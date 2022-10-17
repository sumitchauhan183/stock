@extends('layouts.user.dapp')
@section('content')
    <div class="app-main" id="main">
        <div class="container-fluid">
			   <div class="card card-statistics h-100 mb-0">
				<div class="card-body">
					<div class="BySetorWrapper">
						<h3 class="GrayBg mt-0">Company Detail</h3>
						<div class="SMCapDetail">
							<h4>{{$detail->name}} ({{$detail->ticker}})</h4>
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
                                            @php $detail->operating_income_rating = round($detail->operating_income_rating); @endphp
                                            @if($detail->operating_income_rating == 0)
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->operating_income_rating == 1)
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->operating_income_rating == 2)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->operating_income_rating == 3)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                                <span class=""></span>
                                            @elseif($detail->operating_income_rating == 4)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class=""></span>
                                            @elseif($detail->operating_income_rating == 5)
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                                <span class="YellowCo"></span>
                                            @endif
                                        </li>
										<li><strong>INTRINSIC VALUE</strong> ${{$detail->DCF}}</li>
									</ul>
								</div>
								<div class="col-lg-4 CapDetailSecound">
									<ul>
                                        @php
                                            $avg = ($detail->EPV+$detail->TB+$detail->GRAHAM+$detail->DCF+$detail->FCF)/5;
                                        @endphp
										<li><span class="PurpleCo"></span> <strong>$ {{$detail->EPV}}</strong> </li>
										<li><span class="YellowCo"></span> <strong>$ {{$detail->TB}}</strong> </li>
										<li><span class="BlueCo"></span> <strong>$ {{$detail->GRAHAM}}</strong> </li>
										<li><span class="GreenCo"></span> <strong>$ {{$detail->DCF}}</strong> </li>
										<li><span class="RedCo"></span> <strong>$ {{$detail->FCF}}</strong> </li>
										<li><span class="BgCono">AVG</span> <strong>$ {{round($avg,2)}}</strong> </li>
									</ul>
								</div>
								<div class="col-lg-4">
									<div id="exxon" style="height: 220px; width: 100%;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
@endsection


