@php
    $registrationDisabled = getContent('register_disable.content',true);
@endphp
<div class="register-disable">
    <div class="container">
        <div class="register-disable-image">
            <img class="fit-image" src="{{ frontendImage('register_disable',@$registrationDisabled->data_values->image,'280x280') }}" alt="">
        </div>

        <h5 class="register-disable-title">{{ __(@$registrationDisabled->data_values->heading) }}</h5>
        <p class="register-disable-desc">
            {{ __(@$registrationDisabled->data_values->subheading) }}
        </p>
        <div class="text-center">
            <a href="{{ @$registrationDisabled->data_values->button_url }}" class="register-disable-footer-link cmn-btn">{{ __(@$registrationDisabled->data_values->button_name) }}</a>
        </div>
    </div>
</div>
@push('style')
    <style>
        .register-disable {
            border: 1px solid #cbc4c4;
            background: #0a1227;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .register-disable-image {
            margin: 0 auto;
            text-align: center;
        }

        .register-disable-title {
            margin-top: 25px;
            color: #fff;
        }
    </style>
@endpush
