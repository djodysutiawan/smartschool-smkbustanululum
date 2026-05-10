<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif;max-width:700px;margin:0 auto}
    .back-link{display:inline-flex;align-items:center;gap:6px;color:var(--text3);font-size:13px;text-decoration:none;margin-bottom:20px;transition:color .15s}
    .back-link:hover{color:var(--text2)}
    .page-header{margin-bottom:24px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-print{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border)}
    .btn-print:hover{background:#ede9fe;filter:none}

    .barcode-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .card-top{height:5px;background:linear-gradient(90deg,var(--brand-500),#22c55e)}
    .card-body{padding:36px 40px;text-align:center}
    .kelas-label{display:inline-flex;align-items:center;gap:6px;padding:4px 14px;background:var(--brand-50);color:var(--brand-600);border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;margin-bottom:16px}
    .kelas-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;font-weight:800;color:var(--text);line-height:1.1;margin-bottom:4px}
    .kelas-sub{font-size:14px;color:var(--text3);margin-bottom:28px}
    .qr-box{display:inline-flex;padding:20px;background:var(--surface2);border:1px solid var(--border);border-radius:12px;margin-bottom:18px}
    .barcode-raw-label{font-size:11px;color:var(--text3);margin-bottom:4px;text-transform:uppercase;letter-spacing:.06em;font-weight:600}
    .barcode-raw{font-family:'DM Mono',monospace;font-size:13px;color:var(--text2);background:var(--surface2);padding:7px 16px;border-radius:7px;border:1px solid var(--border);letter-spacing:.08em;margin-bottom:20px;display:inline-block}
    .info-note{font-size:12px;color:var(--text3);line-height:1.7;max-width:400px;margin:0 auto}
    .card-footer{padding:16px 40px;border-top:1px solid var(--surface3);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
    .guru-info{font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .guru-info strong{color:var(--text2);font-weight:600}
</style>

<div class="page">
    <a href="{{ route('guru.barcode-kelas.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Barcode Kelas
    </a>

    <div class="page-header">
        <h1 class="page-title">Barcode Kelas</h1>
        <p class="page-sub">Barcode tetap untuk ditempel di papan kelas — nilai tidak pernah berubah</p>
    </div>

    <div class="barcode-card">
        <div class="card-top"></div>
        <div class="card-body">
            <div class="kelas-label">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Kelas
            </div>
            <div class="kelas-name">{{ $kelas->nama_kelas }}</div>
            <div class="kelas-sub">
                {{ $kelas->jurusan->nama_jurusan ?? '' }}
                @if($kelas->tingkat) · Tingkat {{ $kelas->tingkat }} @endif
                @if($kelas->tahun_ajaran) · TA {{ $kelas->tahun_ajaran }} @endif
            </div>

            <div class="qr-box">
                {!! DNS1D::getBarcodeHTML($barcodeKelas, 'C128', 1.6, 60) !!}
            </div>

            <div>
                <div class="barcode-raw-label">Kode Barcode</div>
                <div class="barcode-raw">{{ $barcodeKelas }}</div>
            </div>

            <p class="info-note">
                Barcode ini merepresentasikan kelas <strong>{{ $kelas->nama_kelas }}</strong>.<br>
                Tempel di papan kelas agar siswa bisa melakukan scan absensi dengan mudah.
            </p>
        </div>
        <div class="card-footer">
            <div class="guru-info">
                Guru: <strong>{{ $guru->nama_lengkap }}</strong>
                @if($guru->nip) · NIP {{ $guru->nip }} @endif
            </div>
            <div style="display:flex;gap:8px">
                <a href="{{ route('guru.barcode-kelas.index') }}" class="btn btn-secondary">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Kembali
                </a>
                <a href="{{ route('guru.barcode-kelas.cetak', $kelas) }}" target="_blank" class="btn btn-print">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Barcode
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>