<?php

use App\Models\Contact;
use Illuminate\Support\Facades\Route;


Route::get('/' , 'Backend\IndexController@index')->name('admin.home');
Route::get('/search/{type?}' , 'Backend\IndexController@search')->name('admin.search');

Route::post('logout',   'Backend\AdminLoginController@logout')->name('admin.logout');

// Profile
Route::get('/pofile' , 'Backend\IndexController@profile')->name('admin.profile');
Route::get('/pofile/edit' , 'Backend\IndexController@edit')->name('admin.profile.edit');
Route::put('/pofile/update' , 'Backend\IndexController@update')->name('admin.pofile.update');
Route::put('/pofile/password' , 'Backend\IndexController@updatePassword')->name('admin.pofile.update.password');
Route::delete('/pofile/image' , 'Backend\IndexController@destroyImage')->name('admin.pofile.destroy.image');


// Categories
Route::get('/categories' , 'Backend\CategoriesController@index')->name('admin.category.all')->middleware(['permission:show categories|edit category|delete category']);
Route::get('/category/create' , 'Backend\CategoriesController@create')->name('admin.category.create')->middleware(['permission:store category']);
Route::post('/category' , 'Backend\CategoriesController@store')->name('admin.category.store')->middleware(['permission:store category']);
// Route::get('/category/{slug}' , 'Backend\CategoriesController@show')->name('admin.category.show')->middleware(['permission:show categories']);
Route::get('/category/{slug}/edit' , 'Backend\CategoriesController@edit')->name('admin.category.edit')->middleware(['permission:edit category']);
Route::get('/category/{slug}/delete-image' , 'Backend\CategoriesController@deleteImage')->name('admin.category.delete.image')->middleware(['permission:edit category']);
Route::put('/category/{slug}' , 'Backend\CategoriesController@update')->name('admin.category.update')->middleware(['permission:edit category']);
Route::delete('/category/{slug}' , 'Backend\CategoriesController@destroy')->name('admin.category.destroy')->middleware(['permission:delete category']);

// Posts
Route::get('/posts' , 'Backend\PostsController@index')->name('admin.post.all')->middleware(['permission:show posts|edit post|delete post']);
Route::get('/post/create' , 'Backend\PostsController@create')->name('admin.post.create')->middleware(['permission:store post']);
Route::post('/post' , 'Backend\PostsController@store')->name('admin.post.store')->middleware(['permission:store post']);
Route::get('/post/{slug}' , 'Backend\PostsController@show')->name('admin.post.show')->middleware(['permission:show posts|edit post|delete post']);
Route::get('/post/{slug}/status/{status}' , 'Backend\PostsController@status')->name('admin.post.status')->middleware(['permission:edit post']);
Route::get('/post/{slug}/edit' , 'Backend\PostsController@edit')->name('admin.post.edit')->middleware(['permission:edit post']);
Route::get('/post/{slug}/cover/' , 'Backend\PostsController@cover')->name('admin.post.cover')->middleware(['permission:edit post']);
Route::get('/post/{slug}/image/{id}' , 'Backend\PostsController@image')->name('admin.post.image')->middleware(['permission:edit post']);
Route::put('/post/{slug}' , 'Backend\PostsController@update')->name('admin.post.update')->middleware(['permission:edit post']);
Route::delete('/post/{slug}' , 'Backend\PostsController@destroy')->name('admin.post.destroy')->middleware(['permission:delete post']);

// Users
Route::get('/users' , 'Backend\UsersController@index')->name('admin.user.all')->middleware(['permission:show users|edit user|delete user']);
Route::get('/user/create' , 'Backend\UsersController@create')->name('admin.user.create')->middleware(['permission:store user']);
Route::post('/user' , 'Backend\UsersController@store')->name('admin.user.store')->middleware(['permission:store user']);
// Route::get('/user/{slug}' , 'Backend\UsersController@show')->name('admin.user.show');
Route::get('/user/{slug}/edit' , 'Backend\UsersController@edit')->name('admin.user.edit')->middleware(['permission:edit user']);
Route::put('/user/password/{slug}' , 'Backend\UsersController@updatePassword')->name('admin.user.update.password')->middleware(['permission:edit user']);
Route::put('/user/{slug}' , 'Backend\UsersController@update')->name('admin.user.update')->middleware(['permission:edit user']);
Route::delete('/user/image/{slug}' , 'Backend\UsersController@destroyImage')->name('admin.user.destroy.image')->middleware(['permission:edit user']);
Route::delete('/user/{slug}' , 'Backend\UsersController@destroy')->name('admin.user.destroy')->middleware(['permission:delete user']);

