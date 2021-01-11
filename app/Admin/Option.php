<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = "options";

    protected $fillable = ['question_id', 'option_number', 'option_title'];
}
