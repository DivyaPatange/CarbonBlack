<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "contacts";

    protected $fillable = ['first_name', 'last_name', 'email', 'phone_no', 'country', 'company', 'industry','inquiry_category', 'existing_client', 'message'];
}
