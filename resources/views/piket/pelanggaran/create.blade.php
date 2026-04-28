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
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center}

    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;flex-wrap:wrap}
    .breadcrumb a{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--brand-600);text-decoration:none}
    .breadcrumb a:hover{text-decoration:underline}
    .breadcrumb-sep{color:var(--text3);font-size:12px}
    .breadcrumb-cur{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3)}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .form-card-header{padding:16px 24px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:10px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .form-card-body{padding:24px}
    .form-card-footer{padding:16px 24px;border-top:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:flex-end;gap:8px}

    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
    .form-grid .col-span-2{grid-column:span 2}
    .form-group{display:flex;flex-direction:column;gap:5px}
    .form-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .form-label .req{color:#dc2626;margin-left:2px}
    .form-control{height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;width:100%;box-sizing:border-box}
    .form-control:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.12);background:#fff}
    .form-control.is-invalid{border-color:#dc2626;background:#fff8f8}
    textarea.form-control{height:auto;padding:10px 12px;resize:vertical;min-height:96px}
    select.form-control{appearance:none;background-image:url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px}
    .form-hint{font-size:11.5px;color:var(--text3);margin-top:1px}
    .form-error{font-size:11.5px;color:#dc2626;margin-top:2px;display:flex;align-items:center;gap:4px}

    .siswa-preview{display:none;margin-top:8px;padding:10px 14px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm)}
    .siswa-preview.show{display:flex;align-items:center;gap:10px}
    .siswa-avatar{width:34px;height:34px;border-radius:8px;background:var(--brand-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--brand-700)}
    .siswa-info .name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .siswa-info .meta{font-size:11.5px;color:var(--text3);margin-top:1px}

    .poin-indicator{display:flex;align-items:center;gap:8px;margin-top:6px}
    .poin-bar-track{flex:1;height:6px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .poin-bar-fill{height:100%;border-radius:99px;transition:width .3s,background .3s}
    .poin-label-right{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;min-width:40px;text-align:right}

    .kat-preview{display:none;margin-top:6px;padding:6px 10px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text2)}
    .kat-preview.show{display:block}

    .form-section{margin-bottom:8px;margin-top:4px}
    .form-section-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;padding-bottom:10px;border-bottom:1px solid var(--border);margin-bottom:20px}

    @media(max-width:640px){
        .page{padding:16px}
        .form-grid{grid-template-columns:1fr}
        .form-grid .col-span-2{grid-column:span 1}
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('piket.pelanggaran.index') }}">Riwayat Pelanggaran</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Input Pelanggaran</span>
    </div>

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Input Pelanggaran</h1>
            <p class="page-sub">Catat pelanggaran siswa dengan lengkap dan akurat</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.pelanggaran.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="form-card">
        <div class="form-card-header">
            <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
                <line x1="9" y1="12" x2="15" y2="12"/>
                <line x1="9" y1="16" x2="13" y2="16"/>
            </svg>
            <span class="form-card-title">Formulir Pelanggaran Siswa</span>
        </div>

        {{-- POST → piket.pelanggaran.store  (/piket/pelanggaran) --}}
        <form action="{{ route('piket.pelanggaran.store') }}" method="POST" id="pelanggaranForm">
            @csrf

            <div class="form-card-body">

                {{-- ── SEKSI: DATA SISWA ─────────────────────────────────── --}}
                <div class="form-section">
                    <p class="form-section-label">Data Siswa</p>
                </div>

                <div class="form-grid" style="margin-bottom:20px">
                    <div class="form-group col-span-2">
                        <label class="form-label" for="siswaSelect">
                            Nama Siswa <span class="req">*</span>
                        </label>
                        <select name="siswa_id" id="siswaSelect"
                            class="form-control {{ $errors->has('siswa_id') ? 'is-invalid' : '' }}"
                            onchange="onSiswaChange(this)">
                            <option value="">— Pilih Siswa —</option>
                            @foreach($siswaList as $s)
                                <option value="{{ $s->id }}"
                                    data-nama="{{ $s->nama_lengkap }}"
                                    data-nis="{{ $s->nis }}"
                                    data-kelas="{{ $s->kelas->nama_kelas ?? '-' }}"
                                    {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_lengkap }} — {{ $s->kelas->nama_kelas ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror

                        {{-- Preview kartu siswa --}}
                        <div class="siswa-preview" id="siswaPreview">
                            <div class="siswa-avatar" id="siswaInitial">—</div>
                            <div class="siswa-info">
                                <p class="name" id="siswaName">—</p>
                                <p class="meta" id="siswaMeta">—</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── SEKSI: DETAIL PELANGGARAN ─────────────────────────── --}}
                <div class="form-section">
                    <p class="form-section-label">Detail Pelanggaran</p>
                </div>

                <div class="form-grid" style="margin-bottom:20px">

                    {{-- Kategori --}}
                    <div class="form-group">
                        <label class="form-label" for="kategoriSelect">
                            Kategori Pelanggaran <span class="req">*</span>
                        </label>
                        <select name="kategori_pelanggaran_id" id="kategoriSelect"
                            class="form-control {{ $errors->has('kategori_pelanggaran_id') ? 'is-invalid' : '' }}"
                            onchange="onKategoriChange(this)">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}"
                                    data-nama="{{ $kat->nama }}"
                                    data-poin="{{ $kat->default_poin ?? '' }}"
                                    {{ old('kategori_pelanggaran_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_pelanggaran_id')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="kat-preview" id="katPreview"></div>
                    </div>

                    {{-- Poin --}}
                    <div class="form-group">
                        <label class="form-label" for="poinInput">
                            Poin Pelanggaran <span class="req">*</span>
                        </label>
                        <input type="number" name="poin" id="poinInput"
                            class="form-control {{ $errors->has('poin') ? 'is-invalid' : '' }}"
                            value="{{ old('poin', 1) }}" min="1" max="100"
                            oninput="updatePoinBar(this.value)">
                        @error('poin')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="poin-indicator">
                            <div class="poin-bar-track">
                                <div class="poin-bar-fill" id="poinBarFill" style="width:1%;background:#15803d"></div>
                            </div>
                            <span class="poin-label-right" id="poinLabel" style="color:#15803d">1 poin</span>
                        </div>
                        <p class="form-hint">Rentang 1 – 100 poin</p>
                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group">
                        <label class="form-label" for="tanggalInput">
                            Tanggal Kejadian <span class="req">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggalInput"
                            class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                            value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                        @error('tanggal')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label" for="statusSelect">
                            Status Awal <span class="req">*</span>
                        </label>
                        <select name="status" id="statusSelect"
                            class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="pending"  {{ old('status', 'pending') === 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ old('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        </select>
                        @error('status')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="form-hint">Hanya bisa diset ke Pending atau Diproses</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group col-span-2">
                        <label class="form-label" for="deskripsiInput">
                            Deskripsi Pelanggaran <span class="req">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsiInput" rows="3"
                            class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                            placeholder="Jelaskan pelanggaran yang terjadi secara singkat dan jelas…">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tindakan (opsional) --}}
                    <div class="form-group col-span-2">
                        <label class="form-label" for="tindakanInput">Tindakan yang Diambil</label>
                        <textarea name="tindakan" id="tindakanInput" rows="2"
                            class="form-control {{ $errors->has('tindakan') ? 'is-invalid' : '' }}"
                            placeholder="Isi jika sudah ada tindakan awal yang diambil (opsional)…">{{ old('tindakan') }}</textarea>
                        @error('tindakan')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="form-hint">Bisa diisi nanti saat menyelesaikan pelanggaran</p>
                    </div>

                </div>
            </div>{{-- /form-card-body --}}

            <div class="form-card-footer">
                {{-- Batal → kembali ke index --}}
                <a href="{{ route('piket.pelanggaran.index') }}" class="btn btn-secondary">Batal</a>

                {{-- Submit → store --}}
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Pelanggaran
                </button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    {{-- Tampilkan validasi error via SweetAlert2 --}}
    @if($errors->any())
    Swal.fire({
        icon: 'warning',
        title: 'Periksa Formulir',
        html: @json(implode('<br>', $errors->all())),
        confirmButtonColor: '#1f63db',
        confirmButtonText: 'Oke, perbaiki'
    });
    @endif

    /**
     * Preview info siswa setelah dipilih dari dropdown.
     */
    function onSiswaChange(sel) {
        const opt     = sel.options[sel.selectedIndex];
        const preview = document.getElementById('siswaPreview');
        const initial = document.getElementById('siswaInitial');
        const name    = document.getElementById('siswaName');
        const meta    = document.getElementById('siswaMeta');

        if (!sel.value) {
            preview.classList.remove('show');
            return;
        }

        const nama  = opt.dataset.nama  || '';
        const nis   = opt.dataset.nis   || '—';
        const kelas = opt.dataset.kelas || '—';

        initial.textContent = nama.charAt(0).toUpperCase();
        name.textContent    = nama;
        meta.textContent    = `NIS: ${nis} · Kelas: ${kelas}`;
        preview.classList.add('show');
    }

    /**
     * Preview nama kategori & isi otomatis field poin dari default_poin.
     */
    function onKategoriChange(sel) {
        const opt     = sel.options[sel.selectedIndex];
        const preview = document.getElementById('katPreview');

        if (!sel.value) {
            preview.classList.remove('show');
            return;
        }

        const nama = opt.dataset.nama || '';
        const poin = opt.dataset.poin;

        preview.textContent = `Kategori dipilih: ${nama}`;
        preview.classList.add('show');

        if (poin && parseInt(poin) > 0) {
            const poinInput = document.getElementById('poinInput');
            poinInput.value = poin;
            updatePoinBar(poin);
        }
    }

    /**
     * Update progress bar poin (hijau ≤20, kuning ≤50, merah >50).
     */
    function updatePoinBar(val) {
        const v    = Math.max(1, Math.min(100, parseInt(val) || 1));
        const fill = document.getElementById('poinBarFill');
        const lbl  = document.getElementById('poinLabel');

        let color;
        if (v <= 20)      { color = '#15803d'; }
        else if (v <= 50) { color = '#a16207'; }
        else              { color = '#dc2626'; }

        fill.style.width      = `${v}%`;
        fill.style.background = color;
        lbl.style.color       = color;
        lbl.textContent       = `${v} poin`;
    }

    /**
     * Inisialisasi state saat halaman dimuat
     * (berguna ketika ada old() value setelah validasi gagal).
     */
    document.addEventListener('DOMContentLoaded', () => {
        const siswa    = document.getElementById('siswaSelect');
        const kategori = document.getElementById('kategoriSelect');
        const poin     = document.getElementById('poinInput');

        if (siswa.value)    onSiswaChange(siswa);
        if (kategori.value) onKategoriChange(kategori);
        if (poin.value)     updatePoinBar(poin.value);
    });
</script>
</x-app-layout>