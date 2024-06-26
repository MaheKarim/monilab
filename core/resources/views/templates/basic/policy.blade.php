@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-end">
                    <a href="{{ route('home') }}" class="fw-bold home-link"> <i class="las la-long-arrow-alt-left"></i> @lang('Go to Home')</a>
                </div>
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            echo $policy->data_values->details
                        @endphp
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
