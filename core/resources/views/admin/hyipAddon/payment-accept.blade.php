@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse ($payment_accepts as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>
                                        <div class="customer-details d-block">
                                            <a class="thumb" href="javascript:void(0)">
                                                <img
                                                    src="{{ getImage(getFilePath('paymentAccept') . '/' . @$item->image, getFileSize('paymentAccept')) }}"
                                                    alt="image">
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{ __(Str::limit($item->name, 20)) }}</td>
                                    <td>@php echo $item->statusBadge @endphp</td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm"
                                                    data-modal_title="@lang('Edit Payment Method')"
                                                    data-resource="{{ $item }}"
                                            >
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </button>
                                            @if ($item->status == Status::ACTIVE)
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this payment method?')"
                                                        data-action="{{ route('admin.hyip.addon.payment.accept.status',$item->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this payment method?')"
                                                        data-action="{{ route('admin.hyip.addon.payment.accept.status',$item->id) }}">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($payment_accepts->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($payment_accepts) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

{{--  Create & Update Modal --}}
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add Payment Method')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.hyip.addon.payment.accept.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            @if (!request()->routeIs('admin.hyip.addon.payment.accept'))
                                <label>@lang('Payment Method Name')</label>
                                <input name="method_id" type="hidden" value="{{ $item->id }}">
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('Payment Method Name')</label>
                            <input class="form-control" name="name" type="text" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <x-image-uploader class="w-100" type="paymentAccept" :required=false />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100 actionBtn" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal/>

@endsection
@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end align-items-center flex-wrap gap-2">
        <x-search-form placeholder="Method Name" />
    </div>
    <button class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn"
            data-modal_title="@lang('Add Payment Method')" type="button"> <i class="las la-plus"></i>@lang('Add new')
    </button>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>

    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                $('.cuModalBtn').on('click', function () {
                    var data = $(this).data('resource');

                    var image = "{{ asset(getFilePath('paymentAccept')) }}";
                    if(data){
                        var backImage = image + '/' + data.image;
                        $('.image-upload-preview').css('background-image', 'url(' + backImage + ')');
                    }else{
                        let defaultImage = `{{ getImage(getFilePath('paymentAccept'), getFileSize('paymentAccept')) }}`;
                        $('.image-upload-preview').css('background-image', 'url(' + defaultImage + ')');
                        $('input[name="image"]').val(defaultImage);
                    }
                });
            });

        })(jQuery);
    </script>
@endpush


