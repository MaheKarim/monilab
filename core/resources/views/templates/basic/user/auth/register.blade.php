@extends($activeTemplate . "layouts.auth")

@section("content")
    @if (gs("registration"))
        <section class="register-section add-list-section">
            <div class="pd-t-70 pd-b-70">
                <div class="container">
                    <div class="add-list-area">
                        <div class="row justify-content-center account-row align-items-center ml-b-20">
                            <div class="col-lg-12">
                                <div class="account-logo text-center">
                                    <a class="site-logo site-title" href="{{ route("home") }}"><img src="{{ getImage(getFilePath("logo_icon") . "/logo.png") }}" alt="site-logo"></a>
                                </div>
                                <div class="account-header">
                                    <h5 class="title">@lang("Register")</h5>
                                </div>
                                <div class="account-area">
    
                                    <div class="account-form-area">
                                        @include($activeTemplate . "partials.social_login")
                                        <form class="verify-gcaptcha disableSubmission add-list-form" action="{{ route("user.register") }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                @if (session()->get("reference") != null)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="referenceBy">@lang("Reference by")</label>
                                                            <input class="form-control form--control" id="referenceBy" name="referBy" type="text" value="{{ session()->get("reference") }}" readonly>
                                                        </div>
                                                    </div>
                                                @endif
    
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">@lang("First Name")</label>
                                                    <input class="form-control form--control" name="firstname" type="text" value="{{ old("firstname") }}" required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">@lang("Last Name")</label>
                                                    <input class="form-control form--control" name="lastname" type="text" value="{{ old("lastname") }}" required>
                                                </div>
    
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang("E-Mail Address")</label>
                                                        <input class="form-control form--control checkUser" name="email" type="email" value="{{ old("email") }}" required>
                                                    </div>
                                                </div>
    
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang("Password")</label>
                                                        <input class="form-control form--control @if (gs("secure_password")) secure-password @endif" name="password" type="password" required>
                                                    </div>
                                                </div>
    
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang("Confirm Password")</label>
                                                        <input class="form-control form--control" name="password_confirmation" type="password" required>
                                                    </div>
                                                </div>
    
                                                <x-captcha />
    
                                            </div>
    
                                            @if (gs("agree"))
                                                @php
                                                    $policyPages = getContent("policy_pages.element", false, orderById: true);
                                                @endphp
                                                <div class="form-group form--check-label">
                                                    <div class="d-flex align-items-center form-check">
                                                        <input id="agree" name="agree" type="checkbox" @checked(old("agree")) required>
                                                        <label for="agree">@lang("I agree with")</label>
                                                    </div>
                                                     <span class="form--check-label__link">
                                                        @foreach ($policyPages as $policy)
                                                            <a href="{{ route("policy.pages", $policy->slug) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <button class="submit-btn w-100" id="recaptcha" type="submit"> @lang("Register")</button>
                                            </div>
                                            <p class="mb-0 text-white">@lang("Already have an account?")
                                                <a href="{{ route("user.login") }}">@lang("Login")</a>
                                            </p>
                                        </form>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="existModalLongTitle">@lang("You are with us")</h5>
                        <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center">@lang("You already have an account please Login ")</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark btn-sm" data-bs-dismiss="modal" type="button">@lang("Close")</button>
                        <a class="btn btn--base btn-sm" href="{{ route("user.login") }}">@lang("Login")</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include($activeTemplate . "partials.registration_disabled")
    @endif

@endsection
@if (gs("registration"))

    @push("style")
        <style>
            .social-login-btn {
                border: 1px solid #ffffff2e;
                color: #fff;
                border-radius: 4px;
            }
            .social-login-btn:hover {
                border-color: #ffffff2e;
                color: #fff;
            }
            .social-login-btn:focus {
                border-color: #ffffff2e;
                color: #fff;
            }
            .register-disable {
                height: 100vh;
                width: 100%;
                background-color: #fff;
                color: black;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .register-disable-image {
                max-width: 300px;
                width: 100%;
                margin: 0 auto 32px;
            }

            .register-disable-title {
                color: rgb(0 0 0 / 80%);
                font-size: 42px;
                margin-bottom: 18px;
                text-align: center
            }

            .register-disable-icon {
                font-size: 16px;
                background: rgb(255, 15, 15, .07);
                color: rgb(255, 15, 15, .8);
                border-radius: 3px;
                padding: 6px;
                margin-right: 4px;
            }

            .register-disable-desc {
                color: rgb(0 0 0 / 50%);
                font-size: 18px;
                max-width: 565px;
                width: 100%;
                margin: 0 auto 32px;
                text-align: center;
            }

            .register-disable-footer-link {
                color: #fff;
                background-color: #5B28FF;
                padding: 13px 24px;
                border-radius: 6px;
                text-decoration: none
            }

            .register-disable-footer-link:hover {
                background-color: #440ef4;
                color: #fff;
            }
        </style>
    @endpush

    @if (gs("secure_password"))
        @push("script-lib")
            <script src="{{ asset("assets/global/js/secure_password.js") }}"></script>
        @endpush
    @endif

    @push("script")
        <script>
            "use strict";
            (function($) {

                $('.checkUser').on('focusout', function(e) {
                    var url = '{{ route("user.checkUser") }}';
                    var value = $(this).val();
                    var token = '{{ csrf_token() }}';

                    var data = {
                        email: value,
                        _token: token
                    }

                    $.post(url, data, function(response) {
                        if (response.data != false) {
                            $('#existModalCenter').modal('show');
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush

@endif
