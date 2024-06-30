@extends($activeTemplate.'layouts.frontend')
@section('content')

    @php
        $counter_content = getContent('counter.content',true);
        $counter_element = getContent('counter.element',false);
    @endphp

    <div class="main-body">
        <section class="banner">
            <div class="banner-section text-center">
                @php echo ads_show('728x90'); @endphp
            </div>
        </section>
        <!-- banner-section end -->


        <!-- event-section start -->
        <section class="event-section pd-t-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">@lang('Latest Hyip')</h2>
                        </div>
                    </div>
                </div>
                <div class="event-area">
                    <div class="row justify-content-center ml-b-10">
                        @foreach ($data['latest_hyips'] as $item)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mrb-10">
                                <div class="event-item">
                                    <h3 class="title"><a href="{{ $item->url }}" class="hyip-click" data-id="{{ $item->id }}" target="_blank">{{ __($item->name) }}</a></h3>
                                    <div class="event-content-area">
                                        <div class="event-content d-flex flex-wrap align-items-center justify-content-between">
                                            <span class="event-title">@lang('Added At')</span>
                                            <span class="event-date badge badge-danger">{{ \Carbon\Carbon::parse($item->created_at)->format('M d,Y') }}</span>
                                        </div>
                                        <div class="event-content d-flex flex-wrap align-items-center justify-content-between">
                                            <span class="event-title">@lang('Status')</span>
                                            <span class="event-date badge badge-success">{{__($item->type->name) }}</span>
                                        </div>
                                    </div>
                                    <div class="event-btn d-flex">
                                        <a href="{{ $item->url }}" class="cmn-btn w-100 hyip-click" data-id="{{ $item->id }}">@lang('Visit Now')</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- event-section end -->

        <!-- quality-section start -->
        <section class="quality-section quality-section-four pd-t-30">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="quality-area">
                            <div class="quality-body text-center">
                                <div class="quality-thumb-area">
                                    <div class="quality-thumb">
                                        @php echo ads_show('728x90'); @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- quality-section end -->

        <!-- counter-section start -->
        <section class="counter-section pd-t-30" id="hyip">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">{{ __($counter_content->data_values->heading) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center ml-b-10">
                    @foreach ($counter_element as $item)
                        <div class="col-xl-4 col-md-6 mrb-10">
                            <div class="counter-item d-flex flex-wrap align-items-center">
                                <div class="counter-icon">
                                    @php
                                        echo $item->data_values->icon;
                                    @endphp
                                </div>
                                <div class="counter-content">
                                    <div class="odo-area">
                                        <h3 class="odo-title odometer color-main" data-odometer-final="{{ __($item->data_values->counter_digit) }}">0</h3>
                                    </div>
                                    <p>{{ __($item->data_values->title) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- counter-section end -->

        <!-- quality-section start -->
        <section class="quality-section quality-section-four pd-t-30">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="quality-area">
                            <div class="quality-body text-center">
                                <div class="quality-thumb-area">
                                    <div class="quality-thumb">
                                        @php echo ads_show('728x90'); @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- quality-section end -->

        <div class="express-section mt-4">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="text-right">
                        <select class="form-control typeSelect">
                            <option value="">@lang('Sort by type')</option>
                            @foreach($data['types'] as $type)
                                <option value="{{ $type->id }}" @if($type->id == @$type_id) selected @endif>{{ __($type->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($hyips as $item)
            <!-- express-section start -->
            <section class="express-section pd-t-30" id="express">
                <div class="custom-container">
                    <div class="express-area">
                        <div class="express-row">
                            <div class="express-row-inner d-flex flex-wrap align-items-center justify-content-between ml-b-10">
                                <div class="express-col-left mrb-10">
                                    <div class="express-item d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="express-item-header d-flex flex-wrap align-items-center">
                                            <span class="premium">{{ __($item->type->name) }}</span>
                                            <h2 class="title mb-0">{{ __($item->name) }}</h2>
                                        </div>
                                        <div class="express-det">
                                            <h6 class="title">
                                                <a href="{{ $item->url }}">@lang('VISIT SITE') <i class="fas fa-chevron-right"></i></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="express-col-right mrb-10">
                                    <div class="express-rating-area d-flex flex-wrap align-items-center">
                                        <div class="pay-area">
                                            <span class="pay">{{ __($item->type->name) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="express-main">
                            <div class="monitor-area">
                                <div class="monitor-row d-flex flex-wrap justify-content-between align-items-start ml-b-10">
                                    <div class="monitor-col-left mrb-10">
                                        <div class="monitor-thumb">
                                            <img src="{{ getImage(getFilePath('hyip')) }}" alt="monitor">
                                        </div>
                                        <div class="monitor-thumb-content text-center">
                                            <h3 class="title text-white">@lang('Ratings')</h3>
                                            <div class="ratings">
                                                @for ($i = 0; $i < $item->rating; $i++)
                                                    <i class="icon-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="monitor-col-right mrb-10">
                                        <div class="monitor-widget-wrapper d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="monitor-widget-area">
                                                <div class="invest-widget-btn">
                                                    <i class="far fa-calendar-alt"></i>

                                                    @lang('Monitor Since') : <span>{{\Carbon\Carbon::createFromTimeStamp(strtotime($item->monitor_since ))->diffInDays()}} @lang('days')</span>
                                                </div>
                                                <div class="invest-widget-btn payout-btn">
                                                    <i class="far fa-calendar-alt"></i>

                                                    @lang('Added At') : <span>{{ \Carbon\Carbon::parse($item->created_at)->format('M d,Y') }}</span>
                                                </div>
                                                <div class="invest-widget-btn rcb-btn">
                                                    <a href="javascript:void(0)" class="vote" data-target="#voteModal"
                                                       data-hyip_id="{{ $item->id }}"
                                                       @foreach($data['polls'] ?? [] as $hpKey => $hyipPoll)
                                                           data-poll{{ $hpKey }}="{{ $item->userPolls()->where('poll_id',$hyipPoll->id)->count() }}"
                                                        @endforeach
                                                    >
                                                        <i class="fas fa-thumbs-up"></i>
                                                        @lang('Vote Now') ({{ $item->userPolls()->count() }})
                                                    </a>
                                                </div>
                                                <div class="invest-widget-btn ins-btn">
                                                    <a href="javascript:void(0)" class="report" data-target="#reportModal" data-hyip_id="{{ $item->id }}">
                                                        <i class="fas fa-shield-alt"></i>
                                                        @lang('Report Scam')
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="monitor-widget-area">
                                                @if ($item->ref_link)
                                                    <div class="invest-widget-btn">
                                                        <a href="{{ $item->ref_link }}">@lang('Visit Ref. Link')</a>
                                                    </div>
                                                @endif
                                                <div class="invest-widget-btn payout-btn des-btn">
                                                    <button data-toggle="modal" data-name="description" data-gate="505" data-dec="{{$item->description}}" class="desc" data-target="#desModal">@lang('Get Description')</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="insurance-area">
                                            <div class="insurance-table d-flex flex-wrap align-items-center">
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('Minimum')</span>
                                                    <span class="insurance-price">{{ __($item->minimum) }} ({{ gs('cur_sym') }})</span>
                                                </div>
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('Maximun')</span>
                                                    <span class="insurance-price">{{ __($item->maximum) }} ({{ gs('cur_sym') }})</span>
                                                </div>
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('Withdraw Type')</span>
                                                    <span class="insurance-price">
                                                    @if ($item->withdraw_type == 1)
                                                            @lang('Manual')
                                                        @else
                                                            @lang('Automatic')
                                                        @endif
                                                </span>
                                                </div>
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('Daily Profit')</span>
                                                    <span class="insurance-price">{{ __($item->daily_profit) }} (%)</span>
                                                </div>
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('Period')</span>
                                                    <span class="insurance-price">{{ __($item->period) }}</span>
                                                </div>
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('Ref. Bonus')</span>
                                                    <span class="insurance-price">{{ __($item->ref_bonus) }}  (%)</span>
                                                </div>
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('Principle Return')</span>
                                                    <span class="insurance-price">
                                                    @if ($item->principle_return == 1)
                                                            @lang('Yes')
                                                        @else
                                                            @lang('No')
                                                        @endif
                                                </span>
                                                </div>
                                                <div class="insurance-item d-flex flex-wrap align-items-center justify-content-between">
                                                    <span class="insurance-title">@lang('DDOS')</span>
                                                    <span class="insurance-price">
                                                    @if ($item->ddos == 1)
                                                            @lang('Yes')
                                                        @else
                                                            @lang('No')
                                                        @endif
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="monitor-social-area d-flex flex-wrap align-items-center justify-content-between">
                                <div class="monitor-social-wrapper d-flex flex-wrap align-items-center">
                                    <h3 class="monitor-social-title">@lang('React') : </h3>
                                    <ul class="monitor-social d-flex flex-wrap">
                                        <li>
                                            <div class="monitor-emoji" data-toggle="tooltip" data-placement="bottom" title="@lang('Happy')">
                                                <a href="{{route('react',$item->id.'?react=happy')}}"><img src="{{ asset('assets') }}/images/emoji/happy.png" alt="emoji"></a>
                                                <div class="monitor-number">
                                                    <span>{{ __($item->happy) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="monitor-emoji" data-toggle="tooltip" data-placement="bottom" title="@lang('Sad')">
                                                <a href="{{route('react',$item->id.'?react=sad')}}"><img src="{{ asset('assets') }}/images/emoji/emoji-2.png" alt="emoji"></a>
                                                <div class="monitor-number">
                                                    <span>{{ __($item->sad) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="monitor-emoji" data-toggle="tooltip" data-placement="bottom" title="@lang('Wow')">
                                                <a href="{{route('react',$item->id.'?react=wow')}}"><img src="{{ asset('assets') }}/images/emoji/emoji-3.png" alt="emoji"></a>
                                                <div class="monitor-number">
                                                    <span>{{ __($item->wow) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="monitor-emoji" data-toggle="tooltip" data-placement="bottom" title="@lang('Love')">
                                                <a href="{{route('react',$item->id.'?react=love')}}"><img src="{{ asset('assets') }}/images/emoji/emoji-4.png" alt="emoji"></a>
                                                <div class="monitor-number">
                                                    <span>{{ __($item->love) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="monitor-emoji" data-toggle="tooltip" data-placement="bottom" title="@lang('Angyr')">
                                                <a href="{{route('react',$item->id.'?react=angry')}}"><img src="{{ asset('assets') }}/images/emoji/angry.png" alt="emoji"></a>
                                                <div class="monitor-number">
                                                    <span>{{ __($item->angry) }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="monitor-social-wrapper d-flex flex-wrap align-items-center">
                                    @if(count($item->features) > 0)
                                        <h3 class="monitor-social-title">@lang('Features') : </h3>
                                        <ul class="monitor-social d-flex flex-wrap">

                                            @foreach ($item->features as $data)
                                                <li>
                                                    <div class="monitor-emoji" data-toggle="tooltip" data-placement="bottom" title="{{ __($data->name) }}">
                                                        <img src="{{ getImage(getFilePath('feature').'/'. $data->image)}}" alt="emoji">
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="monitor-social-wrapper d-flex flex-wrap align-items-center">
                                    @if(count($item->paymentAccepts) > 0)
                                        <h3 class="monitor-social-title">@lang('Payment') : </h3>
                                        <ul class="monitor-social d-flex flex-wrap">
                                            @foreach ($item->paymentAccepts as $data)
                                                <li>
                                                    <div class="monitor-payment" data-toggle="tooltip" data-placement="bottom" title="{{ __($data->name) }}">
                                                        <img src="{{ getImage(getFilePath('paymentAccept').'/'. $data->image)}}" alt="payment">
                                                    </div>
                                                </li>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        <!-- quality-section start -->
        <section class="quality-section quality-section-four pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="quality-area">
                            <div class="quality-body text-center">
                                <div class="quality-thumb-area">
                                    <div class="quality-thumb">
                                        @php echo ads_show('728x90'); @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- quality-section end -->

        {{ $hyips->links() }}

        <!-- Modal -->
        <div class="modal fade" id="desModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">@lang('Description')</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="hiyp-dec"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn cmn-btn" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->


        <!-- Modal -->
        <div class="modal fade" id="voteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">@lang('Vote Now')</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('vote') }}" method="post">
                        @csrf
                        <input type="hidden" name="hyip_id">
                        <div class="modal-body">
                            <div class="vote-wrapper d-flex flex-wrap align-items justify-content-center">
                                @foreach($data['polls'] ?? [] as  $pollKey => $poll)
                                    <div class="form-check vote-check">
                                        <input class="form-check-input" type="radio" name="poll_id" id="inlineRadio{{$pollKey}}" value="{{ $poll->id }}">
                                        <label class="form-check-label" for="inlineRadio{{$pollKey}}">{{ __($poll->name) }} <span class="item{{ $pollKey }}"></span></label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn cmn-btn" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn cmn-btn">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->

        <!-- Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">@lang('Report Now')</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('report') }}" method="post">
                        @csrf
                        <input type="hidden" name="hyip_id">
                        <div class="modal-body">
                            <div class="form-group report-area">
                                <label>@lang('Subject')</label>
                                <input type="text" name="subject" class="form-control">
                            </div>
                            <div class="form-group report-area">
                                <label>@lang('Description')</label>
                                <textarea class="form-control" rows="4" name="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn cmn-btn" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn cmn-btn">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->


    </div>

@endsection
@push('style')
    <style>
        .express-section .nice-select{
            background: #ff0048;
            height: 32px;
            border-radius: 7px;
        }
        .express-section .nice-select .current {
            display: block;
            color: #fff;
            line-height: 1;
        }
        .express-section .nice-select:after {
            border-bottom: 2px solid #e8e4fd;
            border-right: 2px solid #e8e4fd;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($){
            "use strict";
            $(".click").click(function(){
                var url = "{{route('click.count')}}";
                var key = $(this).data('id');
                var data = {id:key}

                $.get(url, data,function(response){

                });

            });

            $(".hyip-click").click(function(){
                var url = "{{route('hyip.click.count')}}";
                var key = $(this).data('id');
                var data = {id:key}

                $.get(url, data,function(response){

                });

            });

            $('.desc').on('click', function () {
                var dec = $(this).data('dec');

                var modal = $('#desModal');
                modal.modal('show');
                modal.find('.hiyp-dec').text(dec);
            });

            $('.vote').on('click', function () {
                var modal = $('#voteModal');
                modal.find('input[name=hyip_id]').val($(this).data('hyip_id'));
                for(var i = 0; i < {{ $polls->count() }}; i++) {
                    modal.find(`.item${i}`).text($(this).data(`poll${i}`))
                }
                modal.modal('show');
            });

            $('.report').on('click', function () {
                var modal = $('#reportModal');
                modal.find('input[name=hyip_id]').val($(this).data('hyip_id'));
                modal.modal('show');
            });

            $(document).on("change", ".typeSelect", function() {
                window.location.href = "{{url('/')}}/hyips/"+$(this).val() ;
            });
        })(jQuery)
    </script>
@endpush
