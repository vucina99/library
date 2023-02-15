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

    public function createAuthor(CreateAuthorRequest $request)
    {
        $createAuthor = $this->author->createAuthor($request);
        if ($request->hasFile('image')) {
            $this->authorImage->uploadImage($request , $createAuthor->id);
        }else{
            AuthorImage::create([
                'first_name' => 'avatar.jpeg',
                'author_id' =>  $createAuthor->id,
                'created_by' => Auth::user()->id
            ]);
        }

        return response(new AuthorResource($createAuthor) , 201);
    }

    public function getAuthors(){
        $authors = $this->author->getAuthors();
        return response(AuthorResource::collection($authors) , 200);
    }
}
