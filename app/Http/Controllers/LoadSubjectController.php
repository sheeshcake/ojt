<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Prospectus;
use App\Models\Course;
use App\Models\Subject;

class LoadSubjectController extends Controller
{
    public function index(){
        return view("layouts.admin.prospectus")->with("prospectus", "active");
    }

    public function get_courses(){
        $data = Course::all()->toArray();
        return json_encode($data);
    }

    public function get_subjects(){
        $data = Subject::all()->toArray();
        return json_encode($data);
    }

    public function get(Request $request){
        $prospectus = Prospectus::join('subjects', 'subjects.id', "=", 'prospectus.subject_id')->get(['subjects.*', 'prospectus.*', 'prospectus.id as prospectus_id'])->toArray();
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
            $allprospectus[$counter][5] = '<div text-dark" data-id="'.$data["prospectus_id"].'" data-column="subject_semester">' . $data["subject_semester"] . '</div>';
            $allprospectus[$counter][6] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$data["course_id"].'">Delete</button>';
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
        // dd($request);
        $data = Prospectus::create($request->except("_token"));
        if($data){
            echo "Subject Added!";
        }else{
            echo "Error adding department";
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
