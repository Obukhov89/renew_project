<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;

class ModuleController extends Controller
{
    public function index()
    {

        return Module::with('permissions')->get();
    }

    public function getRolesAndPermissions()
    {
        $modules = Module::with('modules')->get();
        $permissions = Permission::all();

        return response()->json([
            'modules' => $modules,
            'permissions' => $permissions,
        ]);
    }
}
