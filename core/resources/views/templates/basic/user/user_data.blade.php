@extends($activeTemplate . "layouts.auth")
@section("content")
    <div class="pd-b-100 pd-t-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-end mb-2">
                        <a class="fw-bold home-link" href="{{ route("home") }}"> <i class="las la-long-arrow-alt-left"></i> @lang("Go to Home")</a>
                    </div>
                    <div class="card custom--card">
                        <div class="card-header account-header">
                            <h5 class="card-title">{{ __($pageTitle) }}</h5>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route("user.data.submit") }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang("Username")</label>
                                            <input class="form-control form--control checkUser" name="username" type="text" value="{{ old("username") }}">
                                            <small class="text--danger usernameExist"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang("Country")</label>
                                            <select class="form-control form--control select2" name="country" required>
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" data-code="{{ $key }}" value="{{ $country->country }}">{{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang("Mobile")</label>
                                            <div class="input-group">
                                                <span class="input-group-text mobile-code">

                                                </span>
                                                <input name="mobile_code" type="hidden">
                                                <input name="country_code" type="hidden">
                                                <input class="form-control form--control checkUser" name="mobile" type="number" value="{{ old("mobile") }}" required>
                                            </div>
                                            <small class="text--danger mobileExist"></small>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang("Address")</label>
                                        <input class="form-control form--control" name="address" type="text" value="{{ old("address") }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang("State")</label>
                                        <input class="form-control form--control" name="state" type="text" value="{{ old("state") }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang("Zip Code")</label>
                                        <input class="form-control form--control" name="zip" type="text" value="{{ old("zip") }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang("City")</label>
                                        <input class="form-control form--control" name="city" type="text" value="{{ old("city") }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn cmn-btn w-100" type="submit">
                                        @lang("Submit")
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("style-lib")
    <link href="{{ asset("assets/global/css/select2.min.css") }}" rel="stylesheet">
@endpush

@push("script-lib")
    <script src="{{ asset("assets/global/js/select2.min.js") }}"></script>
@endpush

@push("script")
    <script>
        "use strict";
        (function($) {

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('.select2').select2();

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route("user.checkUser") }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }
        })(jQuery);
    </script>
@endpush

@push("style")
    <style>
        .selection {
            width: 100%;
        }

        .select2-container--default .select2-selection--single {
            background-color: #0f1932 !important;
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff !important;
            line-height: 38px !important;
        }
        .select2-container .select2-selection--single {
            height: 38px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px !important;
        }
    </style>
@endpush
