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
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center}
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--text3)}
    .breadcrumb a{color:var(--text3);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}
    .breadcrumb a:hover{color:var(--text)}
    .breadcrumb-current{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text2)}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .form-layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .form-grid.col3{grid-template-columns:1fr 1fr 1fr}
    .form-grid.col1{grid-template-columns:1fr}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field select,.field input[type=text],.field input[type=date],.field input[type=number],.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:100px}
    .field-hint{font-size:11.5px;color:var(--text3)}

    .char-counter{font-size:11px;color:var(--text3);text-align:right;margin-top:2px}

    .btn-submit-full{width:100%;height:40px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .15s}
    .btn-submit-full:hover{background:var(--brand-700)}

    .info-box{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:var(--brand-700);line-height:1.6}

    @media(max-width:900px){.form-layout{grid-template-columns:1fr}.form-grid{grid-template-columns:1fr}.form-grid.col3{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('guru.jurnal-mengajar.index') }}">Jurnal Mengajar</a>
        <span>›</span>
        <span class="breadcrumb-current">Tambah Jurnal</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Jurnal Mengajar</h1>
            <p class="page-sub">Catat kegiatan mengajar hari ini</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.jurnal-mengajar.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('guru.jurnal-mengajar.store') }}" method="POST">
        @csrf
        <div class="form-layout">

            <div>
                {{-- Identitas --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span class="card-title">Identitas Kelas</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">
                            <div class="field">
                                <label>Kelas <span class="req">*</span></label>
                                <select name="kelas_id" required>
                                    <option value="">— Pilih Kelas —</option>
                                    @foreach($kelasList as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Mata Pelajaran <span class="req">*</span></label>
                                <select name="mata_pelajaran_id" required>
                                    <option value="">— Pilih Mapel —</option>
                                    @foreach($mapelList as $m)
                                        <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Jadwal Pelajaran</label>
                                <select name="jadwal_pelajaran_id">
                                    <option value="">— Pilih Jadwal (Opsional) —</option>
                                    @foreach($jadwalList as $jd)
                                        <option value="{{ $jd->id }}" {{ old('jadwal_pelajaran_id') == $jd->id ? 'selected' : '' }}>
                                            {{ ucfirst($jd->hari) }} – {{ $jd->kelas->nama_kelas ?? '' }} – {{ $jd->mataPelajaran->nama_mapel ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="field-hint">Opsional — hubungkan dengan jadwal</span>
                            </div>
                            <div class="field">
                                <label>Tanggal <span class="req">*</span></label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                                <span class="field-hint">Tidak boleh lebih dari hari ini</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kegiatan --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <span class="card-title">Kegiatan Mengajar</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid" style="margin-bottom:14px">
                            <div class="field">
                                <label>Pertemuan Ke-</label>
                                <input type="number" name="pertemuan_ke" value="{{ old('pertemuan_ke') }}" min="1" max="52" placeholder="1–52">
                                <span class="field-hint">Opsional</span>
                            </div>
                            <div class="field">
                                <label>Metode Pembelajaran</label>
                                <select name="metode_pembelajaran">
                                    <option value="">— Pilih Metode —</option>
                                    @foreach($metodeList as $mt)
                                        <option value="{{ $mt }}" {{ old('metode_pembelajaran') === $mt ? 'selected' : '' }}>{{ ucfirst($mt) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="field" style="margin-bottom:14px">
                            <label>Materi Ajar <span class="req">*</span></label>
                            <textarea name="materi_ajar" id="materiAjar" required maxlength="2000"
                                oninput="countChar('materiAjar','charMateri')"
                                placeholder="Deskripsikan materi yang diajarkan...">{{ old('materi_ajar') }}</textarea>
                            <span class="char-counter" id="charMateri">0 / 2000</span>
                        </div>
                        <div class="field">
                            <label>Catatan Kelas</label>
                            <textarea name="catatan_kelas" id="catatanKelas" maxlength="2000"
                                oninput="countChar('catatanKelas','charCatatan')"
                                placeholder="Catatan tambahan, kejadian khusus, PR, dsb...">{{ old('catatan_kelas') }}</textarea>
                            <span class="char-counter" id="charCatatan">0 / 2000</span>
                        </div>
                    </div>
                </div>

                {{-- Kehadiran --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        <span class="card-title">Rekap Kehadiran (Opsional)</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">
                            <div class="field">
                                <label>Jumlah Hadir</label>
                                <input type="number" name="jumlah_hadir" value="{{ old('jumlah_hadir') }}" min="0" placeholder="0">
                            </div>
                            <div class="field">
                                <label>Jumlah Tidak Hadir</label>
                                <input type="number" name="jumlah_tidak_hadir" value="{{ old('jumlah_tidak_hadir') }}" min="0" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                        <span class="card-title">Simpan Jurnal</span>
                    </div>
                    <div class="card-body" style="padding:16px">
                        <button type="submit" class="btn-submit-full" style="margin-bottom:8px">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Jurnal
                        </button>
                        <a href="{{ route('guru.jurnal-mengajar.index') }}" class="btn btn-secondary" style="width:100%;justify-content:center">Batal</a>
                    </div>
                </div>

                <div class="card" style="background:var(--brand-50);border-color:var(--brand-100)">
                    <div class="card-body" style="padding:14px">
                        <div class="info-box" style="background:none;border:none;padding:0">
                            <p style="font-weight:800;margin-bottom:6px">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:-1px;margin-right:4px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                Informasi
                            </p>
                            <p>Jurnal yang sudah diverifikasi oleh admin tidak dapat diubah atau dihapus. Pastikan isian sudah benar sebelum disimpan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

function countChar(inputId, counterId) {
    const el = document.getElementById(inputId);
    document.getElementById(counterId).textContent = el.value.length + ' / 2000';
}
/* init */
countChar('materiAjar', 'charMateri');
countChar('catatanKelas', 'charCatatan');
</script>
</x-app-layout>