<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthorImage extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $fillable = [
        'name',
        'author_id',
        'created_by'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function uploadImage($request , $author_id){
        //store image in public folder
        $imageName = time() . rand(1, 10000) . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path() . '/img/authors', $imageName);

        //save in database with foregin key author_id
        $authorImage = AuthorImage::create([
            'name' => $imageName,
            'author_id' => $author_id,
            'created_by' => Auth::user()->id
        ]);

        return $authorImage->refresh();
    }
}
