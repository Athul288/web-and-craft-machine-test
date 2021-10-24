<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;

    public function add_user($user)
    {
        return DB::insert('insert into employees (designation_id,name,email,photo,password,date_created) values (?,?,?,?,?,?)', $user);
    }

    public function update_user($user)
    {
        return DB::update('update employees set designation_id=?,name=?,email=?,photo=?,date_updated=? where id=?', $user);
    }

    public function delete_user($user_id)
    {
        return DB::delete("delete from employees where id=?", [$user_id]);
    }

    public function get_employee($user_id)
    {
        $user = DB::select("select designation_id,name,email,photo from employees where id=?", [$user_id]);
        return $user[0];
    }

    public function update_photo($user_id)
    {
        return DB::update('update employees set photo=? where id=?', [null, $user_id]);
    }

    public function get_photo($user_id)
    {
        $photo = DB::select("select photo from employees where id=?", [$user_id]);
        return $photo[0]->photo;
    }
}
