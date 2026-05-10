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
    .btn-nilai{background:var(--brand-600);color:#fff}
    .btn-edit-nilai{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit-nilai:hover{background:var(--brand-100);filter:none}
    .btn-kembalikan{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
    .btn-kembalikan:hover{background:#ffedd5;filter:none}

    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:5px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .info-val.muted{font-weight:500;color:var(--text2)}

    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .panel-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .panel-body{padding:20px}

    .nilai-card{border-radius:var(--radius);padding:20px 24px;display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:12px}
    .nilai-card.dinilai{background:linear-gradient(135deg,#1f63db 0%,#1750c0 100%);color:#fff}
    .nilai-card.dikumpulkan{background:linear-gradient(135deg,#1d4ed8 0%,#1e40af 100%);color:#fff}
    .nilai-card.terlambat{background:linear-gradient(135deg,#c2410c 0%,#9a3412 100%);color:#fff}
    .nilai-card.belum_dikumpulkan{background:linear-gradient(135deg,#64748b 0%,#475569 100%);color:#fff}
    .nilai-left-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;opacity:.8;letter-spacing:.04em;text-transform:uppercase;margin-bottom:4px}
    .nilai-left-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:40px;font-weight:800;line-height:1}
    .nilai-left-note{font-size:11px;opacity:.65;margin-top:4px}
    .nilai-right{text-align:right}
    .status-big{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800}
    .status-label{font-size:12px;opacity:.7;margin-top:3px}

    .attach-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;display:flex;align-items:center;gap:12px}
    .attach-icon{width:38px;height:38px;background:#fff;border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .attach-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .attach-sub{font-size:11.5px;color:var(--text3);margin-top:2px}
    .attach-link{margin-left:auto;display:inline-flex;align-items:center;gap:5px;padding:6px 14px;background:var(--brand-600);color:#fff;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-decoration:none;white-space:nowrap}
    .attach-link:hover{background:var(--brand-700)}
    .jawaban-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.7;white-space:pre-wrap;max-height:300px;overflow-y:auto}
    .umpan-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius-sm);padding:16px;font-family:'DM Sans',sans-serif;font-size:14px;color:#166534;line-height:1.7;white-space:pre-wrap}

    @media(max-width:768px){.page{padding:16px}.header-actions{width:100%}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengumpulan</h1>
            <p class="page-sub">Informasi lengkap pengumpulan tugas siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.pengumpulan-tugas.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            @if(in_array($pengumpulan->status, ['dikumpulkan', 'terlambat', 'dinilai']))
                <a href="{{ route('guru.pengumpulan-tugas.form-nilai', $pengumpulan->id) }}"
                   class="btn {{ $pengumpulan->status === 'dinilai' ? 'btn-edit-nilai' : 'btn-nilai' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    {{ $pengumpulan->status === 'dinilai' ? 'Edit Nilai' : 'Beri Nilai' }}
                </a>
            @endif
            @if($pengumpulan->status === 'dinilai')
                <form action="{{ route('guru.pengumpulan-tugas.kembalikan', $pengumpulan->id) }}" method="POST"
                      id="formKembalikan" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="button" class="btn btn-kembalikan" onclick="confirmKembalikan()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                        Reset Nilai
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Status & Nilai Card --}}
    @php
        $statusLabel = [
            'belum_dikumpulkan' => 'Belum Dikumpulkan',
            'dikumpulkan'       => 'Dikumpulkan',
            'terlambat'         => 'Terlambat',
            'dinilai'           => 'Sudah Dinilai',
        ][$pengumpulan->status] ?? $pengumpulan->status;
    @endphp
    <div class="nilai-card {{ $pengumpulan->status }}">
        <div>
            <p class="nilai-left-label">Nilai</p>
            @if(! is_null($pengumpulan->nilai))
                <p class="nilai-left-val">{{ number_format($pengumpulan->nilai, 1) }}</p>
                <p class="nilai-left-note">
                    Dinilai: {{ $pengumpulan->dinilai_pada
                        ? \Carbon\Carbon::parse($pengumpulan->dinilai_pada)->locale('id')->isoFormat('D MMMM Y, HH:mm')
                        : '—' }}
                </p>
            @else
                <p class="nilai-left-val">—</p>
                <p class="nilai-left-note">Belum dinilai</p>
            @endif
        </div>
        <div class="nilai-right">
            <p class="status-big">{{ $statusLabel }}</p>
            <p class="status-label">Status Pengumpulan</p>
        </div>
    </div>

    {{-- Info identitas --}}
    <div class="info-grid">
        <div class="info-item">
            <p class="info-label">Nama Siswa</p>
            <p class="info-val">{{ $pengumpulan->siswa->nama_lengkap ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">NIS</p>
            <p class="info-val muted">{{ $pengumpulan->siswa->nis ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Judul Tugas</p>
            <p class="info-val">{{ $pengumpulan->tugas->judul ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Batas Waktu</p>
            <p class="info-val muted" style="font-size:12.5px">
                {{ $pengumpulan->tugas?->batas_waktu
                    ? \Carbon\Carbon::parse($pengumpulan->tugas->batas_waktu)->locale('id')->isoFormat('D MMMM Y, HH:mm')
                    : 'Tanpa batas waktu' }}
            </p>
        </div>
        <div class="info-item">
            <p class="info-label">Dikumpulkan Pada</p>
            <p class="info-val muted" style="font-size:12.5px">
                {{ $pengumpulan->dikumpulkan_pada
                    ? \Carbon\Carbon::parse($pengumpulan->dikumpulkan_pada)->locale('id')->isoFormat('D MMMM Y, HH:mm')
                    : '—' }}
            </p>
        </div>
        @if($pengumpulan->dinilai_pada)
        <div class="info-item">
            <p class="info-label">Dinilai Pada</p>
            <p class="info-val muted" style="font-size:12.5px">
                {{ \Carbon\Carbon::parse($pengumpulan->dinilai_pada)->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
            </p>
        </div>
        @endif
    </div>

    {{-- File Lampiran --}}
    @if($pengumpulan->path_file)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
            <span class="panel-title">File Lampiran</span>
        </div>
        <div class="panel-body">
            <div class="attach-box">
                <div class="attach-icon">
                    <svg width="18" height="18" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                    <p class="attach-name">{{ basename($pengumpulan->path_file) }}</p>
                    <p class="attach-sub">File yang diunggah siswa</p>
                </div>
                <a href="{{ asset('storage/' . $pengumpulan->path_file) }}" target="_blank" class="attach-link">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Unduh / Buka
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- URL Link --}}
    @if($pengumpulan->url_link)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            <span class="panel-title">Link / URL</span>
        </div>
        <div class="panel-body">
            <div class="attach-box">
                <div class="attach-icon">
                    <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div style="overflow:hidden;flex:1;min-width:0">
                    <p class="attach-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $pengumpulan->url_link }}</p>
                    <p class="attach-sub">Link yang dikirim siswa</p>
                </div>
                <a href="{{ $pengumpulan->url_link }}" target="_blank" rel="noopener noreferrer" class="attach-link">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Buka Link
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- Jawaban Teks --}}
    @if($pengumpulan->jawaban_teks)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
            <span class="panel-title">Jawaban Teks</span>
        </div>
        <div class="panel-body">
            <div class="jawaban-box">{{ $pengumpulan->jawaban_teks }}</div>
        </div>
    </div>
    @endif

    {{-- Umpan Balik --}}
    @if($pengumpulan->umpan_balik)
    <div class="panel">
        <div class="panel-header">
            <svg width="14" height="14" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span class="panel-title" style="color:#15803d">Umpan Balik Guru</span>
        </div>
        <div class="panel-body">
            <div class="umpan-box">{{ $pengumpulan->umpan_balik }}</div>
        </div>
    </div>
    @endif

    {{-- Belum ada konten --}}
    @if(! $pengumpulan->path_file && ! $pengumpulan->url_link && ! $pengumpulan->jawaban_teks && $pengumpulan->status === 'belum_dikumpulkan')
    <div style="text-align:center;padding:40px 20px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)">
        <svg width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);margin-bottom:4px">Belum Ada Pengumpulan</p>
        <p style="font-size:13px;color:var(--text3)">Siswa belum mengumpulkan tugas ini.</p>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text: @json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text: @json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function confirmKembalikan() {
    Swal.fire({
        title: 'Reset Nilai?',
        html: 'Nilai dan umpan balik akan dihapus. Status akan dikembalikan ke <strong>Dikumpulkan</strong> atau <strong>Terlambat</strong>.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c2410c',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal',
    }).then(function(r) {
        if (r.isConfirmed) document.getElementById('formKembalikan').submit();
    });
}
</script>
</x-app-layout>