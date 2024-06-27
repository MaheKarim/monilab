<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Hyip;
use App\Models\HyipFeature;
use App\Models\HyipPaymentAccept;
use App\Models\HyipReport;
use App\Models\PaymentAccept;
use App\Models\TempHyip;
use App\Models\TempHyipFeatures;
use App\Models\TempHyipPaymentAccept;
use App\Models\Type;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class HyipController extends Controller
{
    public function adminHyipList()
    {
        $pageTitle = 'Admin Hyip';
        $all_hyips = Hyip::latest()->where('user_id',0)->paginate(getPaginate());
        $empty_message = 'No hyip found';

        return view('admin.hyip.admin-hyip',compact('all_hyips','empty_message','pageTitle'));
    }

    public function hyipNew(){
        $pageTitle = 'Add New Hyip';
        $payment_accepts = PaymentAccept::latest()->where('status', Status::ENABLE)->get();
        $types = Type::latest()->where('status', Status::ENABLE)->get();
        $features = Feature::latest()->where('status', Status::ENABLE)->get();
        return view('admin.hyip.new',compact('pageTitle','payment_accepts','types','features'));
    }

    public function hyipStore(Request $request){

        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'url' => 'required|url|max:190',
            'rating' => 'required|numeric|min:1|max:5',
            'plan' => 'required|string|max:190',
            'minimum' => 'required|string|max:190',
            'maximum' => 'required|string|max:190',
            'type_id' => 'required|numeric|gt:0',
            'withdraw_type' => 'required|numeric|gt:0|max:2',
            'monitor_since' => 'required|date',
            'daily_profit' => 'required|string|max:190',
            'period' => 'required|string|max:190',
            'ref_bonus' => 'required|string|max:190',
            'ref_link' => 'nullable|url|max:190',
            'description' => 'required',
        ]);

        $hyip_image = '';
        if($request->hasFile('image')) {
            try {
                $hyip_image = fileUploader($request->image, getFilePath('hyip'), getFileSize('hyip'));
            } catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $hyip = new Hyip();
        $hyip->image = $hyip_image;
        $hyip->user_id = 0;
        $hyip->name = $request->name;
        $hyip->url = $request->url;
        $hyip->rating = $request->rating;
        $hyip->plan = $request->plan;
        $hyip->minimum = $request->minimum;
        $hyip->maximum = $request->maximum;
        $hyip->type_id = $request->type_id;
        $hyip->withdraw_type = $request->withdraw_type;
        $hyip->monitor_since = $request->monitor_since;
        $hyip->daily_profit = $request->daily_profit;
        $hyip->period = $request->period;
        $hyip->ref_bonus = $request->ref_bonus;
        $hyip->ref_link = $request->ref_link;
        $hyip->description = $request->description;
        $hyip->status = isset($request->status) ? Status::ENABLE : Status::DISABLE;
        $hyip->top_payment_site = isset($request->top_payment_site) ? Status::ENABLE : Status::DISABLE;
        $hyip->principle_return = isset($request->principle_return) ? Status::ENABLE : Status::DISABLE;
        $hyip->ddos = isset($request->ddos) ? Status::ENABLE : Status::DISABLE;
        $hyip->save();

        $payment_accepts = PaymentAccept::findOrFail($request->payment_accept);
        $features = Feature::findOrFail($request->features);

        if ($payment_accepts != null) {
            $hyip->paymentAccepts()->sync($payment_accepts->pluck('id'));
        }
        if ($features != null) {
            $hyip->features()->sync($features->pluck('id'));
        }

        $notify[] = ['success', 'Hyip details has been added'];
        return to_route('admin.main.hyip.admin.list')->withNotify($notify);
    }

    public function userHyipList(){
        $pageTitle = 'User Hyip';
        $all_hyips = Hyip::latest()->where('user_id', '!=', 0)->whereHas('user', function ($query) {
            $query->where('status', Status::ENABLE);
        })->latest()->paginate(getPaginate());
        $empty_message = 'No hyip found';

        return view('admin.hyip.user-hyip',compact('all_hyips','empty_message','pageTitle'));
    }

    public function report()
    {
        $pageTitle = 'Reported Hyips';
        $reports = HyipReport::orderBy('id','desc')->with('hyip')->paginate(getPaginate());
        return view('admin.hyip.reports',compact('pageTitle','reports'));
    }

    public function hyipEdit($id)
    {
        $pageTitle = 'Update Hyip';
        $hyip = Hyip::findOrFail($id);
        $types = Type::latest()->where('status', Status::ENABLE)->get();
        $features = Feature::latest()->where('status', Status::ENABLE)->get();
        $payment_accepts = PaymentAccept::latest()->get();
        return view('admin.hyip.edit',compact('pageTitle','hyip','types','features','payment_accepts'));
    }

    public function hyipUpdate(Request $request,$id){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'url' => 'required|url|max:190',
            'rating' => 'required|numeric|min:1|max:5',
            'plan' => 'required|string|max:190',
            'minimum' => 'required|string|max:190',
            'maximum' => 'required|string|max:190',
            'type_id' => 'required|numeric|gt:0',
            'withdraw_type' => 'required|numeric|gt:0|max:2',
            'monitor_since' => 'required|date',
            'daily_profit' => 'required|string|max:190',
            'period' => 'required|string|max:190',
            'ref_bonus' => 'required|string|max:190',
            'ref_link' => 'nullable|url|max:190',
            'description' => 'required',
        ]);

        $hyip = Hyip::findOrFail($id);

        $hyip_image = $hyip->image;

        if($request->hasFile('image')) {
            try{
                $hyip_image = fileUploader($request->image, getFilePath('hyip'), getFileSize('hyip'));
            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $payment_accepts = PaymentAccept::find($request->payment_accept);
        $features = Feature::find($request->features);

        $hyip->image = $hyip_image;
        $hyip->name = $request->name;
        $hyip->url = $request->url;
        $hyip->rating = $request->rating;
        $hyip->plan = $request->plan;
        $hyip->minimum = $request->minimum;
        $hyip->maximum = $request->maximum;
        $hyip->type_id = $request->type_id;
        $hyip->withdraw_type = $request->withdraw_type;
        $hyip->monitor_since = $request->monitor_since;
        $hyip->daily_profit = $request->daily_profit;
        $hyip->period = $request->period;
        $hyip->ref_bonus = $request->ref_bonus;
        $hyip->ref_link = $request->ref_link;
        $hyip->description = $request->description;
        $hyip->status = isset($request->status) ? Status::ENABLE : Status::DISABLE;
        $hyip->top_payment_site = isset($request->top_payment_site) ? Status::ENABLE : Status::DISABLE;
        $hyip->principle_return = isset($request->principle_return) ? Status::ENABLE : Status::DISABLE;
        $hyip->ddos = isset($request->ddos) ?  Status::ENABLE : Status::DISABLE;
        $hyip->save();



        if ($payment_accepts != null) {
            $hyip->paymentAccepts()->sync($payment_accepts->pluck('id'));
        }else{
            HyipPaymentAccept::where('hyip_id', $hyip->id)->delete();
        }

        if ($features != null) {
            $hyip->features()->sync($features->pluck('id'));
        }else{
            HyipFeature::where('hyip_id',$hyip->id)->delete();
        }

        $notify[] = ['success', 'Hyip details has been updated'];
        return back()->withNotify($notify);
    }

    public function userHyipUpdateRequestList() {
        $pageTitle = 'User Hyip Update Request';
        $all_hyips = TempHyip::latest()->paginate(getPaginate());
        $empty_message = 'No hyip update request found';

        return view('admin.hyip.user-hyip-update',compact('all_hyips','empty_message','pageTitle'));
    }

    public function userHyipUpdateApprove($id) {

        $temp_hyip = TempHyip::findOrFail($id);
        $main_hyip = Hyip::findOrFail($temp_hyip->hyip_id);

        if($temp_hyip->image) {
            // TODO:: Image Upload
            $c_location = imagePath()['temp_hyip']['path'];
            $n_location = imagePath()['hyip']['path'];

            removeFile($n_location . '/' . $main_hyip->image);
            rename($c_location . '/' . $temp_hyip->image, $n_location . '/' . $temp_hyip->image);

            $main_hyip->image = $temp_hyip->image;
        }

        $main_hyip->name = $temp_hyip->name;
        $main_hyip->url = $temp_hyip->url;
        $main_hyip->plan = $temp_hyip->plan;
        $main_hyip->minimum = $temp_hyip->minimum;
        $main_hyip->maximum = $temp_hyip->maximum;
        $main_hyip->daily_profit = $temp_hyip->daily_profit;
        $main_hyip->period = $temp_hyip->period;
        $main_hyip->ref_bonus = $temp_hyip->ref_bonus;
        $main_hyip->ref_link = $temp_hyip->ref_link;
        $main_hyip->description = $temp_hyip->description;
        $main_hyip->withdraw_type = $temp_hyip->withdraw_type;
        $main_hyip->principle_return = $temp_hyip->principle_return;
        $main_hyip->ddos = $temp_hyip->ddos;
        $main_hyip->save();

        $temp_payment_accepts = $temp_hyip->paymentAccepts()->get();
        $temp_features = $temp_hyip->features()->get();

        if ($temp_payment_accepts != null) {
            $main_hyip->paymentAccepts()->sync($temp_payment_accepts->pluck('id'));
        }else{
            HyipPaymentAccept::where('hyip_id',$main_hyip->id)->delete();
        }

        if ($temp_features != null) {
            $main_hyip->features()->sync($temp_features->pluck('id'));
        }else{
            HyipFeature::where('hyip_id',$main_hyip->id)->delete();
        }

        TempHyipFeatures::where('temp_hyip_id',$temp_hyip->id)->delete();
        TempHyipPaymentAccept::where('temp_hyip_id',$temp_hyip->id)->delete();

        $temp_hyip->delete();

        $notify[] = ['success', 'Hyip approved successfully'];
        return back()->withNotify($notify);
    }

    public function userHyipUpdateReject($id) {

        $temp_hyip = TempHyip::findOrFail($id);

        if($temp_hyip->image) {
            $location = imagePath()['temp_hyip']['path'];

            removeFile($location . '/' . $temp_hyip->image);
        }

        TempHyipFeatures::where('temp_hyip_id',$temp_hyip->id)->delete();
        TempHyipPaymentAccept::where('temp_hyip_id',$temp_hyip->id)->delete();

        $temp_hyip->delete();

        notify($temp_hyip->user, 'HYIP_UPDATE_REJECTED', [
            'hyip_name' => $temp_hyip->name,
        ]);

        $notify[] = ['success', 'Hyip rejected successfully'];
        return back()->withNotify($notify);
    }

    public function hyipStatus($id)
    {
        return Hyip::changeStatus($id);
    }


}
