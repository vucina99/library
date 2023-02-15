<?php

use App\Http\Controllers\LibrarianController;
use Illuminate\Support\Facades\Route;
Route::pattern('id', '^\d+$'); //proveravamo da li je svaki prosledjeni id integer
Route::group(['prefix' => 'librarian' , 'middleware' => 'librarian'], function () {

    //users

    Route::get('/users', [LibrarianController::class, 'users']);
    Route::get('/get/users', [LibrarianController::class, 'getUsers']);
    Route::post('/create/user', [LibrarianController::class, 'createUser']);
    Route::get('/get/roles', [LibrarianController::class, 'getRoles']);
    Route::patch('/edit/user/{id}', [LibrarianController::class, 'editUser']);

    //authors
    Route::get('/authors', [LibrarianController::class, 'authors']);
    Route::get('/get/authors', [LibrarianController::class, 'getAuthors']);
    Route::post('/create/author', [LibrarianController::class, 'createAuthor']);


    //books
    Route::get('/books', [LibrarianController::class, 'books']);

});


