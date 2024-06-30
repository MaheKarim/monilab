@php
    $footer_text = getContent('footer_text.content',true);
@endphp
@php
    $social_icons = getContent('social_icon.element',false);
@endphp
<div class="privacy-area">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="privacy-wrapper d-flex flex-wrap align-items-center justify-content-between">
                    <p class="mb-0">Monilab</p>
{{--                    <p class="mb-0">{{ __($footer_text->data_values->details) }}</p>--}}
                    <div class="footer-right">
                        <ul class="footer-social">
                            @foreach ($social_icons as $item)
                                <li><a href="{{ $item->data_values->url }}" target="_blank">@php echo $item->data_values->social_icon @endphp</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
