@extends($activeTemplate.'layouts.master')

@section('content')

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
                        <div class="col-lg-12">
                            <form class="add-list-form" action="{{ route('user.advertise.store',$package->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <h5><label for="exampleInputEmail1">@lang('Name')</label> </h5>
                                        <input type="text" placeholder="{{ __($package->name) }}" readonly>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <h5><label for="exampleInputEmail1">@lang('Advertisement Size')</label> </h5>
                                        <input type="text" placeholder="{{$package->add_size}}" readonly>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <h5><label for="exampleInputEmail1">@lang('Advertise For')</label> </h5>
                                        <div class="input-group">
                                            <input type="number" id="add-day" class="form-control form-control-lg" name="day" value="{{ $package->day }}" data-resource="{{ $package }}" required>
                                                <span class="input-group-text">@lang('Day')</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <h5><label for="exampleInputEmail1">@lang('Price')</label> </h5>
                                        <div class="input-group">
                                            <input type="number" id="price" class="form-control form-control-lg" value="{{ $package->price }}" readonly>
                                                <span class="input-group-text">{{ __(gs('cur_sym')) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <h5><label for="exampleInputEmail1">@lang('URL')</label> </h5>
                                        <input type="url" name="url" placeholder="Example : https://demo.com/" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <h5><label for="exampleInputEmail1">@lang('Advertise Image')</label> </h5>
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg, .gif" required>
                                    </div>


                                    <div class="col-lg-12 form-group">
                                        <button type="submit" class="submit-btn">@lang('Submit Now')</button>
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

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('#add-day').on('input', function() {
                var value = $(this).val();
                var resource = $(this).data('resource');

                if (parseInt(value) <= 0) {
                    alert('This Value can not be negative or zero');
                    $("#add-day").val(resource.day);
                    $("#price").val(resource.price);
                }else{
                    var one_day_price = parseInt(resource.price) / parseInt(resource.day);
                    var final_price = Math.round((parseInt(value) * one_day_price));
                    $('#price').val(final_price.toFixed(2));
                }
            });
        })(jQuery);

    </script>
@endpush
