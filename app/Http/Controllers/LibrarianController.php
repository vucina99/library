<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Author;
use App\Models\AuthorImage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibrarianController extends Controller
{
//  private User $user; Zeza me verzija php pa ne mogu da stavim koj ie tip :)
    private $user;
    private $role;
    private $author;
    private $authorImage;

    public function __construct()
    {
        $this->user = new User();
        $this->role = new Role();
        $this->author = new Author();
        $this->authorImage = new AuthorImage();
    }

    public function books()
    {
        return view('librarian.books');
    }

    public function users()
    {
        return view('librarian.users');
    }

    public function authors()
    {
        return view('librarian.authors');
    }

    public function getUsers()
    {
        $users = $this->user->getUsers();
        return response(UserResource::collection($users), 200);
    }

    public function getRoles()
    {
        $role = $this->role->getRoles();
        return response(RoleResource::collection($role), 200);
    }

    public function createUser(CreateUserRequest $request)
    {
        $user = $this->user->createUser($request);
        return response(new UserResource($user), 201);
    }

    public function editUser(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response('User not found', 404);
        }
        $user = $this->user->editUser($request, $user);
        return response(new UserResource($user), 200);
    }

    public function deleteUser($id){
        $user = User::find($id);
        if (!$user) {
            return response('Author not found', 404);
        }

        $user->delete();
        return response('{}' , 204);
    }

    public function createAuthor(CreateAuthorRequest $request)
    {
        //kreiramo autora metodom createAuthor, koja vraca tek kreirani objekat
        $createAuthor = $this->author->createAuthor($request);

        //image nije obavezna pa proveravamo da li je prosledjena
        if ($request->hasFile('image')) {
            //ako jeste prosledjujemo podatke za unos
            $this->authorImage->uploadImage($request, $createAuthor->id);
        } else {
            //ako nije pravimo record u bazi sa defaultnim avatarom
            AuthorImage::create([
                'name' => 'avatar.jpeg',
                'author_id' => $createAuthor->id,
                'created_by' => Auth::user()->id
            ]);
        }

        return response(new AuthorResource($createAuthor), 201);
    }

    public function getAuthors()
    {
        $authors = $this->author->getAuthors();
        return response(AuthorResource::collection($authors), 200);
    }


    public function editAuthor(CreateAuthorRequest $request)
    {
        //proveravamo da li postoji autor, ako ne postoji odma prekidamo program
        $author = Author::find($request->id);
        if (!$author) {
            return response('Author not found', 404);
        }

        //ako je prosledjena slika, radimo brisanje slike iz foldera i recorda u bazi , i dodajemo novu sliku
        if ($request->hasFile('image')) {
            $authorImage = AuthorImage::where('author_id', $request->id)->first();
            if ($authorImage){
                $this->authorImage->removeFile($authorImage);
            }
            $this->authorImage->uploadImage($request, $request->id);
        }

        //ovde radimo update osnovnih podataka u tabeli authors
        $editAuthor = $this->author->editAuthor($request, $author);
        return response(new AuthorResource($editAuthor), 200);
    }


    public function deleteAuthor($id){
        $author = Author::find($id);

        //proveramo da li postoji user i da li je user koji zelimo da obrisemo glavni bibliotekar u app, , takodje ne mozemo da obrisemo sebe kao usera dok smo ulogovani.
        if (!$author || $author->created_by == null || $author->id == Auth::user()->id) {
            return response('Author not found', 404);
        }
        //brisanje fotografije iz foldera kao i brisanje recorda u bazi ako nije avatar
        $authorImage = AuthorImage::where('author_id', $author->id)->first();
        if ($authorImage){
            $this->authorImage->removeFile($authorImage);
        }

        //brisanje autora
        $author->delete();

        return response('{}' , 204);

    }
}
