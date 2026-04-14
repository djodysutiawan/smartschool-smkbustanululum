<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session('success') }}', timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
        Swal.fire({ icon:'error', title:'Gagal!', text:'{{ session('error') }}', timer:3000, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
</script>

<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db; --brand-h:#3582f0; --brand-50:#eef6ff; --brand-100:#d9ebff; --brand-700:#1750c0;
        --surface:#fff; --surface2:#f8fafc; --surface3:#f1f5f9;
        --border:#e2e8f0; --border2:#cbd5e1;
        --text:#0f172a; --text2:#475569; --text3:#94a3b8;
        --radius:10px; --radius-sm:7px;
        --danger:#dc2626; --danger-50:#fee2e2; --danger-100:#fecaca;
        --success:#16a34a; --success-50:#dcfce7; --success-100:#bbf7d0;
        --warning:#d97706; --warning-50:#fef9c3; --warning-100:#fef08a;
        --purple:#7c3aed; --purple-50:#f3e8ff; --purple-100:#e9d5ff;
        --orange:#ea580c; --orange-50:#ffedd5; --orange-100:#fed7aa;
    }
    .page { padding:28px 28px 60px; max-width:1200px; margin:0 auto; }
    .breadcrumb { display:flex; align-items:center; gap:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:600; color:var(--text3); margin-bottom:20px; }
    .breadcrumb a { color:var(--text3); text-decoration:none; transition:color .15s; }
    .breadcrumb a:hover { color:var(--brand); }
    .breadcrumb .sep { color:var(--border2); }
    .breadcrumb .current { color:var(--text2); }
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
    .page-sub   { font-size:12.5px; color:var(--text3); margin-top:3px; }
    .header-actions { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
    .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:background .15s; white-space:nowrap; }
    .btn-primary { background:var(--brand); color:#fff; }
    .btn-primary:hover { background:var(--brand-h); }
    .btn-ghost   { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
    .btn-ghost:hover { background:var(--surface3); }
    .btn-danger  { background:var(--danger-50); color:var(--danger); border:1px solid var(--danger-100); }
    .btn-danger:hover { background:var(--danger-100); }
    .btn-edit-sm { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
    .btn-edit-sm:hover { background:var(--brand-100); }
    .btn-success { background:var(--success-50); color:var(--success); border:1px solid var(--success-100); }
    .btn-success:hover { background:var(--success-100); }
    .btn-dl      { background:var(--purple-50); color:var(--purple); border:1px solid var(--purple-100); }
    .btn-dl:hover { background:var(--purple-100); }
    .btn-sm { padding:5px 11px; font-size:12px; }

    /* Layout grid */
    .detail-grid { display:grid; grid-template-columns:1fr 340px; gap:20px; }
    @media (max-width:900px) { .detail-grid { grid-template-columns:1fr; } }

    /* Cards */
    .card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-bottom:16px; }
    .card-header { padding:14px 20px; border-bottom:1px solid var(--border); background:var(--surface2); display:flex; align-items:center; gap:8px; }
    .card-title  { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text3); letter-spacing:.07em; text-transform:uppercase; }
    .card-body   { padding:20px; }

    /* Info rows */
    .info-row { display:flex; align-items:flex-start; gap:12px; padding:10px 0; border-bottom:1px solid var(--border); }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:.05em; min-width:140px; padding-top:1px; }
    .info-value { font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--text); flex:1; }

    /* Student card */
    .student-profile { display:flex; align-items:center; gap:14px; padding:16px 20px; }
    .student-big-avatar { width:52px; height:52px; border-radius:12px; background:var(--surface3); border:1px solid var(--border2); display:flex; align-items:center; justify-content:center; font-family:'Plus Jakarta Sans',sans-serif; font-size:18px; font-weight:800; color:var(--text2); overflow:hidden; flex-shrink:0; }
    .student-big-avatar img { width:100%; height:100%; object-fit:cover; }
    .student-big-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:15px; font-weight:800; color:var(--text); }
    .student-big-meta { font-size:12.5px; color:var(--text3); margin-top:3px; font-family:'DM Sans',sans-serif; }

    /* Nilai big */
    .nilai-display { text-align:center; padding:24px 20px; }
    .nilai-big { font-family:'Plus Jakarta Sans',sans-serif; font-size:52px; font-weight:800; line-height:1; }
    .nilai-big.na     { color:var(--text3); }
    .nilai-big.nilai-a { color:var(--success); }
    .nilai-big.nilai-b { color:var(--brand-700); }
    .nilai-big.nilai-c { color:var(--warning); }
    .nilai-big.nilai-d { color:var(--danger); }
    .nilai-label { font-size:12px; color:var(--text3); font-family:'DM Sans',sans-serif; margin-top:6px; }
    .nilai-grade-letter { display:inline-block; margin-top:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; padding:4px 14px; border-radius:99px; }

    /* Status badge */
    .status-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; }
    .status-badge .dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
    .status-submitted { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
    .status-submitted .dot { background:var(--brand); }
    .status-graded    { background:var(--success-50); color:var(--success); border:1px solid var(--success-100); }
    .status-graded .dot { background:var(--success); }
    .status-returned  { background:var(--warning-50); color:var(--warning); border:1px solid var(--warning-100); }
    .status-returned .dot { background:var(--warning); }

    /* File box */
    .file-box { display:flex; align-items:center; gap:12px; background:var(--surface2); border:1px solid var(--border); border-radius:var(--radius-sm); padding:14px 16px; }
    .file-box-icon { width:38px; height:38px; border-radius:9px; background:var(--purple-50); border:1px solid var(--purple-100); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .file-box-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
    .file-box-ext  { font-size:12px; color:var(--text3); font-family:'DM Sans',sans-serif; margin-top:2px; }

    /* Grade form */
    .form-group { margin-bottom:14px; }
    .form-label { display:block; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text2); margin-bottom:6px; text-transform:uppercase; letter-spacing:.05em; }
    .form-input { width:100%; font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--text); background:var(--surface2); border:1px solid var(--border); border-radius:var(--radius-sm); padding:9px 12px; outline:none; transition:border-color .15s; box-sizing:border-box; }
    .form-input:focus { border-color:var(--brand); }
    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; }
    .badge-subject { background:#f3e8ff; color:#7c3aed; border:1px solid #e9d5ff; }
    .badge-class   { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.assignment-submissions.index') }}">Submission</a>
        <span class="sep">›</span>
        @if($submission->assignment)
            <a href="{{ route('admin.assignment-submissions.byAssignment', $submission->assignment_id) }}">
                {{ Str::limit($submission->assignment->judul, 30) }}
            </a>
            <span class="sep">›</span>
        @endif
        <span class="current">Detail Submission</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Submission</h1>
            <p class="page-sub">ID #{{ $submission->id }} · {{ $submission->student->nama_lengkap ?? '—' }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.assignment-submissions.edit', $submission->id) }}" class="btn btn-edit-sm btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            @if($submission->file_path)
                <a href="{{ route('admin.assignment-submissions.download', $submission->id) }}" class="btn btn-dl btn-sm">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Download File
                </a>
            @endif
            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6m4-6v6M9 6V4h6v2"/></svg>
                Hapus
            </button>
        </div>
    </div>

    <div class="detail-grid">

        {{-- LEFT --}}
        <div>
            {{-- Info Submission --}}
            <div class="card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p class="card-title">Informasi Submission</p>
                </div>
                <div class="card-body" style="padding:0 20px;">
                    <div class="info-row">
                        <span class="info-label">Tugas</span>
                        <span class="info-value">
                            @if($submission->assignment)
                                <a href="{{ route('admin.assignment-submissions.byAssignment', $submission->assignment_id) }}"
                                   style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--brand);text-decoration:none;">
                                    {{ $submission->assignment->judul }}
                                </a>
                            @else — @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mata Pelajaran</span>
                        <span class="info-value">
                            @if($submission->assignment?->subject)
                                <span class="badge badge-subject">{{ $submission->assignment->subject->nama_mapel }}</span>
                            @else — @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kelas</span>
                        <span class="info-value">
                            @if($submission->assignment?->class)
                                <span class="badge badge-class">{{ $submission->assignment->class->nama_kelas }}</span>
                            @else — @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Deadline</span>
                        <span class="info-value">
                            @if($submission->assignment?->deadline)
                                {{ \Carbon\Carbon::parse($submission->assignment->deadline)->translatedFormat('d M Y, H:i') }} WIB
                            @else — @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dikumpulkan</span>
                        <span class="info-value">
                            @if($submission->submitted_at)
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;">
                                    {{ \Carbon\Carbon::parse($submission->submitted_at)->translatedFormat('d M Y, H:i') }} WIB
                                </span>
                                <span style="font-size:12px;color:var(--text3);margin-left:6px;">
                                    ({{ \Carbon\Carbon::parse($submission->submitted_at)->diffForHumans() }})
                                </span>
                            @else — @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            @php
                                $sm = ['submitted'=>['class'=>'status-submitted','label'=>'Submitted'],'graded'=>['class'=>'status-graded','label'=>'Graded'],'returned'=>['class'=>'status-returned','label'=>'Returned']];
                                $si = $sm[$submission->status] ?? ['class'=>'status-submitted','label'=>ucfirst($submission->status)];
                            @endphp
                            <span class="status-badge {{ $si['class'] }}"><span class="dot"></span>{{ $si['label'] }}</span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- File --}}
            <div class="card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <p class="card-title">File Submission</p>
                </div>
                <div class="card-body">
                    @if($submission->file_path)
                        <div class="file-box">
                            <div class="file-box-icon">
                                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1">
                                <p class="file-box-name">{{ basename($submission->file_path) }}</p>
                                <p class="file-box-ext">{{ strtoupper(pathinfo($submission->file_path, PATHINFO_EXTENSION)) }} File</p>
                            </div>
                            <a href="{{ route('admin.assignment-submissions.download', $submission->id) }}" class="btn btn-dl btn-sm">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Download
                            </a>
                        </div>
                    @else
                        <p style="font-size:13px;color:var(--text3);font-style:italic;font-family:'DM Sans',sans-serif;">Tidak ada file yang dilampirkan</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div>
            {{-- Student Info --}}
            <div class="card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    <p class="card-title">Data Siswa</p>
                </div>
                <div class="student-profile">
                    <div class="student-big-avatar">
                        @if($submission->student?->foto)
                            <img src="{{ asset('storage/'.$submission->student->foto) }}" alt="">
                        @else
                            {{ strtoupper(substr($submission->student->nama_lengkap ?? '?', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <p class="student-big-name">{{ $submission->student->nama_lengkap ?? '—' }}</p>
                        <p class="student-big-meta">NISN: {{ $submission->student->nisn ?? '—' }}</p>
                        <p class="student-big-meta">NIS: {{ $submission->student->nis ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Nilai --}}
            <div class="card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <p class="card-title">Nilai</p>
                </div>
                @php
                    $n = $submission->nilai;
                    if (is_null($n))  { $nc='na'; $grade='—'; $gradeClass=''; $gradeColor=''; }
                    elseif ($n>=90)   { $nc='nilai-a'; $grade='A'; $gradeClass='nilai-a'; $gradeColor='background:var(--success-50);color:var(--success);border:1px solid var(--success-100)'; }
                    elseif ($n>=75)   { $nc='nilai-b'; $grade='B'; $gradeClass='nilai-b'; $gradeColor='background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)'; }
                    elseif ($n>=60)   { $nc='nilai-c'; $grade='C'; $gradeClass='nilai-c'; $gradeColor='background:var(--warning-50);color:var(--warning);border:1px solid var(--warning-100)'; }
                    else              { $nc='nilai-d'; $grade='D'; $gradeClass='nilai-d'; $gradeColor='background:var(--danger-50);color:var(--danger);border:1px solid var(--danger-100)'; }
                @endphp
                <div class="nilai-display">
                    <p class="nilai-big {{ $nc }}">{{ is_null($n) ? '—' : $n }}</p>
                    <p class="nilai-label">dari 100</p>
                    @if(!is_null($n))
                        <span class="nilai-grade-letter" style="{{ $gradeColor }}">Grade {{ $grade }}</span>
                    @endif
                </div>
            </div>

            {{-- Beri Nilai Form --}}
            <div class="card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    <p class="card-title">Beri / Update Nilai</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.assignment-submissions.grade', $submission->id) }}">
                        @csrf @method('PATCH')
                        <div class="form-group">
                            <label class="form-label">Nilai (0–100)</label>
                            <input type="number" name="nilai" min="0" max="100" class="form-input"
                                   value="{{ $submission->nilai }}" placeholder="Masukkan nilai…">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-input" style="appearance:none;cursor:pointer;">
                                <option value="graded"   {{ $submission->status === 'graded'   ? 'selected' : '' }}>Graded</option>
                                <option value="returned" {{ $submission->status === 'returned' ? 'selected' : '' }}>Returned</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan Nilai
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" action="{{ route('admin.assignment-submissions.destroy', $submission->id) }}" style="display:none">
    @csrf @method('DELETE')
</form>
<script>
    function confirmDelete() {
        Swal.fire({ title:'Hapus Submission?', html:'Submission dari <b>{{ $submission->student->nama_lengkap ?? "siswa ini" }}</b> akan dihapus permanen.', icon:'warning', showCancelButton:true, confirmButtonText:'Ya, Hapus', cancelButtonText:'Batal', confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b' })
        .then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
</script>
</x-app-layout>