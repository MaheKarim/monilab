@if(\App\Models\Extension::where('act', 'custom-captcha')->where('status', \App\Constants\Status::ENABLE)->first())

    <div class="form-group col-lg-6">
        @php echo  getCustomCaptcha() @endphp
    </div>
    <div class="form-group col-lg-6">
        <input type="text" name="captcha" placeholder="@lang('Enter Code')">
    </div>
@endif
