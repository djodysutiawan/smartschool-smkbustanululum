<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-50:   #eef6ff;
        --brand-100:  #d9ebff;
        --brand-700:  #1750c0;
        --surface:    #fff;
        --surface2:   #f8fafc;
        --surface3:   #f1f5f9;
        --border:     #e2e8f0;
        --border2:    #cbd5e1;
        --text:       #0f172a;
        --text2:      #475569;
        --text3:      #94a3b8;
        --radius:     10px;
        --radius-sm:  7px;
        --danger:     #dc2626;
        --danger-50:  #fee2e2;
        --danger-100: #fecaca;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* Page header */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* Buttons */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s, filter .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-danger { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: #fecaca; }

    /* Hero banner */
    .hero {
        background: linear-gradient(135deg, #0d1f4e 0%, #1750c0 55%, #0a6b4a 100%);
        border-radius: 14px; padding: 24px 28px; margin-bottom: 22px;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
        flex-wrap: wrap;
    }
    .hero::before {
        content: '';
        position: absolute; inset: 0; pointer-events: none;
        background-image: radial-gradient(circle, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 28px 28px;
    }
    .hero-left { position: relative; }
    .hero-id {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700; letter-spacing: .08em;
        color: rgba(255,255,255,.5); text-transform: uppercase; margin-bottom: 6px;
    }
    .hero-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px; font-weight: 800; color: #fff; line-height: 1.2;
    }
    .hero-sub {
        font-size: 13px; color: rgba(255,255,255,.6); margin-top: 6px;
    }
    .hero-right { position: relative; display: flex; gap: 10px; flex-wrap: wrap; }

    /* Day badge */
    .day-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 6px 18px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800;
    }

    /* Info cards grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 900px) { .info-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 560px) { .info-grid { grid-template-columns: 1fr; } }

    .info-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 18px 20px;
        display: flex; flex-direction: column; gap: 14px;
    }
    .info-card-header {
        display: flex; align-items: center; gap: 10px;
    }
    .info-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .info-card-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px; font-weight: 700; letter-spacing: .07em;
        text-transform: uppercase; color: var(--text3);
    }
    .info-card-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px; font-weight: 800; color: var(--text);
        line-height: 1.3;
    }
    .info-card-sub {
        font-family: 'DM Sans', sans-serif;
        font-size: 12px; color: var(--text3); margin-top: 3px;
    }

    /* Detail section */
    .detail-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .detail-header {
        display: flex; align-items: center; gap: 8px;
        padding: 13px 18px; border-bottom: 1px solid var(--border);
        background: var(--surface2);
    }
    .detail-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; letter-spacing: .07em;
        text-transform: uppercase; color: var(--text3);
    }
    .detail-body { padding: 0; }

    /* Field rows */
    .field-row {
        display: flex; align-items: flex-start;
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        gap: 16px;
    }
    .field-row:last-child { border-bottom: none; }
    .field-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        min-width: 140px; flex-shrink: 0; padding-top: 1px;
    }
    .field-val {
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; color: var(--text); flex: 1;
    }
    .field-val strong {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
    }

    /* Person card inside field */
    .person-card {
        display: flex; align-items: center; gap: 12px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 14px;
    }
    .person-avatar {
        width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 800;
    }
    .person-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .person-sub  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 2px; }

    /* Time display */
    .time-display {
        display: flex; align-items: center; gap: 12px;
    }
    .time-block {
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 8px 16px; text-align: center;
    }
    .time-block .t-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px; font-weight: 700; letter-spacing: .06em;
        text-transform: uppercase; color: var(--brand-700); margin-bottom: 3px;
    }
    .time-block .t-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px; font-weight: 800; color: var(--brand-700); line-height: 1;
    }
    .time-arrow {
        font-size: 18px; color: var(--text3); font-weight: 300;
    }
    .duration-pill {
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: 99px; padding: 5px 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text2);
        display: inline-flex; align-items: center; gap: 5px;
    }

    /* Timestamp row */
    .ts-row {
        display: flex; gap: 24px; flex-wrap: wrap;
        padding: 14px 20px;
        font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3);
    }
    .ts-item strong {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; color: var(--text2); margin-right: 4px;
    }

    /* Action bar */
    .action-bar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px 20px;
    }
    .action-bar-left { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); }
    .action-bar-right { display: flex; gap: 10px; flex-wrap: wrap; }

    @media (max-width: 600px) {
        .page { padding: 16px 16px 40px; }
        .field-row { flex-direction: column; gap: 8px; }
        .field-label { min-width: unset; }
        .time-display { flex-wrap: wrap; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.schedules.index') }}">Jadwal Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Detail #{{ $schedule->id }}</span>
    </nav>

    {{-- Page header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Jadwal Pelajaran</h1>
            <p class="page-sub">Informasi lengkap jadwal ID #{{ $schedule->id }}</p>
        </div>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- ── HERO BANNER ── --}}
    @php
        $hariColor = match($schedule->hari) {
            'Senin'  => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
            'Selasa' => ['bg' => '#dcfce7', 'text' => '#15803d'],
            'Rabu'   => ['bg' => '#fef9c3', 'text' => '#a16207'],
            'Kamis'  => ['bg' => '#ffedd5', 'text' => '#c2410c'],
            'Jumat'  => ['bg' => '#f3e8ff', 'text' => '#7c3aed'],
            'Sabtu'  => ['bg' => '#fce7f3', 'text' => '#be185d'],
            default  => ['bg' => '#f1f5f9', 'text' => '#475569'],
        };
        $mulai   = \Carbon\Carbon::parse($schedule->jam_mulai);
        $selesai = \Carbon\Carbon::parse($schedule->jam_selesai);
        $durMin  = $mulai->diffInMinutes($selesai);
        $durStr  = ($durMin >= 60 ? floor($durMin / 60) . ' jam ' : '') . ($durMin % 60 > 0 ? ($durMin % 60) . ' menit' : '');
    @endphp

    <div class="hero">
        <div class="hero-left">
            <p class="hero-id">Jadwal #{{ $schedule->id }}</p>
            <h2 class="hero-title">{{ $schedule->subject->nama_mapel ?? '—' }}</h2>
            <p class="hero-sub">
                {{ $schedule->class->nama_kelas ?? '—' }}
                &nbsp;·&nbsp;
                {{ $schedule->teacher->nama_lengkap ?? '—' }}
            </p>
        </div>
        <div class="hero-right">
            <span class="day-badge" style="background:{{ $hariColor['bg'] }}; color:{{ $hariColor['text'] }}">
                {{ $schedule->hari }}
            </span>
            <span class="day-badge" style="background:rgba(255,255,255,.15); color:#fff">
                {{ $mulai->format('H:i') }} – {{ $selesai->format('H:i') }}
            </span>
        </div>
    </div>

    {{-- ── INFO CARDS ── --}}
    <div class="info-grid">

        {{-- Mata Pelajaran --}}
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon" style="background:#f3e8ff">
                    <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                </div>
                <span class="info-card-label">Mata Pelajaran</span>
            </div>
            <div>
                <p class="info-card-val">{{ $schedule->subject->nama_mapel ?? '—' }}</p>
                @if($schedule->subject?->kode_mapel)
                    <p class="info-card-sub">Kode: {{ $schedule->subject->kode_mapel }}</p>
                @endif
            </div>
        </div>

        {{-- Kelas --}}
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon" style="background:var(--brand-50)">
                    <svg width="16" height="16" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <span class="info-card-label">Kelas</span>
            </div>
            <div>
                <p class="info-card-val">{{ $schedule->class->nama_kelas ?? '—' }}</p>
                @if($schedule->class?->tingkat || $schedule->class?->jurusan)
                    <p class="info-card-sub">
                        {{ implode(' · ', array_filter([$schedule->class?->tingkat ? 'Tingkat ' . $schedule->class->tingkat : null, $schedule->class?->jurusan])) }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Durasi --}}
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon" style="background:#f0fdf4">
                    <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <span class="info-card-label">Durasi</span>
            </div>
            <div>
                <p class="info-card-val">{{ $durStr }}</p>
                <p class="info-card-sub">{{ $mulai->format('H:i') }} — {{ $selesai->format('H:i') }}</p>
            </div>
        </div>

    </div>

    {{-- ── DETAIL: GURU ── --}}
    <div class="detail-card">
        <div class="detail-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <p class="detail-title">Guru Pengajar</p>
        </div>
        <div class="detail-body">
            <div class="field-row">
                <span class="field-label">Nama Lengkap</span>
                <div class="field-val">
                    <div class="person-card">
                        <div class="person-avatar" style="background:#f1f5f9; color:#475569; border:1px solid #e2e8f0">
                            {{ strtoupper(substr($schedule->teacher->nama_lengkap ?? 'G', 0, 1)) }}
                        </div>
                        <div>
                            <p class="person-name">{{ $schedule->teacher->nama_lengkap ?? '—' }}</p>
                            <p class="person-sub">NIP: {{ $schedule->teacher->nip ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if($schedule->teacher?->email)
                <div class="field-row">
                    <span class="field-label">Email</span>
                    <span class="field-val">{{ $schedule->teacher->email }}</span>
                </div>
            @endif
            @if($schedule->teacher?->no_hp)
                <div class="field-row">
                    <span class="field-label">No. HP</span>
                    <span class="field-val">{{ $schedule->teacher->no_hp }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- ── DETAIL: WAKTU ── --}}
    <div class="detail-card">
        <div class="detail-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p class="detail-title">Waktu Pelaksanaan</p>
        </div>
        <div class="detail-body">
            <div class="field-row">
                <span class="field-label">Hari</span>
                <span class="field-val">
                    <span style="display:inline-flex; align-items:center; gap:6px">
                        <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:{{ $hariColor['text'] }}"></span>
                        <strong>{{ $schedule->hari }}</strong>
                    </span>
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Jam Pelajaran</span>
                <span class="field-val">
                    <div class="time-display">
                        <div class="time-block">
                            <p class="t-label">Mulai</p>
                            <p class="t-val">{{ $mulai->format('H:i') }}</p>
                        </div>
                        <span class="time-arrow">→</span>
                        <div class="time-block">
                            <p class="t-label">Selesai</p>
                            <p class="t-val">{{ $selesai->format('H:i') }}</p>
                        </div>
                        <span class="duration-pill">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                            {{ $durStr }}
                        </span>
                    </div>
                </span>
            </div>
        </div>
    </div>

    {{-- ── DETAIL: META ── --}}
    <div class="detail-card">
        <div class="detail-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <p class="detail-title">Informasi Sistem</p>
        </div>
        <div class="detail-body">
            <div class="ts-row">
                <span class="ts-item">
                    <strong>ID</strong> #{{ $schedule->id }}
                </span>
                <span class="ts-item">
                    <strong>Dibuat</strong>
                    {{ $schedule->created_at->format('d M Y, H:i') }}
                </span>
                <span class="ts-item">
                    <strong>Diperbarui</strong>
                    {{ $schedule->updated_at->format('d M Y, H:i') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── ACTION BAR ── --}}
    <div class="action-bar">
        <span class="action-bar-left">
            Jadwal ini terakhir diperbarui {{ $schedule->updated_at->diffForHumans() }}.
        </span>
        <div class="action-bar-right">
            {{-- Hapus --}}
            <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}"
                onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                    </svg>
                    Hapus
                </button>
            </form>
            {{-- Edit --}}
            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Jadwal
            </a>
        </div>
    </div>

</div>
</x-app-layout>