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
    --purple:#7c3aed; --purple-bg:#ede9fe;
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

/* Jenis badge */
.jenis-badge{display:inline-flex;align-items:center;gap:7px;padding:8px 14px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;}
.jb-pg{background:var(--brand-50);color:var(--brand);border:1.5px solid #bfdbfe;}
.jb-essay{background:var(--purple-bg);color:var(--purple);border:1.5px solid #c4b5fd;}
.jb-bs{background:var(--green-bg);color:var(--green);border:1.5px solid var(--green-bd);}

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

/* Gambar preview */
.img-preview-wrap{display:flex;align-items:flex-start;gap:12px;padding:12px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);margin-top:8px;transition:opacity .2s;}
.img-preview-wrap.akan-dihapus{opacity:.4;}
.img-preview{max-width:200px;max-height:150px;border-radius:6px;border:1px solid var(--border);}
.img-actions{display:flex;flex-direction:column;gap:6px;}
.btn-hapus-img{background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);padding:6px 12px;font-size:12.5px;border-radius:6px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;transition:filter .15s;user-select:none;}
.btn-hapus-img:hover{filter:brightness(.93);}
.btn-hapus-img.aktif{background:var(--red);color:#fff;text-decoration:line-through;}

/* File input */
.file-input-wrap{border:2px dashed var(--border2);border-radius:var(--radius-sm);padding:14px 16px;background:var(--surface2);display:flex;align-items:center;gap:10px;cursor:pointer;transition:border-color .15s,background .15s;}
.file-input-wrap:hover{border-color:var(--brand-h);background:var(--brand-50);}
.file-input-wrap input[type=file]{display:none;}
.file-input-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);}
.img-preview-inline{max-width:320px;max-height:200px;border-radius:var(--radius-sm);margin-top:10px;border:1px solid var(--border);display:none;}

.form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}

