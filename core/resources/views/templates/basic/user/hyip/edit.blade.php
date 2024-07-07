@extends($activeTemplate.'layouts.master')

@section('content')
    @push('style')
        <!-- bootstrap toggle css -->
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-toggle.min.css')}}">
    @endpush

    @include($activeTemplate.'user.left-sidenav')
    <div class="main-body main-body-two">


        <!-- add-list-section start -->
        <section class="add-list-section pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">{{ __($pageTitle) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="add-list-area">
                    <div class="row justify-content-center ml-b-20">
                        <div class="col-lg-12 text-center">
                            <form class="add-list-form" action="{{ route('user.hyip.update',$hyip->id) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-8 form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                         style="background-image: url({{ getImage(getFilePath('temp_hyip').'/'. $hyip->image)}})">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit mt-4">
                                                    <input type="file" class="profilePicUpload d-none" name="image"
                                                           id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUpload1"
                                                           class="bg--success">@lang('Hyip Image')</label>
                                                    <small class="mt-2 text-white">@lang('Supported files'): <b>jpeg,
                                                            jpg, png</b>.
                                                        @lang('Image Will be resized to'):
                                                        <b>( {{ getFilePath(getFileSize('temp_hyip')) }} )</b> px.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-sm-4 form-group">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="text-left">@lang('Hyip Name') <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ __($hyip->name) }}"
                                                       placeholder="@lang('Example') : @lang('Demo Name')" required>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="text-left">@lang('URL') <span class="text-danger">*</span></label>
                                                <input type="url" name="url" value="{{ $hyip->url }}"
                                                       placeholder="@lang('Example') : https://www.demo.com/" required>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="text-left">@lang('Plan') <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="plan" value="{{ __($hyip->plan) }}"
                                                       placeholder="@lang('Example') : @lang('101.00% After 1 day / 1 day / $10 , 109.00% After 7 days / 7 days / $100')"
                                                       required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 form-group">
                                                <h5><label class="text-left">@lang('Minimum Deposit')</label></h5>

                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="0" value="{{ __($hyip->minimum) }}"
                                                           name="minimum" required>
                                                    <div class="input-group-append"><span
                                                            class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 form-group">
                                                <h5><label class="text-left">@lang('Maximum Deposit')</label></h5>

                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="0" value="{{ __($hyip->maximum) }}"
                                                           name="maximum" required>
                                                    <div class="input-group-append"><span
                                                            class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8 form-group">
                                        <label class="text-left">@lang('Real Daily Profit') (%) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="daily_profit" value="{{ __($hyip->daily_profit) }}"
                                               placeholder="@lang('Example') : 1.28">
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8 form-group">
                                        <label class="text-left">@lang('Period') <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="period" value="{{ __($hyip->period) }}"
                                               placeholder="@lang('Example') : @lang('7 days')" required>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8 form-group">
                                        <label class="text-left">@lang('Ref. Bonus') (%) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="ref_bonus" value="{{ __($hyip->ref_bonus) }}"
                                               placeholder="@lang('Example') : 4.20" required>
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-sm-8 form-group">
                                        <label class="text-left">@lang('Ref. Link') (%) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="ref_link" value="{{ $hyip->ref_link }}"
                                               placeholder="@lang('Example') : https://www.demo.com/">
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-8 form-group">
                                        <label class="text-left">@lang('Withdraw Type') <span
                                                class="text-danger">*</span></label>
                                        <div class="add-list-select">
                                            <select name="withdraw_type" required>
                                                <option value="" selected>@lang('Select One')</option>
                                                <option value="1">@lang('Manual')</option>
                                                <option value="2">@lang('Automatic')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-8 form-group">
                                        <label class="text-left">@lang('Principle Return') <span
                                                class="text-danger">*</span></label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                               data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle"
                                               data-on="Yes" data-off="No" name="principle_return"
                                               @if($hyip->principle_return) checked @endif>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8 form-group">
                                        <label class="text-left">@lang('DDOS Protect') <span
                                                class="text-danger">*</span></label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                               data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle"
                                               data-on="Yes" data-off="No" name="ddos" @if($hyip->ddos) checked @endif>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label class="feature-label">@lang('Features')</label>
                                        <div class="payment-list-area">
                                            <ul class="payment-list">
                                                @foreach ($features as $item)
                                                    <li>
                                                        <div class="payment-box d-flex flex-wrap">
                                                            <div class="form-check">
                                                                <input name="features[]" type="checkbox"
                                                                       value="{{ $item->id }}"
                                                                       id="features-{{ $item->id}}"
                                                                @foreach ($hyip->features as $data)
                                                                    {{ $data->id == $item->id ? 'checked' : '' }}
                                                                    @endforeach >
                                                            </div>
                                                            <label for="features-{{ $item->id }}" class="payment-label">
                                                                <span class="payment-check"><img class="icon-hyip"
                                                                                                 src="{{ getImage('assets/images/feature/'. $item->image) }}"
                                                                                                 title="{{ __($item->name) }}"
                                                                                                 alt="{{ __($item->name) }}"></span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="feature-label">@lang('Payment Accept')</label>
                                        <div class="payment-list-area">
                                            <ul class="payment-list">
                                                @foreach ($payment_accepts as $item)
                                                    <li>
                                                        <div class="payment-box d-flex flex-wrap">
                                                            <div class="form-check">
                                                                <input name="payment_accept[]" value="{{ $item->id }}"
                                                                       type="checkbox" id="accept-{{ $item->id }}"
                                                                @foreach ($hyip->paymentAccepts as $data)
                                                                    {{ $data->id == $item->id ? 'checked' : '' }}
                                                                    @endforeach >
                                                            </div>
                                                            <label for="accept-{{ $item->id }}">
                                                                <img class="icon-hyip payment-accept"
                                                                     src="{{ getImage('assets/images/payment_accept/'. $item->image) }}"
                                                                     title="{{ __($item->name) }}"
                                                                     alt="{{ __($item->name) }}">
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="text-left">@lang('Description') <span class="text-danger">*</span></label>
                                        <textarea rows="10" name="description" placeholder="@lang('Enter description')"
                                                  required>{{ __($hyip->description) }}</textarea>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <button type="submit" class="submit-btn">@lang('Update Now')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- add-list-section end -->
    </div>
@endsection
@push('script-lib')
    <!-- bootstrap-toggle js -->
    <script src="{{asset($activeTemplateTrue.'js/bootstrap-toggle.min.js')}}"></script>

@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            function proPicURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var preview = $(input).parents('.thumb').find('.profilePicPreview');
                        $(preview).css('background-image', 'url(' + e.target.result + ')');
                        $(preview).addClass('has-image');
                        $(preview).hide();
                        $(preview).fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".profilePicUpload").on('change', function () {
                proPicURL(this);
            });

            $(".remove-image").on('click', function () {
                $(this).parents(".profilePicPreview").css('background-image', 'none');
                $(this).parents(".profilePicPreview").removeClass('has-image');
                $(this).parents(".thumb").find('input[type=file]').val('');
            });

            $('select[name=withdraw_type]').val("{{$hyip->withdraw_type}}");
        })(jQuery);
    </script>
@endpush
