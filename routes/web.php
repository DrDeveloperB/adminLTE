<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Posts;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('posts', Posts::class);
Route::GET('posts', [Posts::class, 'index'])->name('posts.index');
Route::GET('posts/create', [Posts::class, 'create'])->name('posts.create');
Route::POST('posts/store', [Posts::class, 'store'])->name('posts.store');
Route::GET('posts/{po_idx}/edit', [Posts::class, 'edit'])->name('posts.edit');
Route::PUT('posts/update', [Posts::class, 'update'])->name('posts.update');
Route::GET('posts/{po_idx?}', [Posts::class, 'show'])->name('posts.show');
Route::DELETE('posts/destroy', [Posts::class, 'destroy'])->name('posts.destroy');
Route::POST('posts/ajax_list', [Posts::class, 'ajax_list'])->name('posts.ajax_list');
Route::GET('chkUrl', [Posts::class, 'chkUrl'])->name('posts.chkUrl');

Route::resource('comments', Posts::class);
Route::resource('notice', Posts::class);
Route::resource('qna', Posts::class);
Route::resource('visit_hour', Posts::class);
Route::resource('visit_day', Posts::class);
Route::resource('visit_month', Posts::class);
Route::resource('push_set', Posts::class);
Route::resource('push_log', Posts::class);
Route::resource('member', Posts::class);
Route::resource('intro', Posts::class);
Route::resource('setting', Posts::class);
Route::resource('banner', Posts::class);

Route::resource('teposts', PostController::class, [
    'index' => 'teposts.index',
    'create' => 'teposts.create',
    'store' => 'teposts.store',
    'edit' => 'teposts.edit',
    'update' => 'teposts.update',
    'show' => 'teposts.show',
    'destroy' => 'teposts.destroy',
]);
//Route::get('posts/index',[PostController::class, 'index'])->name('posts.index');
//Route::get('posts/create',[PostController::class, 'create'])->name('posts.create');
//Route::post('posts/store',[PostController::class, 'store'])->name('posts.store');
//Route::get('posts/show',[PostController::class, 'show'])->name('posts.show');
Route::get('teposts/down',[PostController::class, 'download'])->name('teposts.down');
//Route::get('posts/down/{aaa}', function ($aaa) {
//    // return 이 없는 경우 빈 페이지가 로드됨
//    return $aaa;
//});

Route::get('te', function () {
    return view('test');
});
Route::get('tec', [TestController::class, 'index'])->name('tec');

Route::get('ma', function () {
    return view('layout.master');
})->name('ma');
