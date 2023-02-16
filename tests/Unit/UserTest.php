<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;


class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        //ovaj test sadrzi sve CRUD operacije koju su napisane, nisam pisao za autore i knjige jer se sve manje vise ponavlja :)


        //prvi user koji se dobija preko seedera, koristimo ga da bi on bio bibliotekar sa ovlascenjima
        $firstUser = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'librarian')
            ->select('users.*')
            ->first();

        //trazimo rolu sa id-jem bibliotekara kako bi dodelili tek napravljenom korisniku
        $role = Role::where('name', 'librarian')->first();

        //informacije o novom korisniku
        $userArray = [
            'firstName' => 'Vuk',
            'lastName' => 'Zdravkovic',
            'email' => 'test@gmail.com',
            'password' => 'test123',
            'role' => $role->id,
            'created_by' => $firstUser->id
        ];


        $deletedUser = User::withTrashed()
            ->where('email', 'test@gmail.com',)
            ->first();

        // Ako je pronađen zapis sa istim email-om
        if ($deletedUser) {
            // trajno obriši taj zapis iz baze podataka, zato sto imamo soft delete pa unique u bazi pravi problem
            $deletedUser->forceDelete();
        }

        //actingAs koristimo da bi se firstUser predstavio kao ulogovani korisnik
        $responseCreate = $this->actingAs($firstUser)->post('/librarian/create/user', $userArray);
        //proveravamo da li je dobar http statusni kod
        $this->assertEquals(201, $responseCreate->status());

        //za svaki slucaj proverimo da li postoji u bazi
        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
        ]);

        //trazimo opet rolu ali citaoca za update korisnika
        $role = Role::where('name', 'reader')->first();

        //nove informacije korisnika
        $updateUserArray = [
            'firstName' => 'Milos',
            'lastName' => 'Veliki',
            'role' => $role->id,
        ];

        //pozivamo patch metodu za update
        $responseUpdate = $this->actingAs($firstUser)->patch('/librarian/edit/user/' . $responseCreate->original->id, $updateUserArray);
        $this->assertEquals(200, $responseUpdate->status());
        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
            'first_name' => 'Milos',
            'last_name' => 'Veliki',
            'role_id' => $role->id,
        ]);


        //delete usera

        $responseDelete = $this->actingAs($firstUser)->delete('/librarian/delete/user/' . $responseCreate->original->id);
        $this->assertEquals(204, $responseDelete->status());
        $this->assertSoftDeleted('users', [
            'email' => 'test@gmail.com',
        ]);

    }
}
