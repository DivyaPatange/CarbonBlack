<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    protected $table = "user_courses";

    protected $fillable = ['user_id', 'user_course_id'];
}
