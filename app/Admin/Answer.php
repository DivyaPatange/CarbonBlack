<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = "user_answer";

    protected $fillable = ['user_id', 'test_id', 'take_test_id', 'question_id', 'correct_option', 'mark'];
}
