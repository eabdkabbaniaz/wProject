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
    $teacher = Teacher::create([
            'user_id' => $user4->id,
            'is_active' => 1

        ]);
        $user4->assignRole('teacher');
       
        $user5 = User::create([
            'name' => 'superVisorTeacher One',
            'email' => 'superVisorTeacher1@example.com',
            'password' => Hash::make('11111111'),
        ]);
  $superVisorTeacher = Teacher::create([
            'user_id' => $user5->id,
            'is_active' => 1

        ]);
        $user5->assignRole('superVisorTeacher');
       
        $semester1 = Semester::create(['name' => 'الفصل الأول']);
        $semester2 = Semester::create(['name' => 'الفصل الثاني']);
        // Create Experiences
        $frogHeart = Experience::create(['name' => 'تجربة قلب ضفدع']);
        $intestine2 = Experience::create(['name' => 'تجربة معي الخنزير']);
        $intestine1 = Experience::create(['name' => 'تجربة معي الارنب']);

        // Attach Experiences to Semesters
        DB::table('experineces_semesters')->insert([
            ['experience_id' => $intestine1->id, 'semester_id' => $semester1->id],
            ['experience_id' => $intestine2->id, 'semester_id' => $semester1->id],
            ['experience_id' => $frogHeart->id, 'semester_id' => $semester1->id],
            ['experience_id' => $intestine1->id, 'semester_id' => $semester2->id],
            ['experience_id' => $frogHeart->id, 'semester_id' => $semester2->id],
        ]);


        // Create Drugs
        $acetylcholine = Drug::create(['name' => 'acetylcholine']);
        $adrenaline = Drug::create(['name' => 'Adrenaline']);
        $atropine = Drug::create(['name' => 'Atropine']);
        $NorAdrenaline = Drug::create(['name' => 'NorAdrenaline']);
        $Alpha_Beta_blocker = Drug::create(['name' => 'Alpha Beta blocker']);
        $Magnesium = Drug::create(['name' => 'Magnesium']);
        $Carbachol = Drug::create(['name' => 'Carbachol']);
        $Pilocarpine = Drug::create(['name' => 'Pilocarpine']);
        $barium = Drug::create(['name' => 'barium']);

DB::table('experience_drugs')->insert([
    ['drug_id' => $Magnesium->id, 'experience_id' => $intestine1->id, 'effect' => false],
    ['drug_id' => $acetylcholine->id, 'experience_id' => $intestine1->id, 'effect' => true],
    ['drug_id' => $Alpha_Beta_blocker->id, 'experience_id' => $intestine1->id, 'effect' => true],
    ['drug_id' => $adrenaline->id, 'experience_id' => $intestine1->id, 'effect' => false],
    ['drug_id' => $atropine->id, 'experience_id' => $intestine1->id, 'effect' => false],
    ['drug_id' => $NorAdrenaline->id, 'experience_id' => $intestine1->id, 'effect' => false],
    ['drug_id' => $Carbachol->id, 'experience_id' => $intestine1->id, 'effect' => true],
    ['drug_id' => $Pilocarpine->id, 'experience_id' => $intestine1->id, 'effect' => true],
]);


DB::table('experience_drugs')->insert([
    ['drug_id' => $Magnesium->id, 'experience_id' => $intestine2->id, 'effect' => false],
    ['drug_id' => $acetylcholine->id, 'experience_id' => $intestine2->id, 'effect' => true],
    ['drug_id' => $Alpha_Beta_blocker->id, 'experience_id' => $intestine2->id, 'effect' => true],
    ['drug_id' => $adrenaline->id, 'experience_id' => $intestine2->id, 'effect' => false],
    ['drug_id' => $atropine->id, 'experience_id' => $intestine2->id, 'effect' => false],
    ['drug_id' => $barium->id, 'experience_id' => $intestine2->id, 'effect' => true],
]);

$drugsfrogHeart = [
    ['drug' => $acetylcholine, 'effect' => false],
    ['drug' => $adrenaline, 'effect' => true],
    ['drug' => $atropine, 'effect' => true],
    ['drug' => $NorAdrenaline, 'effect' => true],
    ['drug' => $Alpha_Beta_blocker, 'effect' => false],
    ['drug' => $Magnesium, 'effect' => false],
];

foreach ($drugsfrogHeart as $item) {
    DB::table('experience_drugs')->insert([
        'drug_id' => $item['drug']->id,
        'experience_id' => $frogHeart->id,
        'effect' => $item['effect'],
    ]);
}

        // Create 3 Sessions for frogHeart in semester 1
        $expSem = DB::table('experineces_semesters')
            ->where('experience_id', $frogHeart->id)
            ->where('semester_id', $semester1->id)
            ->first();

        // You might want to change teacher_id to an actual existing user id
        // $teacherId = 5;

        $session1 = Session::create([
            'name' => 'جلسة أستيل كولين',
            'code' => 'S1',
            'experience_id' => $expSem->id,
            'teacher_id' => $user5->id,
        ]);

        $session2 = Session::create([
            'name' => 'جلسة أتروبين',
            'code' => 'S2',
            'experience_id' => $expSem->id,
            'teacher_id' =>$user5->id,
        ]);

        $session3 = Session::create([
            'name' => 'جلسة أستيل كولين + أتروبين',
            'code' => 'S3',
            'experience_id' => $expSem->id,
            'teacher_id' => $user5->id,
        ]);

        DB::table('drug_sessions')->insert([
            ['session_id' => $session1->id, 'drug_id' => $acetylcholine->id],
            ['session_id' => $session2->id, 'drug_id' => $atropine->id],
            ['session_id' => $session3->id, 'drug_id' => $acetylcholine->id],
            ['session_id' => $session3->id, 'drug_id' => $atropine->id],
        ]);

    }
}
