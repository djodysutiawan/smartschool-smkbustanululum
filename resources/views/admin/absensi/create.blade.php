<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-back:hover{background:var(--surface3)}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border)}
    .btn-cancel:hover{background:var(--surface3)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-primary:hover{filter:brightness(.93)}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-section{padding:20px 24px 24px}
    .section-divider{border:none;border-top:1px solid var(--border);margin:0}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px}
    .section-label-line{flex:1;height:1px;background:var(--border)}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
    .col-span-2{grid-column:span 2}.col-span-3{grid-column:span 3}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand);margin-left:2px}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s}
    .field textarea{height:auto;padding:10px 12px;resize:vertical}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field input::placeholder,.field textarea::placeholder{color:var(--text3)}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .field select:disabled{opacity:.6;cursor:not-allowed}
    .upload-wrap{border:1.5px dashed var(--border2);border-radius:var(--radius-sm);padding:16px;background:var(--surface2);position:relative}
    .upload-inner{display:flex;align-items:center;gap:12px}
    .upload-icon{width:40px;height:40px;background:var(--surface3);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .upload-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:3px}
    .upload-hint{font-size:12px;color:var(--text3)}
    .upload-input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
    .upload-filename{font-size:12.5px;color:var(--brand);font-family:'DM Sans',sans-serif;margin-top:6px;display:none}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border)}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:680px){.page{padding:16px 16px 40px}.form-grid,.form-grid-3{grid-template-columns:1fr}.col-span-2,.col-span-3{grid-column:span 1}}
</style>

@php
    $metodeLabel = [
        'manual'  => 'Manual',
        'qr'      => 'QR Code',
        'qr_scan' => 'QR Scan',
        'wajah'   => 'Face Recognition',
        'rfid'    => 'RFID',
        'import'  => 'Import',
    ];
