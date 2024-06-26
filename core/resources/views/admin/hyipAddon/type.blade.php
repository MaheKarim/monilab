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
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse ($types as $type)
                                <tr>
                                    <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                    <td data-label="@lang('Name')">{{ __(Str::limit($type->name, 20)) }}</td>
                                    <td data-label="@lang('Status')">@php echo $type->statusBadge @endphp</td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm"
                                                    data-modal_title="@lang('Edit Type')"
                                                    data-resource="{{ $type }}"
                                            >
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </button>
                                            @if ($type->status == Status::ACTIVE)
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this type?')"
                                                        data-action="{{ route('admin.hyip.addon.type.status',$type->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this type?')"
                                                        data-action="{{ route('admin.hyip.addon.type.status',$type->id) }}">
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
                    @if ($types->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($types) }}
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
                <form action="{{ route('admin.hyip.addon.type.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            @if (!request()->routeIs('admin.hyip.addon.type'))
                                <label>@lang('Name')</label>
                                <input name="method_id" type="hidden" value="{{ $type->id }}">
                            @endif
                        </div>

                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" autocomplete="off" required>
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
        <x-search-form placeholder="Hyip Type" />
    </div>
    <button class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn"
            data-modal_title="@lang('Add Hyip Type')" type="button"> <i class="las la-plus"></i>@lang('Add new')
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
                });
            });
        })(jQuery);
    </script>
@endpush


