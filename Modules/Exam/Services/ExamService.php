<?php

namespace Modules\Exam\Services;

use App\Jobs\SendStudentNotification;
use App\Models\User;
use Modules\Exam\App\Models\ExamQuestion;
use Modules\Exam\Repository\ExamRepository;
use Modules\Traits\ApiResponseTrait;

class ExamService
{
    protected $examRepo;

    public function __construct(ExamRepository $examRepo)
    {
        $this->examRepo = $examRepo;
    }

    public function listAll()
    {
        try {

            $data = $this->examRepo->all();
            return ApiResponseTrait::successResponse("succ",   $data)->original;
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }

    public function getById($id)
    {
        try {

            $data = $this->examRepo->find($id);

            return ApiResponseTrait::successResponse("succ",   $data)->original;
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }
public function updatestatus($id)
    {  try {
        $result= $this->examRepo->updatestatus($id);
           return ApiResponseTrait::successResponse("succ",   $result)->original;
       } catch (\Throwable $e) {
           return ApiResponseTrait::errorResponse($e->getMessage());
       }   
       
    }
    public function store(array $data)
    {
        // $data['teacher_id'] = $teacherId;
        try {
            $exam['data']['teacher_id'] = $data['teacher_id'];
            $exam['data']['name'] = $data['name'];
            $exam['data']['number_of_questions'] = $data['number_of_questions'];
            $exam['data']['Final_grade'] = $data['Final_grade'];
            $exam['data']['Start_date'] = $data['Start_date'];
            $exam['data']['End_date'] = $data['End_date'];
            $exam['data']['time'] = $data['time'];
            $exam['subject_id'] = $data['subject_id'];
           
                dispatch(new SendStudentNotification($exam['data']['name']));
            
            $result = $this->examRepo->create($exam);
            return ApiResponseTrait::successResponse("succ",   $result)->original;
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $exam['data']['teacher_id'] = $data['teacher_id'];
            $exam['data']['name'] = $data['name'];
            $exam['data']['number_of_questions'] = $data['number_of_questions'];
            $exam['data']['Final_grade'] = $data['Final_grade'];
            $exam['data']['Start_date'] = $data['Start_date'];
            $exam['data']['End_date'] = $data['End_date'];
            $exam['data']['time'] = $data['time'];
            $exam['subject_id'] = $data['subject_id'];
            $result = $this->examRepo->update($id, $exam);
            return ApiResponseTrait::successResponse("succ",   $result)->original;
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {

            $result =  $this->examRepo->delete($id);
            return ApiResponseTrait::successResponse("succ", " ")->original;
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }
    public function Addmark($request)
    {
        try {

            $user = auth()->user();
            $data['user_id'] = $user->id;
            $data['exam_id'] = $request->exam_id;
            $users = $this->examRepo->findUserExam($data);
            foreach ($request->ans as $an) {
                $question = ExamQuestion::where('question_id', $an['id'])->first();
                $question->answer_id = $an['answer_id'];
                $question->save();
            }
            $users->grade = $request->grade;
            $users->save();


            return ApiResponseTrait::successResponse("succ", $users)->original;
        } catch (\Throwable $e) {
            return ApiResponseTrait::errorResponse($e->getMessage());
        }
    }
}
