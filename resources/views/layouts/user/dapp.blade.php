
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to AnalystKit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendors.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme-style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/information.css') }}" />
    <title>{{config('app.name')}}</title>
    @if($url=='sector-result' || $url == 'allStocks' || $url == 'assets-result')
        <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"  rel="stylesheet">
    @endif
</head>
<body>
<div class="app">
    <div class="app-wrap">
        <!-- begin pre-loader -->
        <div class="loader">
            <div class="h-100 d-flex justify-content-center">
                <div class="align-self-center">
                    <img src="{{ asset('images/loader.svg')}}" alt="loader">
                </div>
            </div>
        </div>
        <!-- end pre-loader -->
        @include('inc.user.header')
        <!-- begin app-container -->

        <div class="app-container">
            @include('inc.user.navbar')
            @yield('content')
        </div>
        <!-- plugins -->
        <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/vendors.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/canvasjs.min.js')}}"> </script>
        <!-- Modal Efects -->
        <script src="{{ asset('js/velocity.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/velocity.ui.min.js') }}" type="text/javascript"></script>

        <!-- plugins -->
        <!-- Modal Efects -->

        @if($url=='profile')
            <script src="{{ asset('js/custom/profile.js') }}"></script>
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    profile.init();
                });
            </script>
        @endif

        @if($url=='settings')
            <script src="{{ asset('js/custom/settings.js') }}"></script>
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    settings.init();
                });
            </script>
        @endif

        @if($url=='change_password')
            <script src="{{ asset('js/custom/change_password.js') }}"></script>
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    changePassword.init();
                });
            </script>
        @endif

        @if($url=='find-value-stock')
            <script src="{{ asset('js/custom/find-value-stock.js') }}"></script>
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    findValueStock.init();
                });
            </script>
        @endif
        @if($url=='sectorstocks')
            <script src="{{ asset('js/custom/sectorstock.js') }}"></script>
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    sectorstocks.init();
                });
            </script>
        @endif
        @if($url=='optimize-investment-mix')
            <script src="{{ asset('js/custom/optimize-investment-mix.js') }}"></script>
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    optimizeInvestmentMix.init();
                });
            </script>
        @endif
        @if($url=='sector-result' || $url == 'allStocks' || $url == 'assets-result')
            <script src="https://cdn.datatables.net/autofill/2.4.0/js/dataTables.autoFill.min.js"></script>
            <script src="https://cdn.datatables.net/searchbuilder/1.3.4/js/dataTables.searchBuilder.min.js"></script>
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    let table = $('#sector-list').DataTable({
                        "order": [[1,'asc']],
                        "columnDefs": [
                            { "width": "20%", "targets": 4 },
                            { "targets": 1, "visible":false}
                            
                        ],
                        searchBuilder: {
                            columns: [3]
                        },
                        "pageLength": 25,
                        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                            $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
                        }
                    });

                    $( '#sector-list_filter input' ).attr('placeholder', 'Ticker');

                    $( '#sector-list_filter input' ).on( 'input', function () {
                        if ( table.columns(3).search() !== $(this).val() ) {
                            table.columns(3).search( $(this).val() ).draw();
                        }
                    } );

                });
            </script>
        @endif
        @if($url=='company-detail')
            <script>
                //close the alert after 3 seconds.
                $(document).ready(function(){
                    var chart = new CanvasJS.Chart("exxon", {
                        theme: "", // "light2", "dark1", "dark2"
                        animationEnabled: false, // change to true
                       axisY:{
                           margin: 20,
                           lineThickness:0,
                           tickLength: 0,
                           labelFontColor: "white",
                        			stripLines: [
                        			{
                        				value: {{$threecp}},
                        				lineDashType: "dash",
                        				label: "3y",
                        				labelPlacement: "outside",
				                        labelAlign: "near",
				                        thickness:1,
				                        labelFontSize:10,
				                        labelBackgroundColor:"transparent",
				                        color:"grey",
				                        labelFontColor:"grey",
				                        labelMargin:10,
				                        showOnTop: true
                        			},{
                        				value: {{$fivecp}},
                        				lineDashType: "dash",
                        				label: "5y......",
                        				labelPlacement: "outside",
                        				labelBackgroundColor:"transparent",
				                        labelAlign: "far",
				                        thickness:1,
				                        labelFontSize:10,
				                        color:"grey",
				                        labelFontColor:"grey",
				                        showOnTop: true
                        			},
                        			{
                        				value: {{$detail->close_price}},
                        				lineDashType: "dash",
                        				label: "$"+"{{$detail->close_price}}...........",
                        				labelPlacement: "outside",
                        				labelBackgroundColor:"transparent",
                        				labelBorderColor:"blue",
				                        labelAlign: "near",
				                        thickness:1,
				                        color:"black",
				                        labelFontColor:"black",
				                        labelFontSize:10,
				                        showOnTop: true
                        			}
                        			]
                        		},
                        		axisX:{
                        		    lineThickness:0,
                           tickLength: 0,
                        		},
                        data: [
                            {
                                // Change type to "bar", "area", "spline", "pie",etc.
                                type: "column",
                                dataPoints: [
                                    { label: "EV", y: {{$detail->EPV}}, color:'#a349a4'},
                                    { label: "TV", y: {{$detail->TB}}, color:'#ffd201'},
                                    { label: "GRM", y: {{$detail->GRAHAM}}, color:'#4f81c0'},
                                    { label: "DCF", y: {{$detail->DCF}}, color:'#b5e61d'},
                                    { label: "FCF", y: {{$detail->FCF}}, color:'#f01919'},
                                    { label: "PLV", y: {{$detail->PL}}, color:'#765454'}
                                ]
                            }
                        ]
                    });
                    chart.render();
                    
                    $('.canvasjs-chart-credit').hide();
                });
            </script>
        @endif

    </div>
</div>
</body>


</html>
