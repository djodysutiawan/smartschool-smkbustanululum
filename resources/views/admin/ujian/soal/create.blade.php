<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand:#1f63db; --brand-h:#3582f0; --brand-50:#eef6ff;
    --surface:#fff; --surface2:#f8fafc; --surface3:#f1f5f9;
    --border:#e2e8f0; --border2:#cbd5e1;
    --text:#0f172a; --text2:#475569; --text3:#94a3b8;
    --green:#15803d; --green-bg:#dcfce7; --green-bd:#bbf7d0;
    --red:#dc2626; --red-bg:#fee2e2; --red-bd:#fecaca;
    --radius:10px; --radius-sm:7px;
}
*{box-sizing:border-box;}
.page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}

.breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;flex-wrap:wrap;}
.breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s;}
.breadcrumb a:hover{color:var(--brand);}
.breadcrumb .sep{color:var(--border2);}
.breadcrumb .current{color:var(--text2);}

.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}

.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-primary{background:var(--brand);color:#fff;}
.btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
.btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
.btn-back:hover{background:var(--surface3);filter:none;}
.btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
.btn-cancel:hover{background:var(--surface3);filter:none;}

.alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);}

.form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px;}
.form-section{padding:20px 24px 24px;}
.section-divider{border:none;border-top:1px solid var(--border);margin:0;}
.section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.08em;text-transform:uppercase;margin-bottom:16px;}
.section-label-line{flex:1;height:1px;background:var(--border);}

.field{display:flex;flex-direction:column;gap:6px;margin-bottom:14px;}
.field:last-child{margin-bottom:0;}
.field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
.req{color:var(--brand);margin-left:2px;}
.field input[type=text],.field input[type=number],.field select,.field textarea{
    padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);
    font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);
    background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s;
}
.field input[type=number]{-moz-appearance:textfield;}
.field textarea{resize:vertical;min-height:80px;line-height:1.6;}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
.field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8;}
.field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;}
.field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;}

/* Jenis Soal Switcher */
.jenis-switch{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;}
.jenis-opt{display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 10px;border:2px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;text-align:center;}
.jenis-opt:hover{border-color:var(--border2);background:var(--surface2);}
.jenis-opt.selected{border-color:var(--brand);background:var(--brand-50);}
.jenis-opt-icon{width:36px;height:36px;border-radius:9px;background:var(--surface3);display:flex;align-items:center;justify-content:center;transition:background .15s;}
.jenis-opt.selected .jenis-opt-icon{background:var(--brand);}
.jenis-opt.selected .jenis-opt-icon svg{stroke:#fff;}
.jenis-opt-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
.jenis-opt.selected .jenis-opt-label{color:var(--brand);}
.jenis-opt-sub{font-size:11px;color:var(--text3);}

/* Pilihan Jawaban */
.pilihan-list{display:flex;flex-direction:column;gap:10px;}
.pilihan-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--surface2);transition:border-color .15s,background .15s;}
.pilihan-item.is-benar{border-color:var(--green-bd);background:var(--green-bg);}
.pilihan-kode{width:32px;height:32px;border-radius:7px;background:var(--surface3);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text2);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .15s,color .15s,border-color .15s;}
.pilihan-item.is-benar .pilihan-kode{background:var(--green);color:#fff;border-color:var(--green);}
.pilihan-input{flex:1;border:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);outline:none;}
.pilihan-input::placeholder{color:var(--text3);}
.pilihan-input[readonly]{color:var(--text2);}
.pilihan-benar-cb{width:16px;height:16px;accent-color:var(--green);cursor:pointer;flex-shrink:0;}
.pilihan-benar-lbl{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);white-space:nowrap;}
.pilihan-item.is-benar .pilihan-benar-lbl{color:var(--green);}
.pilihan-del{background:none;border:none;cursor:pointer;color:var(--text3);padding:4px;display:flex;align-items:center;border-radius:4px;transition:background .12s,color .12s;}
.pilihan-del:hover{color:var(--red);background:var(--red-bg);}

.add-pilihan-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:1.5px dashed var(--border2);border-radius:var(--radius-sm);background:var(--surface2);color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s;margin-top:8px;}
.add-pilihan-btn:hover{border-color:var(--brand-h);color:var(--brand);background:var(--brand-50);}

