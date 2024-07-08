@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'partials.left-sidenav')

    @php
        $contact_element = getContent('contact_us.element',false);
    @endphp
    <div class="main-body">
        <!-- contact-section start -->
        <section class="contact-section add-list-section pd-t-30">
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
                            <form class="add-list-form" method="post" action="">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <input type="text" name="name" placeholder="@lang('Your Name')" value="{{old('name')}}" required>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <input type="email" name="email" placeholder="@lang('Your Email')" value="{{old('email')}}" required>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <input type="text" name="subject" placeholder="@lang('Your Subject')" value="{{old('subject')}}" required>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <textarea name="message" placeholder="@lang('Your Message')" rows="5">{{old('message')}}</textarea>
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
        <!-- contact-section end -->


        <!-- contact-info start -->
        <div class="contact-info-area pd-t-30">
            <div class="custom-container">
                <div class="contact-info-item-area">
                    <div class="row justify-content-center ml-b-30">
                        @foreach ($contact_element as $item)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 text-center mrb-30">
                                <div class="contact-info-item">
                                    @php
                                        echo $item->data_values->icon;
                                    @endphp
                                    <h3 class="title">{{ __($item->data_values->title) }}</h3>
                                    <p>{{ __($item->data_values->short_details) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- contact-info end -->

        <!-- @php echo ads_show(2) @endphp -->
        <!-- quality-section start -->
        <section class="quality-section quality-section-four pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="quality-area">
                            <div class="quality-body text-center">
                                <div class="quality-thumb-area">
                                    <div class="quality-thumb">
                                        @php echo ads_show('728x90'); @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- quality-section end -->
    </div>
    @include($activeTemplate.'partials.right-sidenav')
@endsection
