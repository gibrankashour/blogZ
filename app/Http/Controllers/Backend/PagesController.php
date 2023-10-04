<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class PagesController extends Controller
{
    public function edit($slug) {
        $allCategories = Category::all();
        if(in_array($slug, ['about_us', 'our_vision'])) {
            $page = Post::where('post_type', 'page')->where('slug', $slug)->first();
            // dd(url(),request()->pathInfo);
            return view('backend.pages.edit-page')->with([
                'page' => $page,
                'allCategories' => $allCategories
            ]);
        }else {
            return view('backend.404');
        }
    }
 
    public function update(Request $request, $slug) {
        $page = Post::where('slug', $slug)->where('post_type', 'page')->first();
        
        if($page) {
            if(!$page->user->isAdmin()) {
                return redirect()->route('admin.home')->with([
                    'message' => 'Only admin can edit the previous page!',
                    'alert-type' => 'danger',
                ]);                
            }

            $validator = Validator::make($request->all(),[
                // 'title'         => 'required|string|min:10',
                'description'   => 'required|string|min:100',
                'status'        => 'required|boolean',
                'category'      => 'required|exists:categories,id',
                'Comment_able'  => 'required|boolean',
                'post_cover'    => 'nullable|mimes:jpg,bmp,png|max:4097',
                'images'        => 'nullable',
                'images.*'      => 'nullable|mimes:jpg,bmp,png|max:4097',
            ], [
                'post_cover.mimes'      => 'The page cover must be a file of type: jpg, bmp, png.',
                'post_cover.max'      => 'The page cover must not be greater than 4097 kilobytes. (4MB)',
                'images.*.mimes'      => 'You must add only images files',
                'images.*.max'      => 'Image size must be less than 4MB',
            ]);
    
            if($validator->fails()){
                return redirect()->route('admin.page.edit', $slug)->withErrors($validator)->withInput();
            }
    
            // $data['title']          = $request->input('title');
            // $data['slug']           = Str::slug($request->input('title'));
            $data['description']    = $request->input('description');
            $data['status']         = $request->input('status');
            $data['Comment_able']   = $request->input('Comment_able');
            $data['category_id']    = $request->input('category');

            if($request->file('post_cover') != null) {
                $filename = $slug . '-' . time() . '-post-cover.' . $request->file('post_cover')->getClientOriginalExtension();           
                // إضافة صورة الكفر الجديدية
                $path = public_path('assets/pages/' . $filename);
                Image::make($request->file('post_cover')->getRealPath())->resize(1170, 788, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                // حذف صورة الكفر القديمة
                if(File::exists(public_path('assets/pages/' . $page->post_cover)) && $page->post_cover != null ) {
                    unlink(public_path('assets/pages/' . $page->post_cover));
                }
                $data['post_cover'] = $filename; 
            }
            // تحديث جدول البوستس بالبيانات الجديدة
            $page->update($data);
    
            if($request->file('images') != null && count($request->file('images')) > 0) {
                //dd($request->file('images'));
                $loop = 1;
                foreach( $request->file('images') as $file) {
    
                    $filename = $slug . '-' . time() . '-' . $loop . '.' . $file->getClientOriginalExtension();                   
                    $file_type = $file->getClientMimeType();
                    $path = public_path('assets/pages/' . $filename);
                    $img = Image::make($file->getRealPath())->resize(1170, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);
                    $file_size = $img->filesize();
    
                    $page->media()->create([
                        'file_name' => $filename,
                        'file_type' => $file_type,
                        'file_size' => $file_size 
                    ]);
                    $loop++;
                }
            }

            return redirect()->route('admin.page.edit', $slug)->with([
                'message' => 'Page updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function cover($slug) {
        $page = Post::where('slug', $slug)->where('post_type', 'page')->first();
        
        if($page) {
            if(!$page->user->isAdmin()) {
                return redirect()->route('admin.home')->with([
                    'message' => 'Only admin can edit the previous page',
                    'alert-type' => 'danger',
                ]);                
            }
            if(File::exists(public_path('assets/pages/'. $page->post_cover)) && $page->post_cover != null){
                unlink(public_path('assets/pages/'. $page->post_cover));
                $page->update([
                    'post_cover' => null
                ]);
            }
            return redirect()->route('admin.page.edit', $page->slug)->with([
                'message' => 'Page cover deleted successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function image($slug, $media_id) {
        $media = PostMedia::where('id', $media_id)->whereHas('post', function($query) use($slug){
            $query->where('slug', $slug);
        })->first();
        if($media) {
            if(!$media->post->user->isAdmin()) {
                return redirect()->route('admin.home')->with([
                    'message' => 'Only admin can edit the previous page',
                    'alert-type' => 'danger',
                ]);                
            }
            if(File::exists(public_path('assets/pages/'. $media->file_name)) && $media->file_name != null){
                unlink(public_path('assets/pages/'. $media->file_name));
                $media->delete();
            }
            return redirect()->route('admin.page.edit', $media->post->slug)->with([
                'message' => 'Page image deleted successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return view('backend.404');
        }
    }

}
