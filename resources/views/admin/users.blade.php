<x-app-layout>
    <x-slot name="header">
        <h2>Role &amp; Permission</h2>
    </x-slot>

    <style>
        /* ── Layout ── */
        .rp-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        @media (max-width: 900px) { .rp-grid { grid-template-columns: 1fr; } }

        /* ── Section cards ── */
        .section-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 20px;
        }
        .section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700; font-size: 14px; color: #0f172a;
            margin-bottom: 16px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .section-title-left {
            display: flex; align-items: center; gap: 8px;
        }
        .section-title .dot {
            width: 8px; height: 8px; border-radius: 50%;
        }

        /* ── Table ── */
        .rp-table {
            width: 100%; border-collapse: collapse;
            font-size: 13.5px; color: #334155;
        }
        .rp-table th {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: #94a3b8; padding: 8px 12px;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
        }
        .rp-table td {
            padding: 11px 12px;
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
        }
        .rp-table tr:last-child td { border-bottom: none; }
        .rp-table tr:hover td { background: #f8fafc; }

        /* ── Pills ── */
        .pill {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px; font-weight: 700;
            letter-spacing: .04em; text-transform: uppercase;
            padding: 3px 10px; border-radius: 99px;
            display: inline-block;
        }
        .pill-blue   { background: #eef6ff; color: #1750c0; border: 1px solid #bfdbfe; }
        .pill-green  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .pill-amber  { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .pill-red    { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .pill-gray   { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
        .pill-purple { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }

        /* ── Buttons ── */
        .btn {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px; font-weight: 700;
            padding: 7px 14px; border-radius: 8px;
            border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            transition: opacity .15s;
        }
        .btn:hover { opacity: .85; }
        .btn-primary { background: #1750c0; color: #fff; }
        .btn-danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-ghost   { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
        .btn-sm { padding: 4px 10px; font-size: 11px; border-radius: 6px; }

        /* ── Form ── */
        .form-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px; font-weight: 700;
            color: #475569; display: block; margin-bottom: 5px;
        }
        .form-input {
            width: 100%; padding: 8px 12px;
            border: 1px solid #e2e8f0; border-radius: 8px;
            font-size: 13.5px; color: #0f172a;
            outline: none; transition: border-color .15s;
            font-family: 'DM Sans', sans-serif;
        }
        .form-input:focus { border-color: #1750c0; }
        .form-row { margin-bottom: 14px; }

        /* ── Permission tag cloud ── */
        .perm-cloud { display: flex; flex-wrap: wrap; gap: 6px; }
        .perm-tag {
            font-size: 11.5px; color: #475569;
            background: #f1f5f9; border-radius: 6px;
            padding: 3px 9px; cursor: default;
        }
        .perm-tag.action-view   { background: #eef6ff; color: #1750c0; }
        .perm-tag.action-create { background: #f0fdf4; color: #15803d; }
        .perm-tag.action-edit   { background: #fffbeb; color: #92400e; }
        .perm-tag.action-delete { background: #fef2f2; color: #dc2626; }

        /* ── Modal backdrop ── */
        .modal-backdrop {
            display: none;
            position: fixed; inset: 0;
            background: rgba(15,23,42,.45);
            z-index: 100;
            align-items: center; justify-content: center;
        }
        .modal-backdrop.open { display: flex; }
        .modal {
            background: #fff; border-radius: 16px;
            padding: 28px 30px; width: 100%; max-width: 480px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
            position: relative;
        }
        .modal-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 16px; color: #0f172a;
            margin-bottom: 20px;
        }
        .modal-close {
            position: absolute; top: 18px; right: 18px;
            background: #f1f5f9; border: none; border-radius: 8px;
            width: 30px; height: 30px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: #64748b;
        }
        .modal-close:hover { background: #e2e8f0; }

        /* ── Permission checkbox grid ── */
        .perm-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
            max-height: 220px; overflow-y: auto;
            border: 1px solid #e2e8f0; border-radius: 8px;
            padding: 10px;
        }
        .perm-check {
            display: flex; align-items: center; gap: 7px;
            font-size: 12.5px; color: #334155; cursor: pointer;
        }
        .perm-check input { accent-color: #1750c0; cursor: pointer; }

        /* ── Welcome banner ── */
        .welcome-banner {
            background: linear-gradient(135deg, #0d1f4e 0%, #1750c0 55%, #0a6b4a 100%);
            border-radius: 16px; padding: 22px 26px; margin-bottom: 22px;
            position: relative; overflow: hidden;
        }
        .welcome-banner::before {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .welcome-banner h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 18px; color: #fff; position: relative;
        }
        .welcome-banner p {
            font-size: 13.5px; color: rgba(255,255,255,.65);
            margin-top: 4px; position: relative;
        }

        /* ── Stat row ── */
        .stat-row {
            display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 20px;
        }
        .stat-chip {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
            padding: 14px 18px; flex: 1; min-width: 120px;
            display: flex; flex-direction: column; gap: 4px;
        }
        .stat-chip-val {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 24px; color: #0f172a; line-height: 1;
        }
        .stat-chip-label { font-size: 12px; color: #64748b; }

        /* ── User table search ── */
        .search-bar {
            display: flex; gap: 10px; margin-bottom: 14px; align-items: center;
        }
        .search-bar input {
            flex: 1; padding: 8px 12px;
            border: 1px solid #e2e8f0; border-radius: 8px;
            font-size: 13.5px; outline: none;
        }
        .search-bar input:focus { border-color: #1750c0; }

        /* ── Alert flash ── */
        .alert {
            padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
            font-size: 13.5px; font-family: 'DM Sans', sans-serif;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

        /* ── Permission group ── */
        .perm-group { margin-bottom: 16px; }
        .perm-group-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em;
            color: #94a3b8; margin-bottom: 8px;
        }
    </style>

    {{-- ═══════════════════════════════════════════════════════════
         FLASH MESSAGES
    ═══════════════════════════════════════════════════════════ --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         WELCOME BANNER
    ═══════════════════════════════════════════════════════════ --}}
    <div class="welcome-banner">
        <h3>Role &amp; Permission</h3>
        <p>Kelola hak akses pengguna — atur role, permission, dan assign ke akun user.</p>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         STAT CHIPS
    ═══════════════════════════════════════════════════════════ --}}
    <div class="stat-row">
        <div class="stat-chip">
            <span class="stat-chip-val">{{ $roles->count() }}</span>
            <span class="stat-chip-label">Total Role</span>
        </div>
        <div class="stat-chip">
            <span class="stat-chip-val">{{ $permissions->count() }}</span>
            <span class="stat-chip-label">Total Permission</span>
        </div>
        <div class="stat-chip">
            <span class="stat-chip-val">{{ $users->total() }}</span>
            <span class="stat-chip-label">Total User</span>
        </div>
        <div class="stat-chip">
            <span class="stat-chip-val">{{ $groupedPermissions->count() }}</span>
            <span class="stat-chip-label">Modul</span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         ROW 1 — ROLES | PERMISSIONS
    ═══════════════════════════════════════════════════════════ --}}
    <div class="rp-grid">

        {{-- ── ROLES ── --}}
        <div class="section-card">
            <div class="section-title">
                <div class="section-title-left">
                    <span class="dot" style="background:#1750c0"></span>
                    Daftar Role
                </div>
                <button class="btn btn-primary btn-sm" onclick="openModal('modal-add-role')">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Role
                </button>
            </div>

            <table class="rp-table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Permission</th>
                        <th>User</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>
                                <span class="pill {{ match($role->name) {
                                    'admin'   => 'pill-red',
                                    'teacher' => 'pill-blue',
                                    'student' => 'pill-green',
                                    'parent'  => 'pill-amber',
                                    'piket'   => 'pill-purple',
                                    default   => 'pill-gray',
                                } }}">{{ $role->name }}</span>
                            </td>
                            <td style="color:#64748b; font-size:12.5px">{{ $role->permissions_count }} permission</td>
                            <td style="color:#64748b; font-size:12.5px">{{ $role->users_count }} user</td>
                            <td>
                                <div style="display:flex; gap:5px">
                                    <button class="btn btn-ghost btn-sm"
                                        onclick="openEditRole({{ $role->id }}, '{{ $role->name }}', {{ $role->permissions->pluck('id') }})">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    @if($role->name !== 'admin')
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                            onsubmit="return confirm('Hapus role {{ $role->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; color:#94a3b8; padding:24px">
                                Belum ada role. <a href="#" onclick="openModal('modal-add-role'); return false" style="color:#1750c0">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Seed button --}}
            <div style="margin-top:16px; padding-top:14px; border-top:1px solid #f1f5f9">
                <form method="POST" action="{{ route('admin.role-permission.seed') }}"
                    onsubmit="return confirm('Generate ulang default roles & permissions?')">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm" style="width:100%; justify-content:center">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Seed Default Roles &amp; Permissions
                    </button>
                </form>
            </div>
        </div>

        {{-- ── PERMISSIONS ── --}}
        <div class="section-card">
            <div class="section-title">
                <div class="section-title-left">
                    <span class="dot" style="background:#0a6b4a"></span>
                    Daftar Permission
                </div>
                <div style="display:flex; gap:6px">
                    <button class="btn btn-ghost btn-sm" onclick="openModal('modal-bulk-permission')">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Bulk
                    </button>
                    <button class="btn btn-primary btn-sm" onclick="openModal('modal-add-permission')">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah
                    </button>
                </div>
            </div>

            {{-- Permission grouped by module --}}
            <div style="max-height:380px; overflow-y:auto; padding-right:4px">
                @forelse($groupedPermissions as $module => $perms)
                    <div class="perm-group">
                        <div class="perm-group-label">{{ $module }}</div>
                        <div class="perm-cloud">
                            @foreach($perms as $perm)
                                @php
                                    $action = explode(' ', $perm->name)[0] ?? '';
                                    $cls = match($action) {
                                        'view'   => 'action-view',
                                        'create' => 'action-create',
                                        'edit'   => 'action-edit',
                                        'delete' => 'action-delete',
                                        default  => '',
                                    };
                                @endphp
                                <span class="perm-tag {{ $cls }}" title="{{ $perm->name }}">
                                    {{ $action }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p style="color:#94a3b8; font-size:13px; text-align:center; padding:24px 0">
                        Belum ada permission.
                    </p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         ROW 2 — USER & ROLE ASSIGNMENT
    ═══════════════════════════════════════════════════════════ --}}
    <div class="section-card">
        <div class="section-title">
            <div class="section-title-left">
                <span class="dot" style="background:#92400e"></span>
                User &amp; Role
            </div>
            <a href="{{ route('admin.role-permission.users') }}" class="btn btn-ghost btn-sm">
                Lihat Semua
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <table class="rp-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="font-weight:600; color:#0f172a">{{ $user->name }}</div>
                        </td>
                        <td style="color:#64748b; font-size:12.5px">{{ $user->email }}</td>
                        <td>
                            <div style="display:flex; flex-wrap:wrap; gap:4px">
                                @forelse($user->roles as $r)
                                    <span class="pill {{ match($r->name) {
                                        'admin'   => 'pill-red',
                                        'teacher' => 'pill-blue',
                                        'student' => 'pill-green',
                                        'parent'  => 'pill-amber',
                                        'piket'   => 'pill-purple',
                                        default   => 'pill-gray',
                                    } }}">{{ $r->name }}</span>
                                @empty
                                    <span class="pill pill-gray">— no role</span>
                                @endforelse
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-ghost btn-sm"
                                onclick="openAssign({{ $user->id }}, '{{ addslashes($user->name) }}', {{ $user->roles->pluck('name') }})">
                                Assign Role
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:#94a3b8; padding:24px">Belum ada user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div style="margin-top:14px; padding-top:12px; border-top:1px solid #f1f5f9">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         MODALS
    ═══════════════════════════════════════════════════════════ --}}

    {{-- Modal: Tambah Role --}}
    <div class="modal-backdrop" id="modal-add-role">
        <div class="modal">
            <button class="modal-close" onclick="closeModal('modal-add-role')">✕</button>
            <div class="modal-title">Tambah Role Baru</div>
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="form-row">
                    <label class="form-label">Nama Role</label>
                    <input type="text" name="name" class="form-input" placeholder="contoh: guru_bk" required>
                </div>
                <div class="form-row">
                    <label class="form-label">Assign Permission (opsional)</label>
                    <div class="perm-grid">
                        @foreach($permissions as $perm)
                            <label class="perm-check">
                                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}">
                                {{ $perm->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:20px">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-add-role')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Role</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Edit Role --}}
    <div class="modal-backdrop" id="modal-edit-role">
        <div class="modal">
            <button class="modal-close" onclick="closeModal('modal-edit-role')">✕</button>
            <div class="modal-title">Edit Role</div>
            <form method="POST" id="form-edit-role">
                @csrf @method('PUT')
                <div class="form-row">
                    <label class="form-label">Nama Role</label>
                    <input type="text" name="name" id="edit-role-name" class="form-input" required>
                </div>
                <div class="form-row">
                    <label class="form-label">Sync Permission</label>
                    <div class="perm-grid" id="edit-perm-grid">
                        @foreach($permissions as $perm)
                            <label class="perm-check">
                                <input type="checkbox" class="edit-perm-cb" name="permissions[]" value="{{ $perm->id }}">
                                {{ $perm->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:20px">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-edit-role')">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Role</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Tambah Permission --}}
    <div class="modal-backdrop" id="modal-add-permission">
        <div class="modal">
            <button class="modal-close" onclick="closeModal('modal-add-permission')">✕</button>
            <div class="modal-title">Tambah Permission</div>
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf
                <div class="form-row">
                    <label class="form-label">Nama Permission</label>
                    <input type="text" name="name" class="form-input"
                        placeholder="contoh: view students" required>
                    <p style="font-size:11.5px; color:#94a3b8; margin-top:5px">
                        Format: <code>{action} {modul}</code> — contoh: <code>edit violations</code>
                    </p>
                </div>
                <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:20px">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-add-permission')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Bulk Permission --}}
    <div class="modal-backdrop" id="modal-bulk-permission">
        <div class="modal">
            <button class="modal-close" onclick="closeModal('modal-bulk-permission')">✕</button>
            <div class="modal-title">Bulk Permission per Modul</div>
            <form method="POST" action="{{ route('admin.permissions.bulk') }}">
                @csrf
                <div class="form-row">
                    <label class="form-label">Nama Modul</label>
                    <input type="text" name="module" class="form-input"
                        placeholder="contoh: students" required>
                </div>
                <div class="form-row">
                    <label class="form-label">Actions</label>
                    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:4px">
                        @foreach(['view','create','edit','delete'] as $act)
                            <label class="perm-check">
                                <input type="checkbox" name="actions[]" value="{{ $act }}" checked>
                                {{ $act }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:20px">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-bulk-permission')">Batal</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Assign Role ke User --}}
    <div class="modal-backdrop" id="modal-assign-role">
        <div class="modal">
            <button class="modal-close" onclick="closeModal('modal-assign-role')">✕</button>
            <div class="modal-title">Assign Role ke <span id="assign-user-name" style="color:#1750c0"></span></div>
            <form method="POST" action="{{ route('admin.role-permission.assign') }}">
                @csrf
                <input type="hidden" name="user_id" id="assign-user-id">
                <div class="form-row">
                    <label class="form-label">Pilih Role</label>
                    <div class="perm-grid">
                        @foreach($roles as $role)
                            <label class="perm-check">
                                <input type="checkbox" class="assign-role-cb"
                                    name="roles[]" value="{{ $role->name }}">
                                {{ $role->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:20px">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-assign-role')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         SCRIPTS
    ═══════════════════════════════════════════════════════════ --}}
    <script>
        /* ── Modal helpers ── */
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        // Tutup modal jika klik backdrop
        document.querySelectorAll('.modal-backdrop').forEach(bd => {
            bd.addEventListener('click', function (e) {
                if (e.target === this) this.classList.remove('open');
            });
        });

        /* ── Edit Role ── */
        function openEditRole(id, name, permIds) {
            document.getElementById('edit-role-name').value = name;
            document.getElementById('form-edit-role').action =
                '{{ url("admin/roles") }}/' + id;

            // Reset semua checkbox, lalu centang yang sesuai
            document.querySelectorAll('.edit-perm-cb').forEach(cb => {
                cb.checked = permIds.includes(parseInt(cb.value));
            });

            openModal('modal-edit-role');
        }

        /* ── Assign Role ── */
        function openAssign(userId, userName, currentRoles) {
            document.getElementById('assign-user-id').value  = userId;
            document.getElementById('assign-user-name').textContent = userName;

            document.querySelectorAll('.assign-role-cb').forEach(cb => {
                cb.checked = currentRoles.includes(cb.value);
            });

            openModal('modal-assign-role');
        }
    </script>

</x-app-layout>