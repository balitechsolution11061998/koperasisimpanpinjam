<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    protected $table = 'roles';
    public $guarded = [];
}