@keyframes spin{to{transform:rotate(360deg);}}
@media(max-width:680px){
    .page{padding:16px;}
    .form-row{grid-template-columns:1fr;}
    .form-footer{flex-wrap:wrap;}
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
        <span class="current">Edit Soal #{{ $soal->nomor_soal }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Soal #{{ $soal->nomor_soal }}</h1>
            <p class="page-sub">{{ Str::limit($ujian->judul, 45) }}</p>
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

    {{--
        Route: PUT admin/ujian/{ujian}/soal/{soal}
        Controller: SoalUjianController@update
        Fields: nomor_soal, jenis_soal (hidden), pertanyaan, gambar_soal,
                hapus_gambar, bobot, pilihan[*][kode_pilihan|teks_pilihan|gambar_pilihan|adalah_benar]
    --}}
    <form action="{{ route('admin.ujian.soal.update', [$ujian, $soal]) }}" method="POST"
          enctype="multipart/form-data" id="soalForm">
        @csrf
        @method('PUT')

        {{-- ── Konfigurasi Soal ── --}}
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Konfigurasi Soal
                    <span class="section-label-line"></span>
                </p>
                <div class="form-row">
                    {{-- Jenis soal: tidak bisa diubah, dikirim via hidden input --}}
                    <div class="field" style="margin-bottom:0">
                        <label>Jenis Soal</label>
                        <div style="margin-top:2px">
                            @if($soal->jenis_soal === 'pilihan_ganda')
                                <span class="jenis-badge jb-pg">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                                    Pilihan Ganda
                                </span>
                            @elseif($soal->jenis_soal === 'essay')
                                <span class="jenis-badge jb-essay">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                                    Essay
                                </span>
                            @else
                                <span class="jenis-badge jb-bs">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    Benar / Salah
                                </span>
                            @endif
                            {{-- Wajib dikirim: controller SoalUjianController@update mewajibkan jenis_soal --}}
                            <input type="hidden" name="jenis_soal" value="{{ $soal->jenis_soal }}">
                        </div>
                        <span class="field-hint">Jenis soal tidak dapat diubah.</span>
                    </div>

                    <div class="form-row" style="gap:12px;align-items:end;">
                        <div class="field" style="margin-bottom:0">
                            <label>Nomor Soal</label>
                            {{-- nullable|integer|min:1 — jika kosong controller auto-assign --}}
                            <input type="number" name="nomor_soal"
                                   value="{{ old('nomor_soal', $soal->nomor_soal) }}" min="1">
                        </div>
                        <div class="field" style="margin-bottom:0">
                            <label>Bobot / Poin <span class="req">*</span></label>
                            {{-- required|integer|min:1|max:100 --}}
                            <input type="number" name="bobot"
                                   value="{{ old('bobot', $soal->bobot) }}" min="1" max="100"
                                   class="{{ $errors->has('bobot') ? 'is-invalid' : '' }}">
                            @error('bobot')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Pertanyaan ── --}}
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Pertanyaan
                    <span class="section-label-line"></span>
                </p>

                <div class="field">
                    <label>Teks Pertanyaan <span class="req">*</span></label>
                    {{-- required|string --}}
                    <textarea name="pertanyaan" rows="4"
                              class="{{ $errors->has('pertanyaan') ? 'is-invalid' : '' }}">{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                    @error('pertanyaan')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                {{-- ── Gambar Soal ── --}}
                <div class="field" style="margin-bottom:0">
                    <label>Gambar Soal</label>

                    @if($soal->gambar_soal)
                        {{--
                            Ada gambar existing:
                            - "Ganti gambar" → upload file baru via name="gambar_soal"
                            - "Hapus gambar" → checkbox name="hapus_gambar" value="1"
                            Controller: jika hapus_gambar=true → Storage::delete + set null
                                        jika ada file baru  → Storage::delete lama + store baru
                        --}}
                        <div class="img-preview-wrap" id="gambarSoalWrap">
                            <img src="{{ asset('storage/'.$soal->gambar_soal) }}"
                                 class="img-preview" id="prevGambarSoal"
                                 alt="Gambar soal saat ini">
                            <div class="img-actions">
                                <span style="font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif">Gambar saat ini</span>

                                {{-- Ganti: file input tersembunyi, dipicu label --}}
                                <label style="font-size:12.5px;color:var(--brand);cursor:pointer;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;">
                                    <input type="file" name="gambar_soal" id="gantiGambarInput"
                                           accept="image/jpeg,image/png,image/webp"
                                           style="display:none"
                                           onchange="gantiGambarSoal(this)">
                                    ↑ Ganti gambar
                                </label>

                                {{-- Hapus: checkbox tersembunyi, toggle via tombol --}}
                                <input type="checkbox" name="hapus_gambar" value="1"
                                       id="hapusGambarCb" style="display:none">
                                <button type="button" class="btn-hapus-img"
                                        id="btnHapusGambar"
                                        onclick="toggleHapusGambar()">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                    Hapus gambar
                                </button>
                            </div>
                        </div>
                        {{-- Preview jika pengguna memilih gambar pengganti --}}
                        <img id="prevGambarSoalBaru" class="img-preview-inline" src="#" alt="">
                    @else
                        {{-- Belum ada gambar: tampilkan file picker --}}
                        <div class="file-input-wrap" onclick="document.getElementById('gambarSoalInput').click()">
                            <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <div>
                                <p class="file-input-label">Klik untuk upload gambar</p>
                                <p class="field-hint" style="margin-top:0">JPG, PNG, WEBP — Maks 2MB</p>
                            </div>
                            <input type="file" id="gambarSoalInput" name="gambar_soal"
                                   accept="image/jpeg,image/png,image/webp"
                                   onchange="previewGambarBaru(this,'prevGambarNew')">
                        </div>
                        <img id="prevGambarNew" class="img-preview-inline" src="#" alt="">
                    @endif

                    @error('gambar_soal')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- ── Pilihan Jawaban (hanya PG & benar_salah) ── --}}
            @if($soal->jenis_soal !== 'essay')
            <hr class="section-divider">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Pilihan Jawaban
                    <span class="section-label-line"></span>
                </p>
                <p style="font-size:12.5px;color:var(--text3);margin-bottom:14px;font-family:'DM Sans',sans-serif;">
                    @if($soal->jenis_soal === 'pilihan_ganda')
                        Pilihan ganda: minimal 2 pilihan, tepat 1 jawaban benar. Centang radio untuk menandai benar.
                    @else
                        Benar/Salah: tepat 2 pilihan. Centang radio untuk menandai jawaban yang benar.
                    @endif
                </p>

                {{--
                    simpanPilihan() di controller membaca:
                        pilihan[idx][kode_pilihan]
                        pilihan[idx][teks_pilihan]
                        pilihan[idx][gambar_pilihan]   ← file
                        pilihan[idx][adalah_benar]     ← '1' / '0'

                    Saat update: semua pilihan lama dihapus lalu dibuat ulang dari request.
                --}}
                <div class="pilihan-list" id="pilihanList">
                    @foreach($soal->pilihan as $idx => $p)
                    <div class="pilihan-item {{ $p->adalah_benar ? 'is-benar' : '' }}"
                         id="pilihanItem_{{ $idx }}" data-idx="{{ $idx }}">

                        <div class="pilihan-kode">{{ $p->kode_pilihan }}</div>

                        <input type="hidden" name="pilihan[{{ $idx }}][kode_pilihan]"
                               value="{{ $p->kode_pilihan }}">

                        {{-- Nilai adalah_benar dikontrol JS lewat hidden ini --}}
                        <input type="hidden" name="pilihan[{{ $idx }}][adalah_benar]"
                               id="hidBenar_{{ $idx }}" value="{{ $p->adalah_benar ? '1' : '0' }}">

                        <input class="pilihan-input" type="text"
                               name="pilihan[{{ $idx }}][teks_pilihan]"
                               value="{{ old("pilihan.{$idx}.teks_pilihan", $p->teks_pilihan) }}"
                               placeholder="Teks pilihan {{ $p->kode_pilihan }}…"
                               {{ $soal->jenis_soal === 'benar_salah' ? 'readonly' : '' }}>

                        {{--
                            name="pilihan_benar_idx" adalah radio group murni UI.
                            Nilai sebenarnya dikirim via hidden hidBenar_{idx}.
                            Bug lama: perbandingan string vs int — sekarang pakai data-idx integer.
                        --}}
                        <input type="radio" name="pilihan_benar_idx"
                               value="{{ $idx }}"
                               class="pilihan-benar-cb"
                               {{ $p->adalah_benar ? 'checked' : '' }}
                               onchange="markBenar({{ $idx }})"
                               style="accent-color:var(--green);">
                        <span class="pilihan-benar-lbl">Benar</span>

                        @if($soal->jenis_soal === 'pilihan_ganda')
                        <button type="button" class="pilihan-del"
                                onclick="hapusPilihan({{ $idx }})"
                                title="Hapus pilihan ini">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                        @endif
                    </div>
                    @endforeach
                </div>

                @if($soal->jenis_soal === 'pilihan_ganda')
                <button type="button" class="add-pilihan-btn" onclick="addPilihan()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Pilihan
                </button>
                @endif

                @error('pilihan')
                <span class="field-error" style="display:block;margin-top:10px">{{ $message }}</span>
                @enderror
            </div>
            @endif

            <div class="form-footer">
                <a href="{{ route('admin.ujian.soal.index', $ujian) }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// ─────────────────────────────────────────────────────────────────────────────
