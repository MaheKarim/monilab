@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'user.left-sidenav')

    <div class="main-body main-body-two">

        <!-- deposit-table-section start -->
        <section class="deposit-table-section pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">@lang('Your Advertisements')</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="deposit-table-area">
                            <table class="deposit-table">
                                <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Hyip Name')</th>
                                    <th>@lang('URL')</th>
                                    <th>@lang('Click')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($hyips as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ Str::limit($item->name,40) }}</td>
                                        <td>{{ Str::limit($item->url,40) }}</td>
                                        <td>{{ $item->click }}</td>
                                        <td>
                                            @php echo $item->statusBadge @endphp
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            <a class="cmn-btn" href="{{ route('user.hyip.edit',$item->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">{{ __($empty_message) }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- deposit-table-section end -->
    </div>

@endsection
