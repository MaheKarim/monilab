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
        $payment_accepts = PaymentAccept::latest()->paginate(getPaginate());

        return view('admin.hyipAddon.payment-accept', compact('pageTitle', 'payment_accepts'));
    }

    public function paymentAcceptStore(Request $request, $id = 0)
    {
        $isUpdate = $id != 0;

        $rules = [
            'name' => 'required|string|max:190'
        ];

        if (!$isUpdate) {
            $rules['image'] = ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
        } else {
            $rules['image'] = ['nullable', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
        }

        $request->validate($rules);

        if ($isUpdate) {
            $paymentAccept = PaymentAccept::findOrFail($id);
        } else {
            $paymentAccept = new PaymentAccept();
        }

        $payment_accept_image = $paymentAccept->image;

        if ($request->hasFile('image')) {
            try {
                // TODO:: Image Upload
                $payment_accept_image = fileUploader($request->image, getFilePath('paymentAccept'), getFileSize('paymentAccept'));

                // If updating, delete the old image
                if ($isUpdate && $paymentAccept->image) {
                    fileManager()->removeFile(getFilePath('paymentAccept') . '/' . $paymentAccept->image);
                }
            } catch (\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $paymentAccept->name = $request->name;
        $paymentAccept->image = $payment_accept_image;
        $paymentAccept->status = isset($request->status) ? Status::ENABLE : Status::DISABLE;
        $paymentAccept->save();

        $notify[] = ['success', $isUpdate ? 'Payment accept details have been updated' : 'Payment accept details have been added'];
        return back()->withNotify($notify);
    }

    public function featureAll()
    {
        $pageTitle = 'Feature';
        $empty_message = 'No feature found';
        $features = Feature::latest()->paginate(getPaginate());
        return view('admin.hyipAddon.feature', compact('pageTitle', 'features', 'empty_message'));
    }

    public function featureStore(Request $request, $id = 0)
    {
        $isUpdate = $id != 0;

        $rules = [
            'name' => 'required|string|max:190'
        ];

        if (!$isUpdate) {
            $rules['image'] = ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
        } else {
            $rules['image'] = ['nullable', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
        }

        $request->validate($rules);

        if ($isUpdate) {
            $feature = Feature::findOrFail($id);
        } else {
            $feature = new Feature();
        }

        $feature_image = $feature->image;
        if ($request->hasFile('image')) {
            try {
                // TODO:: Image Upload
                $feature_image = fileUploader($request->image, getFilePath('feature'), getFileSize('feature'));

                // If updating, delete the old image
                if ($isUpdate && $feature_image) {
                    fileManager()->removeFile(getFilePath('feature') . '/' . $feature->image);
                }
            } catch (\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $feature->name = $request->name;
        $feature->image = $feature_image;
        $feature->status = isset($request->status) ? Status::ENABLE : Status::DISABLE;
        $feature->save();

        $notify[] = ['success', $isUpdate ? 'Feature details have been updated' : 'Feature details have been added'];
        return back()->withNotify($notify);
    }

    public function typeAll()
    {
        $pageTitle = 'Hyip Type';
        $empty_message = 'No type found';
        $types = Type::latest()->paginate(getPaginate());
        return view('admin.hyipAddon.type', compact('pageTitle', 'types', 'empty_message'));
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

    public function typeUpdate(Request $request, $id)
    {

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


    public function pollAll()
    {
        $pageTitle = 'Poll For User Vote';
        $empty_message = 'No data found';
        $polls = Poll::get();
        return view('admin.hyipAddon.poll', compact('pageTitle', 'polls', 'empty_message'));
    }

    public function pollStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40'
        ]);

        $poll = new Poll();
        $poll->name = $request->name;
        $poll->save();


        $notify[] = ['success', 'Poll has been added'];
        return back()->withNotify($notify);
    }

    public function pollUpdate(Request $request, $id)
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

    public function status($id)
    {
        return PaymentAccept::changeStatus($id);
    }

    public function featureStatus($id)
    {
        return Feature::changeStatus($id);
    }


}
