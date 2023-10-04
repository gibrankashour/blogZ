<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Factory::create();

        $admin = Admin::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@blogz.test',
            'mobile' => '963920000470',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('123'),
            'status' => 1,
            'admin' => 1,
        ]);
        $admin->assignRole('super admin');


        $editor = Admin::create([
            'name' => 'Editor',
            'username' => 'editor',
            'email' => 'editor@blogz.test',
            'mobile' => '963920000471',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('123'),
            'status' => 1,
            'admin' => 1,
        ]);
        $editor->assignRole(['categories', 'posts', 'users', 'comments']);


        $user1 = User::create(['name' => 'Abo Jad', 'username' => 'gibran', 'email' => 'gibran@blogz.test', 'mobile' => '966500000003', 'email_verified_at' => Carbon::now(), 'password' => bcrypt('123'), 'status' => 1,]);


        $user2 = User::create(['name' => 'Mahmoud Hassan', 'username' => 'mahmoud', 'email' => 'mahmoud@blogz.test', 'mobile' => '966500000004', 'email_verified_at' => Carbon::now(), 'password' => bcrypt('123'), 'status' => 1,]);


        $user3 = User::create(['name' => 'Khaled Ali', 'username' => 'khaled', 'email' => 'khaled@blogz.test', 'mobile' => '966500000005', 'email_verified_at' => Carbon::now(), 'password' => bcrypt('123'), 'status' => 1,]);
 

        for ($i = 0; $i <10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->email,
                'mobile' => '9665' . random_int(10000000, 99999999),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('123'),
                'status' => 1
            ]);

        }
    
    
    }
}
