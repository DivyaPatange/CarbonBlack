<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class UserManual extends Model
{
    protected $table = "user_manuals";

    protected $fillable = ['file', 'manual_for'];
}
