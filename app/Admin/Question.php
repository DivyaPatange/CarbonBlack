<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "question";
    protected $fillable = ['test_id', 'question', 'que_type', 'que_mark'];
}
