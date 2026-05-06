<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);}
    .form-card-sub{font-size:12px;color:var(--text3);margin-top:2px;}
    .form-body{padding:20px;}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;}
    .form-group{display:flex;flex-direction:column;gap:5px;}
    .form-group.full{grid-column:1/-1;}
    label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    label .req{color:#ef4444;margin-left:2px;}
    .form-control{height:40px;padding:0 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;width:100%;box-sizing:border-box;}
    .form-control:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.1);background:#fff;}
    .form-control.is-invalid{border-color:#ef4444;}
    textarea.form-control{height:auto;padding:10px 12px;resize:vertical;}
    select.form-control{cursor:pointer;}
    .hint{font-size:11.5px;color:var(--text3);margin-top:2px;}
    .error-msg{font-size:11.5px;color:#ef4444;margin-top:2px;}
    .alert{padding:12px 16px;border-radius:var(--radius-sm);font-size:13px;margin-bottom:16px;display:flex;align-items:flex-start;gap:10px;}
    .alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
    .alert-info{background:var(--brand-50);border:1px solid var(--brand-100);color:var(--brand-700);}
    .jadwal-list{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:4px;}
    .jadwal-item{border:2px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;cursor:pointer;transition:all .15s;position:relative;}
    .jadwal-item:hover{border-color:var(--brand-500);background:var(--brand-50);}
    .jadwal-item.selected{border-color:var(--brand-600);background:var(--brand-50);}
    .jadwal-item input[type=radio]{position:absolute;opacity:0;width:0;height:0;}
    .jadwal-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--text);}
    .jadwal-meta{font-size:12px;color:var(--text3);margin-top:3px;}
    .jadwal-badge{display:inline-flex;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:var(--brand-50);color:var(--brand-600);margin-top:5px;}
    .divider{border:none;border-top:1px solid var(--border);margin:4px 0 16px;}
    .toggle-gps{display:flex;align-items:center;gap:10px;padding:12px 14px;border:1.5px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;}
    .toggle-gps:hover{border-color:var(--brand-500);background:var(--brand-50);}
    .toggle-gps input{width:16px;height:16px;accent-color:var(--brand-600);cursor:pointer;}
    .toggle-gps-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .toggle-gps-sub{font-size:11.5px;color:var(--text3);}
    .gps-fields{display:none;}
    .gps-fields.show{display:block;}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px;}
    .form-footer{padding:16px 20px;border-top:1px solid var(--border);background:var(--surface2);display:flex;justify-content:flex-end;gap:10px;}
    @media(max-width:640px){.form-grid,.form-grid-3,.jadwal-list{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Sesi QR Absensi</h1>
            <p class="page-sub">Generate QR code untuk absensi siswa per mata pelajaran</p>
        </div>
        <a href="{{ route('admin.sesi-qr.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin:4px 0 0 16px;padding:0;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.sesi-qr.store') }}" id="formSesiQr">
        @csrf

        {{-- PILIH JADWAL HARI INI --}}
        @if($jadwalHariIni->isNotEmpty())
        <div class="form-card">
            <div class="form-card-header">
                <p class="form-card-title">📅 Jadwal Hari Ini — {{ ucfirst($hariIni) }}, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="form-card-sub">Pilih jadwal untuk mengisi otomatis kelas & mata pelajaran, atau isi manual di bawah</p>
            </div>
            <div class="form-body">
                <div class="jadwal-list" id="jadwalList">
                    @foreach($jadwalHariIni as $jadwal)
                    <label class="jadwal-item" id="jadwal-card-{{ $jadwal->id }}" for="jadwal_{{ $jadwal->id }}">
                        <input type="radio" name="_jadwal_pilih" id="jadwal_{{ $jadwal->id }}" value="{{ $jadwal->id }}"
                            data-kelas="{{ $jadwal->kelas_id }}"
                            data-mapel="{{ $jadwal->mata_pelajaran_id }}"
                            data-jam-mulai="{{ substr($jadwal->jam_mulai, 0, 5) }}"
                            data-jam-selesai="{{ substr($jadwal->jam_selesai, 0, 5) }}"
                            {{ old('jadwal_pelajaran_id') == $jadwal->id ? 'checked' : '' }}>
                        <p class="jadwal-mapel">{{ $jadwal->mataPelajaran->nama_mapel }}</p>
                        <p class="jadwal-meta">
                            {{ $jadwal->kelas->nama_kelas }} &bull;
                            {{ substr($jadwal->jam_mulai,0,5) }}–{{ substr($jadwal->jam_selesai,0,5) }}
                            @if($jadwal->ruang) &bull; {{ $jadwal->ruang->nama_ruang }} @endif
                        </p>
                        <span class="jadwal-badge">{{ $jadwal->mataPelajaran->kelompok ?? 'Umum' }}</span>
                        {{-- Perbaikan bug: method hasSesiQrAktifHariIni() dipanggil di view
                             tapi tidak pernah didefinisikan di model JadwalPelajaran.
                             Sekarang diganti dengan query langsung yang aman. --}}
                        @if($jadwal->sesiQr()->whereDate('tanggal', today())->where('is_active', true)->exists())
                        <span class="jadwal-badge" style="background:#dcfce7;color:#15803d;margin-left:4px;">✓ QR Aktif</span>
                        @endif
                    </label>
                    @endforeach
                </div>
                <input type="hidden" name="jadwal_pelajaran_id" id="jadwal_pelajaran_id" value="{{ old('jadwal_pelajaran_id') }}">
            </div>
        </div>
        @else
        <div class="alert alert-info">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            Tidak ada jadwal aktif hari ini. Isi data sesi QR secara manual di bawah.
        </div>
        @endif

        {{-- DATA SESI --}}
        <div class="form-card">
            <div class="form-card-header">
                <p class="form-card-title">Data Sesi QR</p>
            </div>
            <div class="form-body">
                <div class="section-title">Kelas & Mata Pelajaran</div>
                <div class="form-grid" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label for="kelas_id">Kelas <span class="req">*</span></label>
                        <select name="kelas_id" id="kelas_id" class="form-control {{ $errors->has('kelas_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tingkat }}{{ $k->jurusan ? ' · '.$k->jurusan->singkatan : '' }})
                            </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="mata_pelajaran_id">Mata Pelajaran <span class="req">*</span></label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-control {{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Pilih Mata Pelajaran —</option>
                            @foreach(\App\Models\MataPelajaran::aktif()->orderBy('nama_mapel')->get() as $m)
                            <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>

                <hr class="divider">
                <div class="section-title">Waktu Berlaku</div>
                <div class="form-grid-3" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label for="tanggal">Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                            value="{{ old('tanggal', today()->toDateString()) }}" required>
                        @error('tanggal')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="berlaku_mulai">Jam Mulai Berlaku <span class="req">*</span></label>
                        <input type="time" name="berlaku_mulai" id="berlaku_mulai" class="form-control {{ $errors->has('berlaku_mulai') ? 'is-invalid' : '' }}"
                            value="{{ old('berlaku_mulai', now()->format('H:i')) }}" required>
                        @error('berlaku_mulai')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="durasi_menit">Durasi (menit) <span class="req">*</span></label>
                        <input type="number" name="durasi_menit" id="durasi_menit" class="form-control {{ $errors->has('durasi_menit') ? 'is-invalid' : '' }}"
                            value="{{ old('durasi_menit', 90) }}" min="5" max="240" required>
                        <p class="hint">QR otomatis kadaluarsa setelah durasi ini</p>
                        @error('durasi_menit')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>

                <hr class="divider">
                <div class="section-title">Pengaturan Lanjutan</div>
                <div class="form-grid" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label for="radius_meter">Radius Lokasi (meter)</label>
                        <input type="number" name="radius_meter" id="radius_meter" class="form-control"
                            value="{{ old('radius_meter', 100) }}" min="10" max="1000">
                        <p class="hint">Jarak maksimal siswa dari titik QR. Kosongkan untuk tanpa validasi GPS.</p>
                    </div>
                    <div class="form-group">
                        <label for="maks_scan">Maksimal Scan</label>
                        <input type="number" name="maks_scan" id="maks_scan" class="form-control"
                            value="{{ old('maks_scan', 0) }}" min="0">
                        <p class="hint">0 = tidak ada batas. Isi sesuai jumlah siswa jika ingin dibatasi.</p>
                    </div>
                </div>

                {{-- GPS --}}
                <label class="toggle-gps" for="enableGps">
                    <input type="checkbox" id="enableGps" onchange="toggleGps(this)">
                    <div>
                        <p class="toggle-gps-label">📍 Aktifkan Validasi GPS</p>
                        <p class="toggle-gps-sub">Siswa wajib berada dalam radius dari koordinat yang ditentukan</p>
                    </div>
                </label>
                <div class="gps-fields" id="gpsFields" style="margin-top:12px;">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="number" step="any" name="latitude" id="latitude" class="form-control"
                                value="{{ old('latitude') }}" placeholder="-6.9175">
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="number" step="any" name="longitude" id="longitude" class="form-control"
                                value="{{ old('longitude') }}" placeholder="107.6191">
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" style="margin-top:8px;" onclick="gunakanLokasiSekarang()">
                        📍 Gunakan Lokasi Saya Sekarang
                    </button>
                </div>
            </div>
            <div class="form-footer">
                <a href="{{ route('admin.sesi-qr.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Generate QR Code
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // Pilih jadwal → isi otomatis field
    document.querySelectorAll('input[name="_jadwal_pilih"]').forEach(radio => {
        // Restore selected state on load
        if (radio.checked) {
            fillFromJadwal(radio);
            document.getElementById('jadwal-card-' + radio.value)?.classList.add('selected');
        }

        radio.addEventListener('change', function() {
            document.querySelectorAll('.jadwal-item').forEach(c => c.classList.remove('selected'));
            document.getElementById('jadwal-card-' + this.value)?.classList.add('selected');
            fillFromJadwal(this);
        });
    });

    function fillFromJadwal(radio) {
        document.getElementById('jadwal_pelajaran_id').value  = radio.value;
        document.getElementById('kelas_id').value             = radio.dataset.kelas;
        document.getElementById('mata_pelajaran_id').value    = radio.dataset.mapel;
        document.getElementById('berlaku_mulai').value        = radio.dataset.jamMulai;

        // Hitung durasi dari jam mulai–selesai
        if (radio.dataset.jamMulai && radio.dataset.jamSelesai) {
            const [h1, m1] = radio.dataset.jamMulai.split(':').map(Number);
            const [h2, m2] = radio.dataset.jamSelesai.split(':').map(Number);
            document.getElementById('durasi_menit').value = ((h2 * 60 + m2) - (h1 * 60 + m1));
        }
    }

    function toggleGps(cb) {
        document.getElementById('gpsFields').classList.toggle('show', cb.checked);
        if (!cb.checked) {
            document.getElementById('latitude').value  = '';
            document.getElementById('longitude').value = '';
        }
    }

    function gunakanLokasiSekarang() {
        if (!navigator.geolocation) { alert('Browser tidak mendukung GPS.'); return; }
        navigator.geolocation.getCurrentPosition(pos => {
            document.getElementById('latitude').value  = pos.coords.latitude.toFixed(8);
            document.getElementById('longitude').value = pos.coords.longitude.toFixed(8);
        }, () => alert('Gagal mendapatkan lokasi. Pastikan izin GPS diaktifkan.'));
    }

    // Perbaikan bug: sebelumnya hanya gpsFields yang di-show, tapi checkbox enableGps
    // tidak dicentang sehingga terlihat inkonsisten (field muncul tapi checkbox unchecked).
    // Sekarang keduanya disinkronkan bersamaan.
    @if(old('latitude') || old('longitude'))
    (function() {
        var cb = document.getElementById('enableGps');
        cb.checked = true;
        document.getElementById('gpsFields').classList.add('show');
    })();
    @endif
</script>
</x-app-layout>