<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ROLES
    |--------------------------------------------------------------------------
    */

    /**
     * GET /api/v1/roles
     * List semua role beserta jumlah permission & user.
     */
    public function indexRoles(): JsonResponse
    {
        $roles = Role::withCount('permissions', 'users')
                     ->with('permissions:id,name')
                     ->orderBy('name')
                     ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Data role berhasil diambil.',
            'data'    => $roles,
        ]);
    }

    /**
     * POST /api/v1/roles
     * Buat role baru + assign permissions (opsional).
     *
     * Body: { "name": "teacher", "permissions": [1, 2, 3] }
     */
    public function storeRole(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:100|unique:roles,name',
                'permissions'   => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $role = DB::transaction(function () use ($request) {
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            if ($request->filled('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return $role->load('permissions:id,name');
        });

        return response()->json([
            'status'  => true,
            'message' => "Role \"{$role->name}\" berhasil dibuat.",
            'data'    => $role,
        ], 201);
    }

    /**
     * GET /api/v1/roles/{id}
     * Detail role beserta daftar permissions.
     */
    public function showRole(int $id): JsonResponse
    {
        $role = Role::with('permissions:id,name')
                    ->withCount('permissions', 'users')
                    ->find($id);

        if (! $role) {
            return response()->json([
                'status'  => false,
                'message' => 'Role tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail role berhasil diambil.',
            'data'    => $role,
        ]);
    }

    /**
     * PUT /api/v1/roles/{id}
     * Update nama role & sync permissions.
     *
     * Body: { "name": "teacher", "permissions": [1, 2, 3] }
     * Kirim "permissions": [] untuk melepas semua permission.
     */
    public function updateRole(Request $request, int $id): JsonResponse
    {
        $role = Role::find($id);

        if (! $role) {
            return response()->json([
                'status'  => false,
                'message' => 'Role tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'name' => [
                    'required', 'string', 'max:100',
                    Rule::unique('roles', 'name')->ignore($role->id),
                ],
                'permissions'   => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        DB::transaction(function () use ($request, $role) {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions ?? []);
        });

        return response()->json([
            'status'  => true,
            'message' => "Role \"{$role->name}\" berhasil diperbarui.",
            'data'    => $role->fresh(['permissions:id,name']),
        ]);
    }

    /**
     * DELETE /api/v1/roles/{id}
     * Hapus role. Role 'admin' tidak bisa dihapus.
     */
    public function destroyRole(int $id): JsonResponse
    {
        $role = Role::find($id);

        if (! $role) {
            return response()->json([
                'status'  => false,
                'message' => 'Role tidak ditemukan.',
            ], 404);
        }

        if ($role->name === 'admin') {
            return response()->json([
                'status'  => false,
                'message' => 'Role "admin" tidak dapat dihapus.',
            ], 403);
        }

        DB::transaction(function () use ($role) {
            $role->syncPermissions([]);
            $role->users()->detach();
            $role->delete();
        });

        return response()->json([
            'status'  => true,
            'message' => "Role \"{$role->name}\" berhasil dihapus.",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PERMISSIONS
    |--------------------------------------------------------------------------
    */

    /**
     * GET /api/v1/permissions
     * List semua permission, sekaligus dikelompokkan per modul.
     *
     * Response:
     * {
     *   "data": {
     *     "all": [...],
     *     "grouped": { "students": [...], "teachers": [...] }
     *   }
     * }
     */
    public function indexPermissions(): JsonResponse
    {
        $permissions = Permission::orderBy('name')->get();

        $grouped = $permissions->groupBy(function ($p) {
            $parts = explode(' ', $p->name);
            return $parts[1] ?? 'general';
        });

        return response()->json([
            'status'  => true,
            'message' => 'Data permission berhasil diambil.',
            'data'    => [
                'all'     => $permissions,
                'grouped' => $grouped,
            ],
        ]);
    }

    /**
     * POST /api/v1/permissions
     * Buat satu permission baru.
     *
     * Body: { "name": "view students" }
     */
    public function storePermission(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:150|unique:permissions,name',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $permission = Permission::create([
            'name'       => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Permission \"{$permission->name}\" berhasil dibuat.",
            'data'    => $permission,
        ], 201);
    }

    /**
     * POST /api/v1/permissions/bulk
     * Buat banyak permission sekaligus per modul.
     *
     * Body: { "module": "students", "actions": ["view","create","edit","delete"] }
     */
    public function bulkStorePermission(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'module'    => 'required|string|max:100',
                'actions'   => 'required|array|min:1',
                'actions.*' => 'in:view,create,edit,delete',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $created  = [];
        $skipped  = [];

        foreach ($request->actions as $action) {
            $name = "{$action} {$request->module}";
            if (Permission::where('name', $name)->exists()) {
                $skipped[] = $name;
                continue;
            }
            $created[] = Permission::create(['name' => $name, 'guard_name' => 'web']);
        }

        return response()->json([
            'status'  => true,
            'message' => count($created) . " permission dibuat, " . count($skipped) . " dilewati (sudah ada).",
            'data'    => [
                'created' => $created,
                'skipped' => $skipped,
            ],
        ], 201);
    }

    /**
     * PUT /api/v1/permissions/{id}
     * Update nama permission.
     *
     * Body: { "name": "view teachers" }
     */
    public function updatePermission(Request $request, int $id): JsonResponse
    {
        $permission = Permission::find($id);

        if (! $permission) {
            return response()->json([
                'status'  => false,
                'message' => 'Permission tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'name' => [
                    'required', 'string', 'max:150',
                    Rule::unique('permissions', 'name')->ignore($permission->id),
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $permission->update(['name' => $request->name]);

        return response()->json([
            'status'  => true,
            'message' => 'Permission berhasil diperbarui.',
            'data'    => $permission,
        ]);
    }

    /**
     * DELETE /api/v1/permissions/{id}
     * Hapus permission.
     */
    public function destroyPermission(int $id): JsonResponse
    {
        $permission = Permission::find($id);

        if (! $permission) {
            return response()->json([
                'status'  => false,
                'message' => 'Permission tidak ditemukan.',
            ], 404);
        }

        $name = $permission->name;
        $permission->delete();

        return response()->json([
            'status'  => true,
            'message' => "Permission \"{$name}\" berhasil dihapus.",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ASSIGN ROLE & PERMISSION KE USER
    |--------------------------------------------------------------------------
    */

    /**
     * GET /api/v1/users/{id}/roles
     * Lihat role & permission milik user tertentu.
     */
    public function userRoles(int $id): JsonResponse
    {
        $user = User::with('roles.permissions')->find($id);

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Role & permission user berhasil diambil.',
            'data'    => [
                'user'               => $user->only('id', 'name', 'email'),
                'roles'              => $user->roles->pluck('name'),
                'all_permissions'    => $user->getAllPermissions()->pluck('name'),
                'direct_permissions' => $user->permissions->pluck('name'),
            ],
        ]);
    }

    /**
     * POST /api/v1/users/{id}/roles
     * Sync roles ke user (replace semua role lama).
     *
     * Body: { "roles": ["admin", "teacher"] }
     */
    public function assignRole(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'roles'   => 'required|array|min:1',
                'roles.*' => 'exists:roles,name',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $user->syncRoles($request->roles);

        return response()->json([
            'status'  => true,
            'message' => "Role user \"{$user->name}\" berhasil diperbarui.",
            'data'    => [
                'user'  => $user->only('id', 'name', 'email'),
                'roles' => $user->fresh()->roles->pluck('name'),
            ],
        ]);
    }

    /**
     * DELETE /api/v1/users/{id}/roles
     * Cabut semua role dari user.
     */
    public function revokeRole(int $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User tidak ditemukan.',
            ], 404);
        }

        $user->syncRoles([]);

        return response()->json([
            'status'  => true,
            'message' => "Semua role user \"{$user->name}\" berhasil dicabut.",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SEED DEFAULT ROLES & PERMISSIONS
    |--------------------------------------------------------------------------
    */

    /**
     * POST /api/v1/role-permission/seed
     * Generate role & permission default untuk seluruh sistem.
     * Aman dijalankan ulang — menggunakan firstOrCreate.
     */
    public function seed(): JsonResponse
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

        $summary = Role::withCount('permissions')->get()->map(fn ($r) => [
            'role'        => $r->name,
            'permissions' => $r->permissions_count,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Default roles & permissions berhasil di-seed.',
            'data'    => [
                'roles'            => $summary,
                'total_permissions' => Permission::count(),
            ],
        ]);
    }
}