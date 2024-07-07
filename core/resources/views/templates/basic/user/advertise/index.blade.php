@extends($activeTemplate.'layouts.master')

@section('content')
    @include($activeTemplate.'user.left-sidenav')

    <div class="main-body main-body-two">
        <!-- advertise-section start -->
        <section class="advertise-section pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">@lang('Advertise Package')</h2>
                        </div>
                    </div>
                </div>
                <div class="advertise-area">
                    <div class="row justify-content-center ml-b-30">
                        @foreach ($packages as $item)
                            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                                <div class="advertise-item">
                                    <h3 class="title">{{ __($item->name) }}</h3>
                                    <div class="advertise-content-area">
                                        <ul class="advertise-list">
                                            <li><a href="#0">@lang('Price For')
                                                    <span>{{ __($item->day) }} @lang('Day')</span></a></li>
                                            <li>
                                                <a href="#0">@lang('Size')
                                                    <span>
                                                    {{$item->add_size}}
                                                </span>
                                                </a>
                                            </li>
                                            <li><a href="#0">@lang('Price')
                                                    <span>{{ __(showAmount($item->price)) }} </span></a>
                                            </li>
                                        </ul>
                                        <div class="advertise-btn text-center">
                                            <a href="{{ route('user.advertise.new',$item->id) }}"
                                               class="cmn-btn">@lang('Add')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- deposit-method-section end -->

        <!-- deposit-table-section start -->
        <section class="deposit-table-section pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">{{ __($pageTitle) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="deposit-table-area table-responsive">
                            <table class="deposit-table">
                                <thead>
                                <tr>
                                    <th>@lang('Add Size')</th>
                                    <th>@lang('URL')</th>
                                    <th>@lang('Impression')</th>
                                    <th>@lang('Click')</th>
                                    <th>@lang('Start Date')</th>
                                    <th>@lang('End Date')</th>
                                    <th>@lang('Total Price')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($adds as $item)
                                    <tr>
                                        <td data-label="@lang('Add Size')">
                                            {{$item->add_size}}

                                        </td>
                                        <td data-label="@lang('URL')">{{ $item->url }}</td>
                                        <td data-label="@lang('Impression')">{{ $item->impression }}</td>
                                        <td data-label="@lang('Click')">{{ $item->click }}</td>
                                        <td data-label="@lang('Start Date')">
                                            @if($item->start_date)
                                                {{ $item->start_date }}
                                            @else
                                                <span class="badge badge-main">@lang('Not Available')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('End Date')">
                                            @if($item->end_date)
                                                {{ $item->end_date }}
                                            @else
                                                <span class="badge badge-main">@lang('Not Available')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Total Price')">{{ $item->price }}{{ $general->cur_sym }}</td>

                                        <td data-label="@lang('Status')">
                                            @if($item->status == 0)
                                                <span class="badge badge-warning">@lang('Pending')</span>
                                            @else
                                                @if($current_time > $item->end_date)
                                                    <span class="badge badge-danger">@lang('Expired')</span>
                                                @else
                                                    <span class="badge badge-success">@lang('Active')</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">{{ __($empty_message) }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <nav>
                    {{ $adds->links() }}
                </nav>
            </div>
        </section>
        <!-- deposit-table-section end -->
    </div>
@endsection
