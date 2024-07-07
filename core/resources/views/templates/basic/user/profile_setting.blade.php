@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'user.left-sidenav')


    <div class="main-body main-body-two">

        <!-- profile-section start -->
        <section class="profile-section add-list-section pd-t-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">{{ __($pageTitle) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="add-list-area">
                    <form class="add-list-form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center ml-b-20">
                            <div class="col-lg-4 mrb-20">
                                <div class="profile-bar text-center">
                                    <div class="profile-content">
                                        <h3 class="title">{{ __($user->firstname) }} {{ __($user->lastname) }}</h3>
                                    </div>
                                    <div class="profile-thumb">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('userProfile').'/'. $user->image, getFilePath('userProfile'))}})">
                                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit mt-4">
                                                    <input type="file" class="profilePicUpload d-none" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label class="text-white" for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                                                    <small class="mt-2 text-white">@lang('Supported files'): <b>jpeg, jpg, png</b>.
                                                        @lang('Image Will be resized to'): <b>( {{getImage(getFilePath('userProfile'))}} )</b> px.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-8 mrb-20">
                                <div class="row ml-b-20">
                                    <div class="col-lg-12 form-group">
                                        <h3 class="title text-white">@lang('Profile Update')</h3>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('First Name')</label>
                                        <input type="text" name="firstname" value="{{ __($user->firstname) }}" placeholder="@lang('First Name')" required>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('Last Name')</label>
                                        <input type="text" name="lastname" value="{{ __($user->lastname) }}" placeholder="@lang('Last Name')" required>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('Email')</label>
                                        <input type="email" name="email" value="{{ $user->email }}" placeholder="@lang('Your Email')" required>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('Phone No')</label>
                                        <input type="text" name="mobile" value="{{ $user->mobile }}"  placeholder="@lang('Mobile Number')">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('Address')</label>
                                        <input type="text" name="address" value="{{ @$user->address }}"  placeholder="@lang('Address')">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('State')</label>
                                        <input type="text" name="state" value="{{ @$user->state }}"  placeholder="@lang('State')">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('Zip Code')</label>
                                        <input type="text" name="zip" value="{{ @$user->zip }}"  placeholder="@lang('Zip Code')">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="">@lang('City')</label>
                                        <input type="text" name="city" value="{{ @$user->city }}"  placeholder="@lang('City')">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <button type="submit" class="submit-btn">@lang('Update Now')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- profile-section end -->

        <section class="profile-section add-list-section pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">@lang('Password Update')</h2>
                        </div>
                    </div>
                </div>
                <div class="add-list-area">
                    <form class="add-list-form" action="{{ route('user.password.update') }}" method="post">
                        @csrf
                        <div class="row justify-content-center ml-b-20">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <input type="password" name="current_password"  placeholder="@lang('Current Password')" required>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <input type="password" name="password" placeholder="@lang('New Password')" required>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <input type="password" name="password_confirmation" placeholder="@lang('Confirm password')" required>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <button type="submit" class="submit-btn">@lang('Update Now')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('script')
    <script>
        (function($){
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
        })(jQuery);
    </script>
@endpush
