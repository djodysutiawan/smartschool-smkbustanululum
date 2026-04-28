<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}

    /* Info grid */
    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:5px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .info-val.muted{font-weight:500;color:var(--text2)}

    /* Panel */
    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .panel-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .panel-body{padding:20px}
    .panel-text{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.75;white-space:pre-wrap}

    /* Kehadiran boxes */
    .kehadiran-row{display:flex;gap:12px;flex-wrap:wrap}
    .kehadiran-box{flex:1;min-width:140px;border-radius:var(--radius-sm);padding:16px 18px;text-align:center}
    .kehadiran-box.hadir{background:#f0fdf4;border:1px solid #bbf7d0}
    .kehadiran-box.tidak{background:#fff0f0;border:1px solid #fecaca}
    .kehadiran-box .kh-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;margin-bottom:6px}
    .kehadiran-box.hadir .kh-label{color:#15803d}
    .kehadiran-box.tidak .kh-label{color:#dc2626}
    .kehadiran-box .kh-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;font-weight:800;line-height:1}
    .kehadiran-box.hadir .kh-val{color:#15803d}
    .kehadiran-box.tidak .kh-val{color:#dc2626}
    .kehadiran-box .kh-sub{font-size:12px;margin-top:3px}
    .kehadiran-box.hadir .kh-sub{color:#166534}
    .kehadiran-box.tidak .kh-sub{color:#991b1b}

    /* Badge verifikasi */
    .badge-verif{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700}
    .badge-verif.verified{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .badge-verif.pending{background:#fefce8;color:#a16207;border:1px solid #fde68a}

    /* Alert locked */
    .alert-locked{display:flex;align-items:center;gap:10px;padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af}

    @media(max-width:640px){.page{padding:16px}.header-actions{width:100%}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Jurnal Mengajar</h1>
            <p class="page-sub">Informasi lengkap jurnal pertemuan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.jurnal-mengajar.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            @if(!$jurnal->diverifikasi_pada)
            <a href="{{ route('guru.jurnal-mengajar.edit', $jurnal->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Jurnal
            </a>
            <form action="{{ route('guru.jurnal-mengajar.destroy', $jurnal->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Locked notice --}}
    @if($jurnal->diverifikasi_pada)
    <div class="alert-locked">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        Jurnal ini telah diverifikasi dan tidak dapat diubah atau dihapus.
    </div>
    @endif

    {{-- Info utama --}}
    <div class="info-grid">
        <div class="info-item">
            <p class="info-label">Tanggal</p>
            <p class="info-val">{{ \Carbon\Carbon::parse($jurnal->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Kelas</p>
            <p class="info-val">{{ $jurnal->kelas->nama_kelas ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Mata Pelajaran</p>
            <p class="info-val">{{ $jurnal->mataPelajaran->nama_mata_pelajaran ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Pertemuan Ke</p>
            <p class="info-val">{{ $jurnal->pertemuan_ke ? 'Ke-'.$jurnal->pertemuan_ke : '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Metode Pembelajaran</p>
            <p class="info-val muted">{{ $jurnal->metode_pembelajaran ? ucfirst($jurnal->metode_pembelajaran) : '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Status Verifikasi</p>
            @if($jurnal->diverifikasi_pada)
                <span class="badge-verif verified">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Terverifikasi
                </span>
            @else
                <span class="badge-verif pending">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Menunggu Verifikasi
                </span>
            @endif
        </div>
        @if($jurnal->diverifikasi_pada)
        <div class="info-item">
            <p class="info-label">Diverifikasi Oleh</p>
            <p class="info-val muted">{{ $jurnal->diverifikasiOleh->name ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Waktu Verifikasi</p>
            <p class="info-val muted" style="font-size:12.5px">{{ $jurnal->diverifikasi_pada->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
        </div>
        @endif
    </div>

    {{-- Kehadiran --}}
    @if($jurnal->jumlah_hadir !== null || $jurnal->jumlah_tidak_hadir !== null)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span class="panel-title">Kehadiran Siswa</span>
        </div>
        <div class="panel-body">
            <div class="kehadiran-row">
                @if($jurnal->jumlah_hadir !== null)
                <div class="kehadiran-box hadir">
                    <p class="kh-label">Hadir</p>
                    <p class="kh-val">{{ $jurnal->jumlah_hadir }}</p>
                    <p class="kh-sub">siswa</p>
                </div>
                @endif
                @if($jurnal->jumlah_tidak_hadir !== null)
                <div class="kehadiran-box tidak">
                    <p class="kh-label">Tidak Hadir</p>
                    <p class="kh-val">{{ $jurnal->jumlah_tidak_hadir }}</p>
                    <p class="kh-sub">siswa</p>
                </div>
                @endif
                @if($jurnal->jumlah_hadir !== null && $jurnal->jumlah_tidak_hadir !== null)
                <div class="kehadiran-box" style="background:var(--surface2);border:1px solid var(--border)">
                    <p class="kh-label" style="color:var(--text3)">Total</p>
                    <p class="kh-val" style="color:var(--text)">{{ $jurnal->jumlah_hadir + $jurnal->jumlah_tidak_hadir }}</p>
                    <p class="kh-sub" style="color:var(--text3)">siswa</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Materi Ajar --}}
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            <span class="panel-title">Materi Ajar</span>
        </div>
        <div class="panel-body">
            <p class="panel-text">{{ $jurnal->materi_ajar }}</p>
        </div>
    </div>

    {{-- Catatan Kelas --}}
    @if($jurnal->catatan_kelas)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="panel-title">Catatan Kelas</span>
        </div>
        <div class="panel-body">
            <p class="panel-text">{{ $jurnal->catatan_kelas }}</p>
        </div>
    </div>
    @endif

    {{-- Jadwal Terkait --}}
    @if($jurnal->jadwalPelajaran)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span class="panel-title">Jadwal Pelajaran Terkait</span>
        </div>
        <div class="panel-body" style="display:flex;gap:20px;flex-wrap:wrap">
            <div>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:3px">Hari</p>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)">{{ ucfirst($jurnal->jadwalPelajaran->hari) }}</p>
            </div>
            <div>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:3px">Jam</p>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)">
                    {{ \Carbon\Carbon::parse($jurnal->jadwalPelajaran->jam_mulai)->format('H:i') }} –
                    {{ \Carbon\Carbon::parse($jurnal->jadwalPelajaran->jam_selesai)->format('H:i') }}
                </p>
            </div>
        </div>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Jurnal?',
        html: `Jurnal mengajar ini akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>