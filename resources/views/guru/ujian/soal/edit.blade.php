<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --green:#15803d;--red:#dc2626;--purple:#7c3aed;--yellow:#a16207;
    --radius:10px;--radius-sm:7px;
}
*{box-sizing:border-box}
.page{padding:28px 28px 48px;max-width:900px;margin:0 auto}

/* Breadcrumb */
.breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;flex-wrap:wrap}
.breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}
.breadcrumb a:hover{color:var(--text)}
.breadcrumb .sep{color:var(--border2)}
.breadcrumb .cur{color:var(--text2)}

/* Header */
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

/* Buttons */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
.btn:hover{filter:brightness(.93)}
.btn-primary{background:var(--brand-600);color:#fff}
.btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
.btn-secondary:hover{background:var(--surface3);filter:none}

/* Alert */
.alert-warn{background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start}
.alert-warn p{font-size:12.5px;color:#92400e;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;line-height:1.5}

/* Card */
.form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
.form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:10px}
.form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
.form-card-body{padding:20px}

/* Form fields */
.field{margin-bottom:18px}
.field:last-child{margin-bottom:0}
.field label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em}
.field label .req{color:var(--red);margin-left:2px}
.field input[type=text],
.field input[type=number],
.field select,
.field textarea{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s}
.field input[type=text]:focus,
.field input[type=number]:focus,
.field select:focus,
.field textarea:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.12)}
.field textarea{resize:vertical;min-height:90px;line-height:1.6}
.field .hint{font-size:11.5px;color:var(--text3);margin-top:5px;font-family:'DM Sans',sans-serif}
.field .err{font-size:12px;color:var(--red);margin-top:4px;font-family:'DM Sans',sans-serif;font-weight:500}

/* Row split */
.row-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}

/* Jenis pill selector */
.jenis-options{display:flex;gap:8px;flex-wrap:wrap}
.jenis-option{position:relative}
.jenis-option input[type=radio]{position:absolute;opacity:0;width:0;height:0}
.jenis-option label{display:flex;align-items:center;gap:7px;padding:8px 16px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2);cursor:pointer;transition:all .15s;background:var(--surface)}
.jenis-option input[type=radio]:checked + label{border-color:var(--brand-500);background:var(--brand-50);color:var(--brand-700)}
.jenis-option label:hover{background:var(--surface2)}

/* Gambar preview */
.img-preview-wrap{margin-top:10px;display:flex;align-items:flex-start;gap:10px;flex-wrap:wrap}
.img-preview{max-width:180px;max-height:120px;border-radius:var(--radius-sm);border:1px solid var(--border);object-fit:cover}
.img-del-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 11px;border-radius:6px;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;cursor:pointer;background:#fff0f0;color:var(--red);border:1px solid #fecaca;transition:background .15s}
.img-del-btn:hover{background:#fee2e2}
.img-del-label{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);margin-top:5px}

/* Pilihan section */
.pilihan-list{display:flex;flex-direction:column;gap:10px}
.pilihan-row{border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;background:var(--surface);transition:border-color .15s}
.pilihan-row.is-benar{border-color:#86efac;background:#f0fdf4}
.pilihan-row-top{display:flex;align-items:center;gap:10px}
.pilihan-kode{width:36px;height:36px;border-radius:8px;background:var(--surface2);border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text2);flex-shrink:0}
.pilihan-row.is-benar .pilihan-kode{background:#dcfce7;border-color:#86efac;color:var(--green)}
.pilihan-input{flex:1;padding:7px 10px;border:1.5px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s}
.pilihan-input:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.12)}
.pilihan-row.is-benar .pilihan-input{border-color:#86efac;background:#f0fdf4}
.benar-toggle{display:flex;align-items:center;gap:5px;cursor:pointer;padding:5px 10px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);border:1.5px solid var(--border);background:var(--surface);transition:all .15s;white-space:nowrap;user-select:none}
.benar-toggle:hover{background:var(--surface2)}
.benar-toggle.active{background:#dcfce7;color:var(--green);border-color:#86efac}
.benar-toggle input[type=checkbox]{display:none}
.hapus-pilihan{width:30px;height:30px;border-radius:6px;border:1.5px solid var(--border);background:var(--surface);color:var(--text3);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s;flex-shrink:0}
.hapus-pilihan:hover{background:#fee2e2;border-color:#fecaca;color:var(--red)}

/* Tambah pilihan btn */
.btn-add-pilihan{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border:1.5px dashed var(--border2);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);cursor:pointer;background:transparent;transition:all .15s;margin-top:10px}
.btn-add-pilihan:hover{border-color:var(--brand-500);color:var(--brand-600);background:var(--brand-50)}

/* Footer actions */
.form-footer{display:flex;align-items:center;justify-content:flex-end;gap:8px;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}

/* Checkbox toggle */
.switch-wrap{display:flex;align-items:center;gap:8px;cursor:pointer;user-select:none}
.switch-wrap input{display:none}
.switch{width:36px;height:20px;background:var(--border2);border-radius:99px;position:relative;transition:background .2s;flex-shrink:0}
.switch::after{content:'';position:absolute;width:14px;height:14px;background:#fff;border-radius:99px;top:3px;left:3px;transition:left .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
.switch-wrap input:checked ~ .switch{background:var(--brand-500)}
.switch-wrap input:checked ~ .switch::after{left:19px}
.switch-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2)}

