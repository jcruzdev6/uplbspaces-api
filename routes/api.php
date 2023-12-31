<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminUserController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FacilityController;
use App\Http\Controllers\API\FacilityTypeController;
use App\Http\Controllers\API\FacilityRateController;
use App\Http\Controllers\API\DepartmentUnitController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\BookingDateController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\MailerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/** SignIn and SignUp */
Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/signin', [AuthController::class, 'signin']);
Route::post('/auth/signout', [AuthController::class, 'signout']);   
Route::post('/auth/verify', [AuthController::class, 'verify']);   
Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'redirectToProvider']);
    Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::get('/login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);
});


/** Guest APIs */
Route::controller(FacilityTypeController::class)->group(function () {
    Route::get('/facility_types', 'index');
    Route::get('/facility_types/{facility_type}', 'show');
});

Route::controller(FacilityController::class)->group(function () {
    Route::get('/facilities', 'index');
    Route::get('/facilities/{facility}', 'show');
    Route::get('/facilities/type/{facility_type}', [FacilityController::class, 'getFacilityByType']);
});

Route::controller(PageController::class)->group(function () {
    Route::get('/pages', 'index');
    Route::get('/pages/{page}', 'show');
});

Route::controller(FAQController::class)->group(function () {
    Route::get('/faqs', 'index');
    Route::get('/faqs/{faq}', 'show');
});

Route::post('/contactus', [MailerController::class, 'sendContactUs']);

Route::controller(DepartmentUnitController::class)->group(function () {
    Route::get('/department_units', 'index');
    Route::get('/department_units/{department_unit}', 'show');
});

Route::get('/search', [SearchController::class, 'search']);
Route::get('/search/{keyword}', [SearchController::class, 'searchGet']);

Route::controller(BookingController::class)->group(function () {
    Route::get('/bookings/{facility_id}', 'bookingsById');
});

/** Authenticated APIs */
Route::middleware('auth:sanctum')->group(function () {
    /*Route::get('/user', function (Request $request) {
        Log::debug($request->user());
        return $request->user();
    });*/

    Route::get('/user', [AuthController::class, 'me']);
    Route::get('/user/profile', [AuthController::class, 'profile']);
    Route::post('/user/profile', [AuthController::class, 'updateProfile']);

    Route::controller(BookingController::class)->group(function () {
        Route::get('/mybookings', 'mybookings');
    });
});

\DB::listen(function($sql) {
    \Log::info($sql->sql);
    \Log::info($sql->bindings);
    \Log::info($sql->time);
});

