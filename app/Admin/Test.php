<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = "test";

    protected $fillable = ['user_id', 'tab_id', 'marks', 'time', 'passing_mark'];
}