@media(max-width:600px){
    .row-2,.row-3{grid-template-columns:1fr}
    .page{padding:16px}
}
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('guru.ujian.index') }}">Kelola Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('guru.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 35) }}</a>
        <span class="sep">›</span>
        <a href="{{ route('guru.ujian.soal.index', $ujian) }}">Bank Soal</a>
        <span class="sep">›</span>
        <span class="cur">Edit Soal #{{ $soal->nomor_soal }}</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Soal</h1>
            <p class="page-sub">{{ $ujian->judul }} &middot; Soal No. {{ $soal->nomor_soal }}</p>
        </div>
        <a href="{{ route('guru.ujian.soal.index', $ujian) }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Warning jawaban siswa --}}
    @if($adaJawaban)
    <div class="alert-warn">
        <svg width="16" height="16" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <p>Sudah ada siswa yang menjawab soal ini. Mengubah pertanyaan atau jawaban dapat mempengaruhi penilaian yang sudah ada.</p>
    </div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="alert-warn" style="background:#fff0f0;border-color:#fecaca;">
        <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            @foreach($errors->all() as $err)
            <p style="color:var(--red)">{{ $err }}</p>
            @endforeach
        </div>
    </div>
    @endif

    <form action="{{ route('guru.ujian.soal.update', [$ujian, $soal]) }}" method="POST" enctype="multipart/form-data" id="editSoalForm">
        @csrf
        @method('PUT')

        {{-- ── Informasi Dasar ─────────────────────────────────────────────── --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                <span class="form-card-title">Informasi Soal</span>
            </div>
            <div class="form-card-body">
                <div class="row-2" style="margin-bottom:18px">
                    {{-- Nomor Soal --}}
                    <div class="field" style="margin-bottom:0">
                        <label>Nomor Soal <span class="req">*</span></label>
                        <input type="number" name="nomor_soal" min="1"
                               value="{{ old('nomor_soal', $soal->nomor_soal) }}"
                               style="max-width:120px">
                        @error('nomor_soal')<p class="err">{{ $message }}</p>@enderror
                    </div>
                    {{-- Bobot --}}
                    <div class="field" style="margin-bottom:0">
                        <label>Bobot / Poin <span class="req">*</span></label>
                        <input type="number" name="bobot" min="1" max="100"
                               value="{{ old('bobot', $soal->bobot) }}"
                               placeholder="mis. 10"
                               style="max-width:120px">
                        @error('bobot')<p class="err">{{ $message }}</p>@enderror
                        <p class="hint">Total bobot semua soal sebaiknya = 100</p>
                    </div>
                </div>

                {{-- Jenis Soal --}}
                <div class="field">
                    <label>Jenis Soal <span class="req">*</span></label>
                    <div class="jenis-options">
                        @php $jenisSoal = old('jenis_soal', $soal->jenis_soal); @endphp

                        <div class="jenis-option">
                            <input type="radio" name="jenis_soal" id="jenis_pg" value="pilihan_ganda"
                                   {{ $jenisSoal === 'pilihan_ganda' ? 'checked' : '' }}>
                            <label for="jenis_pg">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                                Pilihan Ganda
                            </label>
                        </div>

                        <div class="jenis-option">
                            <input type="radio" name="jenis_soal" id="jenis_bs" value="benar_salah"
                                   {{ $jenisSoal === 'benar_salah' ? 'checked' : '' }}>
                            <label for="jenis_bs">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Benar / Salah
                            </label>
                        </div>

                        <div class="jenis-option">
                            <input type="radio" name="jenis_soal" id="jenis_essay" value="essay"
                                   {{ $jenisSoal === 'essay' ? 'checked' : '' }}>
                            <label for="jenis_essay">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                                Essay
                            </label>
                        </div>
                    </div>
                    @error('jenis_soal')<p class="err">{{ $message }}</p>@enderror
                </div>

                {{-- Pertanyaan --}}
                <div class="field">
                    <label>Teks Pertanyaan <span class="req">*</span></label>
                    <textarea name="pertanyaan" rows="4" placeholder="Tulis pertanyaan di sini…">{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                    @error('pertanyaan')<p class="err">{{ $message }}</p>@enderror
                </div>

                {{-- Gambar Soal --}}
                <div class="field">
                    <label>Gambar Soal <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--text3)">(opsional)</span></label>

                    @if($soal->gambar_soal)
                    <div class="img-preview-wrap" id="currentImgWrap">
                        <div>
                            <p class="img-del-label" style="margin-bottom:6px">Gambar saat ini:</p>
                            <img src="{{ Storage::url($soal->gambar_soal) }}" alt="Gambar soal" class="img-preview" id="currentImg">
                        </div>
                        <div style="display:flex;flex-direction:column;gap:6px;justify-content:flex-end">
                            <label class="switch-wrap" id="hapusGambarToggle">
                                <input type="checkbox" name="hapus_gambar" value="1" id="hapusGambarCb"
                                       {{ old('hapus_gambar') ? 'checked' : '' }}>
                                <div class="switch"></div>
                                <span class="switch-label" style="color:var(--red);font-size:12px">Hapus gambar ini</span>
                            </label>
                        </div>
                    </div>
                    <p class="hint" style="margin-top:8px">Upload gambar baru di bawah untuk <strong>mengganti</strong> gambar yang ada.</p>
                    @endif

                    <input type="file" name="gambar_soal" accept="image/jpeg,image/png,image/webp"
                           id="gambarSoalInput" style="margin-top:8px;font-size:13px">
                    <p class="hint">Format: JPG, PNG, WEBP. Maks. 2 MB.</p>
                    @error('gambar_soal')<p class="err">{{ $message }}</p>@enderror

                    {{-- New image preview --}}
                    <div id="newImgPreviewWrap" style="display:none;margin-top:8px">
                        <p class="img-del-label" style="margin-bottom:6px">Pratinjau gambar baru:</p>
                        <img id="newImgPreview" class="img-preview" alt="Pratinjau">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Pilihan Jawaban ─────────────────────────────────────────────── --}}
        <div class="form-card" id="pilihanSection">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--green)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span class="form-card-title">Pilihan Jawaban</span>
                <span id="pilihanHint" style="margin-left:auto;font-size:11.5px;font-family:'DM Sans',sans-serif;color:var(--text3)"></span>
            </div>
            <div class="form-card-body">
                <div class="pilihan-list" id="pilihanList">
                    @php
                        $pilihanLama = old('pilihan') ?? $soal->pilihan->map(fn($p) => [
                            'kode_pilihan' => $p->kode_pilihan,
                            'teks_pilihan' => $p->teks_pilihan,
                            'adalah_benar' => $p->adalah_benar,
                        ])->toArray();
                    @endphp

                    @foreach($pilihanLama as $idx => $p)
                    <div class="pilihan-row {{ ($p['adalah_benar'] ?? false) ? 'is-benar' : '' }}" data-idx="{{ $idx }}">
                        <div class="pilihan-row-top">
                            <div class="pilihan-kode">{{ strtoupper($p['kode_pilihan']) }}</div>
                            <input type="hidden" name="pilihan[{{ $idx }}][kode_pilihan]" value="{{ strtoupper($p['kode_pilihan']) }}">
                            <input type="text" class="pilihan-input"
                                   name="pilihan[{{ $idx }}][teks_pilihan]"
                                   value="{{ $p['teks_pilihan'] }}"
                                   placeholder="Teks pilihan {{ strtoupper($p['kode_pilihan']) }}…">
                            <label class="benar-toggle {{ ($p['adalah_benar'] ?? false) ? 'active' : '' }}">
                                <input type="checkbox" name="pilihan[{{ $idx }}][adalah_benar]" value="1"
                                       {{ ($p['adalah_benar'] ?? false) ? 'checked' : '' }}
                                       onchange="toggleBenar(this)">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Benar
                            </label>
                            <button type="button" class="hapus-pilihan" onclick="hapusPilihan(this)" title="Hapus pilihan ini">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="button" class="btn-add-pilihan" id="btnTambahPilihan" onclick="tambahPilihan()">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Pilihan
                </button>
            </div>
        </div>

        {{-- ── Essay Info ──────────────────────────────────────────────────── --}}
        <div class="form-card" id="essaySection" style="display:none">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--purple)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                <span class="form-card-title">Soal Essay</span>
            </div>
            <div class="form-card-body">
                <p style="font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6">
                    Soal essay tidak memiliki pilihan jawaban. Guru perlu mengoreksi jawaban siswa secara manual melalui menu <strong>Koreksi Essay</strong>.
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="form-card" style="overflow:hidden">
            <div class="form-footer">
                <a href="{{ route('guru.ujian.soal.index', $ujian) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ── Flash ────────────────────────────────────────────────────────────────────
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

