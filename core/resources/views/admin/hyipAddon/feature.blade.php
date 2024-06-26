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
                            @forelse ($features as $feature)
                                <tr>
                                    <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                    <td data-label="@lang('Image')">
                                        <div class="customer-details d-block">
                                            <a class="thumb" href="javascript:void(0)">
                                                <img
                                                    src="{{ getImage(getFilePath('feature') . '/' . @$feature->image, getFileSize('feature')) }}"
                                                    alt="image">
                                            </a>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Name')">{{ __(Str::limit($feature->name, 20)) }}</td>
                                    <td data-label="@lang('Status')">@php echo $feature->statusBadge @endphp</td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm"
                                                    data-modal_title="@lang('Edit Feature')"
                                                    data-resource="{{ $feature }}"
                                            >
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </button>
                                            @if ($feature->status == Status::ACTIVE)
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this feature?')"
                                                        data-action="{{ route('admin.hyip.addon.feature.status',$feature->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this feature?')"
                                                        data-action="{{ route('admin.hyip.addon.feature.status',$feature->id) }}">
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
                    @if ($features->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($features) }}
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
                    <h5 class="modal-title">@lang('Feature')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.hyip.addon.feature.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            @if (!request()->routeIs('admin.hyip.addon.feature'))
                                <label>@lang('Name')</label>
                                <input name="method_id" type="hidden" value="{{ $feature->id }}">
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <x-image-uploader class="w-100" type="feature" :required=false />
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
        <x-search-form placeholder="Feature Name" />
    </div>
    <button class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn"
            data-modal_title="@lang('Add Feature')" type="button"> <i class="las la-plus"></i>@lang('Add new')
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

                    var image = "{{ asset(getFilePath('feature')) }}";
                    if(data){
                        var backImage = image + '/' + data.image;
                        $('.image-upload-preview').css('background-image', 'url(' + backImage + ')');
                    }else{
                        let defaultImage = `{{ getImage(getFilePath('feature'), getFileSize('feature')) }}`;
                        $('.image-upload-preview').css('background-image', 'url(' + defaultImage + ')');
                        $('input[name="image"]').val(defaultImage);
                    }
                });
            });

        })(jQuery);
    </script>
@endpush


