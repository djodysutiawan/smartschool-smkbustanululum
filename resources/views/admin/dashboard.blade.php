<x-app-layout>
    <x-slot name="header">
        <h2>
            @php $role = Auth::user()->role ?? 'siswa'; @endphp
            @switch($role)
                @case('admin')      Dashboard Admin @break
                @case('guru')       Dashboard Guru @break
                @case('guru_piket') Dashboard Guru Piket @break
                @case('siswa')      Beranda Siswa @break
                @case('orang_tua')  Beranda Orang Tua @break
                @default            Dashboard
            @endswitch
        </h2>
    </x-slot>

    <style>
        /* ── Stat cards ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .stat-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 26px; color: #0f172a;
            line-height: 1;
        }
        .stat-label {
            font-size: 12.5px; color: #64748b;
            font-family: 'DM Sans', sans-serif;
        }
        .stat-delta {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 700;
            display: inline-flex; align-items: center; gap: 3px;
            padding: 2px 8px; border-radius: 99px;
        }
        .delta-up   { background: #f0fdf4; color: #15803d; }
        .delta-down { background: #fef2f2; color: #dc2626; }
        .delta-neu  { background: #f8fafc; color: #475569; }

        /* ── Section cards ── */
        .section-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 20px;
        }
        .section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700; font-size: 14px; color: #0f172a;
            margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-title .dot {
            width: 8px; height: 8px; border-radius: 50%;
        }

        /* ── Two-col grid ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }

        /* ── List items ── */
        .list-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f8fafc;
            font-size: 13.5px; color: #334155;
        }
        .list-item:last-child { border-bottom: none; }
        .list-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .list-meta { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }
        .list-right { margin-left: auto; }

        /* ── Pill status ── */
        .pill {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px; font-weight: 700;
            letter-spacing: .04em; text-transform: uppercase;
            padding: 3px 10px; border-radius: 99px;
        }
        .pill-green  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .pill-red    { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .pill-amber  { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .pill-blue   { background: #eef6ff; color: #1750c0; border: 1px solid #bfdbfe; }

        /* ── Welcome banner ── */
        .welcome-banner {
            background: linear-gradient(135deg, #0d1f4e 0%, #1750c0 55%, #0a6b4a 100%);
            border-radius: 16px;
            padding: 22px 26px;
            margin-bottom: 22px;
            position: relative; overflow: hidden;
        }
        .welcome-banner::before {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .welcome-banner h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 18px; color: #fff;
            position: relative;
        }
        .welcome-banner p {
            font-size: 13.5px; color: rgba(255,255,255,.65);
            margin-top: 4px; position: relative;
        }
    </style>

    @php $user = Auth::user(); $role = $user->role ?? 'siswa'; @endphp

    {{-- Welcome banner --}}
    <div class="welcome-banner">
        <h3>Halo, {{ $user->name }} 👋</h3>
        <p>
            @switch($role)
                @case('admin')      Selamat datang di panel administrator SmartSchool. @break
                @case('guru')       Semoga hari mengajar Anda produktif dan menyenangkan. @break
                @case('guru_piket') Pantau aktivitas sekolah hari ini dari sini. @break
                @case('siswa')      Yuk, cek jadwal dan tugas hari ini! @break
                @case('orang_tua')  Pantau perkembangan putra/putri Anda. @break
            @endswitch
        </p>
    </div>

    {{-- ════════ ADMIN DASHBOARD ════════ --}}
    @if($role === 'admin')

    {{-- <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef6ff;">
                <svg width="18" height="18" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-value">512</p>
                <p class="stat-label">Total Siswa</p>
            </div>
            <span class="stat-delta delta-up">↑ 12 bulan ini</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fdf2f8;">
                <svg width="18" height="18" fill="none" stroke="#be185d" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 2v5M12 2v5M8 2v5"/></svg>
            </div>
            <div>
                <p class="stat-value">38</p>
                <p class="stat-label">Total Guru</p>
            </div>
            <span class="stat-delta delta-neu">Aktif semua</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <svg width="18" height="18" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-value">94<span style="font-size:16px;font-weight:600;color:#64748b;">%</span></p>
                <p class="stat-label">Kehadiran Hari Ini</p>
            </div>
            <span class="stat-delta delta-up">↑ 2% vs kemarin</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2;">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg>
            </div>
            <div>
                <p class="stat-value">7</p>
                <p class="stat-label">Pelanggaran Hari Ini</p>
            </div>
            <span class="stat-delta delta-down">↑ 3 vs kemarin</span>
        </div>
    </div>

    <div class="two-col">
        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#1750c0;"></span>Aktivitas LMS Terbaru</p>
            <div class="list-item">
                <div class="list-icon" style="background:#eef6ff;"><svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg></div>
                <div><p>Materi Matematika XII-A</p><p class="list-meta">Budi Santoso · 10 mnt lalu</p></div>
                <span class="pill pill-blue list-right">Materi</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#f5f3ff;"><svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg></div>
                <div><p>Tugas Fisika XI-B</p><p class="list-meta">Siti Rahma · 25 mnt lalu</p></div>
                <span class="pill pill-amber list-right">Tugas</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#f0fdf4;"><svg width="14" height="14" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg></div>
                <div><p>Ujian Kimia X-C selesai</p><p class="list-meta">Ahmad Fauzi · 1 jam lalu</p></div>
                <span class="pill pill-green list-right">Selesai</span>
            </div>
        </div>

        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#dc2626;"></span>Pelanggaran Terbaru</p>
            <div class="list-item">
                <div class="list-icon" style="background:#fef2f2;"><svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg></div>
                <div><p>Rizky A. — Terlambat</p><p class="list-meta">XI-RPL · 07.45 WIB</p></div>
                <span class="pill pill-amber list-right">Ringan</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#fef2f2;"><svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg></div>
                <div><p>Dika F. — HP saat pelajaran</p><p class="list-meta">X-TKJ · 09.10 WIB</p></div>
                <span class="pill pill-amber list-right">Sedang</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#fef2f2;"><svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg></div>
                <div><p>Fajar M. — Bolos</p><p class="list-meta">XII-AKL · 10.00 WIB</p></div>
                <span class="pill pill-red list-right">Berat</span>
            </div>
        </div>
    </div> --}}

    {{-- ════════ GURU DASHBOARD ════════ --}}
    @elseif($role === 'guru')

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef6ff;">
                <svg width="18" height="18" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/></svg>
            </div>
            <div><p class="stat-value">4</p><p class="stat-label">Jadwal Hari Ini</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <svg width="18" height="18" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><p class="stat-value">127</p><p class="stat-label">Total Siswa Diajar</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fdf2f8;">
                <svg width="18" height="18" fill="none" stroke="#be185d" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div><p class="stat-value">8</p><p class="stat-label">Tugas Belum Dinilai</p></div>
            <span class="stat-delta delta-down">Perlu tindakan</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div><p class="stat-value">91<span style="font-size:16px;color:#64748b;">%</span></p><p class="stat-label">Rata-rata Kehadiran</p></div>
            <span class="stat-delta delta-up">↑ Baik</span>
        </div>
    </div>

    <div class="two-col">
        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#1750c0;"></span>Jadwal Hari Ini</p>
            <div class="list-item">
                <div class="list-icon" style="background:#eef6ff;"><svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><p>Matematika — XI-RPL</p><p class="list-meta">07.30 – 09.00 · Ruang 3B</p></div>
                <span class="pill pill-green list-right">Aktif</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#f8fafc;"><svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><p>Matematika — X-TKJ</p><p class="list-meta">09.15 – 10.45 · Ruang 2A</p></div>
                <span class="pill pill-amber list-right">Berikutnya</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#f8fafc;"><svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><p>Matematika — XII-AKL</p><p class="list-meta">13.00 – 14.30 · Ruang 4C</p></div>
                <span class="pill list-right" style="background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;">Nanti</span>
            </div>
        </div>

        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#be185d;"></span>Tugas Perlu Dinilai</p>
            <div class="list-item">
                <div class="list-icon" style="background:#fdf2f8;"><svg width="14" height="14" fill="none" stroke="#be185d" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg></div>
                <div><p>Soal Persamaan Kuadrat</p><p class="list-meta">XI-RPL · 32 pengumpul</p></div>
                <span class="pill pill-red list-right">Segera</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#fdf2f8;"><svg width="14" height="14" fill="none" stroke="#be185d" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg></div>
                <div><p>Latihan Statistika</p><p class="list-meta">XII-AKL · 28 pengumpul</p></div>
                <span class="pill pill-amber list-right">2 hari lagi</span>
            </div>
        </div>
    </div>

    {{-- ════════ GURU PIKET DASHBOARD ════════ --}}
    @elseif($role === 'guru_piket')

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
            </div>
            <div><p class="stat-value">7</p><p class="stat-label">Pelanggaran Hari Ini</p></div>
            <span class="stat-delta delta-down">↑ 3 vs kemarin</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2;">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            </div>
            <div><p class="stat-value">2</p><p class="stat-label">Kelas Kosong</p></div>
            <span class="stat-delta delta-down">Perlu cek</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <svg width="18" height="18" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/></svg>
            </div>
            <div><p class="stat-value">18</p><p class="stat-label">Kelas Berjalan Normal</p></div>
            <span class="stat-delta delta-up">↑ Baik</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef6ff;">
                <svg width="18" height="18" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div><p class="stat-value">1</p><p class="stat-label">Laporan Harian Dibuat</p></div>
        </div>
    </div>

    <div class="section-card">
        <p class="section-title"><span class="dot" style="background:#d97706;"></span>Pelanggaran Terbaru Hari Ini</p>
        <div class="list-item">
            <div class="list-icon" style="background:#fef2f2;"><svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg></div>
            <div><p>Rizky Aditya — Terlambat masuk</p><p class="list-meta">XI-RPL · 07.45 WIB · 5 poin</p></div>
            <span class="pill pill-amber list-right">Ringan</span>
        </div>
        <div class="list-item">
            <div class="list-icon" style="background:#fef2f2;"><svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg></div>
            <div><p>Dika Firmansyah — HP saat pelajaran</p><p class="list-meta">X-TKJ · 09.10 WIB · 10 poin</p></div>
            <span class="pill pill-amber list-right">Sedang</span>
        </div>
        <div class="list-item">
            <div class="list-icon" style="background:#fef2f2;"><svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg></div>
            <div><p>Fajar Maulana — Tidak masuk tanpa ket.</p><p class="list-meta">XII-AKL · 07.00 WIB · 20 poin</p></div>
            <span class="pill pill-red list-right">Berat</span>
        </div>
    </div>

    {{-- ════════ SISWA DASHBOARD ════════ --}}
    @elseif($role === 'siswa')

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <svg width="18" height="18" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/></svg>
            </div>
            <div><p class="stat-value">92<span style="font-size:16px;color:#64748b;">%</span></p><p class="stat-label">Kehadiran Bulan Ini</p></div>
            <span class="stat-delta delta-up">Sangat baik</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef6ff;">
                <svg width="18" height="18" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div><p class="stat-value">3</p><p class="stat-label">Tugas Belum Dikumpul</p></div>
            <span class="stat-delta delta-down">Segera!</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">
                <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div><p class="stat-value">82</p><p class="stat-label">Rata-rata Nilai</p></div>
            <span class="stat-delta delta-up">↑ Baik</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2;">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
            </div>
            <div><p class="stat-value">5</p><p class="stat-label">Total Poin Pelanggaran</p></div>
            <span class="stat-delta delta-neu">Aman</span>
        </div>
    </div>

    <div class="two-col">
        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#1750c0;"></span>Jadwal Hari Ini</p>
            <div class="list-item">
                <div class="list-icon" style="background:#eef6ff;"><svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><p>Matematika</p><p class="list-meta">07.30 – 09.00 · Budi Santoso</p></div>
                <span class="pill pill-green list-right">Aktif</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#f8fafc;"><svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><p>Fisika</p><p class="list-meta">09.15 – 10.45 · Siti Rahma</p></div>
                <span class="pill pill-amber list-right">Berikutnya</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#f8fafc;"><svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div><p>Bahasa Indonesia</p><p class="list-meta">11.00 – 12.30 · Ahmad Fauzi</p></div>
                <span class="pill list-right" style="background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;">Nanti</span>
            </div>
        </div>

        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#dc2626;"></span>Tugas Mendekati Deadline</p>
            <div class="list-item">
                <div class="list-icon" style="background:#fef2f2;"><svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg></div>
                <div><p>Soal Persamaan Kuadrat</p><p class="list-meta">Matematika · Besok 23.59</p></div>
                <span class="pill pill-red list-right">Segera!</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#fffbeb;"><svg width="14" height="14" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/></svg></div>
                <div><p>Laporan Praktikum Fisika</p><p class="list-meta">Fisika · 3 hari lagi</p></div>
                <span class="pill pill-amber list-right">3 hari</span>
            </div>
        </div>
    </div>

    {{-- ════════ ORANG TUA DASHBOARD ════════ --}}
    @elseif($role === 'orang_tua')

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <svg width="18" height="18" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/></svg>
            </div>
            <div><p class="stat-value">92<span style="font-size:16px;color:#64748b;">%</span></p><p class="stat-label">Kehadiran Anak</p></div>
            <span class="stat-delta delta-up">Sangat baik</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef6ff;">
                <svg width="18" height="18" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div><p class="stat-value">82</p><p class="stat-label">Rata-rata Nilai</p></div>
            <span class="stat-delta delta-up">↑ Baik</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2;">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
            </div>
            <div><p class="stat-value">5</p><p class="stat-label">Poin Pelanggaran</p></div>
            <span class="stat-delta delta-neu">Aman</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f5f3ff;">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/></svg>
            </div>
            <div><p class="stat-value">2</p><p class="stat-label">Notifikasi Baru</p></div>
        </div>
    </div>

    <div class="two-col">
        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#1750c0;"></span>Nilai Terbaru Anak</p>
            <div class="list-item">
                <div class="list-icon" style="background:#eef6ff;"><svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div><p>Matematika</p><p class="list-meta">UTS Semester 2</p></div>
                <span style="margin-left:auto;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:#1750c0;">88</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#f0fdf4;"><svg width="14" height="14" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div><p>Fisika</p><p class="list-meta">Ulangan Harian 3</p></div>
                <span style="margin-left:auto;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:#059669;">79</span>
            </div>
            <div class="list-item">
                <div class="list-icon" style="background:#fdf2f8;"><svg width="14" height="14" fill="none" stroke="#be185d" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div><p>Bahasa Indonesia</p><p class="list-meta">Tugas Esai</p></div>
                <span style="margin-left:auto;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:#be185d;">91</span>
            </div>
        </div>

        <div class="section-card">
            <p class="section-title"><span class="dot" style="background:#059669;"></span>Status Kehadiran Minggu Ini</p>
            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $day)
            <div class="list-item">
                <div style="font-size:12.5px;color:#334155;width:70px;">{{ $day }}</div>
                <span class="pill {{ $loop->index === 2 ? 'pill-amber' : 'pill-green' }}">
                    {{ $loop->index === 2 ? 'Izin' : 'Hadir' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    @endif

</x-app-layout>