/* File input */
.file-input-wrap{border:2px dashed var(--border2);border-radius:var(--radius-sm);padding:14px 16px;background:var(--surface2);display:flex;align-items:center;gap:10px;cursor:pointer;transition:border-color .15s,background .15s;}
.file-input-wrap:hover{border-color:var(--brand-h);background:var(--brand-50);}
.file-input-wrap input[type=file]{display:none;}
.file-input-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);}
.file-name{font-size:12.5px;color:var(--green);font-family:'DM Sans',sans-serif;font-weight:600;margin-top:4px;}
.img-preview-inline{max-width:320px;max-height:200px;border-radius:var(--radius-sm);margin-top:10px;border:1px solid var(--border);display:none;}

/* Toggle switch */
.toggle-row{display:flex;align-items:center;gap:10px;}
.toggle-switch{position:relative;display:inline-block;width:38px;height:22px;}
.toggle-switch input{opacity:0;width:0;height:0;}
.toggle-slider{position:absolute;inset:0;border-radius:99px;background:var(--border2);cursor:pointer;transition:background .2s;}
.toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
.toggle-switch input:checked+.toggle-slider{background:var(--brand);}
.toggle-switch input:checked+.toggle-slider::before{transform:translateX(16px);}
.toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);}

.form-footer{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);flex-wrap:wrap;}
.footer-left{display:flex;align-items:center;gap:10px;}
.footer-right{display:flex;align-items:center;gap:10px;}

