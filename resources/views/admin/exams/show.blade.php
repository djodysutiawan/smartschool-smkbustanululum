<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500, showConfirmButton: false,
            toast: true, position: 'top-end',
        });
    @endif
</script>

<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
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

    .page { padding: 28px 28px 60px; max-width: 900px; margin: 0 auto; }

    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-edit    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); }
    .btn-danger  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }

    /* Status badge besar di hero */
    .hero-status {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        margin-bottom: 12px;
    }
    .hero-status .dot { width: 7px; height: 7px; border-radius: 50%; }
    .status-upcoming { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .status-upcoming .dot { background: var(--brand); }
    .status-today    { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .status-today .dot { background: #16a34a; }
    .status-past     { background: var(--surface3); color: var(--text3); border: 1px solid var(--border2); }
    .status-past .dot { background: var(--text3); }

    /* Info card */
    .info-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .info-card-header {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .info-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .info-card-body { padding: 20px; }

    /* Detail grid */
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
    .detail-item {
        padding: 14px 18px; border-bottom: 1px solid var(--border);
    }
    .detail-item:nth-child(odd)  { border-right: 1px solid var(--border); }
    .detail-item:nth-last-child(-n+2) { border-bottom: none; }
    .detail-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--text3); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 6px;
    }
    .detail-value {
        font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--text); font-weight: 500;
    }
    .detail-value.empty { color: var(--text3); font-style: italic; font-size: 13px; }

    /* Hero judul */
    .exam-hero {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 24px 24px 20px; margin-bottom: 16px;
        display: flex; align-items: flex-start; gap: 18px;
    }
    .exam-hero-icon {
        width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
    }
    .exam-hero-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; font-weight: 800;
        color: var(--text); line-height: 1.3; margin-bottom: 6px;
    }
    .exam-hero-meta {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }

    /* Badge */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-class   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-subject { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }

    /* Teacher row */
    .teacher-row { display: flex; align-items: center; gap: 10px; }
    .teacher-avatar {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
        font-weight: 800; color: var(--text2); overflow: hidden;
    }
    .teacher-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .teacher-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--text);
    }

    /* Date big display */
    .date-big {
        display: flex; align-items: center; gap: 16px;
        padding: 16px 20px;
    }
    .date-big-cal {
        width: 56px; height: 56px; border-radius: 12px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .date-big-cal .cal-month {
        background: var(--brand); color: #fff; width: 100%; text-align: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 9px; font-weight: 800;
        letter-spacing: .08em; text-transform: uppercase; padding: 2px 0;
    }
    .date-big-cal .cal-day {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800;
        color: var(--brand-700); line-height: 1; padding: 4px 0;
    }
    .date-big-info {}
    .date-big-full {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; color: var(--text);
    }
    .date-big-countdown {
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); margin-top: 3px;
    }

    /* Meta row */
    .meta-sep { color: var(--border2); font-size: 14px; }

    /* Timestamps */
    .timestamps {
        display: flex; gap: 16px; flex-wrap: wrap;
        padding: 14px 20px; border-top: 1px solid var(--border);
    }
    .ts-item { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }
    .ts-item strong { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: var(--text2); }

    @media (max-width: 640px) {
        .detail-grid { grid-template-columns: 1fr; }
        .detail-item:nth-child(odd) { border-right: none; }
        .detail-item:nth-last-child(-n+2) { border-bottom: 1px solid var(--border); }
        .detail-item:last-child { border-bottom: none; }
        .page { padding: 16px 16px 40px; }
        .exam-hero { flex-direction: column; gap: 12px; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.exams.index') }}">Ujian</a>
        <span class="sep">›</span>
        <span class="current">{{ Str::limit($exam->judul, 50) }}</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Ujian</h1>
            <p class="page-sub">Informasi lengkap jadwal ujian</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <button type="button" class="btn btn-danger"
                    data-id="{{ $exam->id }}"
                    data-judul="{{ $exam->judul }}"
                    onclick="confirmDelete(this)">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                </svg>
                Hapus
            </button>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @php
        $tgl      = \Carbon\Carbon::parse($exam->tanggal);
        $today    = \Carbon\Carbon::today();
        $diffDays = $today->diffInDays($tgl, false);

        if ($tgl->isToday()) {
            $statusClass = 'status-today';
            $statusLabel = 'Hari Ini';
            $countdown   = 'Ujian berlangsung hari ini';
        } elseif ($tgl->isFuture()) {
            $statusClass = 'status-upcoming';
            $statusLabel = 'Upcoming';
            $countdown   = $diffDays . ' hari lagi';
        } else {
            $statusClass = 'status-past';
            $statusLabel = 'Sudah Lewat';
            $countdown   = abs($diffDays) . ' hari yang lalu';
        }

        $MONTHS_ID = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $DAYS_ID   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    @endphp

    {{-- Hero --}}
    <div class="exam-hero">
        <div class="exam-hero-icon">
            <svg width="24" height="24" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 11l3 3L22 4"/>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
        </div>
        <div style="flex:1;min-width:0">
            <span class="hero-status {{ $statusClass }}">
                <span class="dot"></span>
                {{ $statusLabel }}
            </span>
            <h2 class="exam-hero-title">{{ $exam->judul }}</h2>
            <div class="exam-hero-meta">
                @if($exam->subject)
                    <span class="badge badge-subject">{{ $exam->subject->nama_mapel }}</span>
                @endif
                @if($exam->class)
                    <span class="badge badge-class">{{ $exam->class->nama_kelas }}</span>
                @endif
                @if($exam->subject || $exam->class)
                    <span class="meta-sep">·</span>
                @endif
                <span style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3)">
                    ID #{{ $exam->id }}
                </span>
            </div>
        </div>
    </div>

    {{-- Tanggal Pelaksanaan --}}
    <div class="info-card">
        <div class="info-card-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p class="info-card-title">Tanggal Pelaksanaan</p>
        </div>
        <div class="date-big">
            <div class="date-big-cal">
                <div class="cal-month">{{ strtoupper(substr($MONTHS_ID[$tgl->month], 0, 3)) }}</div>
                <div class="cal-day">{{ $tgl->format('d') }}</div>
            </div>
            <div class="date-big-info">
                <p class="date-big-full">
                    {{ $DAYS_ID[$tgl->dayOfWeek] }}, {{ $tgl->format('d') }} {{ $MONTHS_ID[$tgl->month] }} {{ $tgl->year }}
                </p>
                <p class="date-big-countdown">{{ $countdown }}</p>
            </div>
        </div>
    </div>

    {{-- Detail Info --}}
    <div class="info-card">
        <div class="info-card-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <p class="info-card-title">Informasi Lengkap</p>
        </div>

        <div class="detail-grid">

            {{-- Guru --}}
            <div class="detail-item">
                <p class="detail-label">Guru Pengawas</p>
                @if($exam->teacher)
                    <div class="teacher-row">
                        <div class="teacher-avatar">
                            @if($exam->teacher->foto)
                                <img src="{{ asset('storage/'.$exam->teacher->foto) }}" alt="">
                            @else
                                {{ strtoupper(substr($exam->teacher->nama_lengkap, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="teacher-name">{{ $exam->teacher->nama_lengkap }}</p>
                        </div>
                    </div>
                @else
                    <p class="detail-value empty">Tidak ada</p>
                @endif
            </div>

            {{-- Mata Pelajaran --}}
            <div class="detail-item">
                <p class="detail-label">Mata Pelajaran</p>
                @if($exam->subject)
                    <span class="badge badge-subject" style="font-size:13px;padding:5px 12px">
                        {{ $exam->subject->nama_mapel }}
                    </span>
                @else
                    <p class="detail-value empty">Tidak ada</p>
                @endif
            </div>

            {{-- Kelas --}}
            <div class="detail-item">
                <p class="detail-label">Kelas</p>
                @if($exam->class)
                    <span class="badge badge-class" style="font-size:13px;padding:5px 12px">
                        {{ $exam->class->nama_kelas }}
                    </span>
                @else
                    <p class="detail-value empty">Tidak ada</p>
                @endif
            </div>

            {{-- Status --}}
            <div class="detail-item">
                <p class="detail-label">Status</p>
                <span class="hero-status {{ $statusClass }}" style="margin:0">
                    <span class="dot"></span>
                    {{ $statusLabel }}
                </span>
            </div>

        </div>

        {{-- Timestamps --}}
        <div class="timestamps">
            <span class="ts-item">
                Dibuat: <strong>{{ $exam->created_at->format('d M Y, H:i') }}</strong>
            </span>
            @if($exam->updated_at && $exam->updated_at->ne($exam->created_at))
                <span class="ts-item">
                    Diperbarui: <strong>{{ $exam->updated_at->format('d M Y, H:i') }}</strong>
                </span>
            @endif
        </div>

    </div>

    {{-- Form delete (hidden) --}}
    <form id="deleteForm" method="POST"
          action="{{ route('admin.exams.destroy', $exam->id) }}" style="display:none">
        @csrf @method('DELETE')
    </form>

</div>

<script>
    function confirmDelete(btn) {
        const judul = btn.dataset.judul;
        Swal.fire({
            title: 'Hapus Ujian?',
            html: `Ujian <b>${judul}</b> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
</script>

</x-app-layout>