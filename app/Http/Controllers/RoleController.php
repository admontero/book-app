<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('back.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        return view('back.roles.show', compact('role'));
    }
}
