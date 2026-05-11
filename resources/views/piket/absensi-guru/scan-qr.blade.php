<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--yellow:#a16207;--red:#dc2626;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-success{background:#15803d;color:#fff}
    .btn-sm{padding:5px 12px;font-size:12px;border-radius:6px}

    /* ── Layout ── */
    .scan-grid{display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start}

    /* ── No session banner ── */
    .no-sesi-banner{background:#fff7ed;border:1px solid #fed7aa;border-radius:var(--radius);padding:20px 24px;text-align:center;margin-bottom:20px}
    .no-sesi-icon{width:52px;height:52px;background:#ffedd5;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
    .no-sesi-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;color:#c2410c;margin-bottom:6px}
    .no-sesi-sub{font-size:13px;color:#9a3412}

    /* ── Sesi aktif info ── */
    .sesi-aktif-bar{background:linear-gradient(135deg,#f0fdf4,#ecfdf5);border:1px solid #a7f3d0;border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px;margin-bottom:20px}
    .sesi-dot{width:10px;height:10px;border-radius:50%;background:var(--green);flex-shrink:0;box-shadow:0 0 0 3px #bbf7d0;animation:pulse 2s infinite}
    @keyframes pulse{0%,100%{box-shadow:0 0 0 3px #bbf7d0}50%{box-shadow:0 0 0 6px #bbf7d080}}
    .sesi-info{flex:1}
    .sesi-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--green)}
    .sesi-sub{font-size:12px;color:#166534;margin-top:2px}

    /* ── Form card ── */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-card-body{padding:20px}

    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
    .field:last-child{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .hint{font-weight:400;color:var(--text3);margin-left:4px}
    .field select,.field input{height:42px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,box-shadow .15s;width:100%}
    .field select:focus,.field input:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field .error{font-size:11.5px;color:var(--red);margin-top:3px}

    /* Kode input large */
    .kode-input{height:52px !important;font-size:16px !important;font-weight:700 !important;letter-spacing:.08em;font-family:'Plus Jakarta Sans',sans-serif !important;text-transform:uppercase}

    /* ── Scan log card (right) ── */
    .log-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;position:sticky;top:20px}
    .log-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between}
    .log-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .log-body{max-height:480px;overflow-y:auto}

    .log-item{display:flex;align-items:center;gap:12px;padding:11px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .log-item:last-child{border-bottom:none}
    .log-item:hover{background:#fafbff}
    .log-avatar{width:34px;height:34px;border-radius:99px;background:var(--brand-50);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .log-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .log-meta{font-size:11.5px;color:var(--text3);margin-top:1px}
    .log-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);flex-shrink:0}

    /* ── Badge ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir{background:#dcfce7;color:var(--green)} .badge-hadir .badge-dot{background:var(--green)}
    .badge-telat{background:#fefce8;color:var(--yellow)} .badge-telat .badge-dot{background:var(--yellow)}

    /* ── Status radios ── */
    .status-radios{display:flex;gap:8px;flex-wrap:wrap}
    .status-opt{position:relative}
    .status-opt input{position:absolute;opacity:0;width:0;height:0}
    .status-lbl{display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;border:2px solid var(--border);background:var(--surface2);color:var(--text3);transition:all .12s;user-select:none}
    .status-opt input:checked + .status-lbl.hadir{border-color:var(--green);background:#dcfce7;color:var(--green)}
    .status-opt input:checked + .status-lbl.telat{border-color:var(--yellow);background:#fef9c3;color:var(--yellow)}
    .status-opt input:checked + .status-lbl.izin {border-color:#1d4ed8;background:#dbeafe;color:#1d4ed8}

    /* ── Divider ── */
    .or-divider{display:flex;align-items:center;gap:10px;margin:16px 0;color:var(--text3);font-size:12.5px;font-weight:600}
    .or-divider::before,.or-divider::after{content:'';flex:1;height:1px;background:var(--border)}

    /* ── Empty ── */
    .empty-state{padding:40px 20px;text-align:center}
    .empty-sub{font-size:12.5px;color:var(--text3)}

    @media(max-width:1000px){.scan-grid{grid-template-columns:1fr}.log-card{position:static}}
    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Scan QR Guru</h1>
            <p class="page-sub">Verifikasi kehadiran guru via kode QR</p>
        </div>
        <div style="display:flex;gap:8px">
            <a href="{{ route('piket.sesi-qr-guru.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                Kelola Sesi QR
            </a>
            <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Sesi QR status --}}
    @if($sesiQrAktif)
    <div class="sesi-aktif-bar">
        <span class="sesi-dot"></span>
        <div class="sesi-info">
            <p class="sesi-title">Sesi QR Sedang Aktif</p>
            <p class="sesi-sub">
                Dibuat pukul {{ \Carbon\Carbon::parse($sesiQrAktif->created_at)->format('H:i') }}
                · Berlaku hingga {{ $sesiQrAktif->kadaluarsa_pada ? \Carbon\Carbon::parse($sesiQrAktif->kadaluarsa_pada)->format('H:i') : 'tidak terbatas' }}
                · <strong>{{ $sesiQrAktif->jumlah_scan ?? 0 }}</strong> scan masuk
            </p>
        </div>
        <a href="{{ route('piket.sesi-qr-guru.index') }}" class="btn btn-sm" style="background:#dcfce7;color:var(--green);border:1px solid #a7f3d0">Lihat QR</a>
    </div>
    @else
    <div class="no-sesi-banner">
        <div class="no-sesi-icon">
            <svg width="24" height="24" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <p class="no-sesi-title">Tidak Ada Sesi QR Aktif</p>
        <p class="no-sesi-sub" style="margin-bottom:14px">Guru tidak bisa scan QR mandiri. Buka sesi terlebih dahulu atau gunakan input manual di bawah.</p>
        <a href="{{ route('piket.sesi-qr-guru.index') }}" class="btn btn-success btn-sm">Buka Sesi QR</a>
    </div>
    @endif

    <div class="scan-grid">

        {{-- Form scan --}}
        <div>
            <form action="{{ route('piket.absensi-guru.proses-qr') }}" method="POST" id="scanForm">
                @csrf
                <div class="form-card">
                    <div class="form-card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                        <span class="form-card-title">Input Kode QR</span>
                    </div>
                    <div class="form-card-body">

                        {{-- Kode QR --}}
                        <div class="field">
                            <label>Kode QR Guru <span style="color:#dc2626">*</span></label>
                            <input type="text"
                                   name="kode_qr"
                                   id="kodeQrInput"
                                   class="kode-input"
                                   value="{{ old('kode_qr') }}"
                                   placeholder="Scan atau ketik kode QR…"
                                   autocomplete="off"
                                   autofocus>
                            @error('kode_qr')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            <small style="font-size:11.5px;color:var(--text3);margin-top:4px">
                                Format: UUID dari QR Code yang tampil di layar guru/piket
                            </small>
                        </div>

                        <div class="or-divider">atau pilih guru</div>

                        {{-- Guru ID --}}
                        <div class="field">
                            <label>Nama Guru <span style="color:#dc2626">*</span></label>
                            <select name="guru_id" id="guruSelect">
                                <option value="">— Pilih Guru —</option>
                                @foreach(\App\Models\Guru::aktif()->orderBy('nama_lengkap')->get() as $g)
                                    <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_lengkap }} ({{ $g->nip ?: 'NIP—' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status override --}}
                        <div class="field">
                            <label>Override Status <span class="hint">(kosongkan = otomatis)</span></label>
                            <div class="status-radios">
                                <label class="status-opt">
                                    <input type="radio" name="status" value="" checked>
                                    <span class="status-lbl" style="border-color:var(--border);color:var(--text2)">Otomatis</span>
                                </label>
                                @foreach(['hadir','telat','izin'] as $s)
                                <label class="status-opt">
                                    <input type="radio" name="status" value="{{ $s }}" {{ old('status') === $s ? 'checked' : '' }}>
                                    <span class="status-lbl {{ $s }}">{{ ucfirst($s) }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:6px;height:44px;font-size:14px">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3v3"/><path d="M21 21h-3"/><path d="M16 21v-3"/></svg>
                            Proses Scan QR
                        </button>
                    </div>
                </div>
            </form>

            {{-- Info cara kerja --}}
            <div style="background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 18px">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);margin-bottom:8px">Cara Kerja Scan QR</p>
                <ol style="padding-left:16px;display:flex;flex-direction:column;gap:6px;color:var(--text3);font-size:12.5px;line-height:1.5">
                    <li>Pastikan <strong style="color:var(--text2)">sesi QR aktif</strong> sudah dibuka di halaman Sesi QR Guru</li>
                    <li>Guru scan QR yang ditampilkan di pos piket dari HP mereka</li>
                    <li>Untuk verifikasi manual: masukkan kode QR dari layar guru atau pilih nama guru, lalu klik Proses</li>
                    <li>Status hadir/telat ditentukan otomatis berdasarkan jam scan vs jam batas (<strong style="color:var(--text2)">07:15</strong>)</li>
                </ol>
            </div>
        </div>

        {{-- Log scan hari ini --}}
        <div class="log-card">
            <div class="log-header">
                <span class="log-title">
                    <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Sudah Scan Hari Ini
                    <span style="background:var(--brand-50);color:var(--brand-700);font-size:11px;padding:2px 8px;border-radius:99px;font-weight:700">{{ $sudahScanHariIni->count() }}</span>
                </span>
                <span style="font-size:11.5px;color:var(--text3)">{{ today()->format('d M') }}</span>
            </div>
            <div class="log-body">
                @forelse($sudahScanHariIni as $scan)
                <div class="log-item">
                    <div class="log-avatar">{{ strtoupper(substr($scan->guru->nama_lengkap ?? 'G', 0, 1)) }}</div>
                    <div style="flex:1;min-width:0">
                        <p class="log-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $scan->guru->nama_lengkap ?? '—' }}
                        </p>
                        <p class="log-meta">
                            <span class="badge badge-{{ $scan->status }}" style="padding:1px 7px;font-size:10.5px">
                                <span class="badge-dot"></span>{{ ucfirst($scan->status) }}
                            </span>
                        </p>
                    </div>
                    <span class="log-time">{{ $scan->jam_masuk ? \Carbon\Carbon::parse($scan->jam_masuk)->format('H:i') : '—' }}</span>
                </div>
                @empty
                <div class="empty-state">
                    <p class="empty-sub">Belum ada guru yang scan hari ini</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif
@if(session('warning'))
Swal.fire({icon:'warning',title:'Perhatian!',text:@json(session('warning')),confirmButtonColor:'#1f63db'});
@endif
@if($errors->any())
Swal.fire({icon:'warning',title:'Perhatian!',html:@json(implode('<br>',$errors->all())),confirmButtonColor:'#1f63db'});
@endif

// Auto-focus kode input
document.getElementById('kodeQrInput')?.focus();

// Enter on kode input = submit form langsung
document.getElementById('kodeQrInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const guruId = document.getElementById('guruSelect').value;
        if (!guruId) {
            document.getElementById('guruSelect').focus();
            Swal.fire({icon:'info',title:'Pilih Guru',text:'Pilih nama guru terlebih dahulu.',toast:true,position:'top-end',timer:2500,showConfirmButton:false});
            return;
        }
        document.getElementById('scanForm').submit();
    }
});
</script>
</x-app-layout>