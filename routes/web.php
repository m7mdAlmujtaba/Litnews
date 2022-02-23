<?php

use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\PostController;
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


/*Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth'])->name('dashboard');
 */

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard',  'as' => 'dashboard.'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        // Post routes
        Route::get('/posts', [PostController::class, 'index'])->name('posts');
        Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/post', [PostController::class, 'store'])->name('post.store');
        Route::get('/post/{id}', [PostController::class, 'show']);
        Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::put('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
        Route::delete('/post/{id}/delete', [PostController::class, 'destroy'])->name('post.delete');
});

require __DIR__.'/auth.php';
