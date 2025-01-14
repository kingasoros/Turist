<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\FavoriteController;
use App\Models\Tour;
use App\Http\Controllers\AttractionsController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Middleware\CheckIfUserCanRegister;
use App\Http\Controllers\Auth\RegisteredUserController;


require __DIR__.'/auth.php';
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
    return view('welcome'); 
})->name('home');

Route::get('/search', function (Request $request) {
    return Order::search($request->input('query'))->get();
});

Route::get('/search', [SearchController::class, 'search']);

Route::middleware(['checkifusercanregister'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

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

Route::get('/admin', function () {
    return view('static-pages.front.php.attractions');
})->name('admin');

Route::get('/tours', [TourController::class, 'index'])->name('tours');

Route::post('/add-to-favorites', [FavoriteController::class, 'store'])->middleware('auth');

Route::post('/tours_make_process', [TourController::class, 'store'])->name('tours.store');

Route::delete('/favorites/delete', [FavoriteController::class, 'delete'])->name('favorites.delete');

Route::delete('/tour/{tour}', [TourController::class, 'destroy'])->name('tours.destroy');

Route::post('/api/attractions', [AttractionsController::class, 'getAttractionDetails']);

Route::middleware(['auth', 'is_active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

});

Route::get('/users/{id}/approve/{token}', [AdminUserController::class, 'approveUser']);
Route::get('/users/{id}/decline/{token}', [AdminUserController::class, 'declineUser']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); 
})->name('logout');

Route::get('/users/{id}/activate/{token}', [AdminUserController::class, 'activateUser']);

Route::get('/activate/{token}', function ($token) {
    $user = User::where('activation_token', $token)->first();

    if (!$user) {
        return response('Érvénytelen vagy lejárt token.', 400);
    }

    $user->is_active = 1;
    $user->activation_token = null;
    $user->save();

    return redirect('/')->with('message', 'Fiókod aktiválva lett!');
})->name('activate.account');

Route::post('/api/saveSelectedName', function (Request $request) {
    session(['selectedName' => $request->name]);  // Kiválasztott név mentése a session-ba
    return response()->json(['success' => true]);
});

Route::get('/api/cities', function () {
    $cities = DB::table('attractions')->distinct()->pluck('city_name');
    return response()->json($cities);
});

Route::get('/api/getAttractions', function (Request $request) {
    $selectedName = $request->query('selectedName', '');

    $stmt = DB::connection()->getPdo()->prepare("SELECT * FROM attractions");
    $stmt->execute();
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($selectedName)) {
        $selectedAttraction = DB::connection()->getPdo()->prepare("SELECT * FROM attractions WHERE name = :name LIMIT 1");
        $selectedAttraction->bindParam(':name', $selectedName, PDO::PARAM_STR);
        $selectedAttraction->execute();
        $selectedAttraction = $selectedAttraction->fetch(PDO::FETCH_ASSOC);

        $attractions = array_filter($attractions, function ($attraction) use ($selectedName) {
            return $attraction['name'] !== $selectedName;
        });

        array_unshift($attractions, $selectedAttraction);
    }

    return response()->json($attractions);
});

Route::get('/api/getAttractionsByCity', function (Request $request) {
    $city = $request->input('city');
    
    $attractions = DB::table('attractions')
                     ->when($city, function ($query, $city) {
                         return $query->where('city_name', $city);
                     })
                     ->get();

    return response()->json($attractions);
});

Route::get('/api/types', function () {
    $types = DB::table('attractions')->distinct()->pluck('type');
    return response()->json($types);
});

Route::get('/api/interests', function () {
    $interests = DB::table('attractions')->distinct()->pluck('interest');
    return response()->json($interests);
});

Route::get('/api/getAttractionsByFilters', function (Request $request) {
    $city = $request->input('city');
    $type = $request->input('type');
    $interest = $request->input('interest');
    
    $attractions = DB::table('attractions')
                     ->when($city, function ($query, $city) {
                         return $query->where('city_name', $city);
                     })
                     ->when($type, function ($query, $type) {
                         return $query->where('type', $type);
                     })
                     ->when($interest, function ($query, $interest) {
                         return $query->where('interest', $interest);
                     })
                     ->get();

    return response()->json($attractions);
});
