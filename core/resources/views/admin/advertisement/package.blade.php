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
                                <th scope="col">@lang('Package Name')</th>
                                <th scope="col">@lang('Ad Size')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Price For')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ __(Str::limit($package->name,25)) }}</td>
                                    <td>{{ $package->add_size}}</td>
                                    <td>{{ $package->price }}</td>
                                    <td>{{ $package->day }}</td>
                                    <td>@php echo $package->statusBadge @endphp </td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm"
                                                    data-modal_title="@lang('Edit Package')"
                                                    data-resource="{{ $package }}">
                                                <i class="las la-pencil-alt"></i>@lang('Edit')
                                            </button>
                                            @if ($package->status == Status::ACTIVE)
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this package?')"
                                                        data-action="{{ route('admin.advertise.package.status', $package->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this package?')"
                                                        data-action="{{ route('admin.advertise.package.status', $package->id) }}">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($packages->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($packages) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Add & Update Modal --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Package')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.advertise.package.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Package Name')</label>
                            <input type="text" class="form-control" placeholder="@lang('Example : Gold')" name="name"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Add Size')</label>
                            <select name="add_size" class="form-control" required>
                                <option value="" selected>@lang('Select One')</option>
                                <option value="728x90">@lang('728x90')</option>
                                <option value="160x600">@lang('160x600')</option>
                                <option value="300x600">@lang('300x600')</option>
                                <option value="160x160">@lang('160x160')</option>
                                <option value="300x250">@lang('300x250')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label
                                class="form-control-label font-weight-bold">@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" class="form-control form--control"
                                       name="price" step="0.01" required/>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label
                                class="form-control-label font-weight-bold">@lang('Price For')</label>
                            <div class="input-group">
                                <input type="number" class="form-control form--control"
                                       name="day" step="0.01" required/>
                                <span class="input-group-text">@lang('Day')</span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal/>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn"
            data-modal_title="@lang('Add New Package')" type="button"><i class="las la-plus"></i>@lang('Add new')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush
