<div class="header-right-sidebar">
    <div class="sidebar-inner text-center">
        <div class="header-add-area slot-3">
            @php echo ads_show('300x600'); @endphp
        </div>
        <div class="header-add-area slot-4">
            @php echo ads_show('300x250'); @endphp
        </div>
        <div class="payment-site mrb-30">
            <h3 class="title">@lang('Top Payment Sites')</h3>
            <ul class="payment-site-list">
                @forelse ($top_payment_hyips as $item)
                    <li><a class="hyip-click" href="{{ ($item->url) }}" data-id="{{ $item->id }}" target="_blank">{{ Str::limit(__($item->name),25) }}</a></li>
                @empty
                    <li>@lang('No top payment site found')</li>
                @endforelse
            </ul>
        </div>

        <div class="payment-site mrb-30">
            <h3 class="title">@lang('Top Monitor Sites')</h3>
            <ul class="payment-site-list">
                @forelse ($top_monitor_hyips as $item)
                    <li><a href="{{ $item->url }}" class="hyip-click" data-id="{{ $item->id }}" target="_blank">{{ __($item->name) }}</a> <span>{{\Carbon\Carbon::createFromTimeStamp(strtotime($item->monitor_since ))->diffInDays()}} @lang('Days')</span></li>
                @empty
                    <li>@lang('No top monitor site found')</li>
                @endforelse
            </ul>
        </div>

        <div class="payment-site mrb-30">
            <h3 class="title">@lang('Total Reaction')</h3>
            <ul class="payment-site-list">
                <li class="d-flex flex-wrap justify-content-between">@lang('Happy') ({{ __($happy) }})
                    <div class="payment-thumb">
                        <img src="{{ asset('/assets') }}/images/emoji/happy.png" alt="emoji">
                    </div>
                </li>
                <li class="d-flex flex-wrap justify-content-between">@lang('Sad') ({{ __($sad) }})
                    <div class="payment-thumb">
                        <img src="{{ asset('/assets') }}/images/emoji/emoji-2.png" alt="emoji">
                    </div>
                </li>
                <li class="d-flex flex-wrap justify-content-between">@lang('Wow') ({{ __($wow) }})
                    <div class="payment-thumb">
                        <img src="{{ asset('/assets') }}/images/emoji/emoji-3.png" alt="emoji">
                    </div>
                </li>
                <li class="d-flex flex-wrap justify-content-between">@lang('Love') ({{ __($love) }})
                    <div class="payment-thumb">
                        <img src="{{ asset('/assets') }}/images/emoji/emoji-4.png" alt="emoji">
                    </div>
                </li>
                <li class="d-flex flex-wrap justify-content-between">@lang('Angry') ({{ __($angry) }})
                    <div class="payment-thumb">
                        <img src="{{ asset('/assets') }}/images/emoji/angry.png" alt="emoji">
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
