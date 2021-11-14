<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;
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
Route::resource('regions', RegionController::class)->only([
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
Route::get('/regions/search/{name}', [RegionController::class, 'search']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::resource('regions', RegionController::class)->only([
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
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