@keyframes spin{to{transform:rotate(360deg);}}
@media(max-width:680px){
    .page{padding:16px;}
    .form-row{grid-template-columns:1fr;}
    .jenis-switch{grid-template-columns:1fr;}
    .form-footer{flex-direction:column;align-items:stretch;}
}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.index') }}">Data Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 25) }}</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.soal.index', $ujian) }}">Bank Soal</a>
        <span class="sep">›</span>
        <span class="current">Tambah Soal</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Soal Baru</h1>
            <p class="page-sub">{{ $ujian->judul }} · Soal ke-{{ $nomorBerikutnya }}</p>
        </div>
        <a href="{{ route('admin.ujian.soal.index', $ujian) }}" class="btn btn-back">
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

    <form action="{{ route('admin.ujian.soal.store', $ujian) }}" method="POST"
          enctype="multipart/form-data" id="soalForm">
        @csrf

        {{-- ── Pilih Jenis Soal ── --}}
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Jenis Soal
                    <span class="section-label-line"></span>
                </p>
                <div class="jenis-switch">
                    <label class="jenis-opt {{ old('jenis_soal','pilihan_ganda') === 'pilihan_ganda' ? 'selected' : '' }}"
                           onclick="setJenis(event,'pilihan_ganda')">
                        <div class="jenis-opt-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <p class="jenis-opt-label">Pilihan Ganda</p>
                        <p class="jenis-opt-sub">4–5 opsi, 1 jawaban benar</p>
                        <input type="radio" name="jenis_soal" value="pilihan_ganda" style="display:none"
                               {{ old('jenis_soal','pilihan_ganda') === 'pilihan_ganda' ? 'checked' : '' }}>
                    </label>
                    <label class="jenis-opt {{ old('jenis_soal') === 'benar_salah' ? 'selected' : '' }}"
                           onclick="setJenis(event,'benar_salah')">
                        <div class="jenis-opt-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <p class="jenis-opt-label">Benar / Salah</p>
                        <p class="jenis-opt-sub">Jawaban: Benar atau Salah</p>
                        <input type="radio" name="jenis_soal" value="benar_salah" style="display:none"
                               {{ old('jenis_soal') === 'benar_salah' ? 'checked' : '' }}>
                    </label>
                    <label class="jenis-opt {{ old('jenis_soal') === 'essay' ? 'selected' : '' }}"
                           onclick="setJenis(event,'essay')">
                        <div class="jenis-opt-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                        </div>
                        <p class="jenis-opt-label">Essay</p>
                        <p class="jenis-opt-sub">Jawaban uraian, koreksi manual</p>
                        <input type="radio" name="jenis_soal" value="essay" style="display:none"
                               {{ old('jenis_soal') === 'essay' ? 'checked' : '' }}>
                    </label>
                </div>
                @error('jenis_soal')<span class="field-error" style="margin-top:8px;display:block">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- ── Pertanyaan ── --}}
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Pertanyaan
                    <span class="section-label-line"></span>
                </p>

                <div class="form-row" style="margin-bottom:14px;">
                    <div class="field" style="margin-bottom:0">
                        <label>Nomor Soal <span class="req">*</span></label>
                        <input type="number" name="nomor_soal"
                               value="{{ old('nomor_soal', $nomorBerikutnya) }}" min="1"
                               class="{{ $errors->has('nomor_soal') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Otomatis jika kosong</span>
                        @error('nomor_soal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field" style="margin-bottom:0">
                        <label>Bobot / Poin <span class="req">*</span></label>
                        <input type="number" name="bobot"
                               value="{{ old('bobot', 1) }}" min="1" max="100"
                               class="{{ $errors->has('bobot') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Poin jika jawaban benar</span>
                        @error('bobot')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="field">
                    <label>Teks Pertanyaan <span class="req">*</span></label>
                    <textarea name="pertanyaan" rows="4"
                              placeholder="Tuliskan pertanyaan di sini…"
                              class="{{ $errors->has('pertanyaan') ? 'is-invalid' : '' }}">{{ old('pertanyaan') }}</textarea>
                    @error('pertanyaan')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field" style="margin-bottom:0">
                    <label>Gambar Soal <span style="color:var(--text3);font-weight:400">(opsional)</span></label>
                    <div class="file-input-wrap" onclick="document.getElementById('gambarSoalInput').click()">
                        <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <div>
                            <p class="file-input-label">Klik untuk upload gambar</p>
                            <p class="field-hint" style="margin-top:0">JPG, PNG, WEBP — Maks 2MB</p>
                        </div>
                        <input type="file" id="gambarSoalInput" name="gambar_soal"
                               accept="image/jpeg,image/png,image/webp"
                               onchange="handleGambar(this)">
                    </div>
                    <p class="file-name" id="gambarFileName" style="display:none"></p>
                    <img id="gambarPreview" class="img-preview-inline" src="#" alt="">
                    @error('gambar_soal')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- ── Seksi Pilihan Jawaban (PG & Benar/Salah) ── --}}
            <div id="seksiPilihan" style="display:none">
                <hr class="section-divider">
                <div class="form-section">
                    <p class="section-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Pilihan Jawaban
                        <span class="section-label-line"></span>
                    </p>
                    <p style="font-size:12.5px;color:var(--text3);margin-bottom:14px;font-family:'DM Sans',sans-serif;">
                        Centang radio button untuk menandai jawaban yang benar.
                    </p>
                    <div class="pilihan-list" id="pilihanList"></div>
                    <button type="button" class="add-pilihan-btn" id="btnAddPilihan" onclick="addPilihan()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Pilihan
                    </button>
                </div>
            </div>

            {{-- ── Seksi Essay ── --}}
            <div id="seksiEssay" style="display:none">
                <hr class="section-divider">
                <div class="form-section">
                    <p class="section-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                        Kunci Jawaban Essay
                        <span class="section-label-line"></span>
                    </p>
                    <div class="field" style="margin-bottom:0">
                        <label>Kunci / Pedoman Penskoran <span style="color:var(--text3);font-weight:400">(opsional)</span></label>
                        <textarea name="kunci_essay" rows="4"
                                  placeholder="Tuliskan kunci jawaban atau pedoman penskoran untuk guru…">{{ old('kunci_essay') }}</textarea>
                        <span class="field-hint">Hanya terlihat oleh guru/admin. Siswa tidak dapat melihat kunci ini.</span>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <div class="footer-left">
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="hidden" name="tambah_lagi" value="0">
                            <input type="checkbox" name="tambah_lagi" value="1" id="toggleTambahLagi">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Simpan & tambah soal berikutnya</span>
                    </div>
                </div>
                <div class="footer-right">
                    <a href="{{ route('admin.ujian.soal.index', $ujian) }}" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Soal
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
const KODE_DEFAULT = ['A','B','C','D','E'];
let pilihanCount   = 0;
let jenisSoal      = '{{ old("jenis_soal", "pilihan_ganda") }}';

