<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Modules\Experience\App\Models\Drug;
use Modules\Experience\App\Models\Experience;
use Modules\Experience\App\Models\Semester;
use Modules\Experience\App\Models\Session;
use Modules\Student\App\Models\Category;
use Modules\Student\App\Models\Student;
use  Modules\Experience\App\Models\ExperienceSemester;
use App\Models\User;
use Modules\Student\App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class
        ]);

        // Users
        $user1 = User::create([
            'name' => 'Student One',
            'email' => '123456',
            'password' => Hash::make('11111111'),
        ]);
        $user1->assignRole('student');

        $user3 = User::create([
            'name' => 'Student Two',
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
            'name' => 'Teacher One',
            'email' => 'teacher1@example.com',
            'password' => Hash::make('11111111'),
        ]);
        $teacher = Teacher::create([
            'user_id' => $user4->id,
            'is_active' => 1
        ]);
        $user4->assignRole('teacher');

        $user5 = User::create([
            'name' => 'Supervisor Teacher One',
            'email' => 'supervisorteacher1@example.com',
            'password' => Hash::make('11111111'),
        ]);
        $supervisorTeacher = Teacher::create([
            'user_id' => $user5->id,
            'is_active' => 1
        ]);
        $user5->assignRole('superVisorTeacher');

        // Semesters
        $semester1 = Semester::create(['name' => 'First Semester']);
        $semester2 = Semester::create(['name' => 'Second Semester']);

        // Experiences
        $frogHeart = Experience::create(['name' => 'Frog Heart Experiment']);
        $intestine1 = Experience::create(['name' => 'Rabbit Intestine Experiment']);
        $intestine2 = Experience::create(['name' => 'Pig Intestine Experiment']);

        // Attach Experiences to Semesters
        DB::table('experineces_semesters')->insert([
            ['experience_id' => $intestine1->id, 'semester_id' => $semester1->id],
            ['experience_id' => $intestine2->id, 'semester_id' => $semester1->id],
            ['experience_id' => $frogHeart->id, 'semester_id' => $semester1->id],
            ['experience_id' => $intestine1->id, 'semester_id' => $semester2->id],
            ['experience_id' => $frogHeart->id, 'semester_id' => $semester2->id],
        ]);

        // Drugs
        $acetylcholine = Drug::create(['name' => 'Acetylcholine']);
        $adrenaline = Drug::create(['name' => 'Adrenaline (Epinephrine)']);
        $atropine = Drug::create(['name' => 'Atropine']);
        $norAdrenaline = Drug::create(['name' => 'Noradrenaline (Norepinephrine)']);
        $alphaBetaBlocker = Drug::create(['name' => 'Alpha Beta Blocker']);
        $magnesium = Drug::create(['name' => 'Magnesium']);
        $carbachol = Drug::create(['name' => 'Carbachol']);
        $pilocarpine = Drug::create(['name' => 'Pilocarpine']);
        $barium = Drug::create(['name' => 'Barium']);

        // Experience Drugs - Rabbit Intestine
        DB::table('experience_drugs')->insert([
            ['drug_id' => $magnesium->id, 'experience_id' => $intestine1->id, 'effect' => false],
            ['drug_id' => $acetylcholine->id, 'experience_id' => $intestine1->id, 'effect' => true],
            ['drug_id' => $alphaBetaBlocker->id, 'experience_id' => $intestine1->id, 'effect' => true],
            ['drug_id' => $adrenaline->id, 'experience_id' => $intestine1->id, 'effect' => false],
            ['drug_id' => $atropine->id, 'experience_id' => $intestine1->id, 'effect' => false],
            ['drug_id' => $norAdrenaline->id, 'experience_id' => $intestine1->id, 'effect' => false],
            ['drug_id' => $carbachol->id, 'experience_id' => $intestine1->id, 'effect' => true],
            ['drug_id' => $pilocarpine->id, 'experience_id' => $intestine1->id, 'effect' => true],
        ]);

        // Experience Drugs - Pig Intestine
        DB::table('experience_drugs')->insert([
            ['drug_id' => $magnesium->id, 'experience_id' => $intestine2->id, 'effect' => false],
            ['drug_id' => $acetylcholine->id, 'experience_id' => $intestine2->id, 'effect' => true],
            ['drug_id' => $alphaBetaBlocker->id, 'experience_id' => $intestine2->id, 'effect' => true],
            ['drug_id' => $adrenaline->id, 'experience_id' => $intestine2->id, 'effect' => false],
            ['drug_id' => $atropine->id, 'experience_id' => $intestine2->id, 'effect' => false],
            ['drug_id' => $barium->id, 'experience_id' => $intestine2->id, 'effect' => true],
        ]);

        // Experience Drugs - Frog Heart
        $drugsFrogHeart = [
            ['drug' => $acetylcholine, 'effect' => false],
            ['drug' => $adrenaline, 'effect' => true],
            ['drug' => $atropine, 'effect' => true],
            ['drug' => $norAdrenaline, 'effect' => true],
            ['drug' => $alphaBetaBlocker, 'effect' => false],
            ['drug' => $magnesium, 'effect' => false],
        ];

        foreach ($drugsFrogHeart as $item) {
            DB::table('experience_drugs')->insert([
                'drug_id' => $item['drug']->id,
                'experience_id' => $frogHeart->id,
                'effect' => $item['effect'],
            ]);
        }

           $allDrugs = Drug::all();
        $experiences = ExperienceSemester::all();

        // إنشاء جلسة لكل تجربة ولكل دواء
        foreach ($experiences as $exp) {
            foreach ($allDrugs as $drug) {

        $session1 = Session::create([
            'name' => "{$drug->name} Session",
            'code' => strtoupper(substr($drug->name, 0, 3)) . '-' . $exp->id,
            'experience_id' => $exp->id,
            'teacher_id' => $user5->id,
        ]);
     DB::table('drug_sessions')->insert([
            ['session_id' => $session1->id, 'drug_id' => $drug->id],
        ]);
            }
        }
    
        // Sessions for Frog Heart in Semester 1
        // $expSem = DB::table('experineces_semesters')
        //     ->where('experience_id', $frogHeart->id)
        //     ->where('semester_id', $semester1->id)
        //     ->first();

        // $session1 = Session::create([
        //     'name' => 'Acetylcholine Session',
        //     'code' => 'S1',
        //     'experience_id' => $expSem->id,
        //     'teacher_id' => $user5->id,
        // ]);

        // $session2 = Session::create([
        //     'name' => 'Atropine Session',
        //     'code' => 'S2',
        //     'experience_id' => $expSem->id,
        //     'teacher_id' => $user5->id,
        // ]);

        // $session3 = Session::create([
        //     'name' => 'Acetylcholine + Atropine Session',
        //     'code' => 'S3',
        //     'experience_id' => $expSem->id,
        //     'teacher_id' => $user5->id,
        // ]);

        // DB::table('drug_sessions')->insert([
        //     ['session_id' => $session1->id, 'drug_id' => $acetylcholine->id],
        //     ['session_id' => $session2->id, 'drug_id' => $atropine->id],
        //     ['session_id' => $session3->id, 'drug_id' => $acetylcholine->id],
        //     ['session_id' => $session3->id, 'drug_id' => $atropine->id],
        // ]);
    }
}
