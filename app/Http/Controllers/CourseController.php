<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Department;

class CourseController extends Controller
{
    public function index(){
        return view("layouts.admin.courses")->with("courses", "active");
    }

    public function get_departments(){
        $data = Department::all()->toArray();
        return json_encode($data);
    }

    public function get(){
        $departments = Course::join('departments', 'departments.id', "=", 'courses.department_id')->get(['departments.*', 'courses.*', 'courses.id as course_id'])->toArray();
        $alldepartments = [];
        $counter = 0;
        foreach($departments as $data){
            $alldepartments[$counter][0] = '<div class="text-dark">' . $data["course_id"] . '</div>';
            $alldepartments[$counter][1] = '<div contenteditable class="update text-dark" data-id="'.$data["course_id"].'" data-column="course_name">' . $data["course_name"] . '</div>';
            $alldepartments[$counter][2] = '<div class="update text-dark" data-id="'.$data["course_id"].'" data-column="department_name">' . $data["department_name"] . '</div>';
            $alldepartments[$counter][3] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$data["course_id"].'">Delete</button>';
            $counter++;
        }
        $output = array(
            "draw" => 1,
            "recordsTotal" => count($departments),
            "recordsFiltered" => count($departments),
            "data" => $alldepartments,
        );
        return json_encode($output);
    }

    public function create(Request $request){
        $data = Course::create($request->except("_token"));
        if($data){
            echo "Department Added!";
        }else{
            echo "Error adding department";
        }
    }

    public function delete(Request $request){
        $data = Course::where("id", "=", $request->id)->delete();
        if($data){
            echo "Department Deleted!";
        }else{
            echo "Error deleting department";
        }
    }

    public function update(Request $request){
        $data = Course::where("id", "=", $request->id)->update(
            [$request->column_name => $request->value]
        );
        if($data){
            echo "Department Updated!";
        }else{
            echo "Error updating department";
        }
    }
}
