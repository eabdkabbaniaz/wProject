<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
// use Illuminate\Database\Seeder;
// 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Experience\App\Models\Drug;
use Modules\Experience\App\Models\Experience;
use Modules\Experience\App\Models\Semester;
use Modules\Experience\App\Models\Session;
use Modules\Student\App\Models\Category;
use Modules\Student\App\Models\Student;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
        $teacherId = 5;

        $session1 = Session::create([
            'name' => 'جلسة أستيل كولين',
            'code' => 'S1',
            'experience_id' => $expSem->id,
            'teacher_id' => $teacherId,
        ]);

        $session2 = Session::create([
            'name' => 'جلسة أتروبين',
            'code' => 'S2',
            'experience_id' => $expSem->id,
            'teacher_id' => $teacherId,
        ]);

        $session3 = Session::create([
            'name' => 'جلسة أستيل كولين + أتروبين',
            'code' => 'S3',
            'experience_id' => $expSem->id,
            'teacher_id' => $teacherId,
        ]);

        DB::table('drug_sessions')->insert([
            ['session_id' => $session1->id, 'drug_id' => $acetylcholine->id],
            ['session_id' => $session2->id, 'drug_id' => $atropine->id],
            ['session_id' => $session3->id, 'drug_id' => $acetylcholine->id],
            ['session_id' => $session3->id, 'drug_id' => $atropine->id],
        ]);
    }

    }

