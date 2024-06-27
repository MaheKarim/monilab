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
                            @forelse ($all_hyips as $hyip)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>
                                        <div class="customer-details d-block">
                                            <a class="thumb" href="javascript:void(0)">
                                                <img
                                                    src="{{ getImage(getFilePath('hyip') . '/' . @$hyip->image, getFileSize('hyip')) }}"
                                                    alt="image">
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{ __(Str::limit($hyip->name, 20)) }}</td>
                                    <td>@php echo $hyip->statusBadge @endphp</td>
                                    <td>
                                        <div class="button-group">
                                                <a href="{{ route('admin.main.hyip.edit',$hyip->id) }}" role="button" class="icon-btn admin-edit-icon">
                                                    <i class="la la-pencil-alt"></i>
                                                </a>
                                            @if ($hyip->status == Status::ACTIVE)
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this payment method?')"
                                                        data-action="{{ route('admin.main.hyip.status', $hyip->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this payment method?')"
                                                        data-action="{{ route('admin.main.hyip.status', $hyip->id) }}">
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
                    @if ($all_hyips->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($all_hyips) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal/>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.main.hyip.new') }}" class="btn btn-sm btn-outline--primary float-sm-end"
            type="button"> <i class="las la-plus"></i>@lang('Add new')
    </a>
@endpush
@push('style')
    <style>
        .admin-edit-icon {
          padding: 5px 8px;
            display: inline-block;
        }
    </style>
@endpush


