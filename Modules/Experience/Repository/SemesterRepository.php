<?php
namespace Modules\Experience\Repository;
use Modules\Experience\App\Models\Semester;


class SemesterRepository 
{
    public function all()
    {
    $semester=Semester::all();
    foreach( $semester as $sem){
        if($sem->status==true){
            $sem->status="1";
        }
        else{
            $sem->status="0";
        }
    }
    return     $semester;
    }

    public function find($id): ?Semester
    {
        return Semester::find($id);
    }

    public function create(array $data): Semester
    {
        return Semester::create($data);
    }

    public function update($id, array $data): ?Semester
    {
        $semester = Semester::find($id);
        if ($semester) {
            $semester->update($data);
        }
        return $semester;
    }

    public function delete($id): bool
    {
        $semester = Semester::find($id);
        if ($semester) {
            return $semester->delete();
        }
        return false;
    }
}
