<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Prospectus;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Grades;


class LoadSubjectController extends Controller
{
    public function index(){
        return view("layouts.dean.loadsubject")->with("prospectus", "active");
    }

    public function get_students(){
        $data = Student::all()->toArray();
        return json_encode($data);
    }

    public function get_subjects(){
        $data = Subject::all()->toArray();
        return json_encode($data);
    }

    public function get(Request $request){
        $student_course = Student::where("id", "=", $request->id)->get(["course_id"])->toArray();
        $prospectus = Prospectus::join('subjects', 'subjects.id', "=", 'prospectus.subject_id')
                            ->where("prospectus.course_id", "=", $student_course[0]["course_id"])
                            ->get(['subjects.*', 'prospectus.*', 'prospectus.id as prospectus_id'])->toArray();
        $grades = Grades::where("student_id", "=", $request->id)->get()->toArray();
        $subjects = Subject::all()->toArray();
        $allprospectus = [];
        $counter = 0;
        foreach($prospectus as $data){
            $allprospectus[$counter][0] = '<div text-dark" data-id="'.$data["prospectus_id"].'" data-column="subject_name">' . $data["subject_name"] . '</div>';
            $allprospectus[$counter][1] = '<div text-dark" data-id="'.$data["prospectus_id"].'" data-column="subject_unit">' . $data["subject_unit"] . '</div>';
            $allprospectus[$counter][2] = '<div text-dark" data-id="'.$data["prospectus_id"].'" data-column="subject_hours">' . $data["subject_hours"] . '</div>';
            $selectprereq = "";
            foreach($subjects as $prereq){
                if($prereq["id"] == $data["subject_prerequisite"])$selectprereq = $prereq["subject_name"];
            }
            $allprospectus[$counter][3] = '<div text-dark" data-id="'.$data["prospectus_id"].'" data-column="subject_prerequisite">' . $selectprereq . '</div>';
            $allprospectus[$counter][4] = '<div text-dark" data-id="'.$data["prospectus_id"].'" data-column="subject_year">' . $data["subject_year"] . '</div>';
            $grade_total = "";
            
            if(count($grades) == 0){
                $grade_total = 'Not Enrolled';
            }else{
                foreach($grades as $grade){
                    if($grade["subject_id"] == $data["subject_id"]){
                        if($grade["grade"] == "none") {
                            $grade_total = 'Enrolled(wating for grades)';
                        }else{
                            $grade_total = $grade["grade"];
                        }
                    }else{
                        $grade_total = 'Not Enrolled';
                    }

                }
            }
            $allprospectus[$counter][5] = $grade_total;
            $allprospectus[$counter][6] = '';
            $counter++;
        }
        $output = array(
            "draw" => 1,
            "recordsTotal" => count($prospectus),
            "recordsFiltered" => count($prospectus),
            "data" => $allprospectus,
        );
        return json_encode($output);
    }

    public function create(Request $request){
        $subjects = Subject::join("grades", "grades.subject_id", "=", "subjects.id")
                            ->where([
                                ["subjects.id", "=", $request->subject_id],
                                ['grades.student_id', "=", $request->student_id]
                                ])->get()->toArray();
        if(count($subjects) == 0){
            $subject = Subject::where("id", "=", $request->subject_id)->get()->toArray();
            if($subject[0]["subject_prerequisite"] == NULL){
                $data = Grades::create($request->except("_token"));
                if($data){
                    echo "Subject Added!";
                }else{
                    echo "Error adding subject";
                }
            }else{
                echo "Subject has Prerequisite not complied " . $subject[0]["subject_name"];
            }
        }else{
            if($subjects[0]["subject_prerequisite"] == NULL){
                $data = Grades::create($request->except("_token"));
                if($data){
                    echo "Subject Added!";
                }else{
                    echo "Error adding subject";
                }
            }else{
                $subject = Subject::join("grades", "grades.subject_id", "=", "subjects.id")
                                ->where("subjects.id", "=", $subjects[0]["subject_prerequisite"])
                                ->get()->toArray();
                if($subject[0]["grade"] != NULL){
                    $data = Grades::create($request->except("_token"));
                    if($data){
                        echo "Subject Added!";
                    }else{
                        echo "Error adding subject";
                    }
                }else{
                    echo "Gardes of " . $subjects[0]["subject_name"] . " is not submitted!";
                }
            }
        }

    }

    public function delete(Request $request){
        $data = Course::where("id", "=", $request->id)->delete();
        if($data){
            echo "Subject Deleted!";
        }else{
            echo "Error deleting department";
        }
    }

    public function update(Request $request){
        $data = Course::where("id", "=", $request->id)->update(
            [$request->column_name => $request->value]
        );
        if($data){
            echo "Subject Updated!";
        }else{
            echo "Error updating department";
        }
    }
}
