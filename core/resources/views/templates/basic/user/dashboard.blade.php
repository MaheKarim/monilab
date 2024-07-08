@extends($activeTemplate.'layouts.master')

@section('content')

    @php
        $notice_content = getContent('notice.content',true);
    @endphp

    @include($activeTemplate.'user.left-sidenav')

    <div class="main-body main-body-two">

        <!-- notice-section start -->
        <section class="notice-section pd-t-30">
            <div class="custom-container">
                <div class="notice"></div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">{{ __($notice_content->data_values->heading) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="notice-area">
                            <div class="notice-content">
                                <p>{{ __($notice_content->data_values->details) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- notice-section end -->


        <!-- dashboard-section start -->
        <section class="dashboard-section pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">{{ __($pageTitle) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center ml-b-30">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ showAmount(@$user->balance, 2) }}</h3>
                                <p>@lang('Total Balance')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fab fa-bitcoin"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ $user->hyips()->count() ?? 0 }}</h3>
                                <p>@lang('Total Hyip')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ $user->hyips()->where('status', \App\Constants\Status::ENABLE)->count() }}</h3>
                                <p>@lang('Active Hyip')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ $user->hyips()->where('status', \App\Constants\Status::DISABLE)->count() }}</h3>
                                <p>@lang('Pending Hyips')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ $user->tempHyips()->count() }}</h3>
                                <p>@lang('Hyip Update Pending')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fas fa-ad"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ $user->adds()->count() }}</h3>
                                <p>@lang('Total Advertise')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fas fa-skiing"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ $user->adds()->where('status', \App\Constants\Status::ENABLE)->where('end_date','>=',\Carbon\Carbon::now()->toDateString())->count() }}</h3>
                                <p>@lang('Active Advertise')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mrb-30">
                        <div class="dash-item d-flex flex-wrap justify-content-between text-right">
                            <div class="dash-icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="dash-content">
                                <h3 class="title">{{ $user->adds()->where('status', \App\Constants\Status::DISABLE)->count() }}</h3>
                                <p>@lang('Pending Advertise')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- dashboard-section end -->

        <!-- chart-section start -->
        <section class="chart-section pd-t-30 pd-b-30">

            <div class="chart-area">
                <div class="chart-scroll">
                    <div class="chart-wrapper m-0">
                        <div class="chart-container" style="position: relative; height:350px; width: 100%">
                            <canvas id="myChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>

        </section>
        <!-- chart-section start -->

        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Details')</h5>
                        <button type="button" class="modal-custom-btn " data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mini-card-wrapper">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tile">
                                            <ul class="list-group">
                                                <li class="list-group-item">@lang('Amount') : <span class="withdraw-amount "></span></li>
                                                <li class="list-group-item">@lang('Charge') : <span class="withdraw-charge "></span></li>
                                                <li class="list-group-item">@lang('After Charge') : <span class="withdraw-after_charge"></span></li>
                                                <li class="list-group-item">@lang('Conversion Rate') : <span class="withdraw-rate"></span></li>
                                                <li class="list-group-item">@lang('Payable Amount') : <span class="withdraw-payable"></span></li>
                                            </ul>


                                            <ul class="list-group withdraw-detail mt-1">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn-btn" data-dismiss="modal">@lang('Cancel')</button>
                    </div>
                </div>
            </div>
        </div>


        <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Details')</h5>
                        <button type="button" class="modal-custom-btn " data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="withdraw-detail"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn-btn" data-dismiss="modal">@lang('Cancel')</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('script')
    <!--chart js-->
    @php
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $itr = 0;
        $a_itr = 0;
    @endphp
    <script src="{{asset($activeTemplateTrue.'js/chart.js')}}"></script>
    <script>
        "use strict";
        var config = {
            type: 'line',
            data: {
                labels: @php echo json_encode($months) @endphp,
                datasets: [{
                    label: '@lang('Hyip Click')',
                    backgroundColor: 'red',
                    borderColor: 'red',
                    data: [
                        @foreach($months as $k => $month)
                            @if(@$hyip_chart_data[$itr]['month'] == $month)
                            {{ @$hyip_chart_data[$itr]['click'] }},
                        @php $itr++; @endphp
                            @else
                            0,
                        @endif
                        @endforeach
                    ],
                    fill: false,
                }, {
                    label: '@lang('Advertise Click')',
                    fill: false,
                    backgroundColor: 'blue',
                    borderColor: 'blue',
                    data: [
                        @foreach($months as $k => $month)
                            @if(@$add_chart_data[$a_itr]['month'] == $month)
                            {{ @$add_chart_data[$a_itr]['click'] }},
                        @php $a_itr++; @endphp
                            @else
                            0,
                        @endif
                        @endforeach
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: '@lang('Hyip and Advertise Click Cpmpare Monthly')'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                            suggestedMin: 10,

                            // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                            suggestedMax: 50
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            window.myLine = new Chart(ctx, config);
        };
    </script>
@endpush
