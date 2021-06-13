@extends('layout')


@section('sidebar')
    @include('layouts.dean.includes.sidebar')
@endsection

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
</ol>
<h6 class="font-weight-bolder mb-0">Dashboard</h6>
@endsection

@section('content')

    <div class="card pb-0 mt-5">
        <div class="card-header">
            <h6>Prospectus</h6>
        </div>
        <div class="card-body">
            <input type="hidden" value="{{ csrf_token() }}" id="_token">
            <div class="row">
                <div class="form-group col">
                    <label for="">Student</label>
                    <select name="" id="student_select" class="form-control" data-live-search="true"></select>
                </div>
            </div>
            <div id="table-alert"></div>
            <div class="row">
                <div class="form-group col">
                    <label for="">Subject</label>
                    <select id="subject" class="form-control" data-live-search="true" >
                    </select>
                </div>
                <div class="form-group col">
                    <label for=""></label>
                    <button type="button" name="add" id="add" class="btn btn-info form-control">Add</button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="schedule-table" class="teble">
                    <thead>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Unit</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Hours</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Prerequisite</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Year</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Grade</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script>
        var departments;
        $(document).ready(function(){
            var select_student;
            var select_subject
            fetch_data();
            $(".select-picker").selectpicker();
            function fetch_data(course = 1){
                var dataTable = $('#schedule-table').DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "order" : [[4, "asc"]],
                    "ajax" : {
                        url:"{{ route('dean.getloadsubjects') }}",
                        type:"post",
                        data: {_token: $("#_token").val(), id: 1}
                    },
                });
                $.ajax({
                    url: "{{route('dean.loadsubjects.getstudents')}}",
                    method: "POST",
                    data: {_token: $("#_token").val(), id:course},
                    success: function(d){
                        d = JSON.parse(d);
                        d.forEach((item) => {
                            select_student += '<option value=" ' + item['id'] +  ' ">' + item["f_name"] + " " + item["l_name"]  + "</option>";
                        });
                        $("#student_select").append(select_student);
                        $("#student_select").selectpicker();
                    } 
                });
                $.ajax({
                    url: "{{route('dean.loadsubjects.getsubjects')}}",
                    type: "POST",
                    data: {_token: $("#_token").val(), id: 1},
                    success: function(d){
                        console.log(d);
                        d = JSON.parse(d);
                        d.forEach((item) => {
                            console.log(item['id'] );
                            select_subject += '<option value=" ' + item['subject_id'] +  ' ">' + item["subject_code"] + " - " + item["subject_name"] + "</option>";
                        });
                        $("#subject").append(select_subject);
                        $("#subject").selectpicker();
                    } 
                });
            }
            
            $(document).on('blur', '.update', function(){
                var id = $(this).data("id");
                var column_name = $(this).data("column");
                var value = $(this).text();
                update_data(id, column_name, value);
            });
            $(document).on('click', '#add', function(){
                var student_id = $('#student_select').val();
                var subject_id = $('#subject').val();
                if(subject_id != ''){
                    $.ajax({
                        url:"{{ route('dean.addloadsubjects') }}",
                        method:"POST",
                        data:{
                            student_id: student_id,
                            subject_id: subject_id,
                            _token: $("#_token").val()
                            },
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setTimeout(function(){
                        $('#table-alert').html('');
                    }, 5000);
                }
                else{
                    alert("Both Fields is required");
                }
            });
            $(document).on('click', '.delete', function(){
                var id = $(this).attr("id");
                if(confirm("Are you sure you want to remove this?")){
                    $.ajax({
                        url:"",
                        method:"POST",
                        data:{id:id, _token: $("#_token").val()},
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data();
                        }
                    });
                    setTimeout(function(){
                        $('#table-alert').html('');
                    }, 5000);
                }
            });
        });
    </script>
@endsection
