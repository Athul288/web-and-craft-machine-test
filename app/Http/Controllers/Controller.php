<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Mail\send_mail;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function add_employee(Request $request)
    {
        $status = false;
        $v = Validator::make($request->all(), [
            "full_name" => "required|string",
            "email_address" => "required|email|unique:employees,email",
            "designation" => "required|numeric|exists:designations,id",
            "profile_picture" => "sometimes|image|max:5000"
        ]);
        if (!$v->fails()) {
            $image_name = null;
            $password = uniqid();
            $emp = new Employee();
            if ($request->hasFile('profile_picture')) {
                $destination_path = 'img/photo';
                $image = $request->file('profile_picture');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move($destination_path, $image_name);
            }
            if ($emp->add_user([$request->designation, $request->full_name, $request->email_address, $image_name, $password, date('Y-m-d H:i:s')])) {
                Mail::to($request->email_address)->send(new send_mail($password));
                $status = true;
            }
            return response()->json(array('status' => $status));
        } else {
            return response()->json(array('status' => $status, 'errors' => $v->getMessageBag()->toArray()));
        }
    }

    public function edit_employee(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:employees,id',
            "full_name" => "required|string",
            "email_address" => "required|email|unique:employees,email," . $request->user_id,
            "designation" => "required|numeric|exists:designations,id",
            "profile_picture" => "sometimes|image|max:5000"
        ]);
        if (!$v->fails()) {
            $emp = new Employee();
            $user_id = (int)$request->user_id;
            $image_name = $emp->get_photo($user_id);
            if ($request->hasFile('profile_picture')) {
                $destination_path = 'img/photo';
                $image = $request->file('profile_picture');
                $image_name = (empty($image_name)) ? time() . '.' . $image->getClientOriginalExtension() : $image_name;
                $image->move($destination_path, $image_name);
            }
            $emp->update_user([$request->designation, $request->full_name, $request->email_address, $image_name, date('Y-m-d H:i:s'), $user_id]);
            return response()->json(array('status' => true));
        } else {
            return response()->json(array('status' => false, 'errors' => $v->getMessageBag()->toArray()));
        }
    }

    public function remove_employee(Request $request)
    {
        $status = 0;
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:employees,id'
        ]);
        if (!$validation->fails()) {
            $emp = new Employee();
            $user_id = (int)$request->user_id;
            $photo = $emp->get_photo($user_id);
            @unlink('img/photo/' . $photo);
            $emp->delete_user($user_id);
            $status = 1;
        }
        return response()->json($status, 200);
    }

    public function remove_employee_photo(Request $request)
    {
        $status = 0;
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:employees,id'
        ]);
        if (!$validation->fails()) {
            $emp = new Employee();
            $user_id = (int)$request->user_id;
            $photo = $emp->get_photo($user_id);
            @unlink('img/photo/' . $photo);
            $emp->update_photo($user_id);
            $status = 1;
        }
        return response()->json($status, 200);
    }

    public function get_employee(Request $request)
    {
        $status = 0;
        $message = '';
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:employees,id'
        ]);
        if (!$validation->fails()) {
            $emp = new Employee();
            $user_id = (int)$request->user_id;
            $message = $emp->get_employee($user_id);
            $status = 1;
        }
        $response = array('status' => $status, 'message' => $message);
        return response()->json($response, 200);
    }
}
