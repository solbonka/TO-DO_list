<?php

use App\Http\Controllers\API\NoteController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

// Получение списка всех заметок(для админа)
Route::get('/all-notes', [NoteController::class, 'getAll'])->middleware('isAdmin');

// Получение списка заметок(для пользователя)
Route::get('/notes/', [NoteController::class, 'getMy']);

// Получение конкретной заметки
Route::get('/note', [NoteController::class, 'getOne']);

// Создание новой заметки
Route::post('/note', [NoteController::class, 'create']);

// Обновление существующей заметки
Route::put('/note', [NoteController::class, 'update']);

// Удаление заметки
Route::delete('/note', [NoteController::class, 'delete']);

Route::controller(UserController::class)->group(function () {
    Route::post('signin', 'postSignIn');
    Route::post('signup', 'postSignUp');
    Route::post('logout', 'logout')->middleware('auth:api');
});
