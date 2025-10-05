<?php

namespace Modules\Student\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Student\Services\StudentImportService;
use Modules\Student\Services\ArchiveService;
use Modules\Student\Services\CategoryService;
use Modules\Student\App\Http\Requests\ImportStudentRequest;

class StudentImportController extends Controller
{
    protected $student_service;
    protected $category_service;
    protected $archive_service;

    public function __construct(CategoryService $category_service, StudentImportService $student_service,ArchiveService $archive_service)
    {
        $this->category_service = $category_service;
        $this->student_service = $student_service;
        $this->archive_service = $archive_service;
    }

    public function import(ImportStudentRequest $request)
    {
        if ($request['archive'] == 'yes') {
            $this->archive_service->handle();
        }
        $category = $this->category_service->createBatchCategories($request->category_number);
        return $this->student_service->importAndDistributeStudents($request, $category);
    }
}
