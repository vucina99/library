<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function logoutForm()
    {
        Auth::logout();

        return redirect('/');
    }


    //ovde cemo raditi paginaciju jer moze da bude puno knjiga :)
    public function getBook(Request $request){
        //number data je broj koliko prikazujemo knjiga
        $numberData = 25;
        $book = Book::query();

        //page je stranica na koju smo kliknuli
        $page = $request->page;


        //proveravamo da li postoji search, jer na home stranici ga ima a na books stranici to nemamo
        if(isset($request->search)){
            $search = (object)$request->search;
        }

        if (isset($request->search) && $search->author !== '' && $search->author !== null) {
            $book = $book->where('author_id', $search->author['id']);
        }
        if (isset($request->search) && $search->title !== '' && $search->title !== null) {
            $book = $book->where('title', $search->title);
        }
        if (isset($request->search) && $search->bookNumber !== '' && $search->bookNumber !== null) {
            $book = $book->where('book_number', $search->bookNumber);
        }

        //da bi dobili tacan broj koliko treba da prikazemo brojeva u paginaciji, ali uzimamo gornju vrednost
        $count = ceil($book->count() / $numberData);

        //u zavisnosti od stranice * $numberData, toliko recorda preskacemo i uzimamo sledeci  $numberData
        $book = $book->skip($page * $numberData)->take($numberData)->get();

        return response(['data' => BookResource::collection($book), 'count' => $count]);
    }
}
