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

    public function get_subjects(Request $request){
        $student_course = Student::where("id", "=", $request->id)->get(["course_id"])->toArray();
        $data = Prospectus::join('subjects', 'subjects.id', "=", 'prospectus.subject_id')
        ->where("prospectus.course_id", "=", $student_course[0]["course_id"])
        ->get(['subjects.*', 'prospectus.*', 'prospectus.id as prospectus_id', 'subjects.id as subject_id'])->toArray();
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
        // $subjects = Subject::join("grades", "grades.subject_id", "=", "subjects.id")
        //                     ->where([
        //                         ["subjects.id", "=", $request->subject_id],
        //                         ['grades.student_id', "=", $request->student_id]
        //                         ])->get()->toArray();
        $subject_details = Subject::where("id", "=", $request->subject_id)->get()->toArray();
        $subject_pre = Subject::where("id", "=", $subject_details[0]["subject_prerequisite"])->get()->toArray();
        //check if has prerequisite
        if(count($subject_pre) == 0){
            //no prerequisite
            $grades_pre = Grades::join("subjects", "grades.subject_id", "=", "subjects.id")
                        ->where([
                            ["subjects.id", "=", $request->subject_id],
                            ['grades.student_id', "=", $request->student_id]
                        ])->limit(1)->orderBy("grades.id", "desc")
                        ->get()->toArray();
            if(count($grades_pre) > 0){
                if(intval($grades_pre[0]["grade"]) == 5){
                    $data = Grades::create($request->except("_token"));
                    if($data){
                        echo "Subject ReEnrolled!";
                    }else{
                        echo "Error adding subject";
                    }
                }else{
                    echo $subject_details[0]["subject_name"] . " is Already Enrolled!";
                }
                
            }else{
                $data = Grades::create($request->except("_token"));
                if($data){
                    echo "Subject Added!";
                }else{
                    echo "Error adding subject";
                }
            }
        }else{
            //has prerequisite
            //check grades of prerequisite
            $grades_pre = Grades::join("subjects", "grades.subject_id", "=", "subjects.id")
                ->where([
                ["subjects.id", "=", $subject_details[0]["subject_prerequisite"]],
                ['grades.student_id', "=", $request->student_id]
            ])->limit(1)->orderBy("grades.id", "desc")
            ->get()->toArray();
            // dd($grades_pre);
            if(count($grades_pre) == 0){
                echo $subject_details[0]["subject_name"] . " has Prerequisite: " . $subject_pre[0]["subject_name"];
            }else if($grades_pre[0]["grade"] == "none"){
                echo "Waiting for grades of " . $subject_pre[0]["subject_name"];
            }else{
                if(intval($grades_pre[0]["grade"]) <= 3 && intval($grades_pre[0]["grade"]) > 0){
                    $data = Grades::create($request->except("_token"));
                    if($data){
                        echo "Subject Added!";
                    }else{
                        echo "Error adding subject";
                    }
                }else if(intval($grades_pre[0]["grade"]) == 5){
                    echo $subject_pre[0]["subject_name"] . " is Failed! Please Re-enroll";
                }else if(intval($grades_pre[0]["grade"]) == 4){
                    echo $subject_pre[0]["subject_name"] . " is Incomplete! Please Comply First.";
                }else if(intval($grades_pre[0]["grade"]) == "dropped"){
                    echo $subject_details[0]["subject_name"] . " has Prerequisite: " . $subject_pre[0]["subject_name"];
                }else{
                    echo "Invalid Grades!";
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
