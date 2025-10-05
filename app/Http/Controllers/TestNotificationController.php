<?php

namespace App\Http\Controllers;

use App\Jobs\SendStudentNotification;
use App\Models\User;
use App\Notification\ExamNotification;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Auth;

class TestNotificationController
{
    public function send()
    {
        $user = Auth::user();
        $exam_name = "exam 244";
     //   $user->notify(new TestNotification($exam_name));
       //$user->notify->TestNotication($exam_name);
        dispatch(new SendStudentNotification($exam_name, $user));
        return response()->json(['message' => 'Job dispatched']);
    }
}
