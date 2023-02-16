<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'book_number',
        'author_id',
        'created_by'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    //book
    public function createBook($request){
        $author = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'book_number' => $request->bookNumber,
            'author_id' => $request->author['id'],
            'created_by' => Auth::user()->id
        ]);

        return $author->refresh();
    }
}
