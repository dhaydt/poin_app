<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Catalog;
use App\Models\Config;
use App\Models\Outlet;
use App\Models\Reward;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function outlet(){
        $outlet = Outlet::orderBy('created_at', 'desc')->get();

        foreach($outlet as $b){
            $b['image'] = getenv('APP_URL').'/storage/'.$b['image'];
        }

        return response()->json(['status' => 'success', 'data' => $outlet], 200);
    }
    public function banner(){
        $banner = Banner::orderBy('updated_at', 'desc')->get();

        $banners = [];

        foreach($banner as $b){
            $d['id'] = $b['id'];
            $d['title'] = $b['title'];
            $d['title_eng'] = $b['title_eng'];
            $d['image'] = getenv('APP_URL').'/storage/'.$b['image'];
            array_push($banners, $d);
        }

        return response()->json(['status' => 'success', 'data' => $banners], 200);
    }
    
    public function catalog(){
        $banner = Catalog::orderBy('updated_at', 'desc')->get();

        foreach($banner as $b){
            $b['image'] = getenv('APP_URL').'/storage/'.$b['image'];
        }

        return response()->json(['status' => 'success', 'data' => $banner], 200);
    }

    public function banner_details($id){
        $banner = Banner::find($id);
        if($banner){
            $banner['image'] = getenv('APP_URL').'/storage/'.$banner['image'];
        }else{
            $banner = [];
        }
        return response()->json(['status' => 'success', 'data' => $banner], 200);

    }
    public function outlet_details($id){
        $banner = Outlet::find($id);
        if($banner){
            $banner['image'] = getenv('APP_URL').'/storage/'.$banner['image'];
        }else{
            $banner = [];
        }
        return response()->json(['status' => 'success', 'data' => $banner], 200);
    }
    
    public function catalog_details($id){
        $banner = Catalog::find($id);
        if($banner){
            $banner['image'] = getenv('APP_URL').'/storage/'.$banner['image'];
        }else{
            $banner = [];
        }
        return response()->json(['status' => 'success', 'data' => $banner], 200);
    }

    public function about_us(){
        $about = Config::where('type', 'about_us')->first();

        return response()->json(['status' => 'success', 'data' => $about], 200);
    }
    
    public function contact(){
        $about = Config::where('type', 'contact')->first();

        return response()->json(['status' => 'success', 'data' => $about], 200);
    }
    
    public function term(){
        $about = Config::where('type', 'term_and_condition')->first();

        return response()->json(['status' => 'success', 'data' => $about], 200);
    }

    public function reward(){
        return Reward::get();
    }
}
