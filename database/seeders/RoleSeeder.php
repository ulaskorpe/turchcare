<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name'=>'sudo',
            'admins'=>3,
            'users'=>3,
            'posts'=>3,
            'blogs'=>3,
            'payments'=>3,
            'comments'=>3
        ]);

        Role::create([
            'name'=>'admin',
            'admins'=>0,
            'users'=>2,
            'posts'=>2,
            'blogs'=>2,
            'payments'=>2,
            'comments'=>3
        ]);


        Role::create([
            'name'=>'sub-admin',
            'admins'=>0,
            'users'=>2,
            'posts'=>2,
            'blogs'=>2,
            'payments'=>0,
            'comments'=>2
        ]);
    }
}
