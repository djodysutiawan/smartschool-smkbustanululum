<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-600:#1f63db;--brand-500:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif;max-width:2000px}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px;flex-wrap:wrap}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand-600)}
    .breadcrumb-sep{color:var(--border)}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;margin-bottom:4px}
    .page-sub{font-size:12.5px;color:var(--text3);margin-bottom:24px}

    /* Alert sesi aktif (blocking) */
    .alert-blocking{background:#fff7ed;border:1.5px solid #fed7aa;border-radius:var(--radius);padding:18px 20px;margin-bottom:20px;display:flex;gap:14px;align-items:flex-start}
    .alert-blocking-icon{width:36px;height:36px;background:#ffedd5;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
    .alert-blocking-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:#9a3412;margin-bottom:4px}
    .alert-blocking-body{font-size:13px;color:#c2410c;line-height:1.5}
    .alert-blocking-meta{margin-top:10px;display:flex;gap:10px;flex-wrap:wrap}
    .alert-blocking-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:#fff;border:1px solid #fed7aa;border-radius:6px;font-size:12px;color:#9a3412;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}
    .btn-lihat-sesi{display:inline-flex;align-items:center;gap:6px;padding:7px 16px;background:#ea580c;color:#fff;border:none;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;cursor:pointer;transition:filter .15s}
    .btn-lihat-sesi:hover{filter:brightness(.9)}

    /* Form card */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card.disabled-card{opacity:.55;pointer-events:none;user-select:none}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--surface3);display:flex;align-items:center;gap:10px}
    .form-card-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-card-sub{font-size:12px;color:var(--text3);margin-top:1px}
    .form-card-body{padding:20px}

    /* Fields */
    .field{margin-bottom:18px}
    .field:last-child{margin-bottom:0}
    .field-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);margin-bottom:6px;display:flex;align-items:center;gap:5px}
    .field-label .req{color:var(--red);font-size:11px}
    .field-hint{font-size:11.5px;color:var(--text3);margin-top:5px;font-family:'DM Sans',sans-serif}
    .field-input{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s}
    .field-input:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .field-input.error{border-color:var(--red)}
    .error-msg{font-size:11.5px;color:var(--red);margin-top:4px;display:flex;align-items:center;gap:4px}
    .field-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}

    /* Jadwal picker */
    .jadwal-list{display:flex;flex-direction:column;gap:8px}
    .jadwal-option{position:relative}
    .jadwal-option input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .jadwal-option-label{display:flex;align-items:center;gap:12px;padding:12px 14px;border:2px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;background:var(--surface)}
    .jadwal-option-label:hover{border-color:var(--brand-500);background:var(--brand-50)}
    .jadwal-option input[type=radio]:checked + .jadwal-option-label{border-color:var(--brand-600);background:var(--brand-50)}
    .jadwal-option.disabled .jadwal-option-label{opacity:.5;cursor:not-allowed;background:var(--surface2)}
    .jadwal-option.disabled .jadwal-option-label:hover{border-color:var(--border);background:var(--surface2)}
    .jadwal-radio{width:16px;height:16px;border-radius:50%;border:2px solid var(--border);background:#fff;flex-shrink:0;display:flex;align-items:center;justify-content:center;transition:all .15s}
    .jadwal-option input[type=radio]:checked + .jadwal-option-label .jadwal-radio{border-color:var(--brand-600);background:var(--brand-600)}
    .jadwal-radio::after{content:'';width:6px;height:6px;border-radius:50%;background:#fff;opacity:0;transition:opacity .15s}
    .jadwal-option input[type=radio]:checked + .jadwal-option-label .jadwal-radio::after{opacity:1}
    .jadwal-info{flex:1}
    .jadwal-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--text)}
    .jadwal-detail{font-size:12px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif}
    .jadwal-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand-600);white-space:nowrap}
    .badge-sudah{display:inline-flex;padding:2px 8px;background:var(--yellow-bg);color:var(--yellow);border-radius:99px;font-size:10.5px;font-weight:700;border:1px solid var(--yellow-border);white-space:nowrap}

    /* GPS section */
    .gps-coords{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
    .btn-get-gps{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:var(--brand-600);color:#fff;border:none;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:filter .15s}
    .btn-get-gps:hover{filter:brightness(.9)}
    .gps-status{font-size:12px;color:var(--text3);margin-left:8px;font-family:'DM Sans',sans-serif}

    /* Durasi presets */
    .preset-row{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:10px}
    .preset-btn{padding:5px 12px;border:1px solid var(--border);border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);background:var(--surface2);cursor:pointer;transition:all .15s}
    .preset-btn:hover{border-color:var(--brand-500);color:var(--brand-600);background:var(--brand-50)}
    .preset-btn.active{border-color:var(--brand-600);color:var(--brand-600);background:var(--brand-50)}

    /* Info box */
    .info-box{display:flex;gap:10px;padding:12px 14px;background:#fffbeb;border:1px solid var(--yellow-border);border-radius:var(--radius-sm);font-size:12.5px;color:#92400e;font-family:'DM Sans',sans-serif}
    .info-box svg{flex-shrink:0;margin-top:1px}

    /* Empty jadwal */
    .empty-jadwal{text-align:center;padding:32px 16px;background:var(--surface2);border-radius:var(--radius-sm);border:1px dashed var(--border)}
    .empty-jadwal p{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text2);margin-bottom:4px}
    .empty-jadwal small{font-size:12px;color:var(--text3)}

    /* Footer actions */
    .form-actions{display:flex;gap:10px;align-items:center;padding-top:4px}
    .btn{display:inline-flex;align-items:center;gap:7px;padding:10px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-primary:hover{filter:brightness(.93)}
    .btn-primary:disabled{opacity:.5;cursor:not-allowed;filter:none}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    @media(max-width:600px){
        .page{padding:16px}
        .field-row{grid-template-columns:1fr}
        .gps-coords{grid-template-columns:1fr}
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('guru.sesi-qr.index') }}">Sesi QR</a>
        <span class="breadcrumb-sep">/</span>
        <span>Buat Sesi Baru</span>
    </div>

    <h1 class="page-title">Buat Sesi QR Absensi</h1>
    <p class="page-sub">Sesi QR hanya bisa dibuat berdasarkan jadwal hari ini ({{ ucfirst($hariIni) }})</p>

    {{-- ⚠️ BANNER: Ada sesi aktif yang sedang berjalan (dari siapapun pembuatnya) --}}
    @if($sesiAktifSekarang)
    <div class="alert-blocking">
        <div class="alert-blocking-icon">
            <svg width="18" height="18" fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div style="flex:1">
            <p class="alert-blocking-title">Ada Sesi QR yang Sedang Aktif</p>
            <p class="alert-blocking-body">
                Sesi untuk <strong>{{ $sesiAktifSekarang->mataPelajaran->nama_mapel ?? '—' }}</strong>
                kelas <strong>{{ $sesiAktifSekarang->kelas->nama_kelas ?? '—' }}</strong>
                masih berjalan dan belum selesai.
                Selesaikan atau nonaktifkan sesi tersebut sebelum membuat sesi baru.
            </p>
            <div class="alert-blocking-meta">
                <span class="alert-blocking-chip">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Berakhir: {{ \Carbon\Carbon::parse($sesiAktifSekarang->kadaluarsa_pada)->format('H:i') }} WIB
                </span>
                <span class="alert-blocking-chip">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    Sisa: {{ now()->diffForHumans($sesiAktifSekarang->kadaluarsa_pada, true) }}
                </span>
                <a href="{{ route('guru.sesi-qr.show', $sesiAktifSekarang->id) }}" class="btn-lihat-sesi">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Lihat Sesi Aktif
                </a>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('guru.sesi-qr.store') }}" method="POST" id="formSesi">
    @csrf

    {{-- Pilih Jadwal --}}
    <div class="form-card {{ $sesiAktifSekarang ? 'disabled-card' : '' }}">
        <div class="form-card-header">
            <div class="form-card-icon" style="background:#eff6ff">
                <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="form-card-title">Pilih Jadwal Pelajaran</p>
                <p class="form-card-sub">Hanya jadwal hari ini yang tersedia</p>
            </div>
        </div>
        <div class="form-card-body">
            @if($jadwalHariIni->count() > 0)
            <div class="jadwal-list">
                @foreach($jadwalHariIni as $jadwal)
                @php $sudah = in_array($jadwal->id, $sesiSudahAda); @endphp
                <div class="jadwal-option {{ $sudah ? 'disabled' : '' }}">
                    <input type="radio" name="jadwal_pelajaran_id" id="jadwal_{{ $jadwal->id }}"
                        value="{{ $jadwal->id }}"
                        {{ ($jadwalTerpilih && $jadwalTerpilih->id == $jadwal->id) ? 'checked' : '' }}
                        {{ ($sudah || $sesiAktifSekarang) ? 'disabled' : '' }}>
                    <label class="jadwal-option-label" for="jadwal_{{ $jadwal->id }}">
                        <div class="jadwal-radio"></div>
                        <div class="jadwal-info">
                            <p class="jadwal-mapel">{{ $jadwal->mataPelajaran->nama_mapel ?? '—' }}</p>
                            <p class="jadwal-detail">
                                {{ $jadwal->kelas->nama_kelas ?? '—' }}
                                @if($jadwal->ruang) · {{ $jadwal->ruang->nama_ruang ?? '' }} @endif
                            </p>
                        </div>
                        <div style="text-align:right">
                            <p class="jadwal-time">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                            @if($sudah)
                            <span class="badge-sudah" style="margin-top:3px;display:inline-block">Sudah ada sesi</span>
                            @endif
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
            @if($errors->has('jadwal_pelajaran_id'))
            <p class="error-msg" style="margin-top:8px">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first('jadwal_pelajaran_id') }}
            </p>
            @endif
            @else
            <div class="empty-jadwal">
                <p>Tidak ada jadwal hari ini</p>
                <small>Anda tidak memiliki jadwal mengajar hari {{ ucfirst($hariIni) }} ini</small>
            </div>
            @endif
        </div>
    </div>

    {{-- Durasi & Radius --}}
    <div class="form-card {{ $sesiAktifSekarang ? 'disabled-card' : '' }}">
        <div class="form-card-header">
            <div class="form-card-icon" style="background:#f0fdf4">
                <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="form-card-title">Pengaturan Sesi</p>
                <p class="form-card-sub">Durasi dan batas radius lokasi scan</p>
            </div>
        </div>
        <div class="form-card-body">
            <div class="field-row">
                <div class="field">
                    <label class="field-label" for="durasi_menit">Durasi Sesi</label>
                    <div class="preset-row">
                        <button type="button" class="preset-btn" onclick="setDurasi(30)">30 mnt</button>
                        <button type="button" class="preset-btn" onclick="setDurasi(45)">45 mnt</button>
                        <button type="button" class="preset-btn" onclick="setDurasi(60)">60 mnt</button>
                        <button type="button" class="preset-btn" onclick="setDurasi(90)">90 mnt</button>
                    </div>
                    <input type="number" class="field-input {{ $errors->has('durasi_menit') ? 'error' : '' }}"
                        id="durasi_menit" name="durasi_menit"
                        value="{{ old('durasi_menit') }}" min="5" max="240"
                        placeholder="Menit (kosong = ikut jadwal)">
                    @error('durasi_menit')
                    <p class="error-msg"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</p>
                    @enderror
                    <p class="field-hint">Kosongkan untuk mengikuti durasi jadwal. Min 5, maks 240 menit.</p>
                </div>
                <div class="field">
                    <label class="field-label" for="radius_meter">Radius Lokasi</label>
                    <div class="preset-row">
                        <button type="button" class="preset-btn" onclick="setRadius(30)">30 m</button>
                        <button type="button" class="preset-btn active" onclick="setRadius(100)">100 m</button>
                        <button type="button" class="preset-btn" onclick="setRadius(200)">200 m</button>
                        <button type="button" class="preset-btn" onclick="setRadius(500)">500 m</button>
                    </div>
                    <input type="number" class="field-input {{ $errors->has('radius_meter') ? 'error' : '' }}"
                        id="radius_meter" name="radius_meter"
                        value="{{ old('radius_meter', 100) }}" min="10" max="1000"
                        placeholder="Meter (default: 100)">
                    @error('radius_meter')
                    <p class="error-msg"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</p>
                    @enderror
                    <p class="field-hint">Jarak maksimal siswa dari titik kelas saat scan. Min 10, maks 1000 m.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Lokasi GPS --}}
    <div class="form-card {{ $sesiAktifSekarang ? 'disabled-card' : '' }}">
        <div class="form-card-header">
            <div class="form-card-icon" style="background:#faf5ff">
                <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
            </div>
            <div>
                <p class="form-card-title">Titik Lokasi (Opsional)</p>
                <p class="form-card-sub">Untuk validasi GPS saat siswa scan</p>
            </div>
        </div>
        <div class="form-card-body">
            <div class="info-box" style="margin-bottom:12px">
                <svg width="15" height="15" fill="none" stroke="#92400e" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>Jika tidak diisi, validasi lokasi dinonaktifkan — siswa bisa scan dari mana saja.</span>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px">
                <button type="button" class="btn-get-gps" onclick="getGps()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    Gunakan Lokasi Saya
                </button>
                <span class="gps-status" id="gpsStatus"></span>
            </div>
            <div class="gps-coords">
                <div class="field" style="margin:0">
                    <label class="field-label" for="latitude">Latitude</label>
                    <input type="text" class="field-input" id="latitude" name="latitude"
                        value="{{ old('latitude') }}" placeholder="Contoh: -6.2088">
                </div>
                <div class="field" style="margin:0">
                    <label class="field-label" for="longitude">Longitude</label>
                    <input type="text" class="field-input" id="longitude" name="longitude"
                        value="{{ old('longitude') }}" placeholder="Contoh: 106.8456">
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="form-actions">
        @if($jadwalHariIni->count() > 0 && !$sesiAktifSekarang)
        <button type="submit" class="btn btn-primary" id="btnSubmit">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Buat Sesi QR
        </button>
        @elseif($sesiAktifSekarang)
        <button type="button" class="btn btn-primary" disabled title="Selesaikan sesi aktif terlebih dahulu">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Buat Sesi QR
        </button>
        @endif
        <a href="{{ route('guru.sesi-qr.index') }}" class="btn btn-secondary">Batal</a>
    </div>

    </form>
