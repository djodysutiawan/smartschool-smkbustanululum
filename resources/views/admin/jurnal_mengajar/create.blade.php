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
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}
    .breadcrumb a:hover{color:var(--brand)}
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
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border)}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:680px){.page{padding:16px 16px 40px}.form-grid,.form-grid-3{grid-template-columns:1fr}.col-span-2,.col-span-3{grid-column:span 1}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.jurnal-mengajar.index') }}">Jurnal Mengajar</a>
        <span class="sep">›</span>
        <span class="current">Tambah Jurnal</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Jurnal Mengajar</h1>
            <p class="page-sub">Isi data aktivitas mengajar guru hari ini</p>
        </div>
        <a href="{{ route('admin.jurnal-mengajar.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="alert">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Terdapat {{ $errors->count() }} kesalahan:</strong>
            <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.jurnal-mengajar.store') }}" method="POST" id="jurnalForm">
        @csrf
        <div class="form-card">
            {{-- DATA UTAMA --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Informasi Mengajar
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Guru <span class="req">*</span></label>
                        <select name="guru_id" class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Mata Pelajaran <span class="req">*</span></label>
                        <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Mapel —</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
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
                        <label>Jadwal Pelajaran</label>
                        <select name="jadwal_pelajaran_id" class="{{ $errors->has('jadwal_pelajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Jadwal (opsional) —</option>
                            @foreach($jadwalList as $jd)
                                <option value="{{ $jd->id }}" {{ old('jadwal_pelajaran_id') == $jd->id ? 'selected' : '' }}>
                                    {{ $jd->kelas->nama_kelas ?? '' }} — {{ $jd->mataPelajaran->nama_mapel ?? '' }} ({{ ucfirst($jd->hari) }})
                                </option>
                            @endforeach
                        </select>
                        @error('jadwal_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}">
                        @error('tanggal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Pertemuan Ke-</label>
                        <input type="number" name="pertemuan_ke" value="{{ old('pertemuan_ke') }}" placeholder="cth. 5" min="1" class="{{ $errors->has('pertemuan_ke') ? 'is-invalid' : '' }}">
                        @error('pertemuan_ke')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Metode Pembelajaran</label>
                        <select name="metode_pembelajaran" class="{{ $errors->has('metode_pembelajaran') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Metode —</option>
                            @foreach($metodeList as $mt)
                                <option value="{{ $mt }}" {{ old('metode_pembelajaran') == $mt ? 'selected' : '' }}>{{ ucfirst($mt) }}</option>
                            @endforeach
                        </select>
                        @error('metode_pembelajaran')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field"></div>
                    <div class="field col-span-2">
                        <label>Materi Ajar <span class="req">*</span></label>
                        <textarea name="materi_ajar" rows="3" placeholder="Tuliskan materi yang diajarkan hari ini..." class="{{ $errors->has('materi_ajar') ? 'is-invalid' : '' }}">{{ old('materi_ajar') }}</textarea>
                        @error('materi_ajar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- KEHADIRAN --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Data Kehadiran Siswa
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Jumlah Hadir</label>
                        <input type="number" name="jumlah_hadir" value="{{ old('jumlah_hadir') }}" placeholder="cth. 30" min="0" class="{{ $errors->has('jumlah_hadir') ? 'is-invalid' : '' }}">
                        @error('jumlah_hadir')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jumlah Tidak Hadir</label>
                        <input type="number" name="jumlah_tidak_hadir" value="{{ old('jumlah_tidak_hadir') }}" placeholder="cth. 2" min="0" class="{{ $errors->has('jumlah_tidak_hadir') ? 'is-invalid' : '' }}">
                        @error('jumlah_tidak_hadir')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Catatan Kelas</label>
                        <textarea name="catatan_kelas" rows="3" placeholder="Catatan situasi kelas, kendala, atau hal penting lainnya...">{{ old('catatan_kelas') }}</textarea>
                        @error('catatan_kelas')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.jurnal-mengajar.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Jurnal
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor:'#1f63db',
    });
    @endif
    document.getElementById('jurnalForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>