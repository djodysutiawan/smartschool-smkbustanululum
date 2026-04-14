<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
    @endif
</script>

<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db; --brand-h: #3582f0; --brand-50: #eef6ff;
        --brand-100:  #d9ebff; --brand-700: #1750c0;
        --surface:    #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border:     #e2e8f0; --border2: #cbd5e1;
        --text:       #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius:     10px; --radius-sm: 7px;
        --danger:     #dc2626; --danger-50: #fee2e2; --danger-100: #fecaca;
        --success:    #16a34a; --success-50: #f0fdf4; --success-100: #dcfce7;
        --warn:       #d97706; --warn-50: #fffbeb; --warn-100: #fef3c7;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: background .15s; white-space: nowrap; }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost  { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-danger { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }

    /* Hero card */
    .hero-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 28px 24px; margin-bottom: 16px;
        display: flex; align-items: center; gap: 24px; flex-wrap: wrap;
    }
    .hero-avatar {
        width: 64px; height: 64px; border-radius: 16px; flex-shrink: 0;
        background: var(--brand-50); border: 1.5px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--brand-700);
    }
    .hero-info { flex: 1; min-width: 0; }
    .hero-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; font-weight: 800; color: var(--text); }
    .hero-nisn { font-size: 13px; color: var(--text3); margin-top: 2px; }
    .hero-meta { display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap; }
    .hero-tag {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--surface3); border: 1px solid var(--border);
        color: var(--text2); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 6px;
    }
    .hero-score { text-align: right; }
    .hero-score-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .06em; }
    .hero-score-value { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 40px; font-weight: 800; line-height: 1; margin: 4px 0; }
    .hero-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; }

    /* Score breakdown */
    .breakdown-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .card-header { display: flex; align-items: center; gap: 8px; padding: 13px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; }
    .card-body { padding: 20px; }

    .score-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .score-item {
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px;
        display: flex; flex-direction: column; gap: 8px;
    }
    .score-item-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .06em; }
    .score-item-value { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 28px; font-weight: 800; line-height: 1; }
    .score-item-weight { font-size: 12px; color: var(--text3); }
    .progress-bar { height: 6px; background: var(--surface3); border-radius: 4px; overflow: hidden; border: 1px solid var(--border); }
    .progress-fill { height: 100%; border-radius: 4px; transition: width .4s ease; }

    /* Detail table */
    .detail-table { width: 100%; border-collapse: collapse; }
    .detail-table tr { border-bottom: 1px solid var(--border); }
    .detail-table tr:last-child { border-bottom: none; }
    .detail-table td { padding: 12px 16px; font-family: 'DM Sans', sans-serif; font-size: 13.5px; }
    .detail-table td:first-child { width: 40%; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; background: var(--surface2); }
    .detail-table td:last-child { color: var(--text); font-weight: 500; }

    @media(max-width:640px) { .score-grid { grid-template-columns: 1fr; } .page { padding: 16px 16px 40px; } .hero-score { width: 100%; text-align: left; } }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.grades.index') }}">Nilai Siswa</a>
        <span class="sep">›</span>
        <span class="current">Detail Nilai</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Nilai</h1>
            <p class="page-sub">ID #{{ $grade->id }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.grades.edit', $grade->id) }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Nilai
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                </svg>
                Hapus
            </button>
            <a href="{{ route('admin.grades.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @php
        $na       = $grade->nilai_akhir ?? 0;
        $isLulus  = $na >= 75;
        $scoreClr = $na >= 90 ? '#16a34a' : ($na >= 75 ? '#1f63db' : ($na >= 60 ? '#d97706' : '#dc2626'));
        $badgeBg  = $na >= 90 ? '#f0fdf4' : ($na >= 75 ? '#eef6ff' : ($na >= 60 ? '#fffbeb' : '#fee2e2'));
        $badgeBd  = $na >= 90 ? '#dcfce7' : ($na >= 75 ? '#d9ebff' : ($na >= 60 ? '#fef3c7' : '#fecaca'));
        $grade_letter = $na >= 90 ? 'A' : ($na >= 75 ? 'B' : ($na >= 60 ? 'C' : 'D'));
        $initials = collect(explode(' ', $grade->student->name ?? 'S'))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
    @endphp

    {{-- Hero --}}
    <div class="hero-card">
        <div class="hero-avatar">{{ $initials }}</div>
        <div class="hero-info">
            <p class="hero-name">{{ $grade->student->name ?? '—' }}</p>
            <p class="hero-nisn">NISN: {{ $grade->student->nisn ?? '—' }}</p>
            <div class="hero-meta">
                @if($grade->student->class)
                    <span class="hero-tag">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        {{ $grade->student->class->nama_kelas }}
                    </span>
                @endif
                <span class="hero-tag">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    {{ $grade->subject->nama_mapel ?? '—' }}
                </span>
                <span class="hero-tag">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $grade->teacher->nama_lengkap ?? '—' }}
                </span>
            </div>
        </div>
        <div class="hero-score">
            <p class="hero-score-label">Nilai Akhir</p>
            <p class="hero-score-value" style="color:{{ $scoreClr }}">{{ number_format($na, 2) }}</p>
            <span class="hero-badge" style="background:{{ $badgeBg }}; color:{{ $scoreClr }}; border:1px solid {{ $badgeBd }}">
                {{ $isLulus ? '✓ Lulus' : '✗ Tidak Lulus' }}
            </span>
        </div>
    </div>

    {{-- Score breakdown --}}
    <div class="breakdown-card">
        <div class="card-header">
            <svg width="12" height="12" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            <p class="card-title">Rincian Nilai</p>
        </div>
        <div class="card-body">
            <div class="score-grid">
                @php
                    $scores = [
                        ['label' => 'Nilai Tugas', 'key' => 'nilai_tugas', 'weight' => '30%', 'val' => $grade->nilai_tugas ?? 0],
                        ['label' => 'Nilai UTS',   'key' => 'nilai_uts',   'weight' => '30%', 'val' => $grade->nilai_uts   ?? 0],
                        ['label' => 'Nilai UAS',   'key' => 'nilai_uas',   'weight' => '40%', 'val' => $grade->nilai_uas   ?? 0],
                    ];
                @endphp
                @foreach($scores as $s)
                    @php
                        $v   = (float)$s['val'];
                        $clr = $v >= 90 ? '#16a34a' : ($v >= 75 ? '#1f63db' : ($v >= 60 ? '#d97706' : '#dc2626'));
                        $pct = min(100, $v);
                    @endphp
                    <div class="score-item">
                        <p class="score-item-label">{{ $s['label'] }}</p>
                        <p class="score-item-value" style="color:{{ $clr }}">{{ number_format($v, 2) }}</p>
                        <p class="score-item-weight">Bobot {{ $s['weight'] }}</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width:{{ $pct }}%; background:{{ $clr }}"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Formula --}}
            <div style="margin-top:16px; background:var(--surface3); border:1px solid var(--border); border-radius:var(--radius-sm); padding:12px 16px; display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span style="font-family:'DM Sans',sans-serif; font-size:12.5px; color:var(--text2)">
                    Nilai Akhir = ({{ number_format($grade->nilai_tugas ?? 0, 2) }} × 30%)
                    + ({{ number_format($grade->nilai_uts ?? 0, 2) }} × 30%)
                    + ({{ number_format($grade->nilai_uas ?? 0, 2) }} × 40%)
                    = <strong style="color:var(--text)">{{ number_format($na, 2) }}</strong>
                </span>
            </div>
        </div>
    </div>

    {{-- Info tambahan --}}
    <div class="breakdown-card">
        <div class="card-header">
            <svg width="12" height="12" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            <p class="card-title">Informasi Tambahan</p>
        </div>
        <table class="detail-table">
            <tr>
                <td>Siswa</td>
                <td>{{ $grade->student->name ?? '—' }} <span style="color:var(--text3); font-size:12px">(NISN: {{ $grade->student->nisn ?? '—' }})</span></td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>{{ $grade->student->class->nama_kelas ?? '—' }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>{{ $grade->subject->nama_mapel ?? '—' }}</td>
            </tr>
            <tr>
                <td>Guru Pengampu</td>
                <td>{{ $grade->teacher->nama_lengkap ?? '—' }}</td>
            </tr>
            <tr>
                <td>Predikat</td>
                <td>
                    <span style="font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:800; color:{{ $scoreClr }}">
                        {{ $grade_letter }}
                    </span>
                    &nbsp;
                    <span class="hero-badge" style="font-size:11px; background:{{ $badgeBg }}; color:{{ $scoreClr }}; border:1px solid {{ $badgeBd }}">
                        {{ $isLulus ? 'Lulus' : 'Tidak Lulus' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Dibuat</td>
                <td style="color:var(--text2)">{{ $grade->created_at ? $grade->created_at->format('d M Y, H:i') : '—' }}</td>
            </tr>
            <tr>
                <td>Diperbarui</td>
                <td style="color:var(--text2)">{{ $grade->updated_at ? $grade->updated_at->format('d M Y, H:i') : '—' }}</td>
            </tr>
        </table>
    </div>

</div>

<form method="POST" id="deleteForm" action="{{ route('admin.grades.destroy', $grade->id) }}" style="display:none">
    @csrf @method('DELETE')
</form>

<script>
    function confirmDelete() {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus data nilai ini?',
            text: 'Tindakan ini tidak dapat dibatalkan.',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
</script>
</x-app-layout>