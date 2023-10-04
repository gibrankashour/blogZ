<?php

use App\Models\Contact;
use Illuminate\Support\Facades\Route;

// Admin Login Form

Route::get('admin/login',     'Backend\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('admin/login',    'Backend\AdminLoginController@login');

// Admin Or User Login Error 

Route::get('login-error', function() { return view('backend.login-error'); })->name('login.error');

// User Authinticated System

Route::group([], function() {

    // Login Routes...
    Route::get('login',     'Auth\LoginController@showLoginForm')->name('login')->middleware(['login.error']);
    Route::post('login',    'Auth\LoginController@login');
    
    // Logout Routes...
    Route::post('logout',   'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register',  'Auth\RegisterController@showRegistrationForm')->name('register')->middleware(['login.error']);
    Route::post('register', 'Auth\RegisterController@register');

    // Register the typical reset password routes for an application.
    Route::get('password/reset',        'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request')->middleware(['login.error']);
    Route::post('password/email',       'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset',       'Auth\ResetPasswordController@reset')->name('password.update');

    //Register the typical confirm password routes for an application.
    Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

    // Register the typical email verification routes for an application.
    Route::get('email/verify',              'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}',  'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend',             'Auth\VerificationController@resend')->name('verification.resend');

});


Route::get('/', 'Frontend\IndexController@index')->name('home');
Route::get('/not-found', 'Frontend\IndexController@notFound')->name('notFound');

Route::middleware('auth:web')->prefix('dashboard')->group(function() {
    Route::get('/', 'Frontend\DashboardController@index')->name('dashboard.home');
    
    Route::get('/posts', 'Frontend\DashboardController@allPosts')->name('dashboard.allPosts');
    Route::get('/post', 'Frontend\DashboardController@createPost')->name('dashboard.createPost');
    Route::post('/post/store', 'Frontend\DashboardController@storePost')->name('dashboard.storePost');
    Route::get('/post/{slug}/edit', 'Frontend\DashboardController@editPost')->name('dashboard.editPost');
    Route::put('/post/update', 'Frontend\DashboardController@updatePost')->name('dashboard.updatePost');
    Route::delete('/post/{slug}', 'Frontend\DashboardController@destroyPost')->name('dashboard.destroyPost');
    //delete post photo
    Route::post('/image/{id}', 'Frontend\DashboardController@destroyImage')->name('dashboard.destroyImage');
    //delete profile & cover photo
    Route::get('/user/{type}', 'Frontend\DashboardController@destroyUserImage')->name('dashboard.destroyUserImage');

    Route::get('/my-information', 'Frontend\DashboardController@myInformation')->name('dashboard.myInformation');
    Route::put('/my-information', 'Frontend\DashboardController@updateMyInformation')->name('dashboard.updateMyInformation');
    Route::put('/my-information-password', 'Frontend\DashboardController@updatePassword')->name('dashboard.updatePassword');

    Route::get('/comments', 'Frontend\DashboardController@allComments')->name('dashboard.allComments');
    Route::get('/comments/{id}/edit/{action}', 'Frontend\DashboardController@editComment')->name('dashboard.editComment');
});

/* Route::get('/email', function() {
    $contact = Contact::first();
    return new App\Mail\contactStored($contact);
}); */

Route::get('/page/{slug}', 'Frontend\IndexController@page')->name('page');
Route::get('/page/{slug}', 'Frontend\IndexController@page')->name('page');

Route::get('/contact', 'Frontend\IndexController@contact')->name('contact');
Route::post('/contact', 'Frontend\IndexController@sendContact')->name('contact');

Route::get('/categories', 'Frontend\IndexController@categories')->name('categories');
Route::get('/category/{name}', 'Frontend\IndexController@categoryShow')->name('category.show');

Route::get('/archive/{year}/{month}', 'Frontend\IndexController@archiveShow')->name('archive');

Route::get('/user/{username}/posts', 'Frontend\IndexController@userPostsShow')->name('user.posts.show');

Route::get('/comment/{slug}', 'Frontend\IndexController@commentStore')->name('comment.store');
Route::get('/{slug}', 'Frontend\IndexController@postShow')->name('post.show');