// Comments
Route::get('/comments' , 'Backend\CommentsController@index')->name('admin.comment.all')->middleware(['permission:show comments|activate comment|delete comment']);
Route::get('/comment/{id}/status/{status}' , 'Backend\CommentsController@status')->name('admin.comment.status')->middleware(['permission:activate comment']);
Route::post('/comment' , 'Backend\CommentsController@store')->name('admin.comment.store')->middleware(['permission:store comment']);
Route::delete('/comment/{id}' , 'Backend\CommentsController@destroy')->name('admin.comment.destroy')->middleware(['permission:delete comment']);

// Pages
// Route::get('/page/{slug}' , 'Backend\PagesController@show')->name('admin.page.show')->middleware(['permission:show pages|edit page']);
Route::get('/page/{slug}/edit' , 'Backend\PagesController@edit')->name('admin.page.edit')->middleware(['permission:edit page']);
Route::put('/page/{slug}' , 'Backend\PagesController@update')->name('admin.page.update')->middleware(['permission:edit page']);
Route::get('/page/{slug}/cover/' , 'Backend\PagesController@cover')->name('admin.page.cover')->middleware(['permission:edit page']);
Route::get('/page/{slug}/image/{id}' , 'Backend\PagesController@image')->name('admin.page.image')->middleware(['permission:edit page']);

// Settings
Route::get('/settings', 'Backend\SettingsController@index')->name('admin.settings');
Route::put('/settings/{section}', 'Backend\SettingsController@update')->name('admin.settings.update');

// Roles 
Route::get('/roles', 'Backend\RolesController@index')->name('admin.role.all')->middleware(['permission:show roles|edit role|delete role']);
Route::get('/role/create', 'Backend\RolesController@create')->name('admin.role.create')->middleware(['permission:store role']);
Route::post('/role', 'Backend\RolesController@store')->name('admin.role.store')->middleware(['permission:store role']);
Route::get('/role/{id}' , 'Backend\RolesController@show')->name('admin.role.show')->middleware(['permission:show roles']);
Route::get('/role/{id}/edit' , 'Backend\RolesController@edit')->name('admin.role.edit')->middleware(['permission:edit role']);
Route::put('/role/{id}' , 'Backend\RolesController@update')->name('admin.role.update')->middleware(['permission:edit role']);
Route::delete('/role/{id}' , 'Backend\RolesController@destroy')->name('admin.role.destroy')->middleware(['permission:delete role']);

// Admins
Route::get('/admins' , 'Backend\AdminsController@index')->name('admin.admin.all')->middleware(['role:super admin']);
Route::get('/admin/create' , 'Backend\AdminsController@create')->name('admin.admin.create')->middleware(['role:super admin']);
Route::post('/admin' , 'Backend\AdminsController@store')->name('admin.admin.store')->middleware(['role:super admin']);
Route::get('/admin/password/{slug}' , 'Backend\AdminsController@editPassword')->name('admin.admin.edit.password')->middleware(['role:super admin']);
Route::get('/admin/{slug}' , 'Backend\AdminsController@show')->name('admin.admin.show')->middleware(['role:super admin']);
Route::get('/admin/{slug}/edit' , 'Backend\AdminsController@edit')->name('admin.admin.edit')->middleware(['role:super admin']);
Route::put('/admin/password/{slug}' , 'Backend\AdminsController@updatePassword')->name('admin.admin.update.password')->middleware(['role:super admin']);
Route::put('/admin/{slug}' , 'Backend\AdminsController@update')->name('admin.admin.update')->middleware(['role:super admin']);
Route::delete('/admin/image/{slug}' , 'Backend\AdminsController@destroyImage')->name('admin.admin.destroy.image')->middleware(['role:super admin']);
Route::delete('/admin/{slug}' , 'Backend\AdminsController@destroy')->name('admin.admin.destroy')->middleware(['role:super admin']);

//Contacts
Route::get('/contacts' , 'Backend\ContactUsController@index')->name('admin.contact.all')->middleware(['permission:show contacts|replay contact|delete contact']);
Route::get('/contact/{id}/replay' , 'Backend\ContactUsController@replay')->name('admin.contact.replay')->middleware(['permission:replay contact']);
Route::post('/contact/{id}/replay' , 'Backend\ContactUsController@replaySend')->name('admin.contact.replay.send')->middleware(['permission:replay contact']);
Route::post('/contact/{id}/replay/resend' , 'Backend\ContactUsController@replayResend')->name('admin.contact.replay.resend')->middleware(['permission:replay contact']);
Route::delete('/contact/{id}/destroy' , 'Backend\ContactUsController@destroy')->name('admin.contact.destroy')->middleware(['permission:delete contact']);


/* Route::get('/email', function() {
    $contact = Contact::first();
    $replay = 'Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
    return new App\Mail\contactReplay($contact, $replay);
}); */



