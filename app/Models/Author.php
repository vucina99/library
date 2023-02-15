<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Author extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $fillable = [
        'first_name',
        'last_name',
        'created_by'
    ];
    public function authorImage()
    {
        return $this->hasOne(AuthorImage::class);
    }

    public function createAuthor($request){
        $author = Author::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'created_by' => Auth::user()->id
        ]);

        return $author->refresh();
    }

    public function getAuthors(){
        $authors = Author::all();
        return $authors;
    }
}
