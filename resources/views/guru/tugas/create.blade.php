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
    .page{padding:28px 28px 40px;max-width:2000px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .form-card-body{padding:20px;display:grid;gap:16px}
    .grid-2{grid-template-columns:1fr 1fr}
    .grid-3{grid-template-columns:1fr 1fr 1fr}

    .field{display:flex;flex-direction:column;gap:5px}
    .field.span-2{grid-column:span 2}
    .field.span-3{grid-column:span 3}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field label .hint{font-weight:400;color:var(--text3);margin-left:4px}
    .field input,.field select,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:100px}
    .field .error{font-size:11.5px;color:#dc2626;margin-top:2px}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:#dc2626}

    .upload-area{border:2px dashed var(--border2);border-radius:var(--radius-sm);padding:20px;text-align:center;background:var(--surface2);cursor:pointer;transition:border-color .15s;position:relative}
    .upload-area:hover{border-color:var(--brand-500);background:#f8fbff}
    .upload-area input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
    .upload-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:3px}
    .upload-hint{font-size:12px;color:var(--text3)}
    .upload-filename{font-size:12.5px;color:var(--brand-600);margin-top:6px;font-weight:600;display:none}

    .jenis-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
    .jenis-option{position:relative}
    .jenis-option input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .jenis-card{display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px 8px;border:2px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;background:var(--surface2);text-align:center}
    .jenis-card:hover{border-color:var(--brand-500);background:var(--brand-50)}
    .jenis-option input[type=radio]:checked + .jenis-card{border-color:var(--brand-500);background:var(--brand-50);box-shadow:0 0 0 3px var(--brand-100)}
    .jenis-card-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:var(--surface3)}
    .jenis-card-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}

    .toggle-row{display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:var(--surface2);border-radius:var(--radius-sm);border:1px solid var(--border)}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .toggle-sub{font-size:11.5px;color:var(--text3);margin-top:1px}
    .toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
    .toggle-switch input{opacity:0;width:0;height:0;position:absolute}
    .toggle-slider{position:absolute;inset:0;background:#cbd5e1;border-radius:999px;cursor:pointer;transition:.2s}
    .toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.2s}
    .toggle-switch input:checked + .toggle-slider{background:var(--brand-500)}
    .toggle-switch input:checked + .toggle-slider::before{transform:translateX(18px)}

    @media(max-width:640px){
        .page{padding:16px}
        .grid-2,.grid-3{grid-template-columns:1fr}
        .field.span-2,.field.span-3{grid-column:span 1}
        .jenis-grid{grid-template-columns:1fr 1fr}
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Tugas Baru</h1>
            <p class="page-sub">Buat tugas dan tetapkan batas waktu pengumpulan</p>
        </div>
        <a href="{{ route('guru.tugas.index') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informasi Tugas --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                <span class="form-card-title">Informasi Tugas</span>
            </div>
            <div class="form-card-body grid-2">
                <div class="field span-2">
                    <label>Judul Tugas <span class="req">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Latihan Soal Bab 3 — Persamaan Linear"
                           class="{{ $errors->has('judul') ? 'is-invalid' : '' }}">
                    @error('judul')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Kelas <span class="req">*</span></label>
                    <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Mata Pelajaran <span class="req">*</span></label>
                    <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Mata Pelajaran —</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Tahun Ajaran <span class="req">*</span></label>
                    <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Tahun Ajaran —</option>
                        @foreach($tahunAjaran as $t)
                            <option value="{{ $t->id }}" {{ old('tahun_ajaran_id') == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                    @error('tahun_ajaran_id')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Batas Waktu <span class="req">*</span></label>
                    <input type="datetime-local" name="batas_waktu" value="{{ old('batas_waktu') }}"
                           class="{{ $errors->has('batas_waktu') ? 'is-invalid' : '' }}">
                    @error('batas_waktu')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field span-2">
                    <label>Deskripsi / Petunjuk <span class="hint">(opsional)</span></label>
                    <textarea name="deskripsi" placeholder="Jelaskan instruksi pengerjaan tugas…">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Jenis Pengumpulan --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span class="form-card-title">Jenis Pengumpulan</span>
            </div>
            <div class="form-card-body">
                <div class="jenis-grid">
                    @php $jpIcons = ['file'=>['#1d4ed8','M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'],
                                     'teks'=>['#15803d','M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7 M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'],
                                     'link'=>['#a16207','M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71 M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71'],
                                     'foto'=>['#7c3aed','M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z M12 17a4 4 0 1 0 0-8 4 4 0 0 0 0 8z']] @endphp
                    @foreach($jenisPengumpulan as $j)
                    <label class="jenis-option">
                        <input type="radio" name="jenis_pengumpulan" value="{{ $j }}"
                               {{ old('jenis_pengumpulan', 'file') === $j ? 'checked' : '' }}>
                        <div class="jenis-card">
                            <div class="jenis-card-icon">
                                <svg width="16" height="16" fill="none" stroke="{{ $jpIcons[$j][0] }}" stroke-width="2" viewBox="0 0 24 24">
                                    @if($j==='file')<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                                    @elseif($j==='teks')<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    @elseif($j==='link')<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                    @else<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>@endif
                                </svg>
                            </div>
                            <span class="jenis-card-label">{{ strtoupper($j) }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('jenis_pengumpulan')<span class="error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- File Soal & Penilaian --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                <span class="form-card-title">File Soal & Penilaian</span>
            </div>
            <div class="form-card-body grid-2">
                <div class="field span-2">
                    <label>Upload File Soal <span class="hint">opsional · maks. 10MB</span></label>
                    <div class="upload-area" onclick="document.getElementById('soalInput').click()">
                        <input type="file" name="path_file_soal" id="soalInput" onchange="showFileName(this,'soalLabel')">
                        <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 6px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <p class="upload-label">Klik untuk pilih file soal</p>
                        <p class="upload-hint">PDF, DOC, DOCX, dst.</p>
                        <p id="soalLabel" class="upload-filename"></p>
                    </div>
                    @error('path_file_soal')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Nilai Maksimal <span class="hint">default 100</span></label>
                    <input type="number" name="nilai_maksimal" value="{{ old('nilai_maksimal', 100) }}" min="0" max="100" step="0.5">
                    @error('nilai_maksimal')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Pengaturan --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                <span class="form-card-title">Pengaturan</span>
            </div>
            <div class="form-card-body" style="gap:10px">
                <div class="toggle-row">
                    <div>
                        <p class="toggle-label">Izinkan Pengumpulan Terlambat</p>
                        <p class="toggle-sub">Siswa masih dapat mengumpulkan setelah batas waktu lewat</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="izinkan_terlambat" value="1" {{ old('izinkan_terlambat') ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="toggle-row">
                    <div>
                        <p class="toggle-label">Publikasikan Sekarang</p>
                        <p class="toggle-sub">Tugas akan langsung terlihat oleh siswa setelah disimpan</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="dipublikasikan" value="1" {{ old('dipublikasikan') ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
            <a href="{{ route('guru.tugas.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Tugas
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

function showFileName(input, labelId) {
    const lbl = document.getElementById(labelId);
    if (input.files[0]) { lbl.textContent = input.files[0].name; lbl.style.display = 'block'; }
}
</script>
</x-app-layout>