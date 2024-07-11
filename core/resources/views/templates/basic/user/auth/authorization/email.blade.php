@extends($activeTemplate .'layouts.auth')
@section('content')
    <section class="register-section add-list-section">
        <div class="container">
            <div class="add-list-area">
                <div class="row account-row justify-content-center align-items-center ml-b-20">
                    <div class="col-lg-8">
                        <div class="account-logo text-center">
                            <a class="site-logo site-title" href="{{route('home')}}"><img src="{{getImage(getFilePath('logo_icon') .'/logo.png')}}" alt="site-logo"></a>
                        </div>
                    <form action="{{route('user.verify.email')}}" method="POST" class="submit-form">
                        @csrf
                        <p class="verification-text">@lang('A 6 digit verification code sent to your email address'):  {{ showEmailAddress(auth()->user()->email) }}</p>

                        @include($activeTemplate.'partials.verification_code')

                        <div class="mb-3">
                            <button type="submit" class="btn btn--base w-100 cmn-btn mb-3">@lang('Submit')</button>
                        </div>

                        <div class="mb-3">
                            <p class="verification-text">
                                @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a href="{{route('user.send.verify.code', 'email')}}" class="try-again-link d-none"> @lang('Try again')</a>
                            </p>
                            <a href="{{ route('user.logout') }}" class="cmn-btn">@lang('Logout')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
@push('style')
    <style>
        .verification-text, .verification-header {
            color: #ffffff;
        }
        .verification-code::after {
            display: none;
        }
        a {
            color: #ffffff;
        }
    </style>
@endpush
@push('script')
    <script>
        var distance =Number("{{@$user->ver_code_send_at->addMinutes(2)->timestamp-time()}}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush
