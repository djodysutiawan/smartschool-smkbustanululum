<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN UTAMA — Role & Permission
    |--------------------------------------------------------------------------
    */

    /**
     * GET /admin/users
     * Tampilkan semua role + permission di satu halaman.
     */
    public function index()
    {
        $roles = Role::withCount('permissions', 'users')
                     ->with('permissions:id,name')
                     ->latest()
                     ->get();

        $permissions = Permission::orderBy('name')->get();

        // Kelompokkan permission berdasarkan modul (kata ke-2 dari nama)
        // Contoh: "view students" → modul: "students"
        $groupedPermissions = $permissions->groupBy(function ($p) {
            $parts = explode(' ', $p->name);
            return $parts[1] ?? 'general';
        });

        $users = User::with('roles:id,name')
                     ->latest()
                     ->paginate(10);

        return view('admin.users', compact(
            'roles',
            'permissions',
            'groupedPermissions',
            'users'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ROLES
    |--------------------------------------------------------------------------
    */

    /**
     * POST /admin/roles
     * Buat role baru + assign permissions (opsional).
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::transaction(function () use ($request) {
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            if ($request->filled('permissions')) {
                $role->syncPermissions($request->permissions);
            }
        });

        return redirect()
            ->route('admin.users')
            ->with('success', "Role \"{$request->name}\" berhasil dibuat.");
    }

    /**
     * PUT /admin/roles/{role}
     * Update nama role & sync permissions.
     */
    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::transaction(function () use ($request, $role) {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions ?? []);
        });

        return redirect()
            ->route('admin.users')
            ->with('success', "Role \"{$role->name}\" berhasil diperbarui.");
    }

    /**
     * DELETE /admin/roles/{role}
     * Hapus role. Role 'admin' tidak bisa dihapus.
     */
    public function destroyRole(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()
                ->route('admin.users')
                ->with('error', 'Role "admin" tidak dapat dihapus.');
        }

        DB::transaction(function () use ($role) {
            $role->syncPermissions([]);
            $role->users()->detach();
            $role->delete();
        });

        return redirect()
            ->route('admin.users')
            ->with('success', "Role \"{$role->name}\" berhasil dihapus.");
    }

    /*
    |--------------------------------------------------------------------------
    | PERMISSIONS
    |--------------------------------------------------------------------------
    */

    /**
     * POST /admin/permissions
     * Buat satu permission baru.
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150|unique:permissions,name',
        ]);

        Permission::create([
            'name'       => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.users')
            ->with('success', "Permission \"{$request->name}\" berhasil dibuat.");
    }

    /**
     * POST /admin/permissions/bulk
     * Buat banyak permission sekaligus per modul.
     * Body: module = "students", actions[] = ["view","create","edit","delete"]
     */
    public function bulkStorePermission(Request $request)
    {
        $request->validate([
            'module'    => 'required|string|max:100',
            'actions'   => 'required|array|min:1',
            'actions.*' => 'in:view,create,edit,delete',
        ]);

        $created = 0;
        foreach ($request->actions as $action) {
            $name = "{$action} {$request->module}";
            if (! Permission::where('name', $name)->exists()) {
                Permission::create(['name' => $name, 'guard_name' => 'web']);
                $created++;
            }
        }

        return redirect()
            ->route('admin.users')
            ->with('success', "{$created} permission berhasil dibuat untuk modul \"{$request->module}\".");
    }

    /**
     * PUT /admin/permissions/{permission}
     * Update nama permission.
     */
    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required', 'string', 'max:150',
                Rule::unique('permissions', 'name')->ignore($permission->id),
            ],
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()
            ->route('admin.users')
            ->with('success', "Permission berhasil diperbarui menjadi \"{$request->name}\".");
    }

    /**
     * DELETE /admin/permissions/{permission}
     * Hapus permission.
     */
    public function destroyPermission(Permission $permission)
    {
        $name = $permission->name;
        $permission->delete();

        return redirect()
            ->route('admin.users')
            ->with('success', "Permission \"{$name}\" berhasil dihapus.");
    }

    /*
    |--------------------------------------------------------------------------
    | ASSIGN ROLE KE USER
    |--------------------------------------------------------------------------
    */

    /**
     * GET /admin/role-permission/users
     * Daftar user beserta role masing-masing + fitur search & filter.
     */
    public function users(Request $request)
    {
        $query = User::with('roles:id,name');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role); // built-in scope dari Spatie
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::orderBy('name')->get();

        return view('admin.role-permission.users', compact('users', 'roles'));
    }

    /**
     * POST /admin/role-permission/assign
     * Sync roles ke user tertentu.
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'roles'    => 'required|array|min:1',
            'roles.*'  => 'exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->syncRoles($request->roles);

        return redirect()
            ->route('admin.role-permission.users')
            ->with('success', "Role user \"{$user->name}\" berhasil diperbarui.");
    }

    /**
     * DELETE /admin/role-permission/revoke
     * Cabut semua role dari user.
     */
    public function revokeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->syncRoles([]);

        return redirect()
            ->route('admin.role-permission.users')
            ->with('success', "Semua role user \"{$user->name}\" berhasil dicabut.");
    }

    /*
    |--------------------------------------------------------------------------
    | SEED DEFAULT ROLES & PERMISSIONS
    |--------------------------------------------------------------------------
    */

    /**
     * POST /admin/role-permission/seed
     * Generate role & permission default untuk seluruh sistem.
     * Aman dijalankan ulang — menggunakan firstOrCreate.
     */
    public function seed()
    {
        DB::transaction(function () {

            /*
            |------------------------------------------------------------------
            | 1. ROLES
            |------------------------------------------------------------------
            */
            $roleNames = ['admin', 'teacher', 'student', 'parent', 'piket'];
            $roles = [];
            foreach ($roleNames as $name) {
                $roles[$name] = Role::firstOrCreate([
                    'name'       => $name,
                    'guard_name' => 'web',
                ]);
            }

            /*
            |------------------------------------------------------------------
            | 2. PERMISSIONS — format: "{action} {module}"
            |------------------------------------------------------------------
            */
            $modules = [
                'students', 'teachers', 'parents', 'piket-teachers',
                'classes', 'subjects', 'academic-years', 'schedules',
                'attendances', 'violations', 'reports', 'notifications',
                'settings', 'roles', 'permissions',
            ];
            $actions = ['view', 'create', 'edit', 'delete'];

            foreach ($modules as $module) {
                foreach ($actions as $action) {
                    Permission::firstOrCreate([
                        'name'       => "{$action} {$module}",
                        'guard_name' => 'web',
                    ]);
                }
            }

            /*
            |------------------------------------------------------------------
            | 3. ASSIGN PERMISSIONS KE TIAP ROLE
            |------------------------------------------------------------------
            */

            // Admin — akses penuh ke semua permission
            $roles['admin']->syncPermissions(Permission::all());

            // Teacher — lihat data, input absen & pelanggaran
            $roles['teacher']->syncPermissions(
                Permission::whereIn('name', [
                    'view students', 'view classes', 'view subjects', 'view schedules',
                    'view attendances', 'create attendances', 'edit attendances',
                    'view violations', 'create violations',
                    'view reports', 'view notifications',
                ])->get()
            );

            // Piket — fokus absen & pelanggaran harian
            $roles['piket']->syncPermissions(
                Permission::whereIn('name', [
                    'view students',
                    'view attendances', 'create attendances', 'edit attendances',
                    'view violations', 'create violations',
                    'view notifications',
                ])->get()
            );

            // Parent — hanya lihat data anak
            $roles['parent']->syncPermissions(
                Permission::whereIn('name', [
                    'view students', 'view attendances',
                    'view violations', 'view notifications',
                ])->get()
            );

            // Student — hanya lihat data diri sendiri
            $roles['student']->syncPermissions(
                Permission::whereIn('name', [
                    'view attendances', 'view violations',
                    'view schedules', 'view notifications',
                ])->get()
            );
        });

        return redirect()
            ->route('admin.users')
            ->with('success', 'Default roles & permissions berhasil di-seed.');
    }
}