// ── Jenis Soal Toggle ────────────────────────────────────────────────────────
const KODE = ['A','B','C','D','E'];
let pilihanIdx = document.querySelectorAll('#pilihanList .pilihan-row').length;

function syncJenis() {
    const jenis = document.querySelector('input[name="jenis_soal"]:checked')?.value;
    const pilihanSection = document.getElementById('pilihanSection');
    const essaySection   = document.getElementById('essaySection');
    const hintEl         = document.getElementById('pilihanHint');
    const btnTambah      = document.getElementById('btnTambahPilihan');

    if (jenis === 'essay') {
        pilihanSection.style.display = 'none';
        essaySection.style.display   = 'block';
    } else {
        pilihanSection.style.display = 'block';
        essaySection.style.display   = 'none';

        if (jenis === 'benar_salah') {
            hintEl.textContent = 'Pernyataan Benar dan Salah';
            btnTambah.style.display = 'none';
            // Pastikan hanya 2 pilihan (B & S)
            initBenaralah();
        } else {
            hintEl.textContent = 'Pilihan ganda — maks. 5';
            btnTambah.style.display = 'inline-flex';
        }
    }
}

function initBenaralah() {
    const list = document.getElementById('pilihanList');
    const existing = [...list.querySelectorAll('.pilihan-row')];

    // Jika belum ada / bukan B/S, rebuild
    const kodes = existing.map(r => r.querySelector('.pilihan-kode')?.textContent?.trim());
    if (existing.length !== 2 || !kodes.includes('B') || !kodes.includes('S')) {
        list.innerHTML = '';
        pilihanIdx = 0;
        buatRowBS('B', 'Benar', false);
        buatRowBS('S', 'Salah', false);
    }
}

