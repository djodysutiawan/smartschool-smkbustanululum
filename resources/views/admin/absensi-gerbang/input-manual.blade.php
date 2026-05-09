<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 40px;max-width:860px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-lg{padding:11px 24px;font-size:14px}

    .no-sesi-card{background:var(--surface);border:1px solid #fde68a;border-radius:var(--radius);padding:40px 24px;text-align:center;margin-bottom:20px}
    .no-sesi-icon{width:56px;height:56px;background:#fffbeb;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .no-sesi-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:#92400e;margin-bottom:6px}
    .no-sesi-sub{font-size:13px;color:#a16207;margin-bottom:20px}

    .sesi-info-card{background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1px solid #6ee7b7;border-radius:var(--radius);padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:14px}
    .live-dot{display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse-live 1.4s ease-in-out infinite}
    @keyframes pulse-live{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.45;transform:scale(1.5)}}
    .sesi-info-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:#065f46}
    .sesi-info-meta{font-size:12px;color:#059669;margin-top:2px}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .form-card-body{padding:20px}

    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:16px}
    .field:last-child{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);display:flex;align-items:center;gap:4px}
    .field label .req{color:#dc2626}
    .field select,.field input,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,box-shadow .15s;width:100%}
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field select:disabled,.field input:disabled{opacity:.6;cursor:not-allowed}
    .field textarea{resize:vertical;min-height:80px}
    .field-hint{font-size:11.5px;color:var(--text3);margin-top:2px}
    .field-error{font-size:11.5px;color:#dc2626;margin-top:2px;display:flex;align-items:center;gap:4px}

    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}

    .tipe-selector{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    .tipe-option{position:relative;cursor:pointer}
    .tipe-option input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .tipe-label{display:flex;align-items:center;gap:10px;padding:12px 16px;border:2px solid var(--border);border-radius:var(--radius-sm);background:var(--surface2);transition:all .15s;cursor:pointer}
    .tipe-option input[type=radio]:checked + .tipe-label{border-color:var(--brand-500);background:var(--brand-50)}
    .tipe-option.masuk input[type=radio]:checked + .tipe-label{border-color:#15803d;background:#f0fdf4}
    .tipe-option.pulang input[type=radio]:checked + .tipe-label{border-color:#1d4ed8;background:#eff6ff}
    .tipe-label-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .tipe-option.masuk .tipe-label-icon{background:#dcfce7}
    .tipe-option.pulang .tipe-label-icon{background:#dbeafe}
    .tipe-label-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}
    .tipe-label-sub{font-size:11.5px;color:var(--text3);margin-top:1px}

    .siswa-search-wrap{position:relative}
    .siswa-search-input{width:100%;padding:9px 12px 9px 36px !important}
    .siswa-search-icon{position:absolute;left:10px;top:50%;transform:translateY(-50%);pointer-events:none;color:var(--text3)}
    .siswa-dropdown{position:absolute;top:calc(100% + 4px);left:0;right:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:100;max-height:240px;overflow-y:auto;display:none}
    .siswa-dropdown.show{display:block}
    .siswa-item{display:flex;align-items:center;gap:10px;padding:9px 12px;cursor:pointer;transition:background .1s;border-bottom:1px solid var(--surface3)}
    .siswa-item:last-child{border-bottom:none}
    .siswa-item:hover,.siswa-item.active{background:var(--brand-50)}
    .siswa-item-avatar{width:30px;height:30px;border-radius:8px;background:var(--brand-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand-700)}
    .siswa-item-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .siswa-item-meta{font-size:11.5px;color:var(--text3);margin-top:1px}
    .siswa-selected-card{display:none;align-items:center;gap:10px;padding:10px 14px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);margin-top:6px}
    .siswa-selected-card.show{display:flex}
    .siswa-selected-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--brand-700)}
    .siswa-selected-meta{font-size:11.5px;color:var(--brand-600);margin-top:1px}
    .siswa-clear-btn{margin-left:auto;background:none;border:none;cursor:pointer;color:var(--text3);padding:2px;border-radius:4px;display:flex;align-items:center}
    .siswa-clear-btn:hover{color:var(--text)}

    .dropdown-empty{padding:20px 12px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:var(--text3)}

    .form-footer{display:flex;gap:10px;justify-content:flex-end;padding:16px 20px;border-top:1px solid var(--border);background:var(--surface2)}

    .riwayat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .riwayat-header{padding:12px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
    .riwayat-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:9px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:9px 14px;color:var(--text);vertical-align:middle}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-masuk{background:#dcfce7;color:#15803d} .badge-masuk .badge-dot{background:#15803d}
    .badge-pulang{background:#dbeafe;color:#1d4ed8} .badge-pulang .badge-dot{background:#1d4ed8}
    .badge-manual{background:#fff7ed;color:#c2410c} .badge-manual .badge-dot{background:#c2410c}

    @media(max-width:600px){.grid-2{grid-template-columns:1fr}.tipe-selector{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Input Absensi Manual</h1>
            <p class="page-sub">Catat kehadiran siswa secara manual oleh petugas piket</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.absensi-gerbang.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Log
            </a>
        </div>
    </div>

    @if($sesiAktif)
    {{-- ── Info Sesi Aktif ─────────────────────────────────────────────── --}}
    <div class="sesi-info-card">
        <span class="live-dot"></span>
        <div>
            <p class="sesi-info-title">Sesi {{ $sesiAktif->label_tipe }} aktif — {{ $sesiAktif->dibuka_pada->format('H:i') }}</p>
            <p class="sesi-info-meta">Dibuka oleh {{ $sesiAktif->dibukaOleh->name }} &middot; Input manual akan dicatat ke sesi ini</p>
        </div>
    </div>

    {{-- ── Form Input ───────────────────────────────────────────────────── --}}
    <form method="POST" action="{{ route('admin.absensi-gerbang.store-manual') }}" id="formManual">
        @csrf
        <input type="hidden" name="sesi_gerbang_id" value="{{ $sesiAktif->id }}">

        <div class="form-card">
            <div class="form-card-header">
                <p class="form-card-title">
                    <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    Data Siswa
                </p>
            </div>
            <div class="form-card-body">

                {{-- Cari Siswa --}}
                <div class="field">
                    <label>Cari Siswa <span class="req">*</span></label>
                    <div class="siswa-search-wrap">
                        <svg class="siswa-search-icon" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="siswaSearch" class="siswa-search-input" placeholder="Ketik nama atau NIS siswa…" autocomplete="off">
                        <div class="siswa-dropdown" id="siswaDropdown"></div>
                    </div>
                    <input type="hidden" name="siswa_id" id="siswaId" value="{{ old('siswa_id', request('siswa_id')) }}" required>
                    <div class="siswa-selected-card" id="siswaSelectedCard">
                        <div class="siswa-item-avatar" id="siswaSelectedAvatar"></div>
                        <div>
                            <p class="siswa-selected-name" id="siswaSelectedName"></p>
                            <p class="siswa-selected-meta" id="siswaSelectedMeta"></p>
                        </div>
                        <button type="button" class="siswa-clear-btn" onclick="clearSiswa()" title="Ganti siswa">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                    @error('siswa_id')<p class="field-error">{{ $message }}</p>@enderror
                    <p class="field-hint">Ketik minimal 2 karakter untuk mencari</p>
                </div>

                <div class="grid-2">
                    {{-- Kelas (readonly, diisi otomatis) --}}
                    <div class="field">
                        <label>Kelas</label>
                        <input type="text" id="siswaKelas" placeholder="Otomatis terisi" disabled>
                    </div>
                    {{-- NIS (readonly) --}}
                    <div class="field">
                        <label>NIS</label>
                        <input type="text" id="siswaNIS" placeholder="Otomatis terisi" disabled>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <p class="form-card-title">
                    <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Detail Absensi
                </p>
            </div>
            <div class="form-card-body">

                {{-- Tipe Absensi --}}
                <div class="field">
                    <label>Tipe Absensi <span class="req">*</span></label>
                    <div class="tipe-selector">
                        <label class="tipe-option masuk">
                            <input type="radio" name="tipe" value="masuk"
                                   {{ old('tipe', $sesiAktif->tipe) === 'masuk' ? 'checked' : '' }}>
                            <div class="tipe-label">
                                <div class="tipe-label-icon">
                                    <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </div>
                                <div>
                                    <p class="tipe-label-text">Masuk</p>
                                    <p class="tipe-label-sub">Scan datang ke sekolah</p>
                                </div>
                            </div>
                        </label>
                        <label class="tipe-option pulang">
                            <input type="radio" name="tipe" value="pulang"
                                   {{ old('tipe') === 'pulang' ? 'checked' : '' }}>
                            <div class="tipe-label">
                                <div class="tipe-label-icon">
                                    <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </div>
                                <div>
                                    <p class="tipe-label-text">Pulang</p>
                                    <p class="tipe-label-sub">Scan keluar sekolah</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('tipe')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Catatan --}}
                <div class="field">
                    <label>Catatan <span style="color:var(--text3);font-weight:400">(opsional)</span></label>
                    <textarea name="catatan" placeholder="Mis: siswa lupa bawa kartu, ID rusak, dll…">{{ old('catatan') }}</textarea>
                    @error('catatan')<p class="field-error">{{ $message }}</p>@enderror
                </div>

            </div>
            <div class="form-footer">
                <a href="{{ route('admin.absensi-gerbang.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Simpan Absensi Manual
                </button>
            </div>
        </div>
    </form>

    @else
    {{-- ── Tidak Ada Sesi Aktif ─────────────────────────────────────────── --}}
    <div class="no-sesi-card">
        <div class="no-sesi-icon">
            <svg width="24" height="24" fill="none" stroke="#d97706" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <p class="no-sesi-title">Tidak ada sesi aktif saat ini</p>
        <p class="no-sesi-sub">Input manual memerlukan sesi gerbang yang aktif. Buka sesi terlebih dahulu.</p>
        <a href="{{ route('admin.sesi-gerbang.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buka Sesi Baru
        </a>
    </div>
    @endif

    {{-- ── Riwayat Input Manual Hari Ini ───────────────────────────────── --}}
    @if(isset($riwayatManual) && $riwayatManual->count() > 0)
    <div class="riwayat-card">
        <div class="riwayat-header">
            <p class="riwayat-title">Riwayat Input Manual Hari Ini</p>
            <span style="font-size:12px;color:var(--text3)">{{ $riwayatManual->count() }} record</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Tipe</th>
                    <th>Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatManual as $r)
                <tr>
                    <td style="font-family:'DM Sans',sans-serif;font-size:12.5px;white-space:nowrap">{{ $r->waktu_scan->format('H:i:s') }}</td>
                    <td>
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $r->siswa?->nama_lengkap ?? '—' }}</p>
                        <p style="font-size:11.5px;color:var(--text3)">{{ $r->siswa?->nis ?? '' }}</p>
                    </td>
                    <td style="font-size:12.5px;color:var(--text3)">{{ $r->siswa?->kelas?->nama_kelas ?? '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $r->tipe }}">
                            <span class="badge-dot"></span>{{ $r->label_tipe }}
                        </span>
                    </td>
                    <td style="font-size:12.5px;color:var(--text2)">{{ $r->inputOleh?->name ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({ icon:'warning', title:'Perhatian!', html:@json(implode('<br>', $errors->all())), confirmButtonColor:'#1f63db' });
    @endif

    // ── Siswa Search Autocomplete ─────────────────────────────────────────────
    const searchInput    = document.getElementById('siswaSearch');
    const dropdown       = document.getElementById('siswaDropdown');
    const siswaIdInput   = document.getElementById('siswaId');
    const selectedCard   = document.getElementById('siswaSelectedCard');
    const selectedName   = document.getElementById('siswaSelectedName');
    const selectedMeta   = document.getElementById('siswaSelectedMeta');
    const selectedAvatar = document.getElementById('siswaSelectedAvatar');
    const kelasInput     = document.getElementById('siswaKelas');
    const nisInput       = document.getElementById('siswaNIS');

    let debounceTimer;
    let selectedSiswa = null;

    // Jika ada siswa_id dari URL (dari halaman belum-hadir), load datanya
    const prefilledId = @json(request('siswa_id'));
    if (prefilledId) {
        fetch(`/admin/api/siswa/${prefilledId}`)
            .then(r => r.json())
            .then(d => { if (d.id) selectSiswa(d); })
            .catch(() => {});
    }

    searchInput.addEventListener('input', function() {
        const q = this.value.trim();
        clearTimeout(debounceTimer);

        if (q.length < 2) {
            dropdown.classList.remove('show');
            dropdown.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('admin.api.siswa.search') }}?q=${encodeURIComponent(q)}&limit=8`)
                .then(r => r.json())
                .then(data => renderDropdown(data))
                .catch(() => {
                    dropdown.innerHTML = '<p class="dropdown-empty">Gagal memuat data</p>';
                    dropdown.classList.add('show');
                });
        }, 280);
    });

    function renderDropdown(items) {
        if (!items.length) {
            dropdown.innerHTML = '<p class="dropdown-empty">Siswa tidak ditemukan</p>';
            dropdown.classList.add('show');
            return;
        }

        dropdown.innerHTML = items.map(s => `
            <div class="siswa-item" onclick="selectSiswa(${JSON.stringify(s).replace(/"/g,'&quot;')})">
                <div class="siswa-item-avatar">${s.nama_lengkap.charAt(0).toUpperCase()}</div>
                <div>
                    <p class="siswa-item-name">${s.nama_lengkap}</p>
                    <p class="siswa-item-meta">NIS: ${s.nis} &middot; ${s.kelas ?? '—'}</p>
                </div>
            </div>
        `).join('');
        dropdown.classList.add('show');
    }

    function selectSiswa(s) {
        selectedSiswa = s;
        siswaIdInput.value = s.id;

        selectedAvatar.textContent = s.nama_lengkap.charAt(0).toUpperCase();
        selectedName.textContent   = s.nama_lengkap;
        selectedMeta.textContent   = `NIS: ${s.nis} · ${s.kelas ?? '—'}`;
        kelasInput.value           = s.kelas ?? '—';
        nisInput.value             = s.nis;

        selectedCard.classList.add('show');
        searchInput.value = '';
        searchInput.style.display = 'none';
        dropdown.classList.remove('show');
    }

    function clearSiswa() {
        selectedSiswa = null;
        siswaIdInput.value = '';
        kelasInput.value = '';
        nisInput.value = '';
        selectedCard.classList.remove('show');
        searchInput.style.display = '';
        searchInput.value = '';
        searchInput.focus();
    }

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.siswa-search-wrap')) {
            dropdown.classList.remove('show');
        }
    });

    // ── Form Submit Validation ────────────────────────────────────────────────
    document.getElementById('formManual')?.addEventListener('submit', function(e) {
        if (!siswaIdInput.value) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Pilih Siswa', text:'Silakan cari dan pilih siswa terlebih dahulu.', confirmButtonColor:'#1f63db' });
            return;
        }
        const tipe = document.querySelector('input[name=tipe]:checked');
        if (!tipe) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Pilih Tipe', text:'Silakan pilih tipe absensi (Masuk atau Pulang).', confirmButtonColor:'#1f63db' });
            return;
        }
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .8s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
<style>@keyframes spin{to{transform:rotate(360deg)}}</style>
</x-app-layout>