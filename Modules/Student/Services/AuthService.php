<?php

namespace Modules\Student\Services;

use App\Models\DeviceToken;
use Exception;
use Illuminate\Support\Facades\Hash;
use Modules\Student\Repository\StudentRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Modules\Traits\ApiResponseTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Student\Repository\AuthRepository;
use Modules\Student\Repository\Imports\StudentsImport;
use Modules\Student\Service\Distributors\CategoryDistributorFactory;


class AuthService
{

    protected $repo;
    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }

    public function login($data)
    {
        try {
            $data['device_token'] = $data->device_token;
            $data['university_number'] = $data->university_number;
            $student = $this->repo->findByUniversity_number($data['university_number']);
            if (!$student || !Hash::check($data->password, $student->password)) {
                throw new Exception("الرقم الجامعي او كلمة المرور خاطئة");
            }
            $student['token'] = $student->createToken('my-app-token')->plainTextToken;
            $studentId = $student->id;
            DeviceToken::firstOrCreate([
                'device_token' => $data['device_token'],
                'user_id' => $studentId,
            ]);
            return ApiResponseTrait::successResponse("", $student);
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }

    public function changePassword($data)
    {
        try {
            $student = auth()->user();
            if (!Hash::check($data->old_password, $student->password)) {
                throw new Exception("كلمة المرور خاطئة أعد المحاولة");
            }
            $data['id'] = $student->id;
            $this->repo->changePassword($data);
            return ApiResponseTrait::successResponse("تم تعديل كلمة المرور بنجاح ", $student);
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }
    public function profile()
    {
        try {
            $student = auth()->user()->load('roles');
            $student->role = $student->roles->pluck('name')->first();
            return ApiResponseTrait::successResponse("userProfile", $student);
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }
}
