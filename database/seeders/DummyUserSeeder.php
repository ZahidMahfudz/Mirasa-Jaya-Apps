<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userdata = [
            [
                'name'=>'admin',
                'username'=> 'admin',
                'password'=>bcrypt('admin'),
                'role'=>'admin'
            ],

            [
                'name'=>'Rusmin Utsman Wijaya',
                'username'=> 'rusminutsman',
                'password'=>bcrypt('rusminutsman'),
                'role'=>'manager'
            ],

            [
                'name'=>'Tanto Budi',
                'username'=> 'tantobudi',
                'password'=>bcrypt('tantobudi'),
                'role'=>'owner'
            ],
        ];
        foreach($userdata as $key => $val){
            User::create($val);
        };
    }
}
