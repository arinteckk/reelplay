<?php

namespace App\Http\Controllers\Admin;

use App;
use Validator;
use App\Models\Cast;
use App\Models\Users;
use App\Models\Channel;
use App\Models\Category;
use App\Models\Language;
use App\Models\RentVideo;
use App\Models\TVShow;
use App\Models\Video;
use App\Models\Package;
use App\Models\RentTransction;
use App\Models\Transction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller
{

    public function dashboard()
    {   

        $user  = Users::get()->count();
        $TvShow  = TVShow::get()->count();
        $channel  = Channel::get()->count();
        $cast = Cast::get()->count();
        $video = Video::get()->count();
        $category = Category::get()->count();
        $RentVideo = RentVideo::get()->count();
        $Package = Package::get()->count();
        $RentTransction = RentTransction::sum('price');
        $Transction = Transction::sum('amount');

        $user_table = Users::select('id','name','email','mobile','image','type','created_at') 
                    ->latest()->take(5)->get();

        $tvshow = TVShow::with('type')->latest()->take(4)->get();
        $RecentCast = Cast::latest()->take(4)->get();
        $recent_video = Video::latest()->take(6)->get();
        $rent_video = RentVideo::with('video')->with('tvshow')->latest()->take(4)->get();
        $most_view_video = Video::orderBy('view', 'desc')->first();

        $data['user'] = $user;
        $data['TvShow'] = $TvShow;
        $data['channel'] = $channel;
        $data['cast'] = $cast;
        $data['video'] = $video;
        $data['category'] = $category;
        $data['RentVideo'] = $RentVideo;
        $data['Package'] = $Package;
        $data['RentTransction'] = $RentTransction;
        $data['Transction'] = $Transction;

        return view('admin.dashboard',['result'=>$data, 'user_data'=>$user_table, 'tvshow'=>$tvshow, 'cast'=>$RecentCast, 'rent_video'=>$rent_video, 'recent_video'=>$recent_video, 'most_view_video'=>$most_view_video]);
    }
    public function language($id)
    {
        try{
            Language::where('status', '1')->update(['status' => '0']);

            $language = Language::where('id',$id)->first();
            if(isset($language->id)){
                $language->status = '1';
                if($language->save()){
                    App::setLocale($language->lang_code);
                    session()->put('locale', $language->lang_code);
                    return back()->with('success', __('Label.Language Change Successfully.'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }

}
