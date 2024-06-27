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
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('View')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach ($all_hyips as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td><a href="{{ route('admin.users.detail',$item->user->id) }}">{{ $item->user->username }}</a></td>
                                    @if($item->image != null)
                                        <td >
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('temp_hyip').'/'. $item->image)}}" alt="image">
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td data-label="@lang('Image')">@lang('No Image Update Request')</td>
                                    @endif
                                    <td data-label="@lang('Name')">{{ __(Str::limit($item->name,20)) }}</td>
                                    <td data-label="@lang('Status')">
                                        <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                    </td>
                                    <td data-label="@lang('Created At')">{{ showDateTime($item->created_at,'d M, Y') }}</td>
                                    <td data-label="@lang('Action')"><a href="" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id }}" class="icon-btn"><i class="fas fa-eye"></i></a></td>
                                </tr>

                                <div class="modal fade bd-example-modal-lg-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">@lang('Hyip Details')</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-md-5">
                                                        <label class="form-control-label font-weight-bold">@lang('Hyip Name')</label>
                                                        <input type="text" class="form-control" value="{{ __($item->name) }}" readonly>
                                                    </div>
                                                    <div class="form-group col-md-7">
                                                        <label class="form-control-label font-weight-bold">@lang('URL')</label>
                                                        <input type="url" class="form-control" value="{{ $item->url }}" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('Minimum Deposit')</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="{{ $item->minimum }}" readonly/>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text"><span
                                                                        class="currency_symbol">{{ gs('cur_sym')  }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('Maximum Deposit')</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="{{ $item->maximum }}" readonly/>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text"><span
                                                                        class="currency_symbol">{{ gs('cur_sym') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('Withdraw Type')</label>
                                                        <input type="text" class="form-control" value="@if($item->withdraw_type == \App\Constants\Status::MANUAL)
                                                         @lang('Manual') @elseif($item->withdraw_type == \App\Constants\Status::AUTO) @lang('Automatic') @endif" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('Referral Bonus') (%)</label>
                                                        <input type="text" class="form-control" value="{{ __($item->ref_bonus) }}" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('Real Daily Profit') (%)</label>
                                                        <input type="text" class="form-control" value="{{ __($item->daily_profit) }}" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('Period')</label>
                                                        <input type="text" class="form-control" value="{{ __($item->period) }}" readonly>
                                                    </div>
                                                    @if($item->ref_link != null)
                                                        <div class="form-group col-md-12">
                                                            <label class="form-control-label font-weight-bold">@lang('Ref. Link')</label>
                                                            <input type="url" class="form-control" value="{{ __($item->ref_link) }}" readonly>
                                                        </div>
                                                    @endif
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('Principle Return')</label>
                                                        <input type="text" class="form-control" value="@if($item->principle_return) @lang('Yes') @else @lang('No') @endif" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-control-label font-weight-bold">@lang('DDOS Protect')</label>
                                                        <input type="text" class="form-control" value="@if($item->ddos) @lang('Yes') @else @lang('No') @endif" readonly>
                                                    </div>
                                                    @if ($item->image != null)
                                                        <div class="form-group col-md-12">
                                                            <label class="form-control-label font-weight-bold">@lang('Hyip Image')</label>
                                                            <img class="d-block" src="{{ getImage(getFilePath('temp_hyip').'/'. $item->image)}}" alt="@lang('hyip image')">
                                                        </div>
                                                    @endif
                                                    <div class="form-group col-md-6">
                                                        <h5> <label for="exampleInputEmail1">@lang('Features')</label></h5>
                                                        @foreach ($item->features as $data)
                                                            <img class="mr-1" style="width: 30px" src="{{ getImage(getFilePath('feature').'/'. $data->image)}}" title="{{ __($data->name) }}" alt="...">
                                                        @endforeach
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <h5> <label for="exampleInputEmail1">@lang('Payment Accept')</label></h5>
                                                        @foreach ($item->paymentAccepts as $data)
                                                            <img class="mr-1" style="width: 60px" src="{{ getImage(getFilePath('payment_accept').'/'. $data->image)}}" title="{{ __($data->name) }}" alt="...">
                                                        @endforeach
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="form-control-label font-weight-bold">@lang('Plans')</label>
                                                        <p>{{ $item->plan }}</p>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="form-control-label font-weight-bold">@lang('Description')</label>
                                                        <p>{{ $item->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{route('admin.main.hyip.user.update.approve',$item->id)}}" class="btn btn--primary">@lang('Approve')</a>
                                                <a href="{{route('admin.main.hyip.user.update.reject',$item->id)}}" class="btn btn--danger">@lang('Reject')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($all_hyips->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($all_hyips) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

