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
                    <div class="card-body">
                        <h2 class="text-center text-white">@lang('You are banned')</h2>
                        <p class="fw-bold mb-1  ban-text">@lang('Reason') : </p>
                        <p class="ban-text">{{ $user->ban_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('style')
    <style>
        .ban-text {
            color: #ffffff;
        }
    </style>
@endpush