function buatRowBS(kode, teks, benar) {
    const idx = pilihanIdx++;
    const row = document.createElement('div');
    row.className = 'pilihan-row' + (benar ? ' is-benar' : '');
    row.dataset.idx = idx;
    row.innerHTML = `
        <div class="pilihan-row-top">
            <div class="pilihan-kode">${kode}</div>
            <input type="hidden" name="pilihan[${idx}][kode_pilihan]" value="${kode}">
            <input type="text" class="pilihan-input" name="pilihan[${idx}][teks_pilihan]"
                   value="${teks}" placeholder="${teks}" readonly style="background:var(--surface2);cursor:default">
            <label class="benar-toggle${benar ? ' active' : ''}">
                <input type="checkbox" name="pilihan[${idx}][adalah_benar]" value="1"
                       ${benar ? 'checked' : ''} onchange="toggleBenar(this)">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Benar
            </label>
        </div>`;
    document.getElementById('pilihanList').appendChild(row);
}

function tambahPilihan() {
    const list  = document.getElementById('pilihanList');
    const rows  = list.querySelectorAll('.pilihan-row');
    if (rows.length >= 5) {
        Swal.fire({ icon:'warning', title:'Maks. 5 pilihan', text:'Pilihan ganda dibatasi 5 pilihan.', confirmButtonColor:'#1f63db' });
        return;
    }
    const kode  = KODE[rows.length] || String.fromCharCode(65 + rows.length);
    const idx   = pilihanIdx++;

    const row = document.createElement('div');
    row.className = 'pilihan-row';
    row.dataset.idx = idx;
    row.innerHTML = `
        <div class="pilihan-row-top">
            <div class="pilihan-kode">${kode}</div>
            <input type="hidden" name="pilihan[${idx}][kode_pilihan]" value="${kode}">
            <input type="text" class="pilihan-input" name="pilihan[${idx}][teks_pilihan]"
                   placeholder="Teks pilihan ${kode}…">
            <label class="benar-toggle">
                <input type="checkbox" name="pilihan[${idx}][adalah_benar]" value="1" onchange="toggleBenar(this)">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Benar
            </label>
            <button type="button" class="hapus-pilihan" onclick="hapusPilihan(this)" title="Hapus">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>`;
    list.appendChild(row);
}

