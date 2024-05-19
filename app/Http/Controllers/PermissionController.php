<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function createTest(){
        $role = Role::create(['name' => 'writer']);
        $permission = Permission::create(['name' => 'edit articles']);
        return "done";
    }
}
