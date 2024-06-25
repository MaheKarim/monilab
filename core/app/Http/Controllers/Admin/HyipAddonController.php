<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\PaymentAccept;
use App\Models\Poll;
use App\Models\Type;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class HyipAddonController extends Controller
{
    public function paymentAcceptAll()
    {
        $pageTitle = 'Payment Accept Method';
        $empty_message = 'No payment accept found';
        $payment_accepts = PaymentAccept::latest()->paginate(getPaginate());
        return view('admin.hyipAddon.paymentAccept',compact('pageTitle','payment_accepts','empty_message'));
    }

    public function paymentAcceptStore(Request $request)
    {
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190'
        ]);

        $payment_accept_image = '';
        if($request->hasFile('image')) {
            try{
                // payment_accept
                $location = imagePath()['payment_accept']['path'];
                $size = imagePath()['payment_accept']['size'];

                $payment_accept_image = fileUploader($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

//        PaymentAccept::create([
//            'image' => $payment_accept_image,
//            'name' => $request->name,
//            'status' => $request->status,
//        ]);

        $paymentAccept = new PaymentAccept();
        $paymentAccept->image = $payment_accept_image;
        $paymentAccept->name = $request->name;
        $paymentAccept->status = $request->status;
        $paymentAccept->save();

        $notify[] = ['success', 'Payment accept details has been added'];
        return back()->withNotify($notify);
    }

    public function paymentAcceptUpdate(Request $request,$id){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190'
        ]);

        $payment_accept = PaymentAccept::findOrFail($id);

        $payment_accept_image = $payment_accept->image;
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['payment_accept']['path'];
                $size = imagePath()['payment_accept']['size'];
                $old = $payment_accept->image;
                $payment_accept_image = fileUploader($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $payment_accept->update([
            'image' => $payment_accept_image,
            'name' => $request->name,
            'status' => $request->status,
        ]);

        $notify[] = ['success', 'Payment accept details has been Updated'];
        return back()->withNotify($notify);
    }

    public function typeAll(){
        $pageTitle = 'Hyip Type';
        $empty_message = 'No type found';
        $types = Type::latest()->paginate(getPaginate());
        return view('admin.hyipAddon.type',compact('pageTitle','types','empty_message'));
    }

    public function typeStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:190'
        ]);

//        Type::create([
//            'name' => $request->name,
//            'status' => $request->status
//        ]);
        $type = new Type();
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();

        $notify[] = ['success', 'Type details has been added'];
        return back()->withNotify($notify);
    }

    public function typeUpdate(Request $request,$id){

        $request->validate([
            'name' => 'required|string|max:190'
        ]);

        $type = Type::findOrFail($id);

//        $type->update([
//            'name' => $request->name,
//            'status' => $request->status,
//        ]);
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();


        $notify[] = ['success', 'Type details has been Updated'];
        return back()->withNotify($notify);
    }

    public function featureAll(){
        $pageTitle = 'Feature';
        $empty_message = 'No feature found';
        $features = Feature::latest()->paginate(getPaginate());
        return view('admin.hyipAddon.feature',compact('pageTitle','features', 'empty_message'));
    }

    public function featureStore(Request $request)
    {
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190'
        ]);

        $feature_image = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['feature']['path'];
                $size = imagePath()['feature']['size'];

                $feature_image = fileUploader($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        Feature::create([
            'image' => $feature_image,
            'name' => $request->name,
            'status' => $request->status,
        ]);

        $notify[] = ['success', 'Feature details has been added'];
        return back()->withNotify($notify);
    }

    public function featureUpdate(Request $request,$id){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190'
        ]);

        $feature = Feature::findOrFail($id);

        $feature_image = $feature->image;
        if($request->hasFile('image')) {
            try{
                // feature image add
                $location = imagePath()['feature']['path'];
                $size = imagePath()['feature']['size'];
                $old = $feature->image;
                $feature_image = uploadImage($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $feature->update([
            'image' => $feature_image,
            'name' => $request->name,
            'status' => $request->status,
        ]);

        $notify[] = ['success', 'Feature details has been Updated'];
        return back()->withNotify($notify);
    }

    public function pollAll(){
        $pageTitle = 'Poll For User Vote';
        $empty_message = 'No data found';
        $polls = Poll::get();
        return view('admin.hyipAddon.poll',compact('pageTitle','polls','empty_message'));
    }

    public function pollStore(Request $request){
        $request->validate([
            'name' => 'required|string|max:40'
        ]);

        $poll = new Poll();
        $poll->name = $request->name;
        $poll->save();


        $notify[] = ['success', 'Poll has been added'];
        return back()->withNotify($notify);
    }

    public function pollUpdate(Request $request,$id)
    {

        $request->validate([
            'name' => 'required|string|max:40'
        ]);

        $poll = Poll::findOrFail($id);
        $poll->name = $request->name;
        $poll->status = $request->status ? Status::ENABLE : Status::DISABLE;
        $poll->save();

        $notify[] = ['success', 'Poll has been Updated'];
        return back()->withNotify($notify);
    }

}
