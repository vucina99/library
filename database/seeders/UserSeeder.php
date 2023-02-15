<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $getLibrarianId =  DB::table('roles')->where('name' , 'librarian')->first();
        if($getLibrarianId){
            DB::table('users')->insert([
                'first_name' => 'Mladen',
                'last_name' => 'Simijonovic',
                'email' => 'mladen.simijonovic@thinkit.rs',
                'role_id' => $getLibrarianId->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'password' => Hash::make('ThinkIT321')
            ]);
        }

    }
}
