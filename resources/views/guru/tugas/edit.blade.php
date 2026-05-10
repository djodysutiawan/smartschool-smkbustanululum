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

    /* ── Layout ────────────────────────────────────────────────────────────── */
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* ── Buttons ───────────────────────────────────────────────────────────── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* ── Form Cards ────────────────────────────────────────────────────────── */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .form-card-body{padding:20px;display:grid;gap:16px}
    .grid-2{grid-template-columns:1fr 1fr}

    /* ── Fields ────────────────────────────────────────────────────────────── */
    .field{display:flex;flex-direction:column;gap:5px}
    .field.span-2{grid-column:span 2}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field label .hint{font-weight:400;color:var(--text3);margin-left:4px}
    .field input,.field select,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:100px}
    .field .error-msg{font-size:11.5px;color:#dc2626;margin-top:2px}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:#dc2626}

    /* ── Error banner ──────────────────────────────────────────────────────── */
    .error-banner{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;background:#fff0f0;border:1px solid #fecaca;border-radius:var(--radius-sm);margin-bottom:16px}
    .error-banner ul{margin:0;padding-left:16px;font-size:13px;color:#dc2626;font-family:'DM Sans',sans-serif}
    .error-banner ul li{margin-bottom:2px}

    /* ── Upload ────────────────────────────────────────────────────────────── */
    .upload-area{border:2px dashed var(--border2);border-radius:var(--radius-sm);padding:20px;text-align:center;background:var(--surface2);cursor:pointer;transition:border-color .15s}
    .upload-area:hover{border-color:var(--brand-500);background:#f8fbff}
    .upload-area-inner{pointer-events:none}
    .upload-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:3px}
    .upload-hint{font-size:12px;color:var(--text3)}
    .upload-filename{font-size:12.5px;color:var(--brand-600);margin-top:6px;font-weight:600;display:none}

    .existing-file{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:8px}
    .existing-file-icon{width:32px;height:32px;background:var(--brand-50);border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .existing-file-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .existing-file-hint{font-size:11.5px;color:var(--text3)}

    /* ── Jenis Pengumpulan ─────────────────────────────────────────────────── */
    .jenis-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
    .jenis-option{position:relative}
    .jenis-option input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .jenis-card{display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px 8px;border:2px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;background:var(--surface2);text-align:center}
    .jenis-card:hover{border-color:var(--brand-500);background:var(--brand-50)}
    .jenis-option input[type=radio]:checked + .jenis-card{border-color:var(--brand-500);background:var(--brand-50);box-shadow:0 0 0 3px var(--brand-100)}
    .jenis-card-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:var(--surface3)}
    .jenis-card-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}

    /* ── Toggle Switch ─────────────────────────────────────────────────────── */
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
        .grid-2{grid-template-columns:1fr}
        .field.span-2{grid-column:span 1}
        .jenis-grid{grid-template-columns:1fr 1fr}
    }
</style>

<div class="page">

    {{-- ── Header ─────────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Tugas</h1>
            <p class="page-sub">Perbarui informasi dan pengaturan tugas</p>
        </div>
        <a href="{{ route('guru.tugas.show', $tugas->id) }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- ── Error Banner ─────────────────────────────────────────────────── --}}
    @if($errors->any())
    <div class="error-banner">
        <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{--
        FIX: Gunakan @method('PUT') bukan @method('PATCH').
        Route::resource() Laravel mendaftarkan update dengan method PUT,
        bukan PATCH. Menggunakan PATCH menyebabkan MethodNotAllowedHttpException.
    --}}
    <form action="{{ route('guru.tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ── Informasi Tugas ────────────────────────────────────────────── --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                </svg>
                <span class="form-card-title">Informasi Tugas</span>
            </div>
            <div class="form-card-body grid-2">

                <div class="field span-2">
                    <label>Judul Tugas <span class="req">*</span></label>
                    <input type="text" name="judul"
                           value="{{ old('judul', $tugas->judul) }}"
                           placeholder="Masukkan judul tugas…"
                           maxlength="255"
                           class="{{ $errors->has('judul') ? 'is-invalid' : '' }}">
                    @error('judul')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Kelas <span class="req">*</span></label>
                    <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}"
                                {{ old('kelas_id', $tugas->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Mata Pelajaran <span class="req">*</span></label>
                    <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Mata Pelajaran —</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id }}"
                                {{ old('mata_pelajaran_id', $tugas->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Tahun Ajaran <span class="req">*</span></label>
                    <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Tahun Ajaran —</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}"
                                {{ old('tahun_ajaran_id', $tugas->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                {{ $ta->tahun }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_ajaran_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Batas Waktu <span class="req">*</span></label>
                    @php
                        $batasWaktuParsed = \Carbon\Carbon::parse($tugas->batas_waktu);
                        $batasWaktuValue  = old('batas_waktu', $batasWaktuParsed->format('Y-m-d') . 'T' . $batasWaktuParsed->format('H:i'));
                    @endphp
                    <input type="datetime-local" name="batas_waktu"
                           value="{{ $batasWaktuValue }}"
                           class="{{ $errors->has('batas_waktu') ? 'is-invalid' : '' }}">
                    @error('batas_waktu')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="field span-2">
                    <label>Deskripsi / Petunjuk <span class="hint">(opsional)</span></label>
                    <textarea name="deskripsi"
                              placeholder="Jelaskan instruksi pengerjaan tugas…"
                              class="{{ $errors->has('deskripsi') ? 'is-invalid' : '' }}">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                    @error('deskripsi')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>

        {{-- ── Jenis Pengumpulan ──────────────────────────────────────────── --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                <span class="form-card-title">Jenis Pengumpulan</span>
            </div>
            <div class="form-card-body">
                @error('jenis_pengumpulan')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
                <div class="jenis-grid">
                    @foreach($jenisPengumpulan as $j)
                    <label class="jenis-option">
                        <input type="radio" name="jenis_pengumpulan" value="{{ $j }}"
                               {{ old('jenis_pengumpulan', $tugas->jenis_pengumpulan) === $j ? 'checked' : '' }}>
                        <div class="jenis-card">
                            <div class="jenis-card-icon">
                                @if($j === 'file')
                                    <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                @elseif($j === 'teks')
                                    <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                @elseif($j === 'link')
                                    <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                @else
                                    <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                @endif
                            </div>
                            <span class="jenis-card-label">{{ strtoupper($j) }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── File Soal & Penilaian ──────────────────────────────────────── --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                </svg>
                <span class="form-card-title">File Soal &amp; Penilaian</span>
            </div>
            <div class="form-card-body grid-2">

                <div class="field span-2">
                    @if($tugas->path_file_soal)
                    <div class="existing-file">
                        <div class="existing-file-icon">
                            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div style="flex:1;overflow:hidden">
                            <p class="existing-file-name">{{ basename($tugas->path_file_soal) }}</p>
                            <p class="existing-file-hint">File soal saat ini — upload baru untuk mengganti</p>
                        </div>
                        <a href="{{ asset('storage/' . $tugas->path_file_soal) }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn btn-secondary"
                           style="padding:4px 10px;font-size:11.5px">
                            Lihat
                        </a>
                    </div>
                    @endif

                    <label>
                        {{ $tugas->path_file_soal ? 'Ganti File Soal' : 'Upload File Soal' }}
                        <span class="hint">opsional · PDF/DOC/PPT/XLS/ZIP · maks. 10MB</span>
                    </label>

                    <label class="upload-area" for="soalInput" style="display:block;cursor:pointer">
                        <div class="upload-area-inner">
                            <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="display:block;margin:0 auto 6px">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <p class="upload-label">Klik untuk pilih file</p>
                            <p class="upload-hint">atau drag &amp; drop ke sini</p>
                            <p id="soalLabel" class="upload-filename"></p>
                        </div>
                    </label>
                    <input type="file" name="path_file_soal" id="soalInput"
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar"
                           style="display:none"
                           onchange="showFileName(this, 'soalLabel')">
                    @error('path_file_soal')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Nilai Maksimal <span class="hint">(default: 100)</span></label>
                    <input type="number" name="nilai_maksimal"
                           value="{{ old('nilai_maksimal', $tugas->nilai_maksimal ?? 100) }}"
                           min="0" max="100" step="0.5"
                           class="{{ $errors->has('nilai_maksimal') ? 'is-invalid' : '' }}">
                    @error('nilai_maksimal')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>

        {{-- ── Pengaturan ─────────────────────────────────────────────────── --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
                </svg>
                <span class="form-card-title">Pengaturan</span>
            </div>
            <div class="form-card-body" style="gap:10px">
                <div class="toggle-row">
                    <div>
                        <p class="toggle-label">Izinkan Pengumpulan Terlambat</p>
                        <p class="toggle-sub">Siswa masih dapat mengumpulkan setelah batas waktu lewat</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="izinkan_terlambat" value="1"
                               {{ old('izinkan_terlambat', $tugas->izinkan_terlambat) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="toggle-row">
                    <div>
                        <p class="toggle-label">Publikasikan Tugas</p>
                        <p class="toggle-sub">Tugas akan terlihat oleh siswa jika diaktifkan</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="dipublikasikan" value="1"
                               {{ old('dipublikasikan', $tugas->dipublikasikan) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── Submit ─────────────────────────────────────────────────────── --}}
        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
            <a href="{{ route('guru.tugas.show', $tugas->id) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Perbarui Tugas
            </button>
        </div>

    </form>
</div>{{-- /page --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: @json(session('success')),
    timer: 2800, showConfirmButton: false,
    toast: true, position: 'top-end'
});
@endif

function showFileName(input, labelId) {
    const lbl = document.getElementById(labelId);
    if (input.files && input.files[0]) {
        lbl.textContent = input.files[0].name;
        lbl.style.display = 'block';
    }
}
</script>
</x-app-layout>