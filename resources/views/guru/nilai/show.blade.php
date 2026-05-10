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

    /* Nilai komponen boxes */
    .nilai-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px}
    .nilai-box{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 16px;text-align:center;transition:box-shadow .2s}
    .nilai-box:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .nilai-box-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px}
    .nilai-box-bobot{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:600;color:var(--text3);margin-bottom:8px}
    .nilai-box-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;font-weight:800;line-height:1;margin-bottom:4px}
    .nilai-box-sub{font-size:11px;color:var(--text3)}
    .val-green{color:#15803d} .val-blue{color:#1d4ed8} .val-purple{color:#7c3aed} .val-orange{color:#c2410c}

    /* Rata-rata gradient card */
    .rata-card{background:linear-gradient(135deg,var(--brand-600) 0%,var(--brand-700) 100%);border-radius:var(--radius);padding:20px 24px;color:#fff;display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:12px}
    .rata-left-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;opacity:.8;letter-spacing:.04em;text-transform:uppercase;margin-bottom:4px}
    .rata-left-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:40px;font-weight:800;line-height:1}
    .rata-left-note{font-size:11px;opacity:.6;margin-top:4px}
    .rata-right{text-align:right}
    .rata-predikat{font-family:'Plus Jakarta Sans',sans-serif;font-size:48px;font-weight:800;line-height:1;opacity:.95}
    .rata-predikat-label{font-size:12px;opacity:.7;margin-top:3px}

    /* Status lulus/belum */
    .status-lulus{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .status-lulus.lulus{background:rgba(255,255,255,.2);color:#fff}
    .status-lulus.belum{background:rgba(255,255,255,.15);color:rgba(255,255,255,.8)}

    @media(max-width:768px){.nilai-grid{grid-template-columns:repeat(2,1fr)}.page{padding:16px}.header-actions{width:100%}}
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
            {{-- data-nama agar aman dari XSS --}}
            <form action="{{ route('guru.nilai.destroy', $nilai->id) }}" method="POST"
                  id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                        data-nama="{{ $nilai->siswa->nama_lengkap ?? '' }}"
                        onclick="confirmDelete(this)">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Info identitas siswa --}}
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
            <p class="info-val muted">{{ $nilai->tahunAjaran->tahun ?? '—' }} – {{ ucfirst($nilai->tahunAjaran->semester ?? '—') }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Diinput</p>
            <p class="info-val muted" style="font-size:12.5px">
                {{ $nilai->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
            </p>
        </div>
        @if($nilai->updated_at && $nilai->updated_at->ne($nilai->created_at))
        <div class="info-item">
            <p class="info-label">Terakhir Diubah</p>
            <p class="info-val muted" style="font-size:12.5px">
                {{ $nilai->updated_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
            </p>
        </div>
        @endif
    </div>

    {{-- Nilai akhir & predikat --}}
    <div class="rata-card">
        <div>
            <p class="rata-left-label">Nilai Akhir</p>
            @if(!is_null($nilai->nilai_akhir))
                <p class="rata-left-val">{{ number_format($nilai->nilai_akhir, 1) }}</p>
                <p class="rata-left-note">
                    <span class="status-lulus {{ $nilai->isLulus(70) ? 'lulus' : 'belum' }}">
                        {{ $nilai->isLulus(70) ? '✓ Lulus (KKM 70)' : '✗ Belum Lulus (KKM 70)' }}
                    </span>
                </p>
            @else
                <p class="rata-left-val">—</p>
                <p class="rata-left-note" style="opacity:.6">Belum ada komponen nilai yang diisi</p>
            @endif
        </div>
        <div class="rata-right">
            <p class="rata-predikat">{{ $nilai->predikat ?? '—' }}</p>
            <p class="rata-predikat-label">Predikat</p>
        </div>
    </div>

    {{-- 4 Komponen nilai --}}
    <div class="nilai-grid">
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai Tugas</p>
            <p class="nilai-box-bobot">Bobot 20%</p>
            <p class="nilai-box-val val-green">{{ !is_null($nilai->nilai_tugas) ? number_format($nilai->nilai_tugas, 1) : '—' }}</p>
            <p class="nilai-box-sub">Tugas harian</p>
        </div>
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai Harian</p>
            <p class="nilai-box-bobot">Bobot 30%</p>
            <p class="nilai-box-val val-blue">{{ !is_null($nilai->nilai_harian) ? number_format($nilai->nilai_harian, 1) : '—' }}</p>
            <p class="nilai-box-sub">Ulangan harian</p>
        </div>
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai UTS</p>
            <p class="nilai-box-bobot">Bobot 20%</p>
            <p class="nilai-box-val val-purple">{{ !is_null($nilai->nilai_uts) ? number_format($nilai->nilai_uts, 1) : '—' }}</p>
            <p class="nilai-box-sub">Ujian tengah semester</p>
        </div>
        <div class="nilai-box">
            <p class="nilai-box-label">Nilai UAS</p>
            <p class="nilai-box-bobot">Bobot 30%</p>
            <p class="nilai-box-val val-orange">{{ !is_null($nilai->nilai_uas) ? number_format($nilai->nilai_uas, 1) : '—' }}</p>
            <p class="nilai-box-sub">Ujian akhir semester</p>
        </div>
    </div>

    {{-- Catatan (hanya tampil jika ada) --}}
    @if($nilai->catatan)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="panel-title">Catatan Guru</span>
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
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: @json(session('success')),
    timer: 2800, showConfirmButton: false,
    toast: true, position: 'top-end'
});
@endif
@if(session('error'))
Swal.fire({
    icon: 'error', title: 'Gagal!',
    text: @json(session('error')),
    confirmButtonColor: '#1f63db'
});
@endif

// Gunakan data-attribute agar aman dari XSS
function confirmDelete(btn) {
    var nama = btn.getAttribute('data-nama');
    Swal.fire({
        title: 'Hapus Nilai?',
        html: 'Data nilai <strong>' + Swal.escapeHtml(nama) + '</strong> akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(function(r) {
        if (r.isConfirmed) document.getElementById('delForm').submit();
    });
}
</script>
</x-app-layout>