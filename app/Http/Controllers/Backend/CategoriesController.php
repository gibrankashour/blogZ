<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class CategoriesController extends Controller
{

    public function index() {

        $keyword    = request()->input('keyword') != null ? request()->input('keyword') : null;
        $status     = request()->input('status') != null && in_array(request()->input('status'),['1', '0']) ? request()->input('status') : 'all';
        $sort_by    = request()->input('sort_by') != null && in_array(request()->input('sort_by'),['created_at', 'status', 'name', 'posts_count']) ? request()->input('sort_by') : 'name';
        $order_by   = request()->input('order_by') != null && in_array(request()->input('order_by'),['asc', 'desc']) ? request()->input('order_by') : 'desc';
        $limit_by   = request()->input('limit_by') != null && in_array(request()->input('limit_by'),['10', '20', '50' ,'100']) ? request()->input('limit_by') : '20';

        $allCategories = Category::withCount('posts');

        if($keyword != null) {
            $allCategories = $allCategories->search($keyword, null, true);
        }   
        if($status !== 'all') {
            $allCategories = $allCategories->where('status', $status);
        }
        $allCategories = $allCategories->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('backend.categories.categories', ['allCategories' => $allCategories]);
    }

    public function create() {
        return view('backend.categories.create-category');
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [     
           'name' => 'required|string|min:3|unique:categories,name',         
           'status' => 'required|boolean', 
        ]);
        if($validator->fails()) {
            return redirect()->route('admin.category.create')->withInput()->withErrors($validator);
        }

        $data['name'] = $request->input('name');    
        $data['status'] = $request->input('status');
        $data['slug'] = Str::slug($request->input('name'));

        if($request->file('image') != null) {
            $data['category_image'] = $data['name'] . '-' . rand(0,1000000) . '.' . $request->file('image')->extension();
            $path = public_path('assets/categories/' . $data['category_image']);
            Image::make($request->file('image')->getRealPath())->resize(600, 338, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
        }
        
        if(Category::create($data)) {
            return redirect()->route('admin.category.create')->with([
                'message' => 'Category created successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('admin.category.all')->with([
                'message' => 'Some thing was wrong! try later ',
                'alert-type' => 'danger',
            ]);
        }

    }

    public function edit($slug) {

        $category = Category::where('slug', $slug)->first();

        if($category) {
            return view('backend.categories.edit-category', ['category' => $category]);
        }else{
            return view('backend.404');
        }
    }

    public function update(Request $request, $slug) {

        $category = Category::where('slug', $slug)->first();
        if(!$category) {
            return view('backend.404');
        }

        $validator = Validator::make($request->all(), [ 
           'name' => ['required', 'string', 'min:3',
                        Rule::unique('categories', 'name')->ignore($category->id)],          
           'status' => 'required|boolean', 
        ]);
        if($validator->fails()) {
            return redirect()->route('admin.category.edit', $slug)->withInput()->withErrors($validator);
        }

        $data['name'] = $request->input('name');    
        $data['status'] = $request->input('status');
        $data['slug'] = Str::slug($request->input('name'));

        if($request->file('image') != null) {
            $data['category_image'] = $data['name'] . '-' . rand(0,1000000) . '.' . $request->file('image')->extension();
            $path = public_path('assets/categories/' . $data['category_image']);
            Image::make($request->file('image')->getRealPath())->resize(600, 338, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            if(File::exists(public_path('assets/categories/' . $category->category_image)) && $category->category_image != null) {
                unlink(public_path('assets/categories/' . $category->category_image));
            }
        }
        if($category->update($data)) {
            return redirect()->route('admin.category.edit', $category->slug)->with([
                'message' => 'Category updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('admin.category.all')->with([
                'message' => 'Some thing was wrong! try later ',
                'alert-type' => 'danger',
            ]);
        }

    }

    public function deleteImage($slug) {

        $category = Category::where('slug', $slug)->first();

        if($category) {

            if(File::exists(public_path('assets/categories/' . $category->category_image)) && $category->category_image != null) {
                unlink(public_path('assets/categories/' . $category->category_image));
            }

            $category->update([
                'category_image' => null 
            ]);

            return redirect()->route('admin.category.edit', $category->slug)->with([
                'message' => 'Category image deleted successfully',
                'alert-type' => 'success',
            ]);
        }else{
            return view('backend.404');
        }
    }

    public function destroy($slug) {

        $category = Category::where('slug', $slug)->first();

        if($category) {
            foreach($category->posts as $post) {
                foreach($post->media as $media) {
                    if(File::exists('assets/posts/' . $media->file_name) && $media->file_name !=null) {
                        unlink(public_path('assets/posts/' . $media->file_name));
                    }
                }
                if(File::exists(public_path('assets/posts/' . $post->post_cover)) && $post->post_cover != null) {
                    unlink(public_path('assets/posts/' . $post->post_cover));
                }
            }



            if(File::exists(public_path('assets/categories/' . $category->category_image)) && $category->category_image != null) {
                unlink(public_path('assets/categories/' . $category->category_image));
            }

            if($category->delete()) {
                return redirect()->route('admin.category.all')->with([
                    'message' => 'Category deleted successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.category.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }
        }else{
            return view('backend.404');
        }

    }
}
