<?php

use App\Http\Controllers\LibrarianController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '^\d+$'); //proveravamo da li je svaki prosledjeni id integer
Route::group(['prefix' => 'librarian', 'middleware' => 'librarian'], function () {

    // da ne bih korstio mnogo routes fajlova, napravio sam jedan i sva specijalne mogucnosti bibliotekara sam napisao ovde
    // i ako je mnogo lepse da se razdvoje, nema ih mnogo pa nema smisla praviti vise fajlova :)


    //users
    Route::get('/users', [LibrarianController::class, 'users']);
    Route::get('/get/users', [LibrarianController::class, 'getUsers']);
    Route::post('/create/user', [LibrarianController::class, 'createUser']);
    Route::get('/get/roles', [LibrarianController::class, 'getRoles']);
    Route::patch('/edit/user/{id}', [LibrarianController::class, 'editUser']);
    Route::delete('/delete/user/{id}', [LibrarianController::class, 'deleteUser']);

    //authors
    Route::get('/authors', [LibrarianController::class, 'authors']);
    Route::get('/get/authors', [LibrarianController::class, 'getAuthors']);
    Route::post('/create/author', [LibrarianController::class, 'createAuthor']);
    Route::post('/edit/author', [LibrarianController::class, 'editAuthor']);
    Route::delete('/delete/author/{id}', [LibrarianController::class, 'deleteAuthor']);


    //books
    Route::get('/books', [LibrarianController::class, 'books']);
    Route::post('/create/book', [LibrarianController::class, 'createBook']);
    Route::delete('/delete/book/{id}', [LibrarianController::class, 'deleteBook']);
    Route::patch('/edit/book/{id}', [LibrarianController::class, 'editBook']);


});


