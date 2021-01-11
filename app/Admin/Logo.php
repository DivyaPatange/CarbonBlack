<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $table = "company_logo";
    protected $fillable = ['user_id', 'logo'];
}
