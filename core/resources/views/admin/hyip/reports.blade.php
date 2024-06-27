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
                            <th scope="col">@lang('Hyip Name')</th>
                            <th scope="col">@lang('Title')</th>
                            <th scope="col">@lang('Description')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach ($reports as $item)
                        <tr>
                            <td><a href="{{ route('admin.main.hyip.edit',$item->hyip->id) }}"> {{ __($item->hyip->name) }}</a></td>
                            <td>{{ __($item->subject) }}</td>
                            <td>{{ __(\Illuminate\Support\Str::limit($item->description, 50)) }}</td>
                            <td >
                                <button class="icon-btn detailsBtn" data-details="{{ $item->description }}"><i class="las la-desktop"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                @if ($reports->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($reports) }}
                    </div>
                @endif
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">@lang('Reporet Details')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="details"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function($){
        "use strict";
        $('.detailsBtn').on('click',function(){
            var modal = $('#detailsModal');
            modal.find('.details').text($(this).data('details'));
            modal.modal('show');
        })

    })(jQuery)
</script>
@endpush