function hapusPilihan(btn) {
    const row  = btn.closest('.pilihan-row');
    const list = document.getElementById('pilihanList');
    if (list.querySelectorAll('.pilihan-row').length <= 2) {
        Swal.fire({ icon:'warning', title:'Min. 2 pilihan', text:'Minimal harus ada 2 pilihan jawaban.', confirmButtonColor:'#1f63db' });
        return;
    }
    row.remove();
    renomorPilihan();
}

function renomorPilihan() {
    document.querySelectorAll('#pilihanList .pilihan-row').forEach((row, i) => {
        row.querySelector('.pilihan-kode').textContent = KODE[i] || String.fromCharCode(65 + i);
        row.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/pilihan\[\d+\]/, `pilihan[${i}]`);
        });
    });
}

function toggleBenar(cb) {
    const label = cb.closest('.benar-toggle');
    const row   = cb.closest('.pilihan-row');
    const jenis = document.querySelector('input[name="jenis_soal"]:checked')?.value;

    // PG: hanya 1 jawaban benar
    if (jenis === 'pilihan_ganda' && cb.checked) {
        document.querySelectorAll('#pilihanList input[type=checkbox]').forEach(c => {
            if (c !== cb) {
                c.checked = false;
                c.closest('.benar-toggle').classList.remove('active');
                c.closest('.pilihan-row').classList.remove('is-benar');
            }
        });
    }

    label.classList.toggle('active', cb.checked);
    row.classList.toggle('is-benar', cb.checked);
}

// ── Gambar soal preview ───────────────────────────────────────────────────────
document.getElementById('gambarSoalInput')?.addEventListener('change', function () {
    const file = this.files[0];
    const wrap = document.getElementById('newImgPreviewWrap');
    const img  = document.getElementById('newImgPreview');
    if (file) {
        img.src = URL.createObjectURL(file);
        wrap.style.display = 'block';
    } else {
        wrap.style.display = 'none';
    }
});

// ── Hapus gambar toggle ──────────────────────────────────────────────────────
document.getElementById('hapusGambarCb')?.addEventListener('change', function () {
    const currentImg = document.getElementById('currentImg');
    if (currentImg) {
        currentImg.style.opacity = this.checked ? '.3' : '1';
    }
});

// ── Init ──────────────────────────────────────────────────────────────────────
document.querySelectorAll('input[name="jenis_soal"]').forEach(r => r.addEventListener('change', syncJenis));
syncJenis();
</script>
</x-app-layout>