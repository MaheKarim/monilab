<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Advertise;
use App\Models\Feedback;
use App\Models\Frontend;
use App\Models\Hyip;
use App\Models\HyipReport;
use App\Models\Language;
use App\Models\Page;
use App\Models\Poll;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Type;
use App\Models\UserPoll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class SiteController extends Controller
{
    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',activeTemplate())->where('slug','/')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        $data['latest_hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->with('type')->limit(6)->latest()->get();

        $hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->with('type')->latest()->paginate(10);

        $top_payment_hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->where('top_payment_site', Status::ENABLE)->latest()->get();

        $top_monitor_hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->orderBy('monitor_since', 'asc')->latest()->limit(7)->get();

        $reaction = Hyip::latest()->get();
        $happy = $reaction->sum('happy');
        $sad = $reaction->sum('sad');
        $wow = $reaction->sum('wow');
        $love = $reaction->sum('love');
        $angry = $reaction->sum('angry');

        $polls = Poll::where('status', Status::ENABLE)->get();

        $data['types'] = Type::where('status', Status::ENABLE)->get();

        return view('Template::home', compact('pageTitle','sections','seoContents',
            'seoImage', 'data', 'hyips', 'polls', 'top_payment_hyips', 'top_monitor_hyips', 'happy', 'sad', 'wow', 'love', 'angry'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',activeTemplate())->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle','sections','seoContents','seoImage'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $user = auth()->user();
        $sections = Page::where('tempname',activeTemplate())->where('slug','contact')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        $reaction = Hyip::latest()->get();
        $happy = $reaction->sum('happy');
        $sad = $reaction->sum('sad');
        $wow = $reaction->sum('wow');
        $love = $reaction->sum('love');
        $angry = $reaction->sum('angry');

        $top_payment_hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->where('top_payment_site', Status::ENABLE)->latest()->get();

        $top_monitor_hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->orderBy('monitor_since', 'asc')->latest()->limit(7)->get();


        return view('Template::contact',compact('pageTitle','user',
            'sections','seoContents','seoImage', 'sad','happy','wow','love','angry', 'top_payment_hyips', 'top_monitor_hyips'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy = Frontend::where('slug',$slug)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('policy_pages',$seoContents->image,getFileSize('seo'),true) : null;
        return view('Template::policy',compact('policy','pageTitle','seoContents','seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function cookieAccept(){
        Cookie::queue('gdpr_cookie',gs('site_name') , 43200);
    }

    public function cookiePolicy(){
        $cookieContent = Frontend::where('data_keys','cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE,404);
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view('Template::cookie',compact('pageTitle','cookie'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if(gs('maintenance_mode') == Status::DISABLE){
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys','maintenance.data')->first();

        $top_payment_hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->where('top_payment_site', Status::ENABLE)->latest()->get();

        $top_monitor_hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->orderBy('monitor_since', 'asc')->latest()->limit(7)->get();

        $reaction = Hyip::latest()->get();

        $happy = $reaction->sum('happy');
        $sad = $reaction->sum('sad');
        $wow = $reaction->sum('wow');
        $love = $reaction->sum('love');
        $angry = $reaction->sum('angry');

        $latest_hyips = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->limit(6)->latest()->get();

        $polls = Poll::where('status', Status::ENABLE)->get();

        return view('Template::maintenance',compact('pageTitle','maintenance', 'top_payment_hyips', 'top_monitor_hyips', 'happy', 'sad', 'wow', 'love', 'angry', 'latest_hyips', 'polls'));
    }

    public function clickCount(Request $request){
        $click = Advertise::find($request->id);
        $click->increment('click');
        return 0;
    }

    public function hyipClickCount(Request $request){
        $click = Hyip::find($request->id);
        $click->increment('click');
        return 0;
    }

    public function react(Request $request, $id) {
        $clientIP = request()->ip();
        $feedback = Feedback::where('hyip_id',$id)->where('ip',$clientIP)->count();

        if($feedback > 0) {
            $notify[] = ['error', 'You already react on this'];
            return back()->withNotify($notify);
        }

        if($feedback == 0) {

            $hyip = Hyip::findOrfail($id);

            if ($request->react == 'happy') {

                $hyip->increment('happy');


                $feedback = new Feedback();
                $feedback->hyip_id = $hyip->id;
                $feedback->ip = $clientIP;
                $feedback->save();

                $notify[] = ['success', 'Your reaction is successfully submitted'];
                return back()->withNotify($notify);

            }elseif($request->react == 'sad') {

                $hyip->increment('sad');


                $feedback = new Feedback();
                $feedback->hyip_id = $hyip->id;
                $feedback->ip = $clientIP;
                $feedback->save();

                $notify[] = ['success', 'Your reaction is successfully submitted'];
                return back()->withNotify($notify);

            }elseif($request->react == 'wow') {

                $hyip->increment('wow');

                $feedback = new Feedback();
                $feedback->hyip_id = $hyip->id;
                $feedback->ip = $clientIP;
                $feedback->save();

                $notify[] = ['success', 'Your reaction is successfully submitted'];
                return back()->withNotify($notify);

            }elseif($request->react == 'love') {

                $hyip->increment('love');

                $feedback = new Feedback();
                $feedback->hyip_id = $hyip->id;
                $feedback->ip = $clientIP;
                $feedback->save();

                $notify[] = ['success', 'Your reaction is successfully submitted'];
                return back()->withNotify($notify);

            }elseif($request->react == 'angry') {

                $hyip->increment('angry');


                $feedback = new Feedback();
                $feedback->hyip_id = $hyip->id;
                $feedback->ip = $clientIP;
                $feedback->save();

                $notify[] = ['success', 'Your reaction is successfully submitted'];
                return back()->withNotify($notify);
            }else {
                $notify[] = ['error', 'Do not try cheat us'];
                return back()->withNotify($notify);
            }
        }
    }

    public function vote(Request $request){
        $clientIP = request()->ip();
        $hyip = Hyip::where('status', Status::ENABLE)->where('id',$request->hyip_id)->firstOrFail();
        $poll = Poll::where('status', Status::ENABLE)->where('id',$request->poll_id)->firstOrFail();
        $userpoll = UserPoll::where('hyip_id',$request->hyip_id)->where('ip',$clientIP)->count();

        if($userpoll > 0) {
            $notify[] = ['error', 'Vote already submitted on this'];
            return back()->withNotify($notify);
        }

        $userPoll = new UserPoll();
        $userPoll->hyip_id = $hyip->id;
        $userPoll->poll_id = $poll->id;
        $userPoll->ip = $clientIP;
        $userPoll->save();

        $notify[] = ['success', 'Vote submitted successfully'];
        return back()->withNotify($notify);
    }

    public function report(Request $request){

        $request->validate([
            'hyip_id'=>'required|integer|exists:hyips,id',
            'subject'=>'required',
            'description'=>'required',
        ]);
        $hyip = Hyip::where('status', Status::ENABLE)->where('id',$request->hyip_id)->firstOrFail();

        $report = new HyipReport();
        $report->hyip_id = $hyip->id;
        $report->subject = $request->subject;
        $report->description = $request->description;
        $report->save();

        $notify[] = ['success', 'Report submitted successfully'];
        return back()->withNotify($notify);
    }

    public function hyipType($id = 0){

        $count = Page::where('tempname',activeTemplate())->where('slug','home')->count();
        if($count == 0){
            $in['tempname'] = activeTemplate();
            $in['name'] = 'HOME';
            $in['slug'] = 'home';
            Page::create($in);
        }

        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',activeTemplate())->where('slug','home')->firstOrFail();


        $data['latest_hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->with('type')->limit(6)->latest()->get();

        $data['hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->with('type')->latest()->paginate(10);

        $data['top_payment_hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->where('top_payment_site', Status::ENABLE)->latest()->get();

        $data['top_monitor_hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->orderBy('monitor_since', 'asc')->latest()->limit(7)->get();

        $type = Type::find($id);
        $reaction = Hyip::latest();
        if($type){
            $reaction = $reaction->where('type_id',$id);
        }
        $reaction->get();

        $data['happy'] = $reaction->sum('happy');
        $data['sad'] = $reaction->sum('sad');
        $data['wow'] = $reaction->sum('wow');
        $data['love'] = $reaction->sum('love');
        $data['angry'] = $reaction->sum('angry');

        $data['polls'] = Poll::where('status', Status::ENABLE)->get();

        $data['types'] = Type::where('status', Status::ENABLE)->get();
        $data['type_id'] = $id;

        return view('Template::home', $data);
    }

    public function search(Request $request)
    {
        $data['hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->where('name', 'LIKE', '%'.$request->search.'%')->latest()->paginate(10);

        $data['page_title'] = 'Search Result';
        $data['result_counter'] = ''.count($data['hyips']).' Results found for "'.$request->search.'"';

        $data['top_payment_hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->where('top_payment_site', Status::ENABLE)->latest()->get();

        $data['top_monitor_hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->orderBy('monitor_since', 'asc')->latest()->limit(7)->get();

        $reaction = Hyip::latest()->get();

        $data['happy'] = $reaction->sum('happy');
        $data['sad'] = $reaction->sum('sad');
        $data['wow'] = $reaction->sum('wow');
        $data['love'] = $reaction->sum('love');
        $data['angry'] = $reaction->sum('angry');

        $data['latest_hyips'] = Hyip::where(function($query){
            $query->where('user_id', Status::ADMIN)->orWhereHas('user', function ($user) {
                $user->where('status', Status::ENABLE);
            });
        })->where('status', Status::ENABLE)->limit(6)->latest()->get();

        $data['polls'] = Poll::where('status', Status::ENABLE)->get();

        return view('Template::search', $data);
    }
}
