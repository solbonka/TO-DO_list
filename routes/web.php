<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Swagger\SwaggerController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/api/docs', [SwaggerController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});
Route::get('/generate-swagger-docs', function () {
    Artisan::call('app:generate-swagger-docs');

    // Отобразить сообщение об успешной генерации документации
    return 'Swagger documentation generated successfully.';
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->intended(RouteServiceProvider::HOME);
})->middleware(['auth', 'signed'])->name('verification.verify');