@endphp

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.absensi.index') }}">Data Absensi</a>
        <span class="sep">›</span>
        <span class="current">Catat Absensi</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Catat Absensi Siswa</h1>
            <p class="page-sub">Input data kehadiran siswa secara manual</p>
        </div>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.absensi.store') }}" method="POST" enctype="multipart/form-data" id="absensiForm">
        @csrf
        <div class="form-card">

            {{-- DATA SISWA --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Data Siswa &amp; Kelas
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">

                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" id="kelasSelect" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}"
                                onchange="onKelasChange(this.value)">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal" id="tanggalInput"
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                               onchange="onTanggalChange(this.value)">
                        @error('tanggal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Siswa <span class="req">*</span></label>
                        <select name="siswa_id" id="siswaSelect"
                                class="{{ $errors->has('siswa_id') ? 'is-invalid' : '' }}"
                                disabled>
                            <option value="">— Pilih Kelas Dulu —</option>
                        </select>
                        @error('siswa_id')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint" id="siswaHint" style="display:none">Memuat data siswa…</span>
                    </div>

                    <div class="field">
                        <label>Jadwal Pelajaran</label>
                        <select name="jadwal_pelajaran_id" id="jadwalSelect" disabled>
                            <option value="">— Pilih Kelas &amp; Tanggal Dulu —</option>
                        </select>
                        <span class="field-hint" id="jadwalHint" style="display:none">Memuat jadwal…</span>
                    </div>

                </div>
            </div>

            <hr class="section-divider">

            {{-- STATUS KEHADIRAN --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Status &amp; Waktu
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid-3">
                    <div class="field">
                        <label>Status Kehadiran <span class="req">*</span></label>
                        <select name="status" id="statusSelect" class="{{ $errors->has('status') ? 'is-invalid' : '' }}"
                                onchange="handleStatus(this.value)">
                            <option value="">— Pilih Status —</option>
                            @foreach($statusList as $st)
                                <option value="{{ $st }}" {{ old('status') == $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Metode</label>
                        <select name="metode">
                            @foreach($metodeList as $m)
                                <option value="{{ $m }}" {{ old('metode', 'manual') == $m ? 'selected' : '' }}>
                                    {{ $metodeLabel[$m] ?? ucfirst($m) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}"
                               class="{{ $errors->has('jam_masuk') ? 'is-invalid' : '' }}">
                        @error('jam_masuk')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Jam Keluar</label>
                        <input type="time" name="jam_keluar" value="{{ old('jam_keluar') }}"
                               class="{{ $errors->has('jam_keluar') ? 'is-invalid' : '' }}">
                        @error('jam_keluar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field"></div>
                    <div class="field"></div>

                    <div class="field col-span-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- SURAT IZIN --}}
            <div class="form-section" id="suratIzinSection" style="display:none">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Surat Keterangan
                    <span class="section-label-line"></span>
                </p>
                <div class="field" style="max-width:500px">
                    <label>Upload Surat Izin / Sakit</label>
                    <div class="upload-wrap">
                        <div class="upload-inner">
                            <div class="upload-icon">
                                <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <div>
                                <p class="upload-label">Pilih file</p>
                                <p class="upload-hint">PDF, JPG, PNG — maks. 2 MB</p>
                            </div>
                        </div>
                        <input type="file" name="path_surat_izin" class="upload-input" id="suratInput"
                               accept=".pdf,.jpg,.jpeg,.png"
                               onchange="onSuratFileChange(this)">
                        <p id="suratFilename" class="upload-filename"></p>
                    </div>
                    @error('path_surat_izin')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.absensi.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Absensi
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ── Flash messages ──────────────────────────────────────────────────────
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon:'error',
        title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">
            @foreach($errors->all() as $e)<li>{{ addslashes($e) }}</li>@endforeach
        </ul>`,
        confirmButtonColor:'#1f63db',
    });
    @endif

    // ── FIX #1: Gunakan url() bukan route() agar tidak ada RouteModelBinding
    // saat halaman di-render. ID kelas digabung di JS saat request dikirim.
    // Pastikan nama segmen URL sesuai dengan definisi route di web.php Anda.
    // Contoh route: GET /admin/absensi/kelas/{kelas}/data
    const AJAX_BASE = "{{ url('admin/absensi/kelas') }}";

    // Nilai lama setelah validation error
    const OLD_SISWA_ID  = "{{ old('siswa_id') }}";
    const OLD_JADWAL_ID = "{{ old('jadwal_pelajaran_id') }}";

    // ── Handlers ────────────────────────────────────────────────────────────
    function handleStatus(val) {
        const sec = document.getElementById('suratIzinSection');
        sec.style.display = (val === 'izin' || val === 'sakit') ? 'block' : 'none';
    }
    handleStatus('{{ old("status","") }}');

    function onSuratFileChange(input) {
        const el = document.getElementById('suratFilename');
        el.textContent   = input.files[0]?.name || '';
        el.style.display = input.files[0] ? 'block' : 'none';
    }

    // ── AJAX ─────────────────────────────────────────────────────────────────
    function onKelasChange(kelasId) {
        const tanggal = document.getElementById('tanggalInput').value;
        loadSiswaJadwal(kelasId, tanggal);
    }

    function onTanggalChange(tanggal) {
        const kelasId = document.getElementById('kelasSelect').value;
        if (kelasId) loadSiswaJadwal(kelasId, tanggal);
    }

    function loadSiswaJadwal(kelasId, tanggal) {
        if (!kelasId) {
            resetSiswa();
            resetJadwal();
            return;
        }

        // FIX #1: Bangun URL secara manual, tanpa route() di Blade
        const url = AJAX_BASE + '/' + kelasId + '/data'
                  + (tanggal ? '?tanggal=' + encodeURIComponent(tanggal) : '');

        const siswaEl    = document.getElementById('siswaSelect');
        const jadwalEl   = document.getElementById('jadwalSelect');
        const siswaHint  = document.getElementById('siswaHint');
        const jadwalHint = document.getElementById('jadwalHint');

        siswaEl.disabled   = true;
        jadwalEl.disabled  = true;
        siswaEl.innerHTML  = '<option value="">Memuat…</option>';
        jadwalEl.innerHTML = '<option value="">Memuat…</option>';
        siswaHint.style.display  = 'block';
        jadwalHint.style.display = 'block';

        // FIX #4: Sertakan CSRF token dan credentials agar session cookie dikirim
        fetch(url, {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-XSRF-TOKEN': decodeURIComponent(
                    (document.cookie.match(/XSRF-TOKEN=([^;]+)/) || [])[1] || ''
                ),
            },
        })
        .then(r => {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(data => {
            // Isi dropdown siswa
            siswaEl.innerHTML = '<option value="">— Pilih Siswa —</option>';
            if (data.siswa && data.siswa.length > 0) {
                data.siswa.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value       = s.id;
                    opt.textContent = s.nama_lengkap + ' (' + s.nis + ')';
                    if (String(s.id) === OLD_SISWA_ID) opt.selected = true;
                    siswaEl.appendChild(opt);
                });
                siswaEl.disabled = false;
            } else {
                siswaEl.innerHTML = '<option value="">Tidak ada siswa aktif</option>';
                siswaEl.disabled  = false;
            }

            // Isi dropdown jadwal
            // FIX #3: Laravel serialisasi relasi dengan nama snake_case otomatis
            // with('mataPelajaran') → key JSON adalah "mata_pelajaran"
            jadwalEl.innerHTML = '<option value="">— Pilih Jadwal (opsional) —</option>';
            if (data.jadwal && data.jadwal.length > 0) {
                data.jadwal.forEach(j => {
                    const opt   = document.createElement('option');
                    opt.value   = j.id;
                    // Akses via j.mata_pelajaran (snake_case hasil serialisasi Laravel)
                    const mapel = j.mata_pelajaran ? j.mata_pelajaran.nama_mapel : '—';
                    opt.textContent = mapel + ' ' + j.jam_mulai + '–' + j.jam_selesai;
                    if (String(j.id) === OLD_JADWAL_ID) opt.selected = true;
                    jadwalEl.appendChild(opt);
                });
                jadwalEl.disabled = false;
            } else {
                jadwalEl.innerHTML = '<option value="">Tidak ada jadwal hari ini</option>';
                jadwalEl.disabled  = false;
            }

            siswaHint.style.display  = 'none';
            jadwalHint.style.display = 'none';
        })
        .catch(err => {
            console.error('AJAX error:', err);
            siswaEl.innerHTML  = '<option value="">Gagal memuat siswa</option>';
            jadwalEl.innerHTML = '<option value="">Gagal memuat jadwal</option>';
            siswaEl.disabled   = false;
            jadwalEl.disabled  = false;
            siswaHint.style.display  = 'none';
            jadwalHint.style.display = 'none';
        });
    }

    function resetSiswa() {
        const el = document.getElementById('siswaSelect');
        el.innerHTML = '<option value="">— Pilih Kelas Dulu —</option>';
        el.disabled  = true;
    }
    function resetJadwal() {
        const el = document.getElementById('jadwalSelect');
        el.innerHTML = '<option value="">— Pilih Kelas &amp; Tanggal Dulu —</option>';
        el.disabled  = true;
    }

    // Init: jika ada old('kelas_id') setelah validation error, reload via AJAX
    const OLD_KELAS_ID = "{{ old('kelas_id') }}";
    const OLD_TANGGAL  = "{{ old('tanggal', date('Y-m-d')) }}";
    if (OLD_KELAS_ID) {
        loadSiswaJadwal(OLD_KELAS_ID, OLD_TANGGAL);
    }

    // Submit handler
    document.getElementById('absensiForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>