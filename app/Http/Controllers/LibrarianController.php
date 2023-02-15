<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibrarianController extends Controller
{
    public function books(){
        return view('librarian.books');
    }

    public function users(){
        return view('librarian.users');
    }

    public function authors(){
        return view('librarian.authors');
    }
}
