@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two custom-data-table" id="table">
                            <thead>
                            <tr>
                                <th>@lang('Value')</th>
                                <th>@lang('Add Size')</th>
                                <th>@lang('Impression')</th>
                                <th>@lang('Click')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($admin_adds as $k=> $advertisement)
                                <tr id={{ 'row_' . $advertisement->id }}>
                                    <td>
                                        <img id="image__{{ $advertisement->id }}"
                                             src="{{ getImage(getFilePath('advertisement'). '/' . @$advertisement->image) }}"
                                             alt="" class="max-w-50">
                                    </td>
                                    <td>{{ __(@$advertisement->add_size) }}</td>
                                    <td>
                                        <span class="badge badge--success"> {{ @$advertisement->impression }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge--primary">
                                            {{ @$advertisement->click }}
                                        </span>
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ @$advertisement->url }}">
                                            {{ @$advertisement->url }}
                                        </a>
                                    </td>
                                    <td>
                                        @php echo $advertisement->statusBadge @endphp
                                    </td>
                                    <td>
                                        <button
                                            data-advertisement="{{ json_encode($advertisement->only('id', 'size', 'url', 'status')) }}"
                                            class="btn btn-sm btn-outline--primary editBtn">
                                            <i class="la la-pen"></i> @lang('Edit')
                                        </button>
                                        <button class="btn btn-sm ms-1 btn-outline--danger deleteBtn"
                                                data-id="{{ $advertisement->id }}"><i
                                                class="la la-trash"></i> @lang('Delete')</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($admin_adds->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($admin_adds) }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- ========Create Modal========= --}}
    <div class="modal   fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"> @lang('Add Advertisement')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.advertise.admin.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="image-size">
                                        <label for="" class="font-weight-bold">@lang('Size') <strong
                                                class="text-danger">*</strong></label>
                                        <select class="form-control" name="size">
                                            <option value="" selected>@lang('---Please Select One ----')</option>
                                            <option value="728x90">@lang('728x90')</option>
                                            <option value="160x600">@lang('160x600')</option>
                                            <option value="300x600">@lang('300x600')</option>
                                            <option value="160x160">@lang('160x160')</option>
                                            <option value="300x250">@lang('300x250')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="__image">
                                <div class="form-group">
                                    <div class="image-upload mt-3">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <label for="" class="font-weight-bold">@lang('Image') <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="profilePicPreview" style="background-position: center;">
                                                    <button type="button" class="remove-image">
                                                        <i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" size-validation="" class="profilePicUpload d-none"
                                                       name="image" id="imageUpload" accept=".png, .jpg, .jpeg, .gif">
                                                <label for="imageUpload" class="bg--primary mt-3">@lang('Upload Image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'):
                                                    <b>@lang('jpeg,jpg,png,gif') <span id="__image_size"></span></b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="font-weight-bold">@lang('Redirect Url') <strong
                                            class="text-danger">*</strong> </label>
                                    <input type="text" class="form-control" name="url"
                                           placeholder="@lang('Redirect Url')">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group statusGroup">
                                    <label class="font-weight-bold">@lang('Status')</label>
                                    <input type="checkbox" data-onstyle="-success" data-offstyle="-danger"
                                           data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                           data-width="100%" name="status">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100" id="btn-save"
                                value="add">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary __advertisement"><i
            class="las la-plus"></i>@lang('New Advertisement')</button>
@endpush

@push('style')
    <style>
        #__script,
        #__image {
            display: none;
        }

        .max-w-50 {
            max-width: 50px !important;
        }

        .image-upload .thumb .profilePicPreview {
            max-width: 100%;
        }

    </style>
@endpush


@push('script')

    <script>
        (function ($) {

            $(".__advertisement").on('click', function (e) {
                let modal = $("#modal");
                modal.find("#modalLabel").text("@lang('Add Advertisement')")
                $(modal).find('#__image').css('display', 'none');
                // $(modal).find('#__script').css('display', 'none');
                $(modal).find('#btn-save').text("@lang('Submit')");
                modal.find('.statusGroup').hide();
                modal.modal('show');
            });

            $(document).on('change', '#size', function (e) {
                let size = $(this);

                    let placeholderImageUrl = `{{ route('placeholder.image', ':size') }}`;
                    $(document).find('.image-upload').css('display', 'block')
                    $(document).find('.profilePicPreview').css('background-image',
                        `url(${placeholderImageUrl.replace(':size', size.val())})`)
                    $(document).find('#__image_size').text(`, Upload Image Size Must Be ${size.val()} px`);
                    $(document).find("#imageUpload").attr('size-validation', size.val())
                    changeImagePreview();
            });

            $(document).on('click', '.editBtn', function (e) {

                let advertisement = JSON.parse($(this).attr('data-advertisement'));
                let modal = $("#modal");
                let action = "{{ route('admin.advertise.admin.store', ':id') }}";
                $(modal).find('#size').val(advertisement.size || "")

                    let imageSrc = $(document).find("#image__" + advertisement.id).attr('src');

                    $(modal).find('.profilePicPreview').css('background-image', `url(${imageSrc})`)
                    $(modal).find('.image-upload').css('display', 'block')
                    changeImagePreview()

                modal.find('form').attr('action', action.replace(":id", advertisement.id));
                modal.find('input[name=url]').val(advertisement.url);

                modal.find("#modalLabel").text("@lang('Edit Advertisement')")
                $(modal).find('#btn-save').text("@lang('Update')");
                modal.find('.statusGroup').show();

                if (advertisement.status == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                modal.modal('show');
            });

            function changeImagePreview() {
                let selectSize = $(document).find("#size").val();
                let size = selectSize.split('x');

                $(document).find('#__image').css('display', 'block');
                $(document).find('#__script').css('display', 'none');

                $(document).find(".profilePicPreview").css({
                    'width': `${size[0]}px`,
                    'height': `${size[1]}px`
                })
            }

            $(document).on('change', '#imageUpload', function(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = function() {
                    $(document).find('.profilePicPreview').css('background-image', `url(${reader.result})`);
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    $(document).find('.profilePicPreview').css('background-image', 'none');
                }
            });

        })(jQuery);
    </script>
@endpush
