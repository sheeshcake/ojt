<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Department;

class CourseController extends Controller
{
    public function index(){
        return view("layouts.admin.courses")->with("departments", "active");
    }

    public function search(){
        $data = Department::get('department_name')->toArray();
        return json_encode($data);
    }

    public function get(){
        $departments = Department::orderBy("id", "desc")->get()->toArray();
        $alldepartments = [];
        $counter = 0;
        foreach($departments as $data){
            $alldepartments[$counter][0] = '<div class="text-dark">' . $data["id"] . '</div>';
            $alldepartments[$counter][1] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="department_name">' . $data["department_name"] . '</div>';
            $alldepartments[$counter][2] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$data["id"].'">Delete</button>';
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
        $data = Department::create($request->except("_token"));
        if($data){
            echo "Department Added!";
        }else{
            echo "Error adding department";
        }
    }

    public function delete(Request $request){
        $data = Department::where("id", "=", $request->id)->delete();
        if($data){
            echo "Department Deleted!";
        }else{
            echo "Error deleting department";
        }
    }

    public function update(Request $request){
        $data = Department::where("id", "=", $request->id)->update(
            [$request->column_name => $request->value]
        );
        if($data){
            echo "Department Updated!";
        }else{
            echo "Error updating department";
        }
    }
}
