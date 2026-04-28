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
    .btn-success{background:#15803d;color:#fff}
    .btn-success:hover{background:#166534}

    .layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start}

    /* Main card */
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

    /* Deskripsi */
    .desc-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px 18px;margin-bottom:20px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6}

    /* File soal */
    .file-soal{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:var(--sk-50);border:1px solid var(--sk-100);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--sk-700);text-decoration:none;margin-bottom:20px;transition:background .15s}
    .file-soal:hover{background:var(--sk-100)}

    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .a-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
    .a-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
    .a-error{background:#fee2e2;border:1px solid #fecaca;color:#dc2626}
    .a-info{background:var(--sk-50);border:1px solid var(--sk-100);color:var(--sk-700)}

    /* Form pengumpulan */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .form-head{padding:13px 18px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px}
    .form-body{padding:20px}

    .field{margin-bottom:16px}
    .field label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:5px}
    .field label .req{color:#dc2626}
    .field select,.field input[type=file],.field input[type=url]{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;box-sizing:border-box}
    .field select:focus,.field input:focus{border-color:var(--sk-500);background:#fff}
    .field input[type=file]{height:auto;padding:8px 12px}
    .field textarea{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;resize:vertical;min-height:120px;transition:border-color .15s;box-sizing:border-box}
    .field textarea:focus{border-color:var(--sk-500);background:#fff}
    .field-hint{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);margin-top:4px}
    .field-err{font-family:'DM Sans',sans-serif;font-size:11.5px;color:#dc2626;margin-top:4px}

    .btn-submit{width:100%;height:42px;background:var(--sk-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;transition:background .15s}
    .btn-submit:hover{background:var(--sk-700)}

    /* Hasil pengumpulan */
    .hasil-card{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius);padding:18px 20px}
    .hasil-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:#15803d;margin-bottom:12px;display:flex;align-items:center;gap:7px}
    .hasil-list{list-style:none;padding:0;margin:0}
    .hasil-list li{display:flex;justify-content:space-between;gap:10px;padding:6px 0;border-bottom:1px solid #bbf7d0;font-size:12.5px}
    .hasil-list li:last-child{border-bottom:none}
    .hl-key{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:#166534}
    .hl-val{font-family:'DM Sans',sans-serif;color:#15803d}

    /* Sidebar */
    .sidebar-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .sc-head{padding:12px 16px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)}
    .sc-body{padding:14px 16px}
    .info-list{list-style:none;padding:0;margin:0}
    .info-list li{display:flex;justify-content:space-between;gap:10px;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:12.5px}
    .info-list li:last-child{border-bottom:none}
    .info-key{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text3)}
    .info-val{font-family:'DM Sans',sans-serif;color:var(--text2);text-align:right}

    /* Deadline box */
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

    {{-- Flash --}}
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
                    <p class="mapel-label">{{ $tugas->mataPelajaran->nama_mapel ?? '—' }}</p>
                    <h1 class="tugas-title">{{ $tugas->judul }}</h1>
                    <div class="meta-row">
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $tugas->guru->nama_lengkap ?? '—' }}
                        </span>
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Deadline: {{ $tugas->batas_waktu->format('d M Y, H:i') }} WIB
                        </span>
                        <span class="meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            Nilai maks: {{ $tugas->nilai_maksimal ?? 100 }}
                        </span>
                    </div>
                </div>

                <div class="content-area">

                    {{-- Deskripsi --}}
                    @if($tugas->deskripsi)
                    <div class="desc-box">{{ $tugas->deskripsi }}</div>
                    @endif

                    {{-- File soal --}}
                    @if($tugas->path_file_soal)
                    <a href="{{ asset('storage/'.$tugas->path_file_soal) }}" target="_blank" download class="file-soal">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Unduh File Soal
                    </a>
                    @endif

                    {{-- Status pengumpulan --}}
                    @if($sudahDikumpulkan)
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
                                    <span class="hl-val">{{ ucfirst($pengumpulan->jenis_pengumpulan) }}</span>
                                </li>
                                <li>
                                    <span class="hl-key">Status</span>
                                    <span class="hl-val">{{ ucfirst(str_replace('_', ' ', $pengumpulan->status)) }}</span>
                                </li>
                                @if($pengumpulan->catatan)
                                <li>
                                    <span class="hl-key">Catatan</span>
                                    <span class="hl-val">{{ $pengumpulan->catatan }}</span>
                                </li>
                                @endif
                                @if($pengumpulan->jenis_pengumpulan === 'link')
                                <li>
                                    <span class="hl-key">Link</span>
                                    <span class="hl-val"><a href="{{ $pengumpulan->link_pengumpulan }}" target="_blank" style="color:var(--sk-600)">Buka Link</a></span>
                                </li>
                                @elseif($pengumpulan->file_pengumpulan)
                                <li>
                                    <span class="hl-key">File</span>
                                    <span class="hl-val"><a href="{{ asset('storage/'.$pengumpulan->file_pengumpulan) }}" target="_blank" style="color:var(--sk-600)">Lihat File</a></span>
                                </li>
                                @endif
                            </ul>
                        </div>

                    @elseif(!$masihBisaKumpul)
                        <div class="alert a-error">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Batas waktu pengumpulan sudah habis dan pengumpulan terlambat tidak diizinkan.
                        </div>

                    @else
                        {{-- Form pengumpulan --}}
                        @if($terlambat)
                        <div class="alert a-warning" style="margin-bottom:16px">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            Batas waktu sudah lewat. Pengumpulan akan ditandai sebagai <strong>terlambat</strong>.
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert a-error" style="margin-bottom:16px">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                        </div>
                        @endif

                        <div class="form-card">
                            <div class="form-head">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Form Pengumpulan Tugas
                            </div>
                            <div class="form-body">
                                <form action="{{ route('siswa.tugas.kumpul', $tugas) }}" method="POST" enctype="multipart/form-data" id="formKumpul">
                                    @csrf

                                    <div class="field">
                                        <label>Jenis Pengumpulan <span class="req">*</span></label>
                                        <select name="jenis_pengumpulan" id="jenisSel" onchange="toggleJenis(this.value)" required>
                                            <option value="">— Pilih jenis —</option>
                                            <option value="file"  {{ old('jenis_pengumpulan') === 'file'  ? 'selected' : '' }}>📄 Upload File (PDF, Word, ZIP)</option>
                                            <option value="foto"  {{ old('jenis_pengumpulan') === 'foto'  ? 'selected' : '' }}>📷 Upload Foto</option>
                                            <option value="teks"  {{ old('jenis_pengumpulan') === 'teks'  ? 'selected' : '' }}>📝 Ketik Jawaban</option>
                                            <option value="link"  {{ old('jenis_pengumpulan') === 'link'  ? 'selected' : '' }}>🔗 Link / URL</option>
                                        </select>
                                        @error('jenis_pengumpulan')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>

                                    {{-- File --}}
                                    <div class="field" id="wrap-file" style="display:none">
                                        <label>File Tugas <span class="req">*</span></label>
                                        <input type="file" name="file_pengumpulan" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip">
                                        <p class="field-hint">Format: PDF, Word, JPG, PNG, ZIP · Maks 10MB</p>
                                        @error('file_pengumpulan')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>

                                    {{-- Foto --}}
                                    <div class="field" id="wrap-foto" style="display:none">
                                        <label>Foto Tugas <span class="req">*</span></label>
                                        <input type="file" name="file_pengumpulan" accept=".jpg,.jpeg,.png">
                                        <p class="field-hint">Format: JPG, PNG · Maks 10MB</p>
                                    </div>

                                    {{-- Teks --}}
                                    <div class="field" id="wrap-teks" style="display:none">
                                        <label>Jawaban / Teks <span class="req">*</span></label>
                                        <textarea name="konten_teks" placeholder="Ketik jawaban Anda di sini…">{{ old('konten_teks') }}</textarea>
                                        @error('konten_teks')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>

                                    {{-- Link --}}
                                    <div class="field" id="wrap-link" style="display:none">
                                        <label>Link / URL <span class="req">*</span></label>
                                        <input type="url" name="link_pengumpulan" placeholder="https://…" value="{{ old('link_pengumpulan') }}">
                                        <p class="field-hint">Contoh: link Google Drive, GitHub, dsb.</p>
                                        @error('link_pengumpulan')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="field">
                                        <label>Catatan (opsional)</label>
                                        <textarea name="catatan" placeholder="Catatan tambahan untuk guru…" style="min-height:70px">{{ old('catatan') }}</textarea>
                                        @error('catatan')<p class="field-err">{{ $message }}</p>@enderror
                                    </div>

                                    <button type="submit" class="btn-submit">
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
            {{-- Deadline box --}}
            @php
                $dbClass = $terlambat ? 'db-late' : (now()->diffInHours($tugas->batas_waktu) < 24 ? 'db-warn' : 'db-ok');
                $dbText  = $terlambat ? 'Sudah Berakhir' : now()->diffForHumans($tugas->batas_waktu, ['parts' => 2]);
            @endphp
            <div class="deadline-box {{ $dbClass }}">
                <p class="db-label">Sisa Waktu</p>
                <p class="db-val">{{ $dbText }}</p>
                <p class="db-label" style="margin-top:4px">{{ $tugas->batas_waktu->format('d M Y · H:i') }} WIB</p>
            </div>

            {{-- Info --}}
            <div class="sidebar-card">
                <div class="sc-head">Detail Tugas</div>
                <div class="sc-body">
                    <ul class="info-list">
                        <li>
                            <span class="info-key">Mata Pelajaran</span>
                            <span class="info-val">{{ $tugas->mataPelajaran->nama_mapel ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Guru</span>
                            <span class="info-val">{{ $tugas->guru->nama_lengkap ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Kelas</span>
                            <span class="info-val">{{ $tugas->kelas->nama ?? '—' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Nilai Maks</span>
                            <span class="info-val">{{ $tugas->nilai_maksimal ?? 100 }}</span>
                        </li>
                        <li>
                            <span class="info-key">Terlambat</span>
                            <span class="info-val">{{ $tugas->izinkan_terlambat ? 'Diizinkan' : 'Tidak' }}</span>
                        </li>
                        <li>
                            <span class="info-key">Status Saya</span>
                            <span class="info-val" style="color:{{ $sudahDikumpulkan ? '#15803d' : ($terlambat ? '#dc2626' : '#1d4ed8') }};font-weight:700">
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
function toggleJenis(val) {
    ['file','foto','teks','link'].forEach(j => {
        document.getElementById('wrap-' + j).style.display = (j === val) ? 'block' : 'none';
    });
}
// Init jika ada old value
const oldJenis = '{{ old('jenis_pengumpulan') }}';
if (oldJenis) toggleJenis(oldJenis);
</script>
</x-app-layout>