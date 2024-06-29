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
                                <th scope="col">@lang('Add Size')</th>
                                <th scope="col">@lang('Advertise For')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Start Date')</th>
                                <th scope="col">@lang('End Date')</th>
                                <th scope="col">@lang('Impression')</th>
                                <th scope="col">@lang('Click')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach ($user_adds as $item)
                                <tr>
                                    <td >{{ $loop->index+1 }}</td>
                                    <td ><a href="{{ route('admin.users.detail',$item->user->id) }}">{{ $item->user->username }}</a></td>
                                    <td >
                                        @if ($item->add_size == 1)
                                            @lang('16000 x 200')
                                        @elseif ($item->add_size == 2)
                                            @lang('830 x 180')
                                        @elseif ($item->add_size == 3)
                                            @lang('200 x 480')
                                        @elseif ($item->add_size == 4)
                                            @lang('310 x 380')
                                        @elseif ($item->add_size == 5)
                                            @lang('1600 x 150')
                                        @endif
                                    </td>
                                    <td >{{ $item->day }} @if($item->day == 1) @lang('Day') @else @lang('Days') @endif</td>
                                    <td >{{ $item->price }} {{ $general->cur_sym }}</td>
                                    <td >
                                        @if($item->start_date)
                                            {{ $item->start_date }}
                                        @else
                                            <span class="text--small badge font-weight-normal badge--danger">@lang('Not Available')</span>
                                        @endif
                                    </td>
                                    <td >
                                        @if($item->end_date)
                                            {{ $item->end_date }}
                                        @else
                                            <span class="text--small badge font-weight-normal badge--danger">@lang('Not Available')</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->impression }}</td>
                                    <td>{{ $item->click }}</td>
                                    <td>
                                        @if($item->status == 0)
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                        @else
                                            @if($current_time > $item->end_date)
                                                <span class="text--small badge font-weight-normal badge--danger">@lang('Expired')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')"><a href="#" class="icon-btn  updateBtn" data-route="{{ route('admin.advertise.update',$item->id) }}" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn" data-image="{{ getImage(imagePath()['advertise']['path'].'/'. $item->image)}}"><i class="la la-pencil-alt"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($user_adds->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($user_adds) }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- Update METHOD MODAL --}}
    <div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Update Advertise')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="edit-route" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Redirect Url')</label>
                            <input type="url" class="form-control url" placeholder="@lang('Example') : https://www.demo.com/" name="url" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status')</label>
                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Disabled" name="status">
                        </div>
                        <div class="form-group">
                            <b>@lang('Advertise Image')</b>
                            <div class="image-upload mt-2">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview update-image-preview">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

@push('script')
    <script>
        (function($){
            "use strict";
            $('.updateBtn').on('click', function () {
                var modal = $('#updateBtn');
                var resourse = $(this).data('resourse');
                var route = $(this).data('route');

                $('.url').val(resourse.url);
                if(resourse.status == 0){
                    modal.find('.toggle').addClass('btn--danger off').removeClass('btn--success');
                    modal.find('input[name="status"]').prop('checked',false);
                }else{
                    modal.find('.toggle').removeClass('btn--danger off').addClass('btn--success');
                    modal.find('input[name="status"]').prop('checked',true);
                }
                $('.update-image-preview').css({"background-image": "url("+$(this).data('image')+")"});

                $('select[name=add_size]').val(resourse.add_size);
                $('.edit-route').attr('action',route);
            });
        })(jQuery);
    </script>
@endpush
