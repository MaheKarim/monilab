@extends($activeTemplate .'layouts.auth')
@section('content')
    <section class="register-section add-list-section">
        <div class="container">
            <div class="add-list-area">
                <div class="row account-row justify-content-center align-items-center ml-b-20">
                    <div class="col-lg-12">
                        <div class="account-logo text-center">
                            <a class="site-logo site-title" href="{{route('home')}}"><img src="{{getImage(getFilePath('logo_icon') .'/logo.png')}}" alt="site-logo"></a>
                        </div>
                        <div class="account-header">
                            <h2 class="title">@lang('Login Now')</h2>
                        </div>
                        <div class="account-area">
                            @include($activeTemplate . "partials.social_login")
                            <div class="account-form-area">
                                <form class="add-list-form verify-gcaptcha" method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 form-group">
                                            <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <input type="password" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group col-lg-12 google-captcha d-flex justify-content-center">
                                            <x-captcha />

                                        </div>
                                        @include($activeTemplate.'partials.custom-captcha')
                                        <div class="col-lg-12 form-group">
                                            <div class="checkbox-wrapper d-flex flex-wrap align-items-center ">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="c1" name="remember">
                                                    <label for="c1">@lang('Remember me')</a></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <button type="submit" class="submit-btn" id="recaptcha">@lang('Login Now')</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="forgot-password"><a href="{{route('user.password.request')}}" class="account-control-button">@lang('Forgot Password?')</a></p>
                                <p class="terms-and-conditions">@lang('Don\'t Have An Account?') <a href="{{route('user.register')}}" class="account-control-button">@lang('Register Now')</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

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

@push('script')


    <script>
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>

@endpush
