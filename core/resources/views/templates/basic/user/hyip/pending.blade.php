@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'user.left-sidenav')

    <div class="main-body main-body-two">

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
                        <div class="deposit-table-area">
                            <table class="deposit-table">
                                <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Hyip Name')</th>
                                    <th>@lang('URL')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($hyips as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ Str::limit($item->name,40) }}</td>
                                        <td>{{ Str::limit($item->url,40) }}</td>
                                        <td><span
                                                class="badge badge-warning">@lang('Pending')</span></td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="" class="cmn-btn" data-toggle="modal"
                                               data-target="#hyip-details-{{ $item->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="hyip-details-{{ $item->id }}" tabindex="-1"
                                         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalCenterTitle">@lang('Hyips Details')</h5>
                                                    <button type="button" class="modal-custom-btn " data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mini-card-wrapper">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="tile">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-5">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Hyip Name') </label>
                                                                                </h5>
                                                                                <input type="text"
                                                                                       class="form-control form-control-lg add-size"
                                                                                       value="{{ __($item->name) }}"
                                                                                       readonly>
                                                                            </div>
                                                                            <div class="form-group col-md-7">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('URL') </label>
                                                                                </h5>
                                                                                <input type="url"
                                                                                       class="form-control form-control-lg add-size"
                                                                                       value="{{ __($item->url) }}"
                                                                                       readonly>
                                                                            </div>

                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Minimum Deposit')</label>
                                                                                </h5>
                                                                                <div class="input-group">

                                                                                    <input type="text"
                                                                                           class="form-control form-control-lg"
                                                                                           value="{{ __($item->minimum) }}"
                                                                                           readonly>
                                                                                    <div class="input-group-append">
                                                                                        <span
                                                                                            class="input-group-text">{{ gs('cur_sym') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Maximum Deposit')</label>
                                                                                </h5>
                                                                                <div class="input-group">

                                                                                    <input type="text"
                                                                                           class="form-control form-control-lg"
                                                                                           value="{{ __($item->maximum) }}"
                                                                                           readonly>
                                                                                    <div class="input-group-append">
                                                                                        <span
                                                                                            class="input-group-text">{{ gs('cur_sym' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Withdraw Type') </label>
                                                                                </h5>
                                                                                <input type="text"
                                                                                       class="form-control form-control-lg add-size"
                                                                                       value="@if($item->withdraw_type == 1) @lang('Manual') @elseif($item->withdraw_type == 2) @lang('Automatic') @endif"
                                                                                       readonly>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Referral Bonus')
                                                                                        (%)</label></h5>
                                                                                <input type="text"
                                                                                       class="form-control form-control-lg  add-size"
                                                                                       value="{{ __($item->ref_bonus) }}"
                                                                                       readonly>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Real Daily Profit')
                                                                                        (%)</label></h5>
                                                                                <input type="text"
                                                                                       class="form-control form-control-lg  add-size"
                                                                                       value="{{ __($item->daily_profit) }}"
                                                                                       readonly>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Period')</label>
                                                                                </h5>
                                                                                <input type="text"
                                                                                       class="form-control form-control-lg  add-size"
                                                                                       value="{{ __($item->period) }}"
                                                                                       readonly>
                                                                            </div>
                                                                            @if ($item->ref_link != null)
                                                                                <div class="form-group col-md-4">
                                                                                    <h5><label
                                                                                            for="exampleInputEmail1">@lang('Ref. Link')</label>
                                                                                    </h5>
                                                                                    <input type="url"
                                                                                           class="form-control form-control-lg  add-size"
                                                                                           value="{{ __($item->ref_link) }}"
                                                                                           readonly>
                                                                                </div>
                                                                            @endif

                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Principle Return') </label>
                                                                                </h5>
                                                                                <input type="text"
                                                                                       class="form-control form-control-lg add-size"
                                                                                       value="@if($item->principle_return) @lang('Yes') @else @lang('No') @endif"
                                                                                       readonly>
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('DDOS Protect') </label>
                                                                                </h5>
                                                                                <input type="text"
                                                                                       class="form-control form-control-lg add-size"
                                                                                       value="@if($item->ddos) @lang('Yes') @else @lang('No') @endif"
                                                                                       readonly>
                                                                            </div>

                                                                            @if ($item->image != null)
                                                                                <div class="form-group col-md-12">
                                                                                    <h5><label
                                                                                            for="exampleInputEmail1">@lang('Hyip Image')</label>
                                                                                    </h5>
                                                                                    <div class="form-group">
                                                                                        <img
                                                                                            class="img-fluid home-image"
                                                                                            src="{{ getImage(getFilePath('temp_hyip')).'/'. $item->image }}"
                                                                                            alt="@lang('hyip image')">
                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                            <div class="form-group col-md-6">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Features')</label>
                                                                                </h5>
                                                                                <div class="pyamentmethod pm2">
                                                                                    @foreach ($item->features as $data)
                                                                                        <img style="width: 30px" src="{{ getImage(getFilePath('feature').'/'. $data->image,getFileSize('feature'))}}" title="{{ __($data->name) }}" alt="Image">
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Payment Accept')</label>
                                                                                </h5>
                                                                                <div
                                                                                    class="pyamentmethod pm2 user-hyip-update-payment">
                                                                                    @foreach ($item->paymentAccepts as $data)
                                                                                        <img src="{{ getImage(getFilePath('payment_accept').'/'. $data->image,getFileSize('payment_accept'))}}" title="{{ __($data->name) }}" alt="Image">
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Plans')</label>
                                                                                </h5>

                                                                                <div class="relativeArea">
                                                                                    <p>{{ __($item->plan) }}</p>
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <h5><label
                                                                                        for="exampleInputEmail1">@lang('Description')</label>
                                                                                </h5>
                                                                                <div class="relativeArea">
                                                                                    <p>{{ __($item->description) }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn cmn-btn" data-dismiss="modal"
                                                            aria-label="Close">Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            </div>
        </section>
        <!-- deposit-table-section end -->
    </div>

@endsection
