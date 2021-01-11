<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $table = "answer";

    protected $fillable = ['question_id', 'correct_ans'];
}
