<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SpecialtyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

});

Route::get('/users', [AuthController::class, 'index']);
Route::resource('regions', RegionController::class)->only([
    'index', 'show', 'store'
]);
Route::resource('locations', LocationController::class)->only([
    'index', 'show', 'store'
]);
Route::resource('categories', CategoryController::class)->only([
    'index', 'show', 'store'
]);
Route::resource('subcategories', SubcategoryController::class)->only([
    'index', 'show', 'store'
]);
Route::resource('specialties', SpecialtyController::class)->only([
    'index', 'show', 'store'
]);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('/users')->group(function () {
        Route::get('/{user}/locations', [LocationController::class, 'byUser']);
        Route::post('/login', [AuthController::class, 'login']);
    });
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'show']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::resource('users', AuthController::class)->only([
        'update', 'destroy'
    ]);
    Route::resource('regions', RegionController::class)->only([
        'update', 'destroy'
    ]);
    Route::resource('locations', LocationController::class)->only([
        'update', 'destroy'
    ]);
    Route::resource('categories', CategoryController::class)->only([
        'update', 'destroy'
    ]);
    Route::resource('subcategories', SubcategoryController::class)->only([
        'update', 'destroy'
    ]);
    Route::resource('specialties', SpecialtyController::class)->only([
        'index', 'show', 'store'
    ]);
    // Payment methods
    Route::prefix('payment/methods')->group(function () {
        Route::get('/', 'PaymentMethodController@index');
        Route::post('/', 'PaymentMethodController@store');
        Route::put('/{method}/verify', 'PaymentMethodController@verifyCard');
        Route::put('/{method}/default', 'PaymentMethodController@default');
        Route::delete('/{method}', 'PaymentMethodController@removeCard');
    });
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
