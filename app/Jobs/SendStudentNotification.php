<?php

namespace App\Jobs;

use App\Http\Controllers\TestNotificationController;
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendStudentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $exam_name;
    public function __construct($exam_name)
    {
        $this->exam_name = $exam_name;
    
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $exam_name = $this->exam_name;
        $users = User::all(); // أو أي طريقة لجلب المستخدمين

        foreach ($users as $student) {
            $student->notify(new TestNotification($exam_name));
        }
    }
}
