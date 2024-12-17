<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\FavoriteController;

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


Route::get('/search', function (Request $request) {
    return Order::search($request->input('query'))->get();
});

Route::get('/search', [SearchController::class, 'search']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/blogs', function () {
    return view('static-pages.front.php.blogs');
})->name('blogs');

Route::get('/attractions', function () {
    return view('static-pages.front.php.attractions');
})->name('attractions');

Route::get('/blogs_page/{id}', function ($id) {
    return view('static-pages.front.php.blogs_page');
})->name('blogs_page');

Route::get('/tours', function () {
    return view('static-pages.front.php.tours');
})->name('tours');

Route::get('/tours_make', function () {
    return view('static-pages.front.php.tours_make');
})->name('tours_make');

Route::get('/favorites', function () {
    return view('static-pages.front.php.favorites');
})->name('favorites');

Route::post('/tours_make_process', [TourController::class, 'store'])->name('tours.store');

Route::post('/add-to-favorites', [FavoritesController::class, 'addToFavorites'])->name('favorites.add');
Route::post('/remove-from-favorites', [FavoritesController::class, 'removeFromFavorites'])->name('favorites.remove');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

