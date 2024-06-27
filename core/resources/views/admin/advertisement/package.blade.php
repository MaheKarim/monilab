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
                            @foreach ($packages as $item)
                                <tr>
                                    <td data-label="@lang('Package Name')">{{ __(Str::limit($item->name,25)) }}</td>
                                    <td data-label="Ad Size">
                                        {{$item->add_size}}
                                    </td>
                                    <td data-label="@lang('Price')">{{ $item->day }}</td>
                                    <td data-label="@lang('Price For')">{{ $item->price }}</td>
                                    <td data-label="@lang('Status')">
                                        @if($item->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Disabled')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')"><a href="#" class="icon-btn  updateBtn" data-route="{{ route('admin.advertise.package.update',$item->id) }}" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn"><i class="la la-pencil-alt"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Package')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.advertise.package.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Package Name')</label>
                            <input type="text"class="form-control" placeholder="@lang('Example : Gold')" name="name" required>
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
                            <label>@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="0" name="price" required/>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span
                                            class="currency_symbol">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Price For')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="0" name="day" required/>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span
                                            class="currency_symbol">@lang('Day')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status')</label>
                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Disabled" name="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Update METHOD MODAL --}}
    <div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Update Package')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="edit-route" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Package Name')</label>
                            <input type="text"class="form-control name" placeholder="@lang('Example : Gold')" name="name" required>
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
                            <label>@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" class="form-control form--control" placeholder="0" name="price" required/>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Price For')</label>
                            <div class="input-group">
                                <input type="number" class="form-control form--control day" placeholder="0" name="day" required/>
                                <span class="input-group-text">@lang('Day')</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status')</label>
                            <input id="status" type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Disabled" name="status" >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary float-sm-end addBtn"
       type="button"> <i class="las la-plus"></i>@lang('Add new')
    </button>
@endpush
@push('script')

    <script>
        (function($){
            "use strict";
            $('.addBtn').on('click', function () {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $('.updateBtn').on('click', function () {
                var modal = $('#updateBtn');

                var resourse = $(this).data('resourse');

                var route = $(this).data('route');
                $('.name').val(resourse.name);
                $('.price').val(resourse.price);
                $('.day').val(resourse.day);

                if(resourse.status == 0){
                    modal.find('.toggle').addClass('btn--danger off').removeClass('btn--success');
                    modal.find('input[name="status"]').prop('checked',false);
                }else{
                    modal.find('.toggle').removeClass('btn--danger off').addClass('btn--success');
                    modal.find('input[name="status"]').prop('checked',true);
                }

                $('select[name=add_size]').val(resourse.add_size);
                $('.edit-route').attr('action',route);
            });
        })(jQuery);

    </script>
@endpush