</div>

<script>
function setDurasi(val) {
    document.getElementById('durasi_menit').value = val;
    document.querySelectorAll('.preset-btn').forEach(b => {
        if (b.onclick?.toString().includes('setDurasi')) b.classList.toggle('active', b.onclick?.toString().includes('(' + val + ')'));
    });
}
function setRadius(val) {
    document.getElementById('radius_meter').value = val;
    document.querySelectorAll('.preset-btn').forEach(b => {
        if (b.onclick?.toString().includes('setRadius')) b.classList.toggle('active', b.onclick?.toString().includes('(' + val + ')'));
    });
}
function getGps() {
    const status = document.getElementById('gpsStatus');
    if (!navigator.geolocation) { status.textContent = 'GPS tidak didukung browser ini'; return; }
    status.textContent = 'Mendapatkan lokasi…';
    navigator.geolocation.getCurrentPosition(
        pos => {
            document.getElementById('latitude').value  = pos.coords.latitude.toFixed(6);
            document.getElementById('longitude').value = pos.coords.longitude.toFixed(6);
            status.textContent = '✓ Lokasi berhasil diambil (akurasi ±' + Math.round(pos.coords.accuracy) + 'm)';
            status.style.color = '#15803d';
        },
        err => {
            status.textContent = 'Gagal: ' + (err.code === 1 ? 'Izin lokasi ditolak' : err.message);
            status.style.color = '#dc2626';
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}

// Submit guard
document.getElementById('formSesi')?.addEventListener('submit', function(e) {
    const adaSesiAktif = {{ $sesiAktifSekarang ? 'true' : 'false' }};
    if (adaSesiAktif) {
        e.preventDefault();
        alert('Masih ada sesi QR aktif. Selesaikan atau nonaktifkan sesi tersebut terlebih dahulu.');
        return;
    }
    const jadwal = document.querySelector('input[name=jadwal_pelajaran_id]:checked');
    if (!jadwal) {
        e.preventDefault();
        alert('Pilih jadwal pelajaran terlebih dahulu.');
    }
});
</script>
</x-app-layout>