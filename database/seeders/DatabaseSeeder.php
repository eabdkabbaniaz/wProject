<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
      
        $this->call([
            RolePermissionSeeder::class
        ]);

        // $this->call([
        //     StudentSeeder::class,
        // ]);
        // $this->call([
        //     SettingsTableSeeder::class,
        // ]);
          $user1 = User::create([
            'name' => 'student One',
            'email' => '123456',
            'password' => Hash::make('11111111'),
        ]);

        $user1->assignRole('student');
          $user3 = User::create([
            'name' => 'student Two',
            'email' => '123455',
            'password' => Hash::make('11111111'),
        ]);

        $user3->assignRole('student');

        $user2 = User::create([
            'name' => 'Manager Two',
            'email' => 'manager2@example.com',
            'password' => Hash::make('11111111'),
        ]);

        $user2->assignRole('manger');
       
        $user4 = User::create([
            'name' => 'teacher One',
            'email' => 'teacher1@example.com',
            'password' => Hash::make('11111111'),
        ]);

        $user4->assignRole('teacher');
       
        $user5 = User::create([
            'name' => 'superVisorTeacher One',
            'email' => 'superVisorTeacher1@example.com',
            'password' => Hash::make('11111111'),
        ]);

        $user5->assignRole('superVisorTeacher');
       
            // $this->call([
            //     StudentSeeder::class,
            // ]);
            // $this->call([
            //    SemesterSeeder::class,
            // ]);
            // $this->call([
            //    SettingsTableSeeder::class,
            // ]);
    }
}
