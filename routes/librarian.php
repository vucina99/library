<?php

use App\Http\Controllers\LibrarianController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'librarian' , 'middleware' => 'librarian'], function () {
    Route::get('/books', [LibrarianController::class, 'books']);
    Route::get('/users', [LibrarianController::class, 'users']);
    Route::get('/authors', [LibrarianController::class, 'authors']);

});


