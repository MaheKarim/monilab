<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\Advertise;
use App\Models\AdvertisePackage;
use App\Models\DeviceToken;
use App\Models\Feature;
use App\Models\Form;
use App\Models\Hyip;
use App\Models\PaymentAccept;
use App\Models\TempHyip;
use App\Models\TempHyipFeatures;
use App\Models\TempHyipPaymentAccept;
use App\Models\Transaction;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = Auth::user();

        $hyip_chart_click['month'] = collect([]);
        $hyip_chart_click['click'] = collect([]);

        $hyip_chart = Hyip::where('user_id',$user->id)->where('status', Status::ENABLE)->whereYear('created_at', '=', date('Y'))->orderBy('created_at')->groupBy(DB::Raw("MONTH(created_at)"))->get();

        $hyip_chart_data = $hyip_chart->map(function ($query) use ($hyip_chart_click) {
            $hyip_chart_click['month'] = $query->created_at->format('F');
            $hyip_chart_click['click'] = $query->whereMonth('created_at',$query->created_at)->sum('click');
            return $hyip_chart_click;
        });

        $add_chart_click['month'] = collect([]);
        $add_chart_click['click'] = collect([]);

        $add_chart = Advertise::where('user_id',$user->id)->where('status', Status::ENABLE)->whereYear('end_date', '=', date('Y'))->orderBy('end_date')->groupBy(DB::Raw("MONTH(end_date)"))->get();

        $add_chart_data = $add_chart->map(function ($qur) use ($add_chart_click) {
            $add_chart_click['month'] = Carbon::parse($qur->end_date)->format('F');
            $add_chart_click['click'] = $qur->whereMonth('end_date',Carbon::parse($qur->end_date))->sum('click');
            return $add_chart_click;
        });
        return view('Template::user.dashboard', compact('pageTitle', 'hyip_chart_data','add_chart_data','user'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view('Template::user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Security';
        return view('Template::user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions()
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('user_id',auth()->id())->searchable(['trx'])->filter(['trx_type','remark'])->orderBy('id','desc')->paginate(getPaginate());

        return view('Template::user.transactions', compact('pageTitle','transactions','remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error','Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error','You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act','kyc')->first();
        return view('Template::user.kyc.form', compact('pageTitle','form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view('Template::user.kyc.info', compact('pageTitle','user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act','kyc')->firstOrFail();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $user = auth()->user();
        foreach (@$user->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify').'/'.$kycData->value);
            }
        }
        $userData = $formProcessor->processFormData($request, $formData);
        $user->kyc_data = $userData;
        $user->kyc_rejection_reason = null;
        $user->kv = Status::KYC_PENDING;
        $user->save();

        $notify[] = ['success','KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);

    }

    public function userData()
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request)
    {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile'       => ['required','regex:/^([0-9]*)$/',Rule::unique('users')->where('dial_code',$request->mobile_code)],
        ]);


        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;


        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code = $request->mobile_code;

        $user->profile_complete = Status::YES;
        $user->save();

        return to_route('user.home');
    }

    public function addDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')).'- attachments.'.$extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error','File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function advertise()
    {
        $pageTitle = 'Advertise';
        $packages = AdvertisePackage::where('status', Status::ENABLE)->latest()->get();
        $adds = Advertise::where('user_id', Auth::user()->id)->latest()->paginate(getPaginate());
        $current_time = Carbon::now()->toDateString();
        $empty_message = 'No advertise found';

        return view('Template::user.advertise.index', compact('pageTitle', 'packages', 'adds', 'current_time', 'empty_message'));
    }

    public function advertiseNew($id)
    {
        $pageTitle = 'New Advertise';
        $package = AdvertisePackage::findOrFail($id);

        return view('Template::user.advertise.new', compact('pageTitle', 'package'));
    }

    public function advertiseStore(Request $request, $id)
    {
        $request->validate([
            'day' => 'required|integer|gt:0',
            'url' => 'required|url|max:190',
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])]
        ]);

        $package = AdvertisePackage::where('status', Status::ENABLE)->findOrFail($id);

        $one_day_price = $package->price / $package->day;
        $final_price = round($request->day * $one_day_price);

        $user = Auth::user();

        if ($final_price > $user->balance) {

            $notify[] = ['error', 'You do not have sufficient balance. Make deposit please.'];
            return back()->withNotify($notify);
        }

        $add_image = '';


        $add_image = '';
        // TODO:: Image Upload
        if($request->image){
            if ($request->image->getClientOriginalExtension() == 'gif'){

                list($width, $height) = getimagesize($request->image);
                $size = $width.'x'.$height;

                if($package->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$package->add_size];
                    return back()->withNotify($notify);
                }

                $add_image = uploadFile($request->image, 'assets/images/front-image/');
            }else{
                list($width, $height) = getimagesize($request->image);
                $size = $width.'x'.$height;
                if($package->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$package->add_size];
                    return back()->withNotify($notify);
                }
                $add_image = uploadImage($request->image,'assets/images/front-image/');
            }
        }

        $advertise = new Advertise();
        $advertise->add_size = $package->add_size;
        $advertise->image = $add_image;
        $advertise->url = $request->url;
        $advertise->price = $final_price;
        $advertise->day = $request->day;
        $advertise->status = Status::DISABLE;
        $advertise->user_id = $user->id;
        $advertise->save();


        $user->balance = $user->balance - $final_price;
        $user->save();

        $notify[] = ['success', 'Your advertise submitted successfully. Wait for the approval'];
        return redirect()->route('user.advertise.index')->withNotify($notify);
    }

    public function hyipIndex()
    {
        $pageTitle = 'All Hyip';
        $hyips = Hyip::where('user_id', Auth::user()->id)->latest()->paginate(getPaginate());
        $empty_message = 'No hyip found';

        return view('Template::user.hyip.index', compact('pageTitle', 'hyips', 'empty_message'));
    }

    public function hyipNew()
    {
        $pageTitle = 'New Hyip';
        $payment_accepts = PaymentAccept::latest()->where('status', Status::ENABLE)->get();
        $features = Feature::latest()->where('status', Status::ENABLE)->get();

        return view('Template::user.hyip.new', compact('pageTitle', 'payment_accepts', 'features'));
    }

    public function hyipStore(Request $request)
    {

        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'url' => 'required|url|max:190',
            'plan' => 'required|string|max:190',
            'minimum' => 'required|string|max:190',
            'maximum' => 'required|string|max:190',
            'withdraw_type' => 'required|numeric|gt:0|max:2',
            'daily_profit' => 'required|string|max:190',
            'period' => 'required|string|max:190',
            'ref_bonus' => 'required|string|max:190',
            'ref_link' => 'nullable|url|max:190',
            'description' => 'required',
        ]);


        $hyip_image = '';
        if($request->hasFile('image')) {
            try{
                // TODO:: Upload Image With Size
                $location = imagePath()['hyip']['path'];
                $size = imagePath()['hyip']['size'];

                $hyip_image = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }
        $hyip = new Hyip();
        $hyip->image = $hyip_image;
        $hyip->user_id = Auth::user()->id;
        $hyip->name = $request->name;
        $hyip->url = $request->url;
        $hyip->rating = 0;
        $hyip->plan  = $request->plan;
        $hyip->minimum = $request->minimum;
        $hyip->maximum = $request->maximum;
        $hyip->withdraw_type = $request->withdraw_type;
        $hyip->daily_profit = $request->daily_profit;
        $hyip->period = $request->period;
        $hyip->ref_bonus = $request->ref_bonus;
        $hyip->ref_link = $request->ref_link;
        $hyip->description = $request->description;
        $hyip->status = Status::DISABLE;
        $hyip->principle_return = isset($request->principle_return) ? Status::ENABLE : Status::DISABLE;
        $hyip->ddos = isset($request->ddos) ? Status::ENABLE : Status::DISABLE;
        $hyip->save();

        $payment_accepts = PaymentAccept::where('status', Status::ENABLE)->where('id',$request->payment_accept)->firstOrFail();
        $features = Feature::where('status', Status::ENABLE)->where('id',$request->features)->firstOrFail();

        if ($payment_accepts != null) {
            $hyip->paymentAccepts()->sync($payment_accepts->pluck('id'));
        }
        if ($features != null) {
            $hyip->features()->sync($features->pluck('id'));
        }

        $notify[] = ['success', 'Hyip details has been added. Wait for the admin approval'];
        return back()->withNotify($notify);
    }

    public function hyipEdit($id) {
        $check_hyip = Hyip::findOrFail($id);

        if($check_hyip->user_id != Auth::user()->id) {
            $notify[] = ['error', 'You are not authorized to edit this hyip'];
            return back()->withNotify($notify);
        }
        $hyip = $check_hyip;
        $pageTitle = 'Edit Hyip';
        $payment_accepts = PaymentAccept::latest()->where('status', Status::ENABLE)->get();
        $features = Feature::latest()->where('status', Status::ENABLE)->get();

        return view('Template::user.hyip.edit', compact('hyip','pageTitle','payment_accepts','features'));
    }

    public function hyipUpdate(Request $request,$id)
    {
        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'url' => 'required|url|max:190',
            'plan' => 'required|string|max:190',
            'minimum' => 'required|string|max:190',
            'maximum' => 'required|string|max:190',
            'withdraw_type' => 'required|numeric|gt:0|max:2',
            'daily_profit' => 'required|string|max:190',
            'period' => 'required|string|max:190',
            'ref_bonus' => 'required|string|max:190',
            'ref_link' => 'nullable|url|max:190',
            'description' => 'required',
        ]);

        $check_hyip = TempHyip::where('user_id', Auth::user()->id)->where('hyip_id',$id)->first();

        if($check_hyip) {

            $temp_hyip = TempHyip::findOrFail($check_hyip->id);

            $hyip_image = $temp_hyip->image;

            if($request->hasFile('image')) {
                try{
                    // TODO:: Upload Image With Size
                    $location = imagePath()['temp_hyip']['path'];
                    $size = imagePath()['temp_hyip']['size'];
                    $old = $temp_hyip->image;
                    $hyip_image = uploadImage($request->image, $location , $size, $old);

                }catch(\Exception $exp) {
                    return back()->withNotify(['error', 'Could not upload the image.']);
                }
            }

            $payment_accepts = PaymentAccept::where('status', Status::ENABLE)->where('id',$request->payment_accept)->firstOrFail();
            $features = Feature::where('status', Status::ENABLE)->where('id',$request->features)->firstOrFail();

            $temp_hyip->image = $hyip_image;
            $temp_hyip->name = $request->name;
            $temp_hyip->url = $request->url;
            $temp_hyip->plan = $request->plan;
            $temp_hyip->minimum = $request->minimum;
            $temp_hyip->maximum = $request->maximum;
            $temp_hyip->withdraw_type = $request->withdraw_type;
            $temp_hyip->daily_profit = $request->daily_profit;
            $temp_hyip->period = $request->period;
            $temp_hyip->ref_bonus = $request->ref_bonus;
            $temp_hyip->ref_link = $request->ref_link;
            $temp_hyip->description = $request->description;
            $temp_hyip->principle_return = isset($request->principle_return) ? Status::ENABLE : Status::DISABLE;
            $temp_hyip->ddos = isset($request->ddos) ? Status::ENABLE : Status::DISABLE;
            $temp_hyip->save();

            if ($payment_accepts != null) {
                $temp_hyip->paymentAccepts()->sync($payment_accepts->pluck('id'));
            }else{
                TempHyipPaymentAccept::where('temp_hyip_id',$temp_hyip->id)->delete();
            }

            if ($features != null) {
                $temp_hyip->features()->sync($features->pluck('id'));
            }else{
                TempHyipFeatures::where('temp_hyip_id',$temp_hyip->id)->delete();
            }

            $notify[] = ['success', 'You action is on process. Wait for the admin approval.'];
            return back()->withNotify($notify);
        }

        if($check_hyip == null) {

            $hyip_image = null;
            if($request->hasFile('image')) {
                try{
                    // TODO:: Upload Image
                    $location = imagePath()['temp_hyip']['path'];
                    $size = imagePath()['temp_hyip']['size'];

                    $hyip_image = uploadImage($request->image, $location , $size);

                }catch(\Exception $exp) {
                    return back()->withNotify(['error', 'Could not upload the image.']);
                }
            }

            $temp_hyip = new TempHyip();
            $temp_hyip->hyip_id = $id;
            $temp_hyip->image = $hyip_image;
            $temp_hyip->user_id = Auth::user()->id;
            $temp_hyip->name = $request->name;
            $temp_hyip->url = $request->url;
            $temp_hyip->plan = $request->plan;
            $temp_hyip->minimum = $request->minimum;
            $temp_hyip->maximum = $request->maximum;
            $temp_hyip->withdraw_type = $request->withdraw_type;
            $temp_hyip->daily_profit = $request->daily_profit;
            $temp_hyip->period = $request->period;
            $temp_hyip->ref_bonus = $request->ref_bonus;
            $temp_hyip->ref_link = $request->ref_link;
            $temp_hyip->description = $request->description;
            $temp_hyip->principle_return = isset($request->principle_return) ? Status::ENABLE : Status::DISABLE;
            $temp_hyip->ddos = isset($request->ddos) ? Status::ENABLE : Status::DISABLE;
            $temp_hyip->save();

            $payment_accepts = PaymentAccept::where('status', Status::ENABLE)->where('id',$request->payment_accept)->firstOrFail();
            $features = Feature::where('status', Status::ENABLE)->where('id',$request->features)->firstOrFail();

            if ($payment_accepts != null) {
                $temp_hyip->paymentAccepts()->sync($payment_accepts->pluck('id'));
            }
            if ($features != null) {
                $temp_hyip->features()->sync($features->pluck('id'));
            }

            $notify[] = ['success', 'You action is on process. Wait for the admin approval'];
            return back()->withNotify($notify);
        }

    }

    public function hyipUpdatePending()
    {
        $pageTitle = 'Hyip Update Pending';
        $hyips = TempHyip::where('user_id', Auth::user()->id)->where('status', Status::ENABLE)->get();
        $payment_accepts = PaymentAccept::latest()->where('status', Status::ENABLE)->get();
        $features = Feature::latest()->get();
        $empty_message = 'No pending hyip update';

        return view('Template::user.hyip.pending', compact('pageTitle', 'hyips', 'payment_accepts', 'features', 'empty_message'));
    }

}
