<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\MyBlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->intended('blog_view');
});

Route::get('blog_view', [BlogController::class, 'showAllBlogs']);
Route::get('my_blog_view/{order?}', [MyBlogController::class, 'showMyBlogs']);
Route::post('my_blog_view/store', [MyBlogController::class, 'store']);
Route::get('blog/import', [MyBlogController::class, 'importExternalBlogs']);

Auth::routes();

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', function () {
    return redirect()->intended('my_blog_view');
});

