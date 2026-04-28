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
    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:5px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .info-val.muted{font-weight:500;color:var(--text2)}

    /* Panel */
    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .panel-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .panel-body{padding:20px}

    /* Nilai besar */
    .nilai-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px}
    .nilai-box{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 16px;text-align:center;transition:box-shadow .2s}
    .nilai-box:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .nilai-box-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:8px}
    .nilai-box-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;font-weight:800;line-height:1;margin-bottom:4px}
    .nilai-box-sub{font-size:11px;color:var(--text3)}
    .val-green{color:#15803d} .val-blue{color:#1d4ed8} .val-purple{color:#7c3aed} .val-orange{color:#c2410c}

    /* Rata-rata card */
    .rata-card{background:linear-gradient(135deg,var(--brand-600) 0%,var(--brand-700) 100%);border-radius:var(--radius);padding:20px 24px;color:#fff;display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:12px}
    .rata-left-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;opacity:.8;letter-spacing:.04em;text-transform:uppercase;margin-bottom:4px}
    .rata-left-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:40px;font-weight:800;line-height:1}
    .rata-right{text-align:right}
    .rata-predikat{font-family:'Plus Jakarta Sans',sans-serif;font-size:48px;font-weight:800;line-height:1;opacity:.95}
    .rata-predikat-label{font-size:12px;opacity:.7;margin-top:3px}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-A{background:#dcfce7;color:#15803d} .badge-B{background:#dbeafe;color:#1d4ed8}
    .badge-C{background:#fefce8;color:#a16207} .badge-D{background:#fff7ed;color:#c2410c}
    .badge-E{background:#fee2e2;color:#dc2626}

    @media(max-width:768px){
        .nilai-grid{grid-template-columns:repeat(2,1fr)}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Nilai</h1>
            <p class="page-sub">Informasi lengkap data nilai siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('guru.nilai.edit', $nilai->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Nilai
            </a>
            <form action="{{ route('guru.nilai.destroy', $nilai->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Info Siswa & Mata Pelajaran --}}
    <div class="info-grid">
        <div class="info-item">
            <p class="info-label">Nama Siswa</p>
            <p class="info-val">{{ $nilai->siswa->nama_lengkap ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">NIS</p>
            <p class="info-val muted">{{ $nilai->siswa->nis ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Kelas</p>
            <p class="info-val">{{ $nilai->kelas->nama_kelas ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Mata Pelajaran</p>
            <p class="info-val">{{ $nilai->mataPelajaran->nama_mapel ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Tahun Ajaran</p>
            <p class="info-val muted">{{ $nilai->tahunAjaran->tahun ?? '—' }} / {{ $nilai->tahunAjaran->semester ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Diinput</p>
            <p class="info-val muted" style="font-size:12.5px">{{ $nilai->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
        </div>
    </div>

    {{-- Rata-rata & Predikat --}}
    <div class="rata-card">
        <div>
            <p class="rata-left-label">Nilai Rata-rata</p>
            <p class="rata-left-val">{{ number_format($nilai->nilai_akhir ?? 0, 1) }}</p>
        </div>
        <div class="rata-right">
            <p class="rata-predikat">{{ $nilai->predikat ?? '—' }}</p>
            <p class="rata-predikat-label">Predikat</p>
        </div>
    </div>

    {{-- 4 Komponen Nilai --}}
    <div class="nilai-grid">
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai Tugas</p>
            <p class="nilai-box-val val-green">{{ $nilai->nilai_tugas ?? '—' }}</p>
            <p class="nilai-box-sub">Bobot harian</p>
        </div>
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai Harian</p>
            <p class="nilai-box-val val-blue">{{ $nilai->nilai_harian ?? '—' }}</p>
            <p class="nilai-box-sub">Ulangan harian</p>
        </div>
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai UTS</p>
            <p class="nilai-box-val val-purple">{{ $nilai->nilai_uts ?? '—' }}</p>
            <p class="nilai-box-sub">Ujian tengah semester</p>
        </div>
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai UAS</p>
            <p class="nilai-box-val val-orange">{{ $nilai->nilai_uas ?? '—' }}</p>
            <p class="nilai-box-sub">Ujian akhir semester</p>
        </div>
    </div>

    {{-- Catatan --}}
    @if($nilai->catatan)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="panel-title">Catatan</span>
        </div>
        <div class="panel-body">
            <p style="font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.7;white-space:pre-wrap">{{ $nilai->catatan }}</p>
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
        title: 'Hapus Nilai?',
        html: `Data nilai <strong>{{ addslashes($nilai->siswa->nama_lengkap ?? '') }}</strong> akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>