<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $table = "attempt";

    protected $fillable = ['user_id', 'test_id', 'tab_id', 'status'];
}
