@extends($activeTemplate .'layouts.auth')
@section('content')
<div class="pd-t-70 pd-b-70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            
                <div class="card custom--card">
                    <div class="card-body">
                        <h3 class="text-center text-danger">@lang('You are banned')</h3>
                        <p class="fw-bold mb-1">@lang('Reason'):</p>
                        <p>{{ $user->ban_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <style>
        .home-link {
            gap: 8px;
        }
    </style>
@endpush