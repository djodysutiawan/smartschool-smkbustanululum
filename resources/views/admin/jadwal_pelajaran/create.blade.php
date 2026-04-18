<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3)}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-cancel:hover{background:var(--surface3)}
    .btn-primary{background:var(--brand);color:#fff}.btn-primary:hover{filter:brightness(.93)}.btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .form-section{padding:20px 24px 24px}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px}
    .section-label-line{flex:1;height:1px;background:var(--border)}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .col-span-2{grid-column:span 2}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand);margin-left:2px}
    .field input,.field select{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s}
    .field input:focus,.field select:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field input::placeholder{color:var(--text3)}
    .field input.is-invalid,.field select.is-invalid{border-color:var(--red);background:#fff8f8}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .toggle-row{display:flex;align-items:center;gap:12px}
    .toggle-switch{position:relative;display:inline-block;width:42px;height:24px}
    .toggle-switch input{opacity:0;width:0;height:0}
    .toggle-slider{position:absolute;inset:0;border-radius:99px;background:var(--border2);cursor:pointer;transition:background .2s}
    .toggle-slider::before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
    .toggle-switch input:checked + .toggle-slider{background:var(--brand)}
    .toggle-switch input:checked + .toggle-slider::before{transform:translateX(18px)}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2)}
    .conflict-hint{display:none;padding:10px 14px;border-radius:var(--radius-sm);background:#fff7ed;border:1px solid #fed7aa;color:#c2410c;font-size:13px;font-family:'DM Sans',sans-serif;margin-top:8px}
    .conflict-hint.show{display:block}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border)}
    @media(max-width:680px){.page{padding:16px 16px 40px}.form-grid{grid-template-columns:1fr}.col-span-2{grid-column:span 1}}
    @keyframes spin{to{transform:rotate(360deg)}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.jadwal-pelajaran.index') }}">Jadwal Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah Jadwal</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Jadwal Pelajaran</h1>
            <p class="page-sub">Isi semua data jadwal dengan benar, perhatikan konflik jam guru</p>
        </div>
        <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.jadwal-pelajaran.store') }}" method="POST" id="formJP">
        @csrf
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Informasi Jadwal
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }}</option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Mata Pelajaran <span class="req">*</span></label>
                        <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Mata Pelajaran —</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Guru <span class="req">*</span></label>
                        <select name="guru_id" id="guruSelect" class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Ruang</label>
                        <select name="ruang_id" class="{{ $errors->has('ruang_id') ? 'is-invalid' : '' }}">
                            <option value="">— Tanpa Ruang —</option>
                            @foreach($ruangList as $r)
                                <option value="{{ $r->id }}" {{ old('ruang_id') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruang }}</option>
                            @endforeach
                        </select>
                        @error('ruang_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Hari <span class="req">*</span></label>
                        <select name="hari" id="hariSelect" class="{{ $errors->has('hari') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Hari —</option>
                            @foreach($hariList as $h)
                                <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                            @endforeach
                        </select>
                        @error('hari')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jam Mulai <span class="req">*</span></label>
                        <input type="time" name="jam_mulai" id="jamMulai" value="{{ old('jam_mulai') }}" class="{{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}">
                        @error('jam_mulai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jam Selesai <span class="req">*</span></label>
                        <input type="time" name="jam_selesai" id="jamSelesai" value="{{ old('jam_selesai') }}" class="{{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}">
                        @error('jam_selesai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Pertemuan Ke</label>
                        <input type="number" name="pertemuan_ke" value="{{ old('pertemuan_ke') }}" placeholder="cth. 1" min="1" class="{{ $errors->has('pertemuan_ke') ? 'is-invalid' : '' }}">
                        @error('pertemuan_ke')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Sumber Jadwal</label>
                        <select name="sumber_jadwal" class="{{ $errors->has('sumber_jadwal') ? 'is-invalid' : '' }}">
                            <option value="manual" {{ old('sumber_jadwal', 'manual') == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="otomatis" {{ old('sumber_jadwal') == 'otomatis' ? 'selected' : '' }}>Otomatis</option>
                        </select>
                        @error('sumber_jadwal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Status Aktif</label>
                        <div class="toggle-row" style="margin-top:4px">
                            <input type="hidden" name="is_active" value="0">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" id="isActiveToggle" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">{{ old('is_active', '1') == '1' ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                    </div>
                </div>
                <div class="conflict-hint" id="conflictHint">
                    ⚠️ Perhatian: Pastikan guru dan kelas tidak memiliki jadwal lain pada hari dan jam ini. Sistem akan memvalidasi saat disimpan.
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Jadwal
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('error'))
    Swal.fire({icon:'error',title:'Bentrok Jadwal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
    @if($errors->any())
    Swal.fire({icon:'error',title:'Terdapat Kesalahan',html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,confirmButtonColor:'#1f63db'});
    @endif

    document.getElementById('isActiveToggle').addEventListener('change', function() {
        document.getElementById('toggleLabel').textContent = this.checked ? 'Aktif' : 'Nonaktif';
    });

    function checkConflictHint() {
        const guru = document.getElementById('guruSelect').value;
        const hari = document.getElementById('hariSelect').value;
        const jam  = document.getElementById('jamMulai').value;
        document.getElementById('conflictHint').classList.toggle('show', !!(guru && hari && jam));
    }
    ['guruSelect','hariSelect','jamMulai'].forEach(id => {
        document.getElementById(id).addEventListener('change', checkConflictHint);
    });

    document.getElementById('formJP').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>