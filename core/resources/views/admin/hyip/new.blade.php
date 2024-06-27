@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.main.hyip.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>@lang('Hyip Image')</h5>
                                        <div class="image-upload hyip-image-upload mt-2">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <x-image-uploader className="w-100" type="hyip" :required=true/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label font-weight-bold">@lang('Hyip Name')</label>
                                                <input type="text" class="form-control"
                                                       placeholder="@lang('Example : Demo Hyip')"
                                                       value="{{ old('name') }}"
                                                       name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label class="form-control-label font-weight-bold">@lang('URL')</label>
                                                <input type="url" class="form-control"
                                                       placeholder="@lang('Example') : https://www.demo.com/"
                                                       value="{{ old('url') }}" name="url" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label font-weight-bold">@lang('Rating')</label>
                                                <input type="number" class="form-control" name="rating"
                                                       placeholder="@lang('Example') : 4" value="{{ old('rating') }}"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-control-label font-weight-bold">@lang('Plan')</label>
                                                <input type="text" class="form-control"
                                                       placeholder="@lang('Example : 101.00% After 1 day / 1 day / $10 , 109.00% After 7 days / 7 days / $100')"
                                                       value="{{ old('plan') }}" name="plan" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label font-weight-bold">@lang('Minimum Deposit')</label>

                                                <div class="input-group">
                                                    <span class="input-group-text">{{ gs('cur_text') }}</span>
                                                    <input type="text" class="form-control form--control" name="minimum"
                                                           value="{{ old('minimum') }}" required/>
                                                    <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label font-weight-bold">@lang('Maximum Deposit')</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">{{ gs('cur_text') }}</div>
                                                    <input type="text" class="form-control form--control"
                                                           name="maximum"
                                                           value="{{ old('maximum') }}" required/>
                                                    <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label font-weight-bold">@lang('Type')</label>
                                                <select name="type_id" class="form-control" required>
                                                    <option value="" selected>@lang('Select One')</option>
                                                    @foreach ($types as $item)
                                                        <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label font-weight-bold">@lang('Withdraw Type')</label>
                                                <select name="withdraw_type" class="form-control" required>
                                                    <option value="" selected>@lang('Select One')</option>
                                                    <option value="1">@lang('Manual')</option>
                                                    <option value="2">@lang('Automatic')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label font-weight-bold">@lang('Monitor Since')</label>
                                                <input type="text" class="form-control form--control"
                                                       name="monitor_since"
                                                       placeholder="@lang('Example') : 2024-10-02"
                                                       value="{{ old('monitor_since') }}"
                                                       autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label font-weight-bold">@lang('Real Daily Profit')
                                                    (%)</label>
                                                <input type="text" class="form-control" name="daily_profit"
                                                       placeholder="@lang('Example') : 1.28"
                                                       value="{{ old('daily_profit') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">@lang('Period')</label>
                                        <input type="text" class="form-control" name="period"
                                               placeholder="@lang('Example : 7 days or Lifetime')"
                                               value="{{ old('period') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Ref. Bonus')
                                            (%)</label>
                                        <input type="text" class="form-control" name="ref_bonus"
                                               placeholder="@lang('Example') : 4.20"
                                               value="{{ old('ref_bonus') }}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">@lang('Ref. Link')</label>
                                        <input type="url" class="form-control" name="ref_link"
                                               placeholder="@lang('Example') : https://www.demo.com/"
                                               value="{{ old('ref_link') }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">
                                            @lang('Payment Accept')
                                        </label>

                                        <select class="select2-multi-select" name="payment_accept[]"
                                                multiple="multiple">
                                            @foreach ($payment_accepts as $item)
                                                <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">@lang('Features')</label>
                                        <select class="select2-multi-select" name="features[]"
                                                multiple="multiple">
                                            @foreach ($features as $item)
                                                <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">@lang('Status')</label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                               data-onstyle="-success"
                                               data-offstyle="-danger" data-bs-toggle="toggle" data-height="35"
                                               data-on="@lang('Enable')" data-off="@lang('Disable')"
                                               name="status">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">@lang('Make Top Payment Site')</label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                               data-onstyle="-success"
                                               data-offstyle="-danger" data-bs-toggle="toggle" data-height="35"
                                               data-on="@lang('Enable')" data-off="@lang('Disable')"
                                               name="top_payment_site">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">@lang('Principle Return')</label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                               data-onstyle="-success"
                                               data-offstyle="-danger" data-bs-toggle="toggle" data-height="35"
                                               data-on="@lang('Enable')" data-off="@lang('Disable')"
                                               name="principle_return">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">@lang('DDOS Protect')</label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                               data-onstyle="-success"
                                               data-offstyle="-danger" data-bs-toggle="toggle" data-height="35"
                                               data-on="@lang('Enable')" data-off="@lang('Disable')" name="ddos">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label
                                            class="form-control-label font-weight-bold">@lang('Description')</label>
                                        <textarea name="description" rows="6" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style-lib')
@endpush

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/daterangepicker.css')}}">

    <style>
        .hyip-image-upload .image--uploader {
            width: 100%;
        }
    </style>
@endpush

@push('script')

    <script src="{{asset('assets/admin/js/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script>
        $(function () {
            $('input[name="monitor_since"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, function (start, end, label) {
                var years = moment().diff(start, 'years');
                alert("You are " + years + " years old!");
            });
        });
    </script>
@endpush

