<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:roles.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:roles.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $validated['name']]);

            if (isset($validated['permissions'])) {
                $role->givePermissionTo($validated['permissions']);
            }

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du rôle: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Empêcher la modification du rôle Super Admin
        if ($role->name === 'Super Admin' && !auth()->user()->isSuperAdmin()) {
            return redirect()->route('roles.index')->with('error', 'Vous ne pouvez pas modifier le rôle Super Admin.');
        }

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Empêcher la modification du rôle Super Admin
        if ($role->name === 'Super Admin' && !auth()->user()->isSuperAdmin()) {
            return redirect()->route('roles.index')->with('error', 'Vous ne pouvez pas modifier le rôle Super Admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        DB::beginTransaction();
        try {
            $role->update(['name' => $validated['name']]);

            // Synchroniser les permissions
            $role->syncPermissions($validated['permissions'] ?? []);

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rôle mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour du rôle: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Empêcher la suppression du rôle Super Admin
        if ($role->name === 'Super Admin') {
            return redirect()->route('roles.index')->with('error', 'Le rôle Super Admin ne peut pas être supprimé.');
        }

        // Vérifier si le rôle est utilisé par des utilisateurs
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Ce rôle ne peut pas être supprimé car il est assigné à des utilisateurs.');
        }

        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du rôle: ' . $e->getMessage());
        }
    }
}
