<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempCourses extends Model
{
    protected $table = 'temp_courses';
    protected $fillable = ['title', 'img','category', 'path', 'description', 'admin_id'];
     public function coursetab()
    {
        return $this->belongsToMany('App\Coursetab','name');
    }
}
