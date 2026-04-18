<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    .page{padding:28px 28px 60px;max-width:900px;margin:0 auto;}

    /* ── Breadcrumb ─────────────────────────────────────────────────────── */
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px;flex-wrap:wrap;}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s;}
    .breadcrumb a:hover{color:var(--brand);}
    .breadcrumb-sep{color:var(--border2);}
    .breadcrumb-cur{color:var(--text2);font-weight:600;}

    /* ── Page header ────────────────────────────────────────────────────── */
    .page-header{margin-bottom:28px;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:13px;color:var(--text3);margin-top:4px;}

    /* ── Cards ──────────────────────────────────────────────────────────── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;}
    .card-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;}
    .card-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .card-icon.blue{background:var(--brand-50);}
    .card-icon.green{background:var(--green-bg);}
    .card-icon.yellow{background:var(--yellow-bg);}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);}
    .card-sub{font-size:12px;color:var(--text3);margin-top:1px;}
    .card-body{padding:20px;}

    /* ── Download hero ──────────────────────────────────────────────────── */
    .download-hero{background:linear-gradient(135deg,var(--brand-50) 0%,#fff 60%);border:1px solid var(--brand-100);border-radius:var(--radius);padding:28px;text-align:center;margin-bottom:20px;}
    .dh-icon{width:64px;height:64px;background:var(--brand);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 8px 24px rgba(31,99,219,.25);}
    .dh-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text);margin-bottom:6px;}
    .dh-sub{font-size:13px;color:var(--text2);line-height:1.6;max-width:420px;margin:0 auto 20px;}
    .btn-download{display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:var(--brand);color:#fff;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;text-decoration:none;transition:background .15s,box-shadow .15s;box-shadow:0 4px 14px rgba(31,99,219,.3);}
    .btn-download:hover{background:var(--brand-700);box-shadow:0 6px 20px rgba(31,99,219,.4);}
    .file-meta{display:inline-flex;align-items:center;gap:6px;margin-top:12px;font-size:11.5px;color:var(--text3);}
    .file-meta span{background:var(--surface3);padding:2px 8px;border-radius:4px;font-weight:600;color:var(--text2);}

    /* ── Kolom table ────────────────────────────────────────────────────── */
    .col-table{width:100%;border-collapse:collapse;font-size:13px;}
    .col-table thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    .col-table thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;}
    .col-table tbody tr{border-bottom:1px solid #f1f5f9;}
    .col-table tbody tr:last-child{border-bottom:none;}
    .col-table tbody tr:hover{background:#fafbff;}
    .col-table td{padding:10px 14px;color:var(--text2);vertical-align:middle;}
    .col-name{font-family:'DM Mono','Courier New',monospace;font-size:12px;font-weight:600;color:var(--brand-700);background:var(--brand-50);padding:2px 8px;border-radius:4px;white-space:nowrap;}
    .col-type{font-size:11.5px;font-weight:700;padding:2px 8px;border-radius:4px;white-space:nowrap;}
    .type-int{background:#fdf4ff;color:#7c3aed;}
    .type-str{background:var(--green-bg);color:var(--green);}
    .type-time{background:var(--brand-50);color:var(--brand-700);}
    .type-bool{background:var(--yellow-bg);color:var(--yellow);}
    .required-dot{width:6px;height:6px;border-radius:50%;display:inline-block;margin-right:4px;}
    .dot-required{background:var(--red);}
    .dot-optional{background:var(--text3);}

    /* ── Steps ──────────────────────────────────────────────────────────── */
    .steps{display:flex;flex-direction:column;gap:14px;}
    .step{display:flex;gap:14px;align-items:flex-start;}
    .step-num{width:28px;height:28px;border-radius:50%;background:var(--brand);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
    .step-content p{font-size:13px;color:var(--text2);line-height:1.6;}
    .step-content strong{color:var(--text);font-weight:700;}

    /* ── Alert ──────────────────────────────────────────────────────────── */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);font-size:13px;line-height:1.6;}
    .alert-warning{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);}
    .alert-info{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}

    /* ── Back btn ───────────────────────────────────────────────────────── */
    .btn-back{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;text-decoration:none;transition:background .15s;}
    .btn-back:hover{background:var(--surface3);}

    @media(max-width:640px){.page{padding:16px;}.download-hero{padding:20px;}}
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.jadwal-pelajaran.index') }}">Jadwal Pelajaran</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Template Import</span>
    </nav>

    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="page-title">Template Import Jadwal Pelajaran</h1>
        <p class="page-sub">Unduh template Excel, isi data sesuai petunjuk, lalu import melalui halaman daftar jadwal.</p>
    </div>

    {{-- Download Hero --}}
    <div class="download-hero">
        <div class="dh-icon">
            <svg width="28" height="28" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="12" y1="11" x2="12" y2="17"/>
                <polyline points="9 14 12 17 15 14"/>
            </svg>
        </div>
        <h2 class="dh-title">Download Template Excel</h2>
        <p class="dh-sub">File template berisi kolom-kolom yang diperlukan beserta 2 baris data contoh untuk memudahkan pengisian.</p>
        <a href="{{ route('admin.jadwal-pelajaran.import.template') }}" class="btn-download">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Download Template (.xlsx)
        </a>
        <div class="file-meta">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Format: <span>XLSX</span> Ukuran: <span>~15 KB</span>
        </div>
    </div>

    {{-- Kolom & Keterangan --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon blue">
                <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
            </div>
            <div>
                <p class="card-title">Struktur Kolom Template</p>
                <p class="card-sub">Pastikan urutan kolom tidak diubah saat mengisi data</p>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <div style="overflow-x:auto;">
                <table class="col-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kolom</th>
                            <th>Tipe</th>
                            <th>Wajib</th>
                            <th>Keterangan & Nilai yang Diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columns = [
                            [1,  'tahun_ajaran_id',   'Integer', true,  'ID tahun ajaran. Lihat di menu <strong>Tahun Ajaran</strong>.'],
                            [2,  'guru_id',           'Integer', true,  'ID guru pengampu. Lihat di menu <strong>Guru</strong>.'],
                            [3,  'mata_pelajaran_id', 'Integer', true,  'ID mata pelajaran. Lihat di menu <strong>Mata Pelajaran</strong>.'],
                            [4,  'kelas_id',          'Integer', true,  'ID kelas. Lihat di menu <strong>Kelas</strong>.'],
                            [5,  'ruang_id',          'Integer', false, 'ID ruangan (boleh dikosongkan). Lihat di menu <strong>Ruang</strong>.'],
                            [6,  'hari',              'String',  true,  'Isi dengan salah satu: <code>senin</code> / <code>selasa</code> / <code>rabu</code> / <code>kamis</code> / <code>jumat</code> / <code>sabtu</code>'],
                            [7,  'jam_mulai',         'Time',    true,  'Format <strong>HH:MM</strong>. Contoh: <code>07:00</code>'],
                            [8,  'jam_selesai',       'Time',    true,  'Format <strong>HH:MM</strong>, harus setelah jam_mulai. Contoh: <code>08:30</code>'],
                            [9,  'pertemuan_ke',      'Integer', false, 'Nomor urut pertemuan (angka positif, boleh dikosongkan).'],
                            [10, 'sumber_jadwal',     'String',  false, 'Isi dengan: <code>manual</code> atau <code>otomatis</code>. Default: <code>manual</code>'],
                            [11, 'is_active',         'Boolean', false, '<code>1</code> = aktif, <code>0</code> = tidak aktif. Default: <code>1</code>'],
                        ];
                        $typeClass = ['Integer'=>'type-int','String'=>'type-str','Time'=>'type-time','Boolean'=>'type-bool'];
                        @endphp

                        @foreach($columns as [$no, $col, $type, $required, $desc])
                        <tr>
                            <td style="color:var(--text3);font-size:12px;font-weight:700;">{{ $no }}</td>
                            <td><span class="col-name">{{ $col }}</span></td>
                            <td><span class="col-type {{ $typeClass[$type] ?? '' }}">{{ $type }}</span></td>
                            <td style="text-align:center;">
                                @if($required)
                                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:700;color:var(--red);">
                                        <span class="required-dot dot-required"></span>Wajib
                                    </span>
                                @else
                                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:11.5px;color:var(--text3);">
                                        <span class="required-dot dot-optional"></span>Opsional
                                    </span>
                                @endif
                            </td>
                            <td style="font-size:12.5px;line-height:1.6;">{!! $desc !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Langkah Import --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon green">
                <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <p class="card-title">Langkah-langkah Import</p>
                <p class="card-sub">Ikuti urutan ini agar proses import berhasil</p>
            </div>
        </div>
        <div class="card-body">
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-content">
                        <p><strong>Download template</strong> menggunakan tombol di atas, lalu buka file di Microsoft Excel atau Google Sheets.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-content">
                        <p><strong>Hapus 2 baris contoh</strong> (baris ke-2 dan ke-3) sebelum mulai mengisi data asli.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-content">
                        <p><strong>Isi data</strong> mulai baris ke-2. Perhatikan tipe data dan nilai yang diterima untuk setiap kolom seperti pada tabel di atas.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <div class="step-content">
                        <p><strong>Simpan file</strong> dalam format <strong>.xlsx</strong>, <strong>.xls</strong>, atau <strong>.csv</strong> (maksimal 2 MB).</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">5</div>
                    <div class="step-content">
                        <p>Kembali ke <a href="{{ route('admin.jadwal-pelajaran.index') }}" style="color:var(--brand);font-weight:600;">halaman Jadwal Pelajaran</a>, klik tombol <strong>Import</strong>, lalu unggah file tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert peringatan --}}
    <div class="alert alert-warning" style="margin-bottom:16px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <div>
            <strong>Perhatian:</strong> Pastikan semua ID (tahun_ajaran_id, guru_id, mata_pelajaran_id, kelas_id, ruang_id) sudah ada di database sebelum mengimpor.
            Jadwal yang memiliki konflik waktu (guru/kelas/ruang bentrok) akan <strong>ditolak</strong> saat proses import.
        </div>
    </div>

    <div class="alert alert-info">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            Jangan mengubah nama atau urutan kolom di baris pertama (header). Sistem membaca kolom berdasarkan <strong>posisi, bukan nama kolom</strong>.
        </div>
    </div>

    {{-- Footer action --}}
    <div style="margin-top:24px;display:flex;gap:10px;align-items:center;">
        <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn-back">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Daftar Jadwal
        </a>
    </div>

</div>
</x-app-layout>