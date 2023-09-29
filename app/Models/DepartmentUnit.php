<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUnit extends Model
{
    use HasFactory;

    public function registered_users()
    {
        return $this->hasMany('App\Models\RegisteredUser');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\DepartmentUnit', 'parent_id');
    }

}
