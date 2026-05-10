<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;--s-400:#3b82f6;
        --s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;
        --p-500:#8b5cf6;--p-100:#ede9fe;--p-50:#f5f3ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Instrument Sans',sans-serif;}
    .page{padding:24px 28px 64px;}

    .page-header{display:flex;align-items:center;gap:14px;margin-bottom:24px;}
    .back-btn{display:inline-flex;align-items:center;gap:6px;height:36px;padding:0 14px;border-radius:var(--radius-sm);background:var(--surface);border:1px solid var(--border);font-family:'Outfit',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s;flex-shrink:0;}
    .back-btn:hover{background:var(--surface3);color:var(--text);}
    .page-title{font-family:'Outfit',sans-serif;font-size:21px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text4);margin-top:3px;}

    .form-layout{display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start;}

    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;}
    .card-header{padding:16px 20px;border-bottom:1px solid var(--border);}
    .card-header-title{font-family:'Outfit',sans-serif;font-size:14px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;}
    .card-body{padding:20px;}

    .form-group{margin-bottom:18px;}
    .form-group:last-child{margin-bottom:0;}
    .form-label{font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:7px;}
    .form-label .req{color:var(--r-500);margin-left:2px;}
    .form-control{width:100%;height:42px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-xs);font-family:'Instrument Sans',sans-serif;font-size:14px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .form-control:focus{border-color:var(--s-400);background:var(--surface);box-shadow:0 0 0 3px rgba(59,130,246,.1);}
    .form-control.is-invalid{border-color:var(--r-500);}
    .form-hint{font-size:12px;color:var(--text4);margin-top:5px;}
    .form-error{font-size:12px;color:var(--r-500);margin-top:5px;display:flex;align-items:center;gap:4px;}

    /* ── Tipe Toggle ── */
    .tipe-toggle{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:20px;}
    .tipe-option{display:none;}
    .tipe-label{display:flex;align-items:center;gap:10px;padding:12px 14px;border:2px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;background:var(--surface2);}
    .tipe-option:checked + .tipe-label{border-color:var(--s-500);background:var(--s-50);}
    .tipe-option.guru:checked + .tipe-label{border-color:var(--p-500);background:var(--p-50);}
    .tipe-label-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .tipe-label-icon.siswa-icon{background:var(--s-100);}
    .tipe-label-icon.guru-icon{background:var(--p-100);}
    .tipe-label-text{font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .tipe-label-sub{font-size:11.5px;color:var(--text4);margin-top:1px;}

    /* ── Search input ── */
    .search-wrap{position:relative;}
    .search-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);pointer-events:none;}
    .search-input{padding-left:38px !important;}
    .search-results{position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:20;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);box-shadow:0 8px 32px rgba(0,0,0,.1);max-height:260px;overflow-y:auto;display:none;}
    .search-results.open{display:block;}
    .search-result-item{display:flex;align-items:center;gap:10px;padding:10px 14px;cursor:pointer;transition:background .1s;border-bottom:1px solid var(--border);}
    .search-result-item:last-child{border-bottom:none;}
    .search-result-item:hover{background:var(--s-50);}
    .search-result-item.guru-item:hover{background:var(--p-50);}
    .result-avatar{width:32px;height:32px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-size:12px;font-weight:800;color:#fff;}
    .result-avatar.siswa-av{background:linear-gradient(135deg,var(--s-600),var(--s-400));}
    .result-avatar.guru-av{background:linear-gradient(135deg,var(--p-500),#a78bfa);}
    .result-nama{font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .result-meta{font-size:11.5px;color:var(--text4);margin-top:1px;}

    /* ── Selected box ── */
    .selected-box{display:none;align-items:center;gap:10px;padding:12px 14px;border-radius:var(--radius-xs);margin-top:8px;}
    .selected-box.show{display:flex;}
    .selected-box.siswa-selected{background:var(--s-50);border:1px solid var(--s-100);}
    .selected-box.guru-selected{background:var(--p-50);border:1px solid var(--p-100);}
    .selected-avatar{width:38px;height:38px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-size:14px;font-weight:800;color:#fff;}
    .selected-avatar.siswa-av{background:linear-gradient(135deg,var(--s-600),var(--s-400));}
    .selected-avatar.guru-av{background:linear-gradient(135deg,var(--p-500),#a78bfa);}
    .selected-nama{font-family:'Outfit',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);}
    .selected-meta{font-size:12px;color:var(--text3);margin-top:2px;}
    .selected-clear{margin-left:auto;cursor:pointer;color:var(--text4);transition:color .15s;background:none;border:none;line-height:1;}
    .selected-clear:hover{color:var(--r-500);}

    /* ── Section visibility ── */
    .section-siswa{display:block;}
    .section-guru{display:none;}

    /* ── Preview card ── */
    .preview-card{border-radius:var(--radius);padding:20px;color:#fff;position:relative;overflow:hidden;}
    .preview-card.siswa-preview{background:linear-gradient(145deg,var(--s-800),var(--s-700));}
    .preview-card.guru-preview{background:linear-gradient(145deg,#2d1b69,var(--p-500));}
    .preview-card::before{content:'';position:absolute;top:-30px;right:-30px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;}
    .preview-label{font-size:11px;font-weight:700;font-family:'Outfit',sans-serif;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;}
    .preview-kode{font-family:'Outfit',sans-serif;font-size:12px;font-weight:800;color:#fff;letter-spacing:.1em;word-break:break-all;}
    .preview-nama{font-family:'Outfit',sans-serif;font-size:16px;font-weight:800;color:#fff;margin-top:12px;}
    .preview-meta{font-size:12px;color:rgba(255,255,255,.5);margin-top:4px;}
    .preview-divider{height:1px;background:rgba(255,255,255,.1);margin:14px 0;}
    .preview-row{display:flex;justify-content:space-between;font-size:12px;color:rgba(255,255,255,.6);margin-top:6px;}
    .preview-row strong{color:rgba(255,255,255,.9);}
    .barcode-wrap{background:#fff;border-radius:8px;padding:12px 10px 8px;margin-top:14px;text-align:center;}
    .barcode-wrap svg{width:100%;height:auto;}
    .barcode-sub{font-family:'Outfit',sans-serif;font-size:10px;color:var(--text3);margin-top:4px;letter-spacing:.06em;}

    .info-box{border-radius:var(--radius-sm);padding:14px 16px;margin-bottom:16px;}
    .info-box.blue{background:var(--s-50);border:1px solid var(--s-100);}
    .info-box.purple{background:var(--p-50);border:1px solid var(--p-100);}
    .info-box-title{font-family:'Outfit',sans-serif;font-size:12.5px;font-weight:700;margin-bottom:6px;display:flex;align-items:center;gap:6px;}
    .info-box.blue .info-box-title{color:var(--s-600);}
    .info-box.purple .info-box-title{color:var(--p-500);}
    .info-box-text{font-size:12.5px;color:var(--text3);line-height:1.6;}

    .btn{display:inline-flex;align-items:center;gap:7px;height:42px;padding:0 20px;border-radius:var(--radius-sm);font-family:'Outfit',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;}
    .btn-primary{background:var(--s-600);color:#fff;width:100%;justify-content:center;}
    .btn-primary:hover{background:var(--s-700);}
    .btn-purple{background:var(--p-500);color:#fff;width:100%;justify-content:center;}
    .btn-purple:hover{background:#7c3aed;}
    .btn-success{background:var(--g-500);color:#fff;width:100%;justify-content:center;}
    .btn-success:hover{background:#059669;}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface3);}

    .form-actions{display:flex;flex-direction:column;gap:8px;margin-top:20px;}

    @media(max-width:768px){
        .page{padding:14px 14px 56px;}
        .form-layout{grid-template-columns:1fr;}
    }
</style>

<div class="page">
    <div class="page-header">
        <a href="{{ route('admin.barcode-gerbang.index') }}" class="back-btn">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <div>
            <h1 class="page-title">Buat Barcode Gerbang</h1>
            <p class="page-sub">Buat barcode baru untuk siswa atau guru</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.barcode-gerbang.store') }}" id="createForm">
        @csrf
        <input type="hidden" name="langsung_cetak" id="langsungCetakInput" value="0">

        <div class="form-layout">

            {{-- ── Kiri: Form ────────────────────────────── --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <span class="card-header-title">
                            <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Data Pemilik Barcode
                        </span>
                    </div>
                    <div class="card-body">

                        {{-- Tipe Pemilik --}}
                        <div class="form-group">
                            <label class="form-label">Tipe Pemilik <span class="req">*</span></label>
                            <div class="tipe-toggle">
                                <div>
                                    <input type="radio" name="tipe_pemilik" value="siswa" id="tipeSiswa"
                                        class="tipe-option"
                                        {{ old('tipe_pemilik', $guru ? 'guru' : 'siswa') === 'siswa' ? 'checked' : '' }}
                                        onchange="onTipeChange()">
                                    <label for="tipeSiswa" class="tipe-label">
                                        <div class="tipe-label-icon siswa-icon">
                                            <svg width="18" height="18" fill="none" stroke="var(--s-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        </div>
                                        <div>
                                            <p class="tipe-label-text">Siswa</p>
                                            <p class="tipe-label-sub">Barcode untuk siswa</p>
                                        </div>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="tipe_pemilik" value="guru" id="tipeGuru"
                                        class="tipe-option guru"
                                        {{ old('tipe_pemilik', $guru ? 'guru' : 'siswa') === 'guru' ? 'checked' : '' }}
                                        onchange="onTipeChange()">
                                    <label for="tipeGuru" class="tipe-label">
                                        <div class="tipe-label-icon guru-icon">
                                            <svg width="18" height="18" fill="none" stroke="var(--p-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        </div>
                                        <div>
                                            <p class="tipe-label-text">Guru</p>
                                            <p class="tipe-label-sub">Barcode untuk guru/staf</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('tipe_pemilik')
                                <p class="form-error">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ── SECTION SISWA ── --}}
                        <div class="section-siswa" id="sectionSiswa">
                            <div class="info-box blue">
                                <p class="info-box-title">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    Catatan
                                </p>
                                <p class="info-box-text">Barcode lama milik siswa akan otomatis dinonaktifkan. Kode baru di-generate otomatis berdasarkan NIS dan tahun.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pilih Siswa <span class="req">*</span></label>
                                <input type="hidden" name="siswa_id" id="siswaId" value="{{ old('siswa_id', $siswa?->id) }}">
                                <div class="search-wrap">
                                    <span class="search-icon">
                                        <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    </span>
                                    <input type="text" id="siswaSearch" class="form-control search-input @error('siswa_id') is-invalid @enderror"
                                        placeholder="Ketik nama atau NIS siswa..."
                                        value="{{ $siswa ? $siswa->nama_lengkap . ' — ' . $siswa->nis : '' }}"
                                        autocomplete="off">
                                    <div class="search-results" id="siswaResults"></div>
                                </div>
                                <div class="selected-box siswa-selected {{ $siswa ? 'show' : '' }}" id="siswaSelected">
                                    <div class="selected-avatar siswa-av" id="siswaAvatar">
                                        {{ strtoupper(substr($siswa?->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="selected-nama" id="siswaNama">{{ $siswa?->nama_lengkap ?? '' }}</p>
                                        <p class="selected-meta" id="siswaMeta">{{ $siswa ? 'NIS '.$siswa->nis.' · '.($siswa->kelas->nama_kelas ?? '—') : '' }}</p>
                                    </div>
                                    <button type="button" class="selected-clear" onclick="clearSiswa()" title="Ganti siswa">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                                @error('siswa_id')
                                    <p class="form-error">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- ── SECTION GURU ── --}}
                        <div class="section-guru" id="sectionGuru">
                            <div class="info-box purple">
                                <p class="info-box-title">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    Catatan
                                </p>
                                <p class="info-box-text">Barcode lama milik guru akan otomatis dinonaktifkan. Kode baru di-generate otomatis berdasarkan NIP dan tahun.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pilih Guru <span class="req">*</span></label>
                                <input type="hidden" name="guru_id" id="guruId" value="{{ old('guru_id', $guru?->id) }}">
                                <div class="search-wrap">
                                    <span class="search-icon">
                                        <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    </span>
                                    <input type="text" id="guruSearch" class="form-control search-input @error('guru_id') is-invalid @enderror"
                                        placeholder="Ketik nama atau NIP guru..."
                                        value="{{ $guru ? $guru->nama_lengkap . ' — ' . $guru->nip : '' }}"
                                        autocomplete="off">
                                    <div class="search-results" id="guruResults"></div>
                                </div>
                                <div class="selected-box guru-selected {{ $guru ? 'show' : '' }}" id="guruSelected">
                                    <div class="selected-avatar guru-av" id="guruAvatar">
                                        {{ strtoupper(substr($guru?->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="selected-nama" id="guruNama">{{ $guru?->nama_lengkap ?? '' }}</p>
                                        <p class="selected-meta" id="guruMeta">{{ $guru ? 'NIP '.$guru->nip.' · '.($guru->status_kepegawaian ?? '—') : '' }}</p>
                                    </div>
                                    <button type="button" class="selected-clear" onclick="clearGuru()" title="Ganti guru">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                                @error('guru_id')
                                    <p class="form-error">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Berlaku Mulai --}}
                        <div class="form-group">
                            <label class="form-label">Berlaku Mulai <span class="req">*</span></label>
                            <input type="date" name="berlaku_mulai" class="form-control @error('berlaku_mulai') is-invalid @enderror"
                                value="{{ old('berlaku_mulai', today()->toDateString()) }}" required
                                oninput="updatePreview()">
                            @error('berlaku_mulai')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Berlaku Sampai --}}
                        <div class="form-group">
                            <label class="form-label">Berlaku Sampai</label>
                            <input type="date" name="berlaku_sampai" class="form-control @error('berlaku_sampai') is-invalid @enderror"
                                value="{{ old('berlaku_sampai') }}"
                                oninput="updatePreview()">
                            <p class="form-hint">Kosongkan jika berlaku selamanya</p>
                            @error('berlaku_sampai')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control"
                                placeholder="Misal: Tahun Ajaran 2025/2026"
                                value="{{ old('keterangan') }}">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.barcode-gerbang.index') }}" class="btn btn-outline" style="width:100%;justify-content:center">Batal</a>
                    <button type="button" onclick="submitForm(false)" class="btn btn-primary" id="btnSimpan">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
                        Buat Barcode
                    </button>
                    <button type="button" onclick="submitForm(true)" class="btn btn-success">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                        Simpan &amp; Cetak
                    </button>
                </div>
            </div>

            {{-- ── Kanan: Preview ────────────────────────── --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <span class="card-header-title">
                            <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                            Preview Barcode
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="preview-card siswa-preview" id="previewCard">
                            <p class="preview-label" id="previewTipeLabel">Barcode Gerbang — Siswa</p>
                            <p class="preview-kode" id="previewKode">SIS-[NIS]-{{ now()->year }}-XXXX</p>

                            <div class="barcode-wrap">
                                <svg id="previewBarcodeSvg"></svg>
                                <p class="barcode-sub" id="previewBarcodeText">SIS-[NIS]-{{ now()->year }}-XXXX</p>
                            </div>

                            <div class="preview-divider"></div>
                            <p class="preview-nama" id="previewNama">—</p>
                            <p class="preview-meta" id="previewMeta">—</p>
                            <div class="preview-divider"></div>
                            <div class="preview-row">
                                <span>Berlaku mulai</span>
                                <strong id="previewMulai">{{ today()->format('d M Y') }}</strong>
                            </div>
                            <div class="preview-row">
                                <span>Berlaku sampai</span>
                                <strong id="previewSampai">Selamanya</strong>
                            </div>
                        </div>
                        <p style="font-size:11.5px;color:var(--text4);margin-top:10px;text-align:center">
                            Kode final di-generate otomatis saat disimpan
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
// ── State ────────────────────────────────────────────────────────────────
let selectedSiswaId  = '{{ old('siswa_id', $siswa?->id ?? '') }}';
let selectedGuruId   = '{{ old('guru_id',  $guru?->id  ?? '') }}';
let selectedSiswaNis = '{{ $siswa?->nis ?? '' }}';
let selectedGuruNip  = '{{ $guru?->nip ?? '' }}';
let currentTipe      = document.querySelector('[name=tipe_pemilik]:checked')?.value ?? 'siswa';

const YEAR = {{ now()->year }};

// ── Submit ────────────────────────────────────────────────────────────────
function submitForm(cetak) {
    document.getElementById('langsungCetakInput').value = cetak ? '1' : '0';
    document.getElementById('createForm').submit();
}

// ── Tipe change ───────────────────────────────────────────────────────────
function onTipeChange() {
    currentTipe = document.querySelector('[name=tipe_pemilik]:checked').value;
    const isSiswa = currentTipe === 'siswa';

    document.getElementById('sectionSiswa').style.display = isSiswa ? 'block' : 'none';
    document.getElementById('sectionGuru').style.display  = isSiswa ? 'none'  : 'block';

    const card = document.getElementById('previewCard');
    card.className = 'preview-card ' + (isSiswa ? 'siswa-preview' : 'guru-preview');

    const prefix = isSiswa ? 'SIS' : 'GUR';
    const id     = isSiswa ? (selectedSiswaNis || '[NIS]') : (selectedGuruNip || '[NIP]');
    const kode   = `${prefix}-${id}-${YEAR}-XXXX`;

    document.getElementById('previewTipeLabel').textContent = `Barcode Gerbang — ${isSiswa ? 'Siswa' : 'Guru'}`;
    document.getElementById('previewKode').textContent = kode;
    document.getElementById('previewBarcodeText').textContent = kode;
    document.getElementById('previewNama').textContent = '—';
    document.getElementById('previewMeta').textContent = '—';
    renderBarcode(kode);
}

// ── Siswa search ──────────────────────────────────────────────────────────
let siswaTimer;
const siswaSearch  = document.getElementById('siswaSearch');
const siswaResults = document.getElementById('siswaResults');

siswaSearch.addEventListener('input', function () {
    clearTimeout(siswaTimer);
    const q = this.value.trim();
    if (q.length < 2) { siswaResults.classList.remove('open'); return; }
    siswaTimer = setTimeout(() => fetchSiswa(q), 300);
});
siswaSearch.addEventListener('focus', function () {
    if (this.value.trim().length >= 2) siswaResults.classList.add('open');
});

async function fetchSiswa(q) {
    try {
        const res  = await fetch(`/admin/siswa/search?q=${encodeURIComponent(q)}&per_page=8`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        renderSiswaResults(data.data ?? data);
    } catch (e) { console.warn('Siswa search error:', e); }
}

function renderSiswaResults(list) {
    if (!list.length) {
        siswaResults.innerHTML = '<div style="padding:16px;text-align:center;font-size:13px;color:#94a3b8">Siswa tidak ditemukan</div>';
    } else {
        siswaResults.innerHTML = list.map(s => `
            <div class="search-result-item" onclick="selectSiswa(${s.id},'${esc(s.nama_lengkap)}','${esc(s.nis??'')}','${esc(s.kelas?.nama_kelas??'—')}')">
                <div class="result-avatar siswa-av">${s.nama_lengkap.charAt(0).toUpperCase()}</div>
                <div>
                    <p class="result-nama">${s.nama_lengkap}</p>
                    <p class="result-meta">NIS ${s.nis??'—'} · ${s.kelas?.nama_kelas??'—'}</p>
                </div>
            </div>
        `).join('');
    }
    siswaResults.classList.add('open');
}

function selectSiswa(id, nama, nis, kelas) {
    selectedSiswaId  = id;
    selectedSiswaNis = nis;
    document.getElementById('siswaId').value = id;
    siswaSearch.value = '';
    siswaResults.classList.remove('open');

    document.getElementById('siswaAvatar').textContent = nama.charAt(0).toUpperCase();
    document.getElementById('siswaNama').textContent   = nama;
    document.getElementById('siswaMeta').textContent   = `NIS ${nis} · ${kelas}`;
    document.getElementById('siswaSelected').classList.add('show');

    const kode = `SIS-${nis}-${YEAR}-XXXX`;
    updatePreviewPemilik(nama, `NIS ${nis} · ${kelas}`, kode);
}

function clearSiswa() {
    selectedSiswaId = selectedSiswaNis = '';
    document.getElementById('siswaId').value = '';
    siswaSearch.value = '';
    document.getElementById('siswaSelected').classList.remove('show');
    const kode = `SIS-[NIS]-${YEAR}-XXXX`;
    document.getElementById('previewNama').textContent = '—';
    document.getElementById('previewMeta').textContent = '—';
    document.getElementById('previewKode').textContent = kode;
    document.getElementById('previewBarcodeText').textContent = kode;
    renderBarcode(kode);
}

// ── Guru search ───────────────────────────────────────────────────────────
let guruTimer;
const guruSearch  = document.getElementById('guruSearch');
const guruResults = document.getElementById('guruResults');

guruSearch.addEventListener('input', function () {
    clearTimeout(guruTimer);
    const q = this.value.trim();
    if (q.length < 2) { guruResults.classList.remove('open'); return; }
    guruTimer = setTimeout(() => fetchGuru(q), 300);
});
guruSearch.addEventListener('focus', function () {
    if (this.value.trim().length >= 2) guruResults.classList.add('open');
});

async function fetchGuru(q) {
    try {
        const res  = await fetch(`/admin/barcode-gerbang/search-guru?q=${encodeURIComponent(q)}&per_page=8`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        renderGuruResults(data);
    } catch (e) { console.warn('Guru search error:', e); }
}

function renderGuruResults(list) {
    if (!list.length) {
        guruResults.innerHTML = '<div style="padding:16px;text-align:center;font-size:13px;color:#94a3b8">Guru tidak ditemukan</div>';
    } else {
        guruResults.innerHTML = list.map(g => `
            <div class="search-result-item guru-item" onclick="selectGuru(${g.id},'${esc(g.nama_lengkap)}','${esc(g.nip??'')}','${esc(g.status_kepegawaian??'—')}')">
                <div class="result-avatar guru-av">${g.nama_lengkap.charAt(0).toUpperCase()}</div>
                <div>
                    <p class="result-nama">${g.nama_lengkap}</p>
                    <p class="result-meta">NIP ${g.nip??'—'} · ${g.status_kepegawaian??'—'}</p>
                </div>
            </div>
        `).join('');
    }
    guruResults.classList.add('open');
}

function selectGuru(id, nama, nip, status) {
    selectedGuruId  = id;
    selectedGuruNip = nip;
    document.getElementById('guruId').value = id;
    guruSearch.value = '';
    guruResults.classList.remove('open');

    document.getElementById('guruAvatar').textContent = nama.charAt(0).toUpperCase();
    document.getElementById('guruNama').textContent   = nama;
    document.getElementById('guruMeta').textContent   = `NIP ${nip} · ${status}`;
    document.getElementById('guruSelected').classList.add('show');

    const kode = `GUR-${nip}-${YEAR}-XXXX`;
    updatePreviewPemilik(nama, `NIP ${nip} · ${status}`, kode);
}

function clearGuru() {
    selectedGuruId = selectedGuruNip = '';
    document.getElementById('guruId').value = '';
    guruSearch.value = '';
    document.getElementById('guruSelected').classList.remove('show');
    const kode = `GUR-[NIP]-${YEAR}-XXXX`;
    document.getElementById('previewNama').textContent = '—';
    document.getElementById('previewMeta').textContent = '—';
    document.getElementById('previewKode').textContent = kode;
    document.getElementById('previewBarcodeText').textContent = kode;
    renderBarcode(kode);
}

// ── Close dropdown on outside click ──────────────────────────────────────
document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-wrap')) {
        siswaResults.classList.remove('open');
        guruResults.classList.remove('open');
    }
});

// ── Preview helpers ───────────────────────────────────────────────────────
function updatePreviewPemilik(nama, meta, kode) {
    document.getElementById('previewNama').textContent = nama;
    document.getElementById('previewMeta').textContent = meta;
    document.getElementById('previewKode').textContent = kode;
    document.getElementById('previewBarcodeText').textContent = kode;
    renderBarcode(kode);
}

function updatePreview() {
    const mulai  = document.querySelector('[name=berlaku_mulai]').value;
    const sampai = document.querySelector('[name=berlaku_sampai]').value;
    const fmt = d => d ? new Date(d).toLocaleDateString('id-ID', {day:'numeric',month:'short',year:'numeric'}) : '—';
    document.getElementById('previewMulai').textContent  = mulai  ? fmt(mulai)  : '—';
    document.getElementById('previewSampai').textContent = sampai ? fmt(sampai) : 'Selamanya';
}

function renderBarcode(kode) {
    try {
        JsBarcode('#previewBarcodeSvg', kode, {
            format:'CODE128', width:1.8, height:55,
            displayValue:false, margin:0, lineColor:'#0f172a',
        });
    } catch(e) {}
}

function esc(s) { return String(s).replace(/\\/g,'\\\\').replace(/'/g,"\\'").replace(/"/g,'&quot;'); }

// ── Init ──────────────────────────────────────────────────────────────────
// Set tipe awal
onTipeChange();

// Restore preview jika ada preselected siswa/guru (via old() atau query string)
@if($siswa)
    selectSiswa({{ $siswa->id }}, '{{ addslashes($siswa->nama_lengkap) }}', '{{ $siswa->nis }}', '{{ addslashes($siswa->kelas->nama_kelas ?? '—') }}');
@elseif($guru)
    selectGuru({{ $guru->id }}, '{{ addslashes($guru->nama_lengkap) }}', '{{ $guru->nip }}', '{{ addslashes($guru->status_kepegawaian ?? '—') }}');
@else
    renderBarcode(`SIS-[NIS]-${YEAR}-XXXX`);
@endif
</script>
</x-app-layout>