// State
// ─────────────────────────────────────────────────────────────────────────────
let pilihanCount = {{ $soal->pilihan->count() }};   // integer: jumlah pilihan saat ini
const jenisSoal  = '{{ $soal->jenis_soal }}';
const KODE_LIST  = ['A','B','C','D','E','F','G','H'];

// ─────────────────────────────────────────────────────────────────────────────
// markBenar(idx)
// FIX BUG LAMA: perbandingan harus integer vs integer.
// Dulu: parseInt(el.id.replace(...)) → string, perbandingan === selalu false.
// Sekarang: gunakan data-idx attribute yang di-set di template sebagai integer.
// ─────────────────────────────────────────────────────────────────────────────
function markBenar(selectedIdx) {
    // selectedIdx sudah integer dari inline onchange="markBenar({{ $idx }})"
    document.querySelectorAll('#pilihanList .pilihan-item').forEach(function(el) {
        var itemIdx = parseInt(el.getAttribute('data-idx'), 10);
        var isBenar = (itemIdx === selectedIdx);

        el.classList.toggle('is-benar', isBenar);

        var hidden = document.getElementById('hidBenar_' + itemIdx);
        if (hidden) hidden.value = isBenar ? '1' : '0';
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// addPilihan() — tambah baris pilihan baru (hanya PG)
// Setiap pilihan baru juga mendapat data-idx yang benar agar markBenar bekerja.
// ─────────────────────────────────────────────────────────────────────────────
function addPilihan() {
    var idx  = pilihanCount++;
    var kode = KODE_LIST[idx] !== undefined ? KODE_LIST[idx] : String.fromCharCode(65 + idx);
    var div  = document.createElement('div');
    div.className = 'pilihan-item';
    div.id        = 'pilihanItem_' + idx;
    div.setAttribute('data-idx', idx);   // penting untuk markBenar()
    div.innerHTML =
        '<div class="pilihan-kode">' + kode + '</div>' +
        '<input type="hidden" name="pilihan[' + idx + '][kode_pilihan]" value="' + kode + '">' +
        '<input type="hidden" name="pilihan[' + idx + '][adalah_benar]" id="hidBenar_' + idx + '" value="0">' +
        '<input class="pilihan-input" type="text"' +
            ' name="pilihan[' + idx + '][teks_pilihan]"' +
            ' placeholder="Teks pilihan ' + kode + '…" required>' +
        '<input type="radio" name="pilihan_benar_idx" value="' + idx + '"' +
            ' class="pilihan-benar-cb"' +
            ' onchange="markBenar(' + idx + ')"' +
            ' style="accent-color:var(--green);">' +
        '<span class="pilihan-benar-lbl">Benar</span>' +
        '<button type="button" class="pilihan-del" onclick="hapusPilihan(' + idx + ')" title="Hapus pilihan ini">' +
            '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' +
            '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
        '</button>';
    document.getElementById('pilihanList').appendChild(div);
}

// ─────────────────────────────────────────────────────────────────────────────
// hapusPilihan(idx) — hapus baris pilihan dari DOM
// ─────────────────────────────────────────────────────────────────────────────
function hapusPilihan(idx) {
    var el = document.getElementById('pilihanItem_' + idx);
    if (el) el.remove();
}

// ─────────────────────────────────────────────────────────────────────────────
// previewGambarBaru(input, previewId) — preview gambar baru (belum ada gambar)
// ─────────────────────────────────────────────────────────────────────────────
function previewGambarBaru(input, previewId) {
    var prev = document.getElementById(previewId);
    if (!input.files || !input.files[0] || !prev) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        prev.src = e.target.result;
        prev.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}

// ─────────────────────────────────────────────────────────────────────────────
// gantiGambarSoal(input) — pengguna memilih gambar pengganti
// Tampilkan preview baru, sembunyikan gambar lama, batalkan hapus_gambar.
// FIX BUG LAMA: previewGambar() hanya menampilkan preview tanpa
//               me-hide/show elemen yang tepat.
// ─────────────────────────────────────────────────────────────────────────────
function gantiGambarSoal(input) {
    if (!input.files || !input.files[0]) return;

    // Batalkan hapus_gambar jika sempat dicentang
    var cb = document.getElementById('hapusGambarCb');
    if (cb && cb.checked) {
        cb.checked = false;
        syncHapusGambar(false);
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        // Tampilkan preview baru
        var prevBaru = document.getElementById('prevGambarSoalBaru');
        if (prevBaru) {
            prevBaru.src = e.target.result;
            prevBaru.style.display = 'block';
        }
        // Sembunyikan gambar lama (visual feedback)
        var prevLama = document.getElementById('prevGambarSoal');
        if (prevLama) prevLama.style.opacity = '0.3';
    };
    reader.readAsDataURL(input.files[0]);
}

// ─────────────────────────────────────────────────────────────────────────────
// toggleHapusGambar() — toggle checkbox hapus_gambar
// FIX BUG LAMA: dulu memanipulasi elemen via ID yang salah (btnHapusGambar
//               adalah <label>, bukan elemen yang memiliki style langsung).
//               Sekarang: checkbox punya ID sendiri (hapusGambarCb),
//               tombol punya ID sendiri (btnHapusGambar), dan
//               syncHapusGambar() mengurus keduanya.
// ─────────────────────────────────────────────────────────────────────────────
function toggleHapusGambar() {
    var cb = document.getElementById('hapusGambarCb');
    if (!cb) return;
    cb.checked = !cb.checked;
    syncHapusGambar(cb.checked);
}

function syncHapusGambar(aktif) {
    var wrap = document.getElementById('gambarSoalWrap');
    var btn  = document.getElementById('btnHapusGambar');
    if (wrap) wrap.classList.toggle('akan-dihapus', aktif);
    if (btn)  btn.classList.toggle('aktif', aktif);

    // Jika hapus diaktifkan, batalkan pilihan file pengganti
    if (aktif) {
        var gantiInput = document.getElementById('gantiGambarInput');
        if (gantiInput) gantiInput.value = '';
        var prevBaru = document.getElementById('prevGambarSoalBaru');
        if (prevBaru) { prevBaru.src = '#'; prevBaru.style.display = 'none'; }
        var prevLama = document.getElementById('prevGambarSoal');
        if (prevLama) prevLama.style.opacity = '1';
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Submit guard — disable tombol agar tidak double submit
// ─────────────────────────────────────────────────────────────────────────────
document.getElementById('soalForm').addEventListener('submit', function() {
    var btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML =
        '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"' +
        ' viewBox="0 0 24 24" style="animation:spin .7s linear infinite">' +
        '<path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…';
});
</script>
</x-app-layout>