// ── Jenis Soal Switcher ─────────────────────────────────────────────────
function setJenis(e, jenis) {
    jenisSoal = jenis;
    document.querySelectorAll('input[name=jenis_soal]').forEach(r => r.checked = (r.value === jenis));
    document.querySelectorAll('.jenis-opt').forEach(el => el.classList.remove('selected'));
    e.currentTarget.classList.add('selected');
    document.getElementById('pilihanList').innerHTML = '';
    pilihanCount = 0;
    applyJenis();
}

function applyJenis() {
    const isPG = jenisSoal === 'pilihan_ganda';
    const isBS = jenisSoal === 'benar_salah';
    const isEs = jenisSoal === 'essay';
    document.getElementById('seksiPilihan').style.display  = (isPG || isBS) ? '' : 'none';
    document.getElementById('seksiEssay').style.display    = isEs ? '' : 'none';
    document.getElementById('btnAddPilihan').style.display = isPG ? 'inline-flex' : 'none';
    if (isPG && pilihanCount === 0) ['A','B','C','D'].forEach(k => addPilihan(k, '', false));
    if (isBS && pilihanCount === 0) { addPilihan('B','Benar',true); addPilihan('S','Salah',true); }
}

// ── Pilihan Ganda ───────────────────────────────────────────────────────
function addPilihan(kode, teks, locked) {
    if (jenisSoal === 'pilihan_ganda' && pilihanCount >= 5) {
        alert('Maksimal 5 pilihan jawaban.'); return;
    }
    const idx  = pilihanCount++;
    const k    = kode || KODE_DEFAULT[idx] || String.fromCharCode(65 + idx);
    const div  = document.createElement('div');
    div.className = 'pilihan-item';
    div.id = 'pilihanItem_' + idx;
    div.innerHTML = `
        <div class="pilihan-kode">${k}</div>
        <input type="hidden" name="pilihan[${idx}][kode_pilihan]" value="${k}">
        <input type="hidden" name="pilihan[${idx}][adalah_benar]" id="benar_${idx}" value="0">
        <input class="pilihan-input" type="text"
               name="pilihan[${idx}][teks_pilihan]"
               value="${teks || ''}"
               placeholder="Teks pilihan ${k}…"
               ${locked ? 'readonly' : ''}>
        <input type="radio" name="pilihan_benar_idx" value="${idx}"
               class="pilihan-benar-cb"
               onchange="markBenar(${idx})"
               style="accent-color:var(--green);">
        <span class="pilihan-benar-lbl">Benar</span>
        ${!locked ? `<button type="button" class="pilihan-del" onclick="hapusPilihan(${idx})">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>` : ''}`;
    document.getElementById('pilihanList').appendChild(div);
}

function markBenar(idx) {
    document.querySelectorAll('.pilihan-item').forEach(el => {
        const id = parseInt(el.id.replace('pilihanItem_',''));
        el.classList.toggle('is-benar', id === idx);
        const h = document.getElementById('benar_' + id);
        if (h) h.value = (id === idx) ? '1' : '0';
    });
}

function hapusPilihan(idx) {
    const el = document.getElementById('pilihanItem_' + idx);
    if (el) el.remove();
}

// ── Gambar ──────────────────────────────────────────────────────────────
function handleGambar(input) {
    const nameEl    = document.getElementById('gambarFileName');
    const previewEl = document.getElementById('gambarPreview');
    if (input.files && input.files[0]) {
        nameEl.textContent   = '✓ ' + input.files[0].name;
        nameEl.style.display = 'block';
        const reader = new FileReader();
        reader.onload = e => { previewEl.src = e.target.result; previewEl.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else {
        nameEl.style.display    = 'none';
        previewEl.style.display = 'none';
    }
}

// ── Submit ──────────────────────────────────────────────────────────────
document.getElementById('soalForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
});

// ── Init ────────────────────────────────────────────────────────────────
(function() {
    document.querySelectorAll('.jenis-opt').forEach(opt => {
        const r = opt.querySelector('input[type=radio]');
        if (r && r.checked) opt.classList.add('selected');
    });
    applyJenis();
})();
</script>
</x-app-layout>