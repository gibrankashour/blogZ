<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Spatie\Valuestore\Valuestore;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{

    public function index() {
        
        $section = session('section') ? session('section') :'general';
        
        $generals = Setting::where('section', 'general')->orderBy('id', 'asc')->get();
        $socials  = Setting::where('section', 'social_accounts')->orderBy('id', 'asc')->get();
        $image    = Setting::where('section', 'images')->orderBy('id', 'asc')->get();

        return view('backend.settings', ['generals' => $generals, 'socials' => $socials, 'section' =>$section, 'images' => $image]);
    }

    public function update(Request $request,$section) {
        
        $rules = [];
        $messages = [];
        foreach($request->all() as $key => $value) {
            if(in_array($key, ['site_title', 'site_slogan', 'site_description', 'site_keywords', 'admin_title', 'address'])) {
                $rules[$key] = 'required|min:5|string';
            }
            if(in_array($key, ['address_latitude', 'address_longitude'])) {
                $rules[$key] = 'nullable|numeric';
            }
            if($key == 'site_status') {
                $rules[$key] = 'required|in:Active,Inactive';
            }
            if($key == 'site_email') {
                $rules[$key] = 'required|array|min:1';
                $rules[$key.'.*'] = 'email';
                $messages[$key.'.*.email'] = 'Site email must be a valid email address.';
            }
            if($key == 'phone_number') {
                $rules[$key] = 'required|array|min:1';
                $rules[$key.'.*'] = 'numeric';
                $messages[$key.'.*.numeric'] = 'Phone number must be a valid number.';
            }
            if(in_array($key, ['google_maps_api_key', 'google_recaptcha_api_key', 'google_analytics_client_id'])) {
                $rules[$key] = 'nullable|min:5|string';
            }
            if(in_array($key, ['facebook_id', 'twitter_id', 'instagram_id', 'flickr_id', 'youtube_id'])) {
                $rules[$key] = 'nullable|min:5|url';
            }
            if(in_array($key, ['website_cover'])) {
                $rules[$key] = 'nullable|image|mimes:jpg,jpeg,png';
            }
        }
        //dd($request->all(), $rules);
        $validator = Validator::make($request->all(),$rules, $messages);
        if($validator->fails()){            
            return redirect()->route('admin.settings')->with(['section' => $section])->withInput()->withErrors($validator);
        }


        $data = '';
        foreach($request->except(['_token', '_method']) as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if($setting->type != 'file') {
                $data = is_array($value) ? implode('|', $value) : $value;
                $setting->update(['value' => $data]);
            }else {
                if($request->file($key) != null) {
                    //تخزين الصورة الجديدة 
                    $data = $key . '-' . rand(0,1000000) . '.' . $request->file($key)->extension();
                    $path = public_path('assets/website/' . $data);
                    Image::make($request->file($key)->getRealPath())->save($path, 100);
                    // حذف الصورة القديمة
                    if(File::exists(public_path('assets/website/' . $setting->value) && $setting->value != null)) {
                        unlink(public_path('assets/website/' . $setting->value));
                    }
                    $setting->update(['value' => $data]);
                }
            }

        }

        $this->updateCache();
        
        return redirect()->route('admin.settings')->with([
            'section' => $section,
            'message' => 'Settings updated successfully',
            'alert-type' => 'success',
        ]);
    }


    private function updateCache() {
        $valuestore = Valuestore::make(config_path('settings.json'));
        $settings = Setting::all();
        foreach($settings as $setting) {
            $valuestore->put($setting->key, $setting->value);
        }
    }

}
