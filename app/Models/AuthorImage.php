<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AuthorImage extends Model
{
    use HasFactory , SoftDeletes;



    protected $fillable = [
        'name',
        'author_id',
        'created_by'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function uploadImage($request, $author_id)
    {
        //pravim jedinstveno ime slike, i sliku prosledjujemo u foolder img/authors
        $imageName = time() . rand(1, 10000) . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path() . '/img/authors', $imageName);

        //cuvamo u record u bazi sa autorom_id kome pripada slika
        $authorImage = AuthorImage::create([
            'name' => $imageName,
            'author_id' => $author_id,
            'created_by' => Auth::user()->id
        ]);

        return $authorImage->refresh();
    }


    public function removeFile($authorImage)
    {
        if ($authorImage->name !== 'avatar.jpeg') {
            // Define the path to the file you want to delete
            $path = public_path('img/authors/' . $authorImage->name);

            // Check if the file exists
            if (File::exists($path)) {
                // Delete the file
                File::delete($path);
            }
        }

        $authorImage->delete();
        return true;
    }
}
