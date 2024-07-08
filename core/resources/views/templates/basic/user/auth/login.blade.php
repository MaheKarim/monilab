@extends($activeTemplate .'layouts.auth')
@section('content')
    <section class="register-section add-list-section">
        <div class="container">
            <div class="add-list-area">
                <div class="row account-row justify-content-center align-items-center ml-b-20">
                    <div class="col-lg-12">
                        <div class="account-logo text-center">
                            <a class="site-logo site-title" href="{{route('home')}}"><img src="{{getImage(getFilePath('logo_icon'))}}" alt="site-logo"></a>
                        </div>
                        <div class="account-header">
                            <h2 class="title">@lang('Login Now')</h2>
                        </div>
                        <div class="account-area">
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
