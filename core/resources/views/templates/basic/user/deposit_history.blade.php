@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'user.left-sidenav')

    <div class="main-body main-body-two">

        <section class="deposit-table-section pd-t-30 pd-b-30">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-header">
                            <h2 class="section-title">{{ __($pageTitle) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="table-responsive deposit-table-area">
                            <table class="table custom--table">
                                <thead>
                                <tr>
                                    <th>@lang('Gateway | Transaction')</th>
                                    <th class="text-center">@lang('Initiated')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Conversion')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($deposits as $deposit)
                                    <tr>
                                        <td>
                                                <span class="fw-bold">
                                                    <span class="text-primary">
                                                        @if($deposit->method_code < 5000)
                                                            {{ __(@$deposit->gateway->name) }}
                                                        @else
                                                            @lang('Google Pay')
                                                        @endif
                                                    </span>
                                                </span>
                                            <br>
                                            <small> {{ $deposit->trx }} </small>
                                        </td>

                                        <td class="text-center">
                                            {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                        </td>
                                        <td class="text-center">
                                            {{ showAmount($deposit->amount ) }} + <span class="text--danger" data-bs-toggle="tooltip" title="@lang('Processing Charge')">{{ showAmount($deposit->charge)}} </span>
                                            <br>
                                            <strong data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount+$deposit->charge) }}
                                            </strong>
                                        </td>
                                        <td class="text-center">
                                            {{ showAmount(1) }}  =  {{ showAmount($deposit->rate,currencyFormat:false) }} {{__($deposit->method_currency)}}
                                            <br>
                                            <strong>{{ showAmount($deposit->final_amount,currencyFormat:false) }} {{__($deposit->method_currency)}}</strong>
                                        </td>
                                        <td class="text-center">
                                            @php echo $deposit->statusBadge @endphp
                                        </td>
                                        @php
                                            $details = [];
                                            if($deposit->method_code >= 1000 && $deposit->method_code <= 5000){
                                                foreach (@$deposit->detail ?? [] as $key => $info) {
                                                    $details[] = $info;
                                                    if ($info->type == 'file') {
                                                        $details[$key]->value = route('user.download.attachment',encrypt(getFilePath('verify').'/'.$info->value));
                                                    }
                                                }
                                            }
                                        @endphp

                                        <td>
                                            @if($deposit->method_code >= 1000 && $deposit->method_code <= 5000)
                                                <a href="javascript:void(0)" class="btn btn--base btn-sm detailBtn" data-info="{{ json_encode($details) }}"
                                                   @if ($deposit->status == Status::PAYMENT_REJECT)
                                                       data-admin_feedback="{{ $deposit->admin_feedback }}"
                                                    @endif
                                                >
                                                    <i class="fas fa-desktop"></i>
                                                </a>
                                            @else
                                                <button type="button" class="btn btn--success btn-sm" data-bs-toggle="tooltip" title="@lang('Automatically processed')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if($deposits->hasPages())
                    <div class="card-footer">
                        {{ paginateLinks($deposits) }}
                    </div>
                @endif
            </div>
        </section>
    </div>

    {{-- APPROVE MODAL --}}
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="modal-custom-btn " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mini-card-wrapper">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tile">
                                        <ul class="list-group">
                                            <li class="list-group-item">@lang('Amount') : <span class="withdraw-amount "></span></li>
                                            <li class="list-group-item">@lang('Charge') : <span class="withdraw-charge "></span></li>
                                            <li class="list-group-item">@lang('After Charge') : <span class="withdraw-after_charge"></span></li>
                                            <li class="list-group-item">@lang('Conversion Rate') : <span class="withdraw-rate"></span></li>
                                            <li class="list-group-item">@lang('Payable Amount') : <span class="withdraw-payable"></span></li>
                                        </ul>
                                        <ul class="list-group withdraw-detail mt-1"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn-btn" data-dismiss="modal">@lang('Cancel')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="modal-custom-btn " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn-btn" data-dismiss="modal">@lang('Cancel')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($){
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-charge').text($(this).data('charge'));
                modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
                modal.find('.withdraw-rate').text($(this).data('rate'));
                modal.find('.withdraw-payable').text($(this).data('payable'));
                var list = [];
                var details =  Object.entries($(this).data('info'));

                var ImgPath = "{{asset(getImage(getFilePath('depositVerify')))}}/";
                var singleInfo = '';
                for (var i = 0; i < details.length; i++) {
                    if (details[i][1].type == 'file') {
                        singleInfo += `<li class="list-group-item">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="..." class="w-100">
                                        </li>`;
                    }else{
                        singleInfo += `<li class="list-group-item">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${details[i][1].field_name}</span>
                                        </li>`;
                    }
                }

                if (singleInfo)
                {
                    modal.find('.withdraw-detail').html(`<br><strong class="my-3 text-white">@lang('Payment Information')</strong>  ${singleInfo}`);
                }else{
                    modal.find('.withdraw-detail').html(`${singleInfo}`);
                }
                modal.modal('show');
            });
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
