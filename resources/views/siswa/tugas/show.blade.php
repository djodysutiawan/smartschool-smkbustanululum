<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --sk-700:#1750c0;--sk-600:#1f63db;--sk-500:#3582f0;--sk-100:#d9ebff;--sk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}
    .btn-primary{background:var(--sk-600);color:#fff}
    .btn-primary:hover{background:var(--sk-700)}

    .layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start}

    .main-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .main-header{padding:20px 24px;border-bottom:1px solid var(--border)}
    .back-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .breadcrumb{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px}
    .breadcrumb a{color:var(--text3);text-decoration:none}
    .breadcrumb a:hover{color:var(--sk-600)}
    .mapel-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--sk-600);letter-spacing:.06em;text-transform:uppercase;margin-bottom:8px}
    .tugas-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:14px}
    .meta-row{display:flex;flex-wrap:wrap;gap:14px}
    .meta-item{display:flex;align-items:center;gap:5px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)}

    .content-area{padding:24px}

    .desc-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px 18px;margin-bottom:20px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6;white-space:pre-wrap}

    .file-soal{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:var(--sk-50);border:1px solid var(--sk-100);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--sk-700);text-decoration:none;margin-bottom:20px;transition:background .15s}
    .file-soal:hover{background:var(--sk-100)}

    .alert{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .a-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
    .a-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
    .a-error{background:#fee2e2;border:1px solid #fecaca;color:#dc2626}
    .a-info{background:var(--sk-50);border:1px solid var(--sk-100);color:var(--sk-700)}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .form-head{padding:13px 18px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px}
    .form-body{padding:20px}

    .field{margin-bottom:16px}
    .field label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:5px}
    .field label .req{color:#dc2626}
    .field select,.field input[type=file],.field input[type=url],.field input[type=text]{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;box-sizing:border-box}
    .field select:focus,.field input:focus{border-color:var(--sk-500);background:#fff}
    .field input[type=file]{height:auto;padding:8px 12px}
    .field textarea{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;resize:vertical;min-height:120px;transition:border-color .15s;box-sizing:border-box}
    .field textarea:focus{border-color:var(--sk-500);background:#fff}
    .field-hint{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);margin-top:4px}
    .field-err{font-family:'DM Sans',sans-serif;font-size:11.5px;color:#dc2626;margin-top:4px}

    .btn-submit{width:100%;height:42px;background:var(--sk-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;transition:background .15s}
    .btn-submit:hover{background:var(--sk-700)}
    .btn-submit:disabled{opacity:.6;cursor:not-allowed}

    .hasil-card{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius);padding:18px 20px}
    .hasil-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:#15803d;margin-bottom:12px;display:flex;align-items:center;gap:7px}
    .hasil-list{list-style:none;padding:0;margin:0}
    .hasil-list li{display:flex;justify-content:space-between;gap:10px;padding:6px 0;border-bottom:1px solid #bbf7d0;font-size:12.5px;flex-wrap:wrap}
    .hasil-list li:last-child{border-bottom:none}
    .hl-key{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:#166534}
    .hl-val{font-family:'DM Sans',sans-serif;color:#15803d;word-break:break-all}

    .sidebar-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .sc-head{padding:12px 16px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)}
    .sc-body{padding:14px 16px}
    .info-list{list-style:none;padding:0;margin:0}
    .info-list li{display:flex;justify-content:space-between;gap:10px;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:12.5px}
    .info-list li:last-child{border-bottom:none}
    .info-key{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text3)}
    .info-val{font-family:'DM Sans',sans-serif;color:var(--text2);text-align:right}

    .deadline-box{border-radius:var(--radius-sm);padding:12px 16px;text-align:center;margin-bottom:14px}
    .db-ok{background:#f0fdf4;border:1px solid #bbf7d0}
    .db-warn{background:#fffbeb;border:1px solid #fde68a}
    .db-late{background:#fff0f0;border:1px solid #fecaca}
    .db-label{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);margin-bottom:4px}
    .db-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800}
    .db-ok .db-val{color:#15803d}
    .db-warn .db-val{color:#a16207}
    .db-late .db-val{color:#dc2626}

    @media(max-width:800px){.layout{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    @if(session('success'))
    <div class="alert a-success" style="margin-bottom:16px">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="layout">

        {{-- Main --}}
        <div>
            <div class="main-card">
                <div class="main-header">
                    <div class="back-row">
                        <div class="breadcrumb">
                            <a href="{{ route('siswa.tugas.index') }}">Tugas</a>
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            <span>{{ Str::limit($tugas->judul, 40) }}</span>
                        </div>
                        <a href="{{ route('siswa.tugas.index') }}" class="btn btn-secondary">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </a>
                    </div>

                    <p class="mapel-label">{{ optional($tugas->mataPelajaran)->nama_mapel ?? '—' }}</p>
                    <h1 class="tugas-title">{{ $tugas->judul }}</h1>

                    <div class="meta-row">
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ optional($tugas->guru)->nama_lengkap ?? '—' }}
                        </span>
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Deadline: {{ $tugas->batas_waktu->format('d M Y, H:i') }} WIB
                        </span>
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            Nilai maks: {{ rtrim(rtrim(number_format($tugas->nilai_maksimal ?? 100, 2), '0'), '.') }}
                        </span>
                        <span class="meta-item">
                            {{-- FIX: tampilkan jenis pengumpulan dari kolom tugas --}}
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                            Jenis: {{ match($tugas->jenis_pengumpulan) {
                                'file'  => 'Upload File',
                                'teks'  => 'Ketik Jawaban',
                                'link'  => 'Link / URL',
                                'semua' => 'File / Teks / Link',
                                default => ucfirst($tugas->jenis_pengumpulan ?? '—')
                            } }}
                        </span>
                    </div>
                </div>

                <div class="content-area">

                    @if($tugas->deskripsi)
                    <div class="desc-box">{{ $tugas->deskripsi }}</div>
                    @endif

                    @if($tugas->path_file_soal)
                    <a href="{{ asset('storage/' . $tugas->path_file_soal) }}" target="_blank" download class="file-soal">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Unduh File Soal
                    </a>
                    @endif

                    {{-- ─── SUDAH DIKUMPULKAN ─── --}}
                    @if($sudahDikumpulkan && $pengumpulan)
                        <div class="hasil-card">
                            <p class="hasil-title">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Tugas Sudah Dikumpulkan
                            </p>
                            <ul class="hasil-list">
                                <li>
                                    <span class="hl-key">Waktu Pengumpulan</span>
                                    <span class="hl-val">{{ $pengumpulan->dikumpulkan_pada?->format('d M Y, H:i') ?? '—' }}</span>
                                </li>
                                <li>
                                    <span class="hl-key">Jenis</span>
                                    {{-- FIX: label jenis dari accessor (baca relasi tugas) --}}
                                    <span class="hl-val">{{ $pengumpulan->label_jenis }}</span>
                                </li>
                                <li>
                                    <span class="hl-key">Status</span>
                                    <span class="hl-val">{{ $pengumpulan->label_status }}</span>
                                </li>

                                {{-- FIX: gunakan nama kolom DB yang benar --}}

                                {{-- Link: kolom DB = url_link --}}
                                @if($tugas->jenis_pengumpulan === 'link' && $pengumpulan->url_link)
                                <li>
                                    <span class="hl-key">Link</span>
                                    <span class="hl-val">
                                        <a href="{{ $pengumpulan->url_link }}" target="_blank" rel="noopener noreferrer" style="color:var(--sk-600)">
                                            Buka Link
                                        </a>
                                    </span>
                                </li>
                                @endif

                                {{-- File: kolom DB = path_file --}}
                                @if($tugas->jenis_pengumpulan === 'file' && $pengumpulan->path_file)
                                <li>
                                    <span class="hl-key">File</span>
                                    <span class="hl-val">
                                        <a href="{{ asset('storage/' . $pengumpulan->path_file) }}" target="_blank" style="color:var(--sk-600)">
                                            Lihat File
                                        </a>
                                    </span>
                                </li>
                                @endif

                                {{-- Teks: kolom DB = jawaban_teks --}}
                                @if($tugas->jenis_pengumpulan === 'teks' && $pengumpulan->jawaban_teks)
                                <li style="flex-direction:column;align-items:flex-start;gap:6px">
                                    <span class="hl-key">Jawaban Teks</span>
                                    <span class="hl-val" style="text-align:left;white-space:pre-wrap;background:#dcfce7;padding:8px 10px;border-radius:6px;width:100%;box-sizing:border-box">{{ $pengumpulan->jawaban_teks }}</span>
                                </li>
                                @endif

                                {{-- Jenis 'semua': tampilkan semua yang terisi --}}
                                @if($tugas->jenis_pengumpulan === 'semua')
                                    @if($pengumpulan->url_link)
                                    <li>
                                        <span class="hl-key">Link</span>
                                        <span class="hl-val">
                                            <a href="{{ $pengumpulan->url_link }}" target="_blank" rel="noopener noreferrer" style="color:var(--sk-600)">Buka Link</a>
                                        </span>
                                    </li>
                                    @endif
                                    @if($pengumpulan->path_file)
                                    <li>
                                        <span class="hl-key">File</span>
                                        <span class="hl-val">
                                            <a href="{{ asset('storage/' . $pengumpulan->path_file) }}" target="_blank" style="color:var(--sk-600)">Lihat File</a>
                                        </span>
                                    </li>
                                    @endif
                                    @if($pengumpulan->jawaban_teks)
                                    <li style="flex-direction:column;align-items:flex-start;gap:6px">
                                        <span class="hl-key">Jawaban Teks</span>
                                        <span class="hl-val" style="text-align:left;white-space:pre-wrap;background:#dcfce7;padding:8px 10px;border-radius:6px;width:100%;box-sizing:border-box">{{ $pengumpulan->jawaban_teks }}</span>
                                    </li>
                                    @endif
                                @endif

                                @if($pengumpulan->sudahDinilai())
                                <li>
                                    <span class="hl-key">Nilai</span>
                                    <span class="hl-val" style="font-weight:700;font-size:14px">
                                        {{ rtrim(rtrim(number_format($pengumpulan->nilai, 2), '0'), '.') }}
                                        / {{ rtrim(rtrim(number_format($tugas->nilai_maksimal ?? 100, 2), '0'), '.') }}
                                    </span>
                                </li>
                                @if($pengumpulan->umpan_balik)
                                <li style="flex-direction:column;align-items:flex-start;gap:6px">
                                    <span class="hl-key">Umpan Balik Guru</span>
                                    <span class="hl-val" style="text-align:left;white-space:pre-wrap">{{ $pengumpulan->umpan_balik }}</span>
                                </li>
                                @endif
                                @endif

                            </ul>
                        </div>

                    {{-- ─── WAKTU HABIS, TIDAK BISA KUMPUL ─── --}}
                    @elseif(! $masihBisaKumpul)
                        <div class="alert a-error">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Batas waktu pengumpulan sudah habis dan pengumpulan terlambat tidak diizinkan.
                        </div>

                    {{-- ─── FORM PENGUMPULAN ─── --}}
                    @else

                        @if($terlambat)
                        <div class="alert a-warning">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            Batas waktu sudah lewat. Pengumpulan akan ditandai sebagai <strong>terlambat</strong>.
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert a-error">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            <div>
                                @foreach($errors->all() as $e)
                                    <div>{{ $e }}</div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="form-card">
                            <div class="form-head">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Form Pengumpulan Tugas
                            </div>
                            <div class="form-body">
                                {{--
                                    FIX: action sesuai route, enctype multipart wajib ada.
                                    Nama field input disesuaikan dengan kolom DB:
                                      path_file    → kolom DB: path_file
                                      jawaban_teks → kolom DB: jawaban_teks
                                      url_link     → kolom DB: url_link
                                    Kolom 'catatan' tidak ada di DB → dihapus dari form.
                                    Tidak ada select jenis_pengumpulan karena jenis
                                    sudah ditentukan di tugas (kolom DB tugas.jenis_pengumpulan).
                                --}}
                                <form action="{{ route('siswa.tugas.kumpul', $tugas) }}"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      id="formKumpul">
                                    @csrf

                                    {{-- Field upload file (jenis: file atau semua) --}}
                                    @if(in_array($tugas->jenis_pengumpulan, ['file', 'semua']))
                                    <div class="field">
                                        <label>
                                            Upload File
                                            @if(in_array($tugas->jenis_pengumpulan, ['file']))
                                                <span class="req">*</span>
                                            @endif
                                        </label>
                                        {{-- FIX: name="path_file" sesuai kolom DB --}}
                                        <input type="file"
                                               name="path_file"
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                                               {{ in_array($tugas->jenis_pengumpulan, ['file']) ? 'required' : '' }}>
                                        <p class="field-hint">Format: PDF, Word, JPG, PNG, ZIP · Maks 10MB</p>
                                        @error('path_file')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>
                                    @endif

                                    {{-- Field jawaban teks (jenis: teks atau semua) --}}
                                    @if(in_array($tugas->jenis_pengumpulan, ['teks', 'semua']))
                                    <div class="field">
                                        <label>
                                            Jawaban / Teks
                                            @if($tugas->jenis_pengumpulan === 'teks')
                                                <span class="req">*</span>
                                            @endif
                                        </label>
                                        {{-- FIX: name="jawaban_teks" sesuai kolom DB --}}
                                        <textarea name="jawaban_teks"
                                                  placeholder="Ketik jawaban Anda di sini…"
                                                  {{ $tugas->jenis_pengumpulan === 'teks' ? 'required' : '' }}>{{ old('jawaban_teks') }}</textarea>
                                        @error('jawaban_teks')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>
                                    @endif

                                    {{-- Field link/URL (jenis: link atau semua) --}}
                                    @if(in_array($tugas->jenis_pengumpulan, ['link', 'semua']))
                                    <div class="field">
                                        <label>
                                            Link / URL
                                            @if($tugas->jenis_pengumpulan === 'link')
                                                <span class="req">*</span>
                                            @endif
                                        </label>
                                        {{-- FIX: name="url_link" sesuai kolom DB --}}
                                        <input type="url"
                                               name="url_link"
                                               placeholder="https://…"
                                               value="{{ old('url_link') }}"
                                               {{ $tugas->jenis_pengumpulan === 'link' ? 'required' : '' }}>
                                        <p class="field-hint">Contoh: link Google Drive, GitHub, dsb.</p>
                                        @error('url_link')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>
                                    @endif

                                    <button type="submit" class="btn-submit" id="btnSubmit">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        Kumpulkan Tugas
                                    </button>
                                </form>
                            </div>
                        </div>

                    @endif

                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            @php
                $jamSisa = (int) now()->diffInHours($tugas->batas_waktu, false);
                $dbClass = $terlambat ? 'db-late' : ($jamSisa < 24 ? 'db-warn' : 'db-ok');
                $dbText  = $terlambat
                    ? 'Sudah Berakhir'
                    : now()->diffForHumans($tugas->batas_waktu, ['parts' => 2]);
            @endphp
            <div class="deadline-box {{ $dbClass }}">
                <p class="db-label">Sisa Waktu</p>
                <p class="db-val">{{ $dbText }}</p>
                <p class="db-label" style="margin-top:4px">{{ $tugas->batas_waktu->format('d M Y · H:i') }} WIB</p>
            </div>

            <div class="sidebar-card">
                <div class="sc-head">Detail Tugas</div>
                <div class="sc-body">
                    <ul class="info-list">
                        <li>
                            <span class="info-key">Mata Pelajaran</span>
                            <span class="info-val">{{ optional($tugas->mataPelajaran)->nama_mapel ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Guru</span>
                            <span class="info-val">{{ optional($tugas->guru)->nama_lengkap ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Kelas</span>
                            <span class="info-val">{{ $tugas->kelas->nama ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Jenis Pengumpulan</span>
                            {{-- FIX: tampilkan dari kolom tugas --}}
                            <span class="info-val">{{ match($tugas->jenis_pengumpulan) {
                                'file'  => 'Upload File',
                                'teks'  => 'Ketik Jawaban',
                                'link'  => 'Link / URL',
                                'semua' => 'Semua Format',
                                default => ucfirst($tugas->jenis_pengumpulan ?? '—')
                            } }}</span>
                        </li>
                        <li>
                            <span class="info-key">Nilai Maks</span>
                            <span class="info-val">{{ rtrim(rtrim(number_format($tugas->nilai_maksimal ?? 100, 2), '0'), '.') }}</span>
                        </li>
                        <li>
                            <span class="info-key">Pengumpulan Terlambat</span>
                            <span class="info-val">{{ $tugas->izinkan_terlambat ? 'Diizinkan' : 'Tidak' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Status Saya</span>
                            <span class="info-val" style="font-weight:700;color:{{ $sudahDikumpulkan ? '#15803d' : ($terlambat ? '#dc2626' : '#1d4ed8') }}">
                                {{ $sudahDikumpulkan ? 'Sudah Dikumpulkan' : ($terlambat ? 'Terlambat' : 'Belum') }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// FIX: Disable tombol hanya setelah form lolos validasi HTML bawaan browser.
// Jika browser menangkap field invalid (required kosong, url salah format, dll),
// form tidak jadi dikirim — tombol TIDAK di-disable agar user bisa coba lagi.
var formKumpul = document.getElementById('formKumpul');
var btnSubmit  = document.getElementById('btnSubmit');

if (formKumpul && btnSubmit) {
    formKumpul.addEventListener('submit', function(e) {
        // checkValidity() menjalankan validasi HTML5 tanpa menampilkan pesan
        if (!formKumpul.checkValidity()) {
            // Biarkan browser tampilkan pesan validasi native, jangan disable
            return;
        }
        // Form valid dan akan benar-benar dikirim — disable untuk cegah double submit
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg> Mengirim…';
    });
}

// Re-enable tombol saat user kembali ke halaman ini via tombol Back browser
// (pageshow lebih reliable daripada load untuk kasus bfcache)
window.addEventListener('pageshow', function(e) {
    if (btnSubmit) {
        btnSubmit.disabled = false;
    }
});
</script>
</x-app-layout>