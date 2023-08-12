<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredUser extends Model
{
    use HasFactory;
    protected $table = 'registered_users';

    public function department_unit()
    {
        return $this->belongsTo('App\Models\DepartmentUnit');
    }
}
