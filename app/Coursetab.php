<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursetab extends Model
{
    protected $table = 'coursetabs';
    protected $primaryKey = 'course_id';
    protected $fillable = ['course_id','admin_id','name'];
    public function tempcourses()
    {
        return $this->hasMany('App\TempCourses', 'category');
    }
}
