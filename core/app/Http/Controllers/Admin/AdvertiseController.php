<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\AdvertisePackage;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    public function packageAll()
    {
        $pageTitle = 'All Packages';
        $packages = AdvertisePackage::latest()->get();
        return view('admin.advertisement.package',compact('pageTitle','packages'));
    }

    public function packageStore(Request $request, $id=0)
    {
        $request->validate([
            'name'=>'required|string|max:190',
            'add_size'=>'required|in:728x90,160x600,300x600,160x160,300x250',
            'price'=>'required|numeric',
            'day'=>'required|numeric',
        ]);

        if ($request->id != 0) {
            $advertisePackage = AdvertisePackage::findOrFail($request->id);
            $message = 'Package has been updated';
        } else {
            $advertisePackage = new AdvertisePackage();
            $message = 'Package has been added';
        }

        $advertisePackage->name     = $request->name;
        $advertisePackage->add_size = $request->add_size;
        $advertisePackage->price    = $request->price;
        $advertisePackage->day      = $request->day;
        $advertisePackage->status   = isset($request->status) ? Status::ENABLE : Status::DISABLE;
        $advertisePackage->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function packageStatus($id)
    {
        return AdvertisePackage::changeStatus($id);
    }

    public function adminAdds() {
        $pageTitle = 'Admin Adds';
        $admin_adds = Advertise::where('user_id', Status::DISABLE)->latest()->paginate(getPaginate());
        return view('admin.advertisement.admin-add',compact('pageTitle','admin_adds'));
    }

    public function adminAddsStore(Request $request, $id=0) {

        $imgRequired = $id ? 'nullable' : 'required';
        $sizes = adsSizes();

        $validation = [
            'url'   =>     'required|url|max:190',
            'image' => [$imgRequired, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])],
        ];

        $request->validate($validation);
        if($id){
            $add = new Advertise();
            $message = 'Advertise has been added';
        }else{
            $add = Advertise::findOrFail($id);
            $message = 'Advertise has been updated';
        }

        if($request->image) {
            $old = $add->image ?? null;
            if ($request->image->getClientOriginalExtension() == 'gif'){
                list($width, $height) = getFileSize($request->image);
                $size = $width.'x'.$height;

                if($add->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$add->add_size];
                    return back()->withNotify($notify);
                }
                $add->image = fileUploader($request->image, getFilePath('advertisement'),$request->size,$old);
            }else{
                list($width, $height) = getFileSize($request->image);
                $size = $width.'x'.$height;
                if($add->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$add->add_size];
                    return back()->withNotify($notify);
                }
                $add->image = fileUploader($request->image, getFilePath('advertisement'),$request->size,$old);
            }
        }

        $add->user_id = Status::ADMIN;
        $add->add_size = $request->add_size;
        $add->day = $request->day;
        if (isset($request->status)) {
            if ($add->user_id != Status::DISABLE) {
                $add->end_date = Carbon::now()->addDays($add->day)->toDateString();
            }

            $add->start_date = Carbon::now()->toDateString();
            $add->status = Status::ENABLE;
        }else{
            $add->status = Status::DISABLE;
        }

        $add->url = $request->url;
        $add->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);

    }

    public function addsStatus($id)
    {
        return Advertise::changeStatus($id);
    }

    public function userAdds() {
        $pageTitle = 'User Adds';
        $user_adds = Advertise::where('user_id', '!=', Status::ADMIN)->whereHas('user', function ($query) {
            $query->where('status', Status::ENABLE);
        })->latest()->paginate(getPaginate());

        $current_time = Carbon::now()->toDateString();

        return view('admin.advertisement.user-add',compact('pageTitle','user_adds','current_time'));
    }

}
