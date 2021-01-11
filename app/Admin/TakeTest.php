<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class TakeTest extends Model
{
    protected $table = "take_test";

    protected $fillable = ['user_id', 'test_id', 'status'];
}
