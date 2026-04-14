<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
        --brand-50:   #eef6ff;
        --brand-100:  #d9ebff;
        --brand-700:  #1750c0;
        --surface:    #fff;
        --surface2:   #f8fafc;
        --surface3:   #f1f5f9;
        --border:     #e2e8f0;
        --border2:    #cbd5e1;
        --text:       #0f172a;
        --text2:      #475569;
        --text3:      #94a3b8;
        --radius:     10px;
        --radius-sm:  7px;
        --danger:     #dc2626;
        --danger-50:  #fee2e2;
        --danger-100: #fecaca;
        --success:    #16a34a;
        --success-50: #f0fdf4;
        --success-100:#dcfce7;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* Page header */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* Buttons */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }

    /* Alert error */
    .alert-error {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
        background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100);
    }
    .alert-error ul { margin: 4px 0 0 16px; padding: 0; }
    .alert-error li { margin-bottom: 2px; }

    /* Form card */
    .form-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 22px 24px; }

    /* Form */
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700; color: var(--text2);
        letter-spacing: .04em; text-transform: uppercase;
    }
    .form-label .req { color: var(--danger); }

    .form-control {
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 9px 12px;
        outline: none; transition: border-color .15s, box-shadow .15s;
        width: 100%; box-sizing: border-box;
    }
    .form-control:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(31,99,219,.1);
    }
    .form-control.is-invalid { border-color: var(--danger); }
    .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(220,38,38,.1); }

    .form-hint {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3);
    }
    .form-error {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--danger);
        display: flex; align-items: center; gap: 4px;
    }

    /* Input with prefix (kode mapel) */
    .input-group { display: flex; }
    .input-prefix {
        display: flex; align-items: center; padding: 9px 12px;
        background: var(--surface3); border: 1px solid var(--border);
        border-right: none; border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 700; color: var(--text3); white-space: nowrap; flex-shrink: 0;
    }
    .input-group .form-control {
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }
    .input-group .form-control:focus { border-color: var(--brand); }

    /* Char counter */
    .char-row {
        display: flex; align-items: center; justify-content: space-between;
    }
    .char-counter {
        font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3);
        transition: color .15s;
    }
    .char-counter.warn  { color: var(--danger); }

    /* Live preview card */
    .preview-wrap {
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 16px 18px; margin-top: 20px;
        display: none;
    }
    .preview-wrap.visible { display: block; }
    .preview-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px;
        font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
        color: var(--brand-700); margin-bottom: 12px;
    }
    .preview-subject {
        display: flex; align-items: center; gap: 12px;
    }
    .preview-icon {
        width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
        background: var(--brand-100); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px;
        font-weight: 800; color: var(--brand-700);
        transition: all .2s;
    }
    .preview-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px;
        font-weight: 800; color: var(--brand-700);
    }
    .preview-code {
        display: inline-flex; align-items: center; gap: 4px;
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--brand);
        margin-top: 4px;
    }

    /* Tips box */
    .tips-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .tips-body { padding: 18px 20px; }
    .tip-item {
        display: flex; align-items: flex-start; gap: 10px;
        margin-bottom: 12px; font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: var(--text2); line-height: 1.5;
    }
    .tip-item:last-child { margin-bottom: 0; }
    .tip-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--brand); margin-top: 7px; flex-shrink: 0;
    }

    /* Layout 2 kolom */
    .layout { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; align-items: start; }

    /* Form footer */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; border-top: 1px solid var(--border); background: var(--surface2);
    }

    @media (max-width: 768px) {
        .page { padding: 16px 16px 40px; }
        .layout { grid-template-columns: 1fr; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.subjects.index') }}">Data Mata Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah Mata Pelajaran</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Mata Pelajaran</h1>
            <p class="page-sub">Isi form di bawah untuk menambahkan mata pelajaran baru</p>
        </div>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>Terdapat kesalahan pada form:</strong>
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="layout">

        {{-- Kolom kiri: form utama --}}
        <div>
            <form method="POST" action="{{ route('admin.subjects.store') }}">
                @csrf

                <div class="form-card">
                    <div class="card-header">
                        <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                        <p class="card-title">Informasi Mata Pelajaran</p>
                    </div>
                    <div class="card-body">

                        {{-- Nama Mapel --}}
                        <div class="form-group">
                            <label class="form-label" for="nama_mapel">
                                Nama Mata Pelajaran <span class="req">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_mapel"
                                name="nama_mapel"
                                value="{{ old('nama_mapel') }}"
                                placeholder="Contoh: Matematika, Bahasa Indonesia, Fisika…"
                                maxlength="255"
                                class="form-control {{ $errors->has('nama_mapel') ? 'is-invalid' : '' }}"
                                oninput="onNamaInput(this); updatePreview()"
                                autocomplete="off"
                            >
                            <div class="char-row">
                                <span>
                                    @error('nama_mapel')
                                        <p class="form-error">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="12" y1="8" x2="12" y2="12"/>
                                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @else
                                        <span class="form-hint">Nama lengkap mata pelajaran.</span>
                                    @enderror
                                </span>
                                <span class="char-counter" id="namaCounter">0 / 255</span>
                            </div>
                        </div>

                        {{-- Kode Mapel --}}
                        <div class="form-group">
                            <label class="form-label" for="kode_mapel">
                                Kode Mata Pelajaran <span class="req">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-prefix">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:5px">
                                        <polyline points="16 18 22 12 16 6"/>
                                        <polyline points="8 6 2 12 8 18"/>
                                    </svg>
                                    KODE
                                </span>
                                <input
                                    type="text"
                                    id="kode_mapel"
                                    name="kode_mapel"
                                    value="{{ old('kode_mapel') }}"
                                    placeholder="MTK, B.IND, FIS…"
                                    maxlength="20"
                                    class="form-control {{ $errors->has('kode_mapel') ? 'is-invalid' : '' }}"
                                    oninput="onKodeInput(this); updatePreview()"
                                    autocomplete="off"
                                    style="text-transform:uppercase"
                                >
                            </div>
                            <div class="char-row" style="margin-top:4px">
                                <span>
                                    @error('kode_mapel')
                                        <p class="form-error">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="12" y1="8" x2="12" y2="12"/>
                                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @else
                                        <span class="form-hint">Kode unik, maks. 20 karakter. Contoh: MTK, B.IND, PAI.</span>
                                    @enderror
                                </span>
                                <span class="char-counter" id="kodeCounter">0 / 20</span>
                            </div>
                        </div>

                        {{-- Live preview --}}
                        <div class="preview-wrap" id="previewWrap">
                            <p class="preview-label">Preview tampilan</p>
                            <div class="preview-subject">
                                <div class="preview-icon" id="previewIcon">—</div>
                                <div>
                                    <p class="preview-name" id="previewName">—</p>
                                    <p class="preview-code">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="16 18 22 12 16 6"/>
                                            <polyline points="8 6 2 12 8 18"/>
                                        </svg>
                                        <span id="previewCode">—</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="form-footer">
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Simpan Mata Pelajaran
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- Kolom kanan: tips --}}
        <div>
            <div class="tips-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p class="card-title">Panduan Pengisian</p>
                </div>
                <div class="tips-body">
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span><strong>Nama Mata Pelajaran</strong> diisi dengan nama lengkap, misalnya <em>Matematika</em>, <em>Bahasa Indonesia</em>, atau <em>Pendidikan Agama Islam</em>.</span>
                    </div>
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span><strong>Kode Mapel</strong> harus unik dan singkat — digunakan sebagai identitas unik di jadwal. Contoh: <em>MTK</em>, <em>B.IND</em>, <em>PAI</em>, <em>PKN</em>.</span>
                    </div>
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span>Kode mapel maksimal <strong>20 karakter</strong> dan akan otomatis diubah menjadi huruf kapital.</span>
                    </div>
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span>Setelah disimpan, mata pelajaran ini dapat digunakan saat membuat <strong>Jadwal Pelajaran</strong>.</span>
                    </div>
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span>Kode mapel <strong>tidak bisa dipakai dua kali</strong> — sistem akan menolak jika kode sudah terdaftar.</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    /* ── Char counter nama mapel ── */
    function onNamaInput(el) {
        const max = 255;
        const len = el.value.length;
        const counter = document.getElementById('namaCounter');
        counter.textContent = len + ' / ' + max;
        counter.classList.toggle('warn', len > max - 20);
    }

    /* ── Char counter + uppercase kode mapel ── */
    function onKodeInput(el) {
        el.value = el.value.toUpperCase();
        const max = 20;
        const len = el.value.length;
        const counter = document.getElementById('kodeCounter');
        counter.textContent = len + ' / ' + max;
        counter.classList.toggle('warn', len >= max - 3);
    }

    /* ── Live preview ── */
    function updatePreview() {
        const nama = document.getElementById('nama_mapel').value.trim();
        const kode = document.getElementById('kode_mapel').value.trim();
        const wrap = document.getElementById('previewWrap');

        if (!nama && !kode) { wrap.classList.remove('visible'); return; }

        /* Icon: pakai kode jika ada, fallback ke 2 huruf pertama nama */
        const iconText = kode
            ? kode.substring(0, 3)
            : nama.substring(0, 2).toUpperCase();

        document.getElementById('previewIcon').textContent = iconText || '—';
        document.getElementById('previewName').textContent = nama || '—';
        document.getElementById('previewCode').textContent = kode || '—';

        wrap.classList.add('visible');
    }

    /* ── Init (jika ada old values setelah validation error) ── */
    document.addEventListener('DOMContentLoaded', function () {
        const nama = document.getElementById('nama_mapel');
        const kode = document.getElementById('kode_mapel');
        if (nama.value) onNamaInput(nama);
        if (kode.value) onKodeInput(kode);
        updatePreview();
    });
</script>

</x-app-layout>