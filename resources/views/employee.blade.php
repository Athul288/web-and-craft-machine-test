@extends('layout')
@section('content')
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Employee</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email_address">Email Address</label>
                            <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Enter email address" required>
                            <span class="text-danger error-text email_address_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <select id="designation" name="designation" class="form-control" required>
                                <option value="">-- Choose designation --</option>
                                @php
                                $query=DB::select('select * from designations order by title asc');
                                foreach($query as $row){
                                echo '<option value="'.$row->id.'">'.$row->title.'</option>';
                                }
                                @endphp
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                                </div>
                                <div class="col-md-4 text-center preview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block" data-type="add">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<section class="content-header">
    <h1>
        Employee
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Employee</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title">Manage Employees Here</h3>
                        </div>
                        <div class="col-md-2">
                            <button data-toggle="modal" data-target="#modal-default" type="button" class="btn btn-md bg-olive margin pull-right"><i class="fa fa-plus"></i> Add Employee</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            $query=DB::select('select d.title,e.* from employees as e inner join designations as d on d.id=e.designation_id order by e.id desc');
                            foreach($query as $row){
                            $image=(empty($row->photo))?'no-preview.jpg':$row->photo;
                            @endphp
                            <tr data-id="{{ $row->id }}">
                                <td>{{ $i }}</td>
                                <td><img class="profile" src="{{ url('img/photo/'.$image) }}"></td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->email }}</td>
                                <td>
                                    <button type="button" class="edit btn bg-purple btn-xs"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="delete btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                            @php
                            $i++;
                            }
                            @endphp
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop