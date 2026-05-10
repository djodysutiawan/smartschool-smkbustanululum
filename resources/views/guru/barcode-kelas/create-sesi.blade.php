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
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif}
    .page{padding:28px 28px 48px;max-width:9000px;margin:0 auto}
    .back-link{display:inline-flex;align-items:center;gap:6px;color:var(--text3);font-size:13px;text-decoration:none;margin-bottom:20px;transition:color .15s}
    .back-link:hover{color:var(--text2)}
    .page-header{margin-bottom:24px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13px;display:flex;align-items:flex-start;gap:8px}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}
    .alert-warning{background:var(--yellow-bg);border:1px solid var(--yellow-border);color:var(--yellow)}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-head{padding:16px 22px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .form-card-head-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .form-card-head-sub{font-size:12px;color:var(--text3);margin-top:2px}
    .form-card-body{padding:22px}

    .form-group{margin-bottom:18px}
    .form-group:last-child{margin-bottom:0}
    .form-label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:6px;letter-spacing:.02em}
    .form-label span{color:var(--red);margin-left:2px}
    .form-control{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s}
    .form-control:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .form-control.is-invalid{border-color:var(--red)}
    .form-hint{font-size:11.5px;color:var(--text3);margin-top:5px;line-height:1.5}
    .invalid-feedback{font-size:11.5px;color:var(--red);margin-top:5px;display:flex;align-items:center;gap:4px}

    .jadwal-options{display:flex;flex-direction:column;gap:8px}
    .jadwal-option{display:flex;align-items:flex-start;gap:12px;padding:14px 16px;border:1px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;background:var(--surface)}
    .jadwal-option:hover{border-color:var(--brand-500);background:var(--brand-50)}
    .jadwal-option.selected{border-color:var(--brand-500);background:var(--brand-50)}
    .jadwal-option.disabled{opacity:.5;cursor:not-allowed;background:var(--surface3)}
    .jadwal-option input[type=radio]{margin-top:2px;accent-color:var(--brand-600)}
    .jadwal-option-info{flex:1;min-width:0}
    .jadwal-option-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13.5px}
    .jadwal-option-meta{font-size:12px;color:var(--text3);margin-top:3px;display:flex;flex-wrap:wrap;gap:8px}
    .jadwal-meta-chip{display:inline-flex;align-items:center;gap:4px;font-size:11.5px;color:var(--text2)}
    .sudah-ada-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 9px;background:var(--yellow-bg);color:var(--yellow);border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;margin-left:8px;border:1px solid var(--yellow-border)}

    .input-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .input-with-unit{display:flex;align-items:center;gap:0}
    .input-with-unit .form-control{border-radius:var(--radius-sm) 0 0 var(--radius-sm);flex:1}
    .unit-label{height:40px;padding:0 12px;background:var(--surface2);border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;display:flex;align-items:center;font-size:12.5px;color:var(--text3);white-space:nowrap}

    .geo-detect{display:flex;gap:8px;margin-top:8px;align-items:center}
    .btn-detect{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);cursor:pointer;transition:background .15s}
    .btn-detect:hover{background:var(--surface3)}
    .geo-status{font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px}

    .form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)}

    .step-indicator{display:flex;align-items:center;gap:0;margin-bottom:24px}
    .step{display:flex;align-items:center;gap:8px}
    .step-num{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800}
    .step-num.active{background:var(--brand-600);color:#fff}
    .step-num.done{background:var(--green-bg);color:var(--green)}
    .step-num.idle{background:var(--surface3);color:var(--text3)}
    .step-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}
    .step-label.active{color:var(--text)}
    .step-divider{width:32px;height:1px;background:var(--border);margin:0 4px}

    @media(max-width:640px){.input-row{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">
    <a href="{{ route('guru.barcode-kelas.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Barcode Kelas
    </a>

    <div class="page-header">
        <h1 class="page-title">Buat Sesi QR Absensi</h1>
        <p class="page-sub">Pilih jadwal hari ini untuk memulai sesi QR code absensi siswa</p>
    </div>

    {{-- Alert error --}}
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    @if($jadwalHariIni->count() === 0)
    <div class="alert alert-warning">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Tidak ada jadwal hari ini ({{ ucfirst($hariIni) }}). Sesi QR hanya bisa dibuat untuk jadwal hari ini.
    </div>
    @endif

    <form action="{{ route('guru.barcode-kelas.store-sesi') }}" method="POST" id="formSesi">
        @csrf

        {{-- 1. Pilih Jadwal --}}
        <div class="form-card">
            <div class="form-card-head">
                <div class="form-card-head-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Pilih Jadwal Pelajaran
                </div>
                <div class="form-card-head-sub">Hanya menampilkan jadwal hari ini — {{ ucfirst($hariIni) }}</div>
            </div>
            <div class="form-card-body">
                @if($jadwalHariIni->count() > 0)
                <div class="jadwal-options">
                    @foreach($jadwalHariIni as $jadwal)
                    @php $sudahAda = in_array($jadwal->id, $sesiSudahAda); @endphp
                    <label class="jadwal-option {{ $sudahAda ? 'disabled' : '' }} {{ $jadwalTerpilih && $jadwalTerpilih->id === $jadwal->id ? 'selected' : '' }}"
                        for="jadwal_{{ $jadwal->id }}">
                        <input type="radio" name="jadwal_pelajaran_id" id="jadwal_{{ $jadwal->id }}"
                            value="{{ $jadwal->id }}"
                            {{ $sudahAda ? 'disabled' : '' }}
                            {{ ($jadwalTerpilih && $jadwalTerpilih->id === $jadwal->id) ? 'checked' : (old('jadwal_pelajaran_id') == $jadwal->id ? 'checked' : '') }}
                            onchange="updateSelected(this)">
                        <div class="jadwal-option-info">
                            <div class="jadwal-option-mapel">
                                {{ $jadwal->mataPelajaran->nama_mapel ?? '—' }}
                                @if($sudahAda)
                                <span class="sudah-ada-badge">
                                    <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                                    Sudah ada sesi hari ini
                                </span>
                                @endif
                            </div>
                            <div class="jadwal-option-meta">
                                <span class="jadwal-meta-chip">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                    {{ $jadwal->kelas->nama_kelas ?? '—' }}
                                </span>
                                <span class="jadwal-meta-chip">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </span>
                                @if($jadwal->ruang)
                                <span class="jadwal-meta-chip">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                                    {{ $jadwal->ruang->nama_ruang }}
                                </span>
                                @endif
                                <span class="jadwal-meta-chip" style="color:var(--text3)">
                                    Durasi default: {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($jadwal->jam_selesai)) }} menit
                                </span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @else
                <p style="font-size:13px;color:var(--text3);text-align:center;padding:24px 0">
                    Tidak ada jadwal tersedia hari ini untuk membuat sesi QR.
                </p>
                @endif
                @error('jadwal_pelajaran_id')
                <div class="invalid-feedback" style="margin-top:10px">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        {{-- 2. Pengaturan Sesi --}}
        <div class="form-card">
            <div class="form-card-head">
                <div class="form-card-head-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93L17.66 6.34A8 8 0 0 1 12 4V2a10 10 0 0 0-8.5 15.5"/></svg>
                    Pengaturan Sesi
                </div>
                <div class="form-card-head-sub">Opsional — kosongkan untuk menggunakan nilai default dari jadwal</div>
            </div>
            <div class="form-card-body">
                <div class="input-row">
                    <div class="form-group">
                        <label class="form-label">Durasi Sesi</label>
                        <div class="input-with-unit">
                            <input type="number" name="durasi_menit" id="durasi_menit"
                                class="form-control @error('durasi_menit') is-invalid @enderror"
                                min="5" max="240" placeholder="Otomatis dari jadwal"
                                value="{{ old('durasi_menit') }}">
                            <span class="unit-label">menit</span>
                        </div>
                        <p class="form-hint">Min 5 menit, maks 240 menit. Default: durasi jadwal.</p>
                        @error('durasi_menit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Radius Absensi</label>
                        <div class="input-with-unit">
                            <input type="number" name="radius_meter" id="radius_meter"
                                class="form-control @error('radius_meter') is-invalid @enderror"
                                min="10" max="1000" placeholder="100"
                                value="{{ old('radius_meter', 100) }}">
                            <span class="unit-label">meter</span>
                        </div>
                        <p class="form-hint">Radius lokasi siswa saat scan QR. Default: 100 m.</p>
                        @error('radius_meter')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Lokasi (opsional) --}}
        <div class="form-card">
            <div class="form-card-head">
                <div class="form-card-head-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    Lokasi Kelas <span style="font-size:11px;color:var(--text3);font-weight:400;font-family:'DM Sans',sans-serif">(opsional)</span>
                </div>
                <div class="form-card-head-sub">Digunakan untuk validasi radius absensi siswa</div>
            </div>
            <div class="form-card-body">
                <div class="geo-detect">
                    <button type="button" class="btn-detect" onclick="detectLocation()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                        Deteksi Lokasi Sekarang
                    </button>
                    <span class="geo-status" id="geoStatus">
                        <span id="geoIcon" style="opacity:.4">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                        </span>
                        <span id="geoText">Klik untuk mendeteksi lokasi Anda</span>
                    </span>
                </div>
                <div class="input-row" style="margin-top:14px">
                    <div class="form-group">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" id="latitude"
                            class="form-control @error('latitude') is-invalid @enderror"
                            placeholder="-6.123456"
                            value="{{ old('latitude') }}">
                        @error('latitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" id="longitude"
                            class="form-control @error('longitude') is-invalid @enderror"
                            placeholder="107.123456"
                            value="{{ old('longitude') }}">
                        @error('longitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('guru.barcode-kelas.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" {{ $jadwalHariIni->count() === 0 ? 'disabled' : '' }}>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Buat Sesi QR & Tampilkan
            </button>
        </div>
    </form>
</div>

<script>
// Highlight selected jadwal option
function updateSelected(radio) {
    document.querySelectorAll('.jadwal-option').forEach(el => el.classList.remove('selected'));
    if (radio.checked) radio.closest('.jadwal-option').classList.add('selected');
}

// Detect geolocation
function detectLocation() {
    const geoText = document.getElementById('geoText');
    const geoIcon = document.getElementById('geoIcon');
    geoText.textContent = 'Mendeteksi lokasi…';
    geoIcon.style.opacity = '1';

    if (!navigator.geolocation) {
        geoText.textContent = 'Browser tidak mendukung geolokasi';
        return;
    }
    navigator.geolocation.getCurrentPosition(
        pos => {
            const lat = pos.coords.latitude.toFixed(6);
            const lng = pos.coords.longitude.toFixed(6);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            geoText.textContent = `Lokasi terdeteksi: ${lat}, ${lng}`;
            geoText.style.color = 'var(--green)';
        },
        err => {
            geoText.textContent = 'Gagal mendeteksi lokasi: ' + err.message;
            geoText.style.color = 'var(--red)';
        },
        { enableHighAccuracy: true, timeout: 8000 }
    );
}
</script>
</x-app-layout>