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
    .back-link{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:color .15s;margin-bottom:8px}
    .back-link:hover{color:var(--brand-600)}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-print{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
    .btn-print:hover{background:#ffedd5;filter:none}
    .btn-approve{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-approve:hover{background:#dcfce7;filter:none}
    .btn-reject{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-reject:hover{background:#fee2e2;filter:none}
    .btn-kembali{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn-kembali:hover{background:#dbeafe;filter:none}

    .detail-layout{display:grid;grid-template-columns:1fr 340px;gap:16px;align-items:start}

    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{display:flex;align-items:center;gap:8px;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .card-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .card-body{padding:20px}

    .info-row{display:flex;gap:12px;padding:9px 0;border-bottom:1px solid #f1f5f9}
    .info-row:last-child{border-bottom:none;padding-bottom:0}
    .info-row:first-child{padding-top:0}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);width:140px;flex-shrink:0;padding-top:1px}
    .info-val{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);flex:1}
    .info-val.bold{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}

    .siswa-hero{display:flex;align-items:center;gap:14px;padding:16px 20px;background:var(--brand-50);border-bottom:1px solid var(--brand-100)}
    .siswa-avatar{width:48px;height:48px;border-radius:12px;background:var(--brand-100);display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .siswa-hero-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .siswa-hero-meta{font-size:12.5px;color:var(--text3);margin-top:2px}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-menunggu{background:#fefce8;color:#a16207} .badge-menunggu .badge-dot{background:#a16207}
    .badge-disetujui{background:#dcfce7;color:#15803d} .badge-disetujui .badge-dot{background:#15803d}
    .badge-ditolak{background:#fee2e2;color:#dc2626} .badge-ditolak .badge-dot{background:#dc2626}
    .badge-sudah_kembali{background:#eff6ff;color:#1d4ed8} .badge-sudah_kembali .badge-dot{background:#1d4ed8}

    .timeline{display:flex;flex-direction:column;gap:0}
    .tl-item{display:flex;gap:12px;position:relative}
    .tl-item:not(:last-child) .tl-line{flex:1;width:2px;background:var(--border);margin:4px auto 0;min-height:20px}
    .tl-dot-wrap{display:flex;flex-direction:column;align-items:center;width:20px;flex-shrink:0}
    .tl-dot{width:10px;height:10px;border-radius:50%;border:2px solid var(--border);background:var(--surface);flex-shrink:0;margin-top:4px}
    .tl-dot.done{background:var(--brand-600);border-color:var(--brand-600)}
    .tl-dot.green{background:#15803d;border-color:#15803d}
    .tl-dot.red{background:#dc2626;border-color:#dc2626}
    .tl-content{padding-bottom:16px;flex:1}
    .tl-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)}
    .tl-sub{font-size:12px;color:var(--text3);margin-top:2px}

    .action-panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .action-panel-header{padding:12px 16px;background:var(--surface2);border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    .action-panel-body{padding:14px 16px;display:flex;flex-direction:column;gap:8px}
    .action-btn-full{width:100%;justify-content:center}

    .mini-form{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px;margin-top:4px;display:none}
    .mini-form.open{display:block}
    .mini-form label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2);display:block;margin-bottom:5px}
    .mini-form textarea,.mini-form input[type=time]{width:100%;padding:8px 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;box-sizing:border-box;transition:border-color .15s}
    .mini-form textarea:focus,.mini-form input[type=time]:focus{border-color:var(--brand-500)}
    .mini-form textarea{resize:vertical;min-height:70px}
    .mini-form-actions{display:flex;gap:6px;margin-top:8px;justify-content:flex-end}

    @media(max-width:900px){.detail-layout{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <a href="{{ route('admin.izin-keluar-siswa.index') }}" class="back-link">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Daftar
            </a>
            <h1 class="page-title">Detail Izin Keluar Siswa</h1>
            <p class="page-sub">
                @if($izin->nomor_surat) No. Surat: <strong>{{ $izin->nomor_surat }}</strong> &mdash; @endif
                {{ \Carbon\Carbon::parse($izin->tanggal)->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
        <div class="header-actions">
            @if($izin->status === 'menunggu')
                <a href="{{ route('admin.izin-keluar-siswa.edit', $izin->id) }}" class="btn btn-edit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
            @endif
            @if(in_array($izin->status, ['disetujui', 'sudah_kembali']))
                <a href="{{ route('admin.izin-keluar-siswa.cetak-surat', $izin->id) }}" target="_blank" class="btn btn-print">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Surat
                </a>
            @endif
            <form action="{{ route('admin.izin-keluar-siswa.destroy', $izin->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-layout">

        {{-- LEFT --}}
        <div>
            <div class="card">
                <div class="siswa-hero">
                    <div class="siswa-avatar">
                        <svg width="24" height="24" fill="none" stroke="var(--brand-600)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <p class="siswa-hero-name">{{ $izin->siswa->nama_lengkap ?? '—' }}</p>
                        <p class="siswa-hero-meta">
                            {{ $izin->siswa->kelas->nama_kelas ?? '—' }}
                            @if($izin->siswa?->nis) &nbsp;·&nbsp; NIS: {{ $izin->siswa->nis }} @endif
                        </p>
                    </div>
                    <div style="margin-left:auto">
                        <span class="badge badge-{{ $izin->status }}">
                            <span class="badge-dot"></span>
                            {{ \App\Models\IzinKeluarSiswa::STATUS_LIST[$izin->status] ?? ucfirst($izin->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Tanggal</span>
                        <span class="info-val bold">{{ \Carbon\Carbon::parse($izin->tanggal)->isoFormat('D MMMM Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tahun Ajaran</span>
                        <span class="info-val">
                            {{ $izin->tahunAjaran?->label ?? '—' }}
                            @if($izin->tahunAjaran?->isAktif())
                                <span style="font-size:11px;background:#dcfce7;color:#15803d;padding:1px 7px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;margin-left:4px">Aktif</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jam Keluar</span>
                        <span class="info-val bold">{{ $izin->jam_keluar ? \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') : '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Rencana Kembali</span>
                        <span class="info-val">{{ $izin->jam_kembali ? \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') : '—' }}</span>
                    </div>
                    @if($izin->jam_kembali_aktual)
                    <div class="info-row">
                        <span class="info-label">Kembali Aktual</span>
                        <span class="info-val bold" style="color:#1d4ed8">{{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Kategori</span>
                        <span class="info-val">{{ \App\Models\IzinKeluarSiswa::KATEGORI_LIST[$izin->kategori] ?? ucfirst($izin->kategori) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tujuan</span>
                        <span class="info-val">{{ $izin->tujuan }}</span>
                    </div>
                    @if($izin->keterangan)
                    <div class="info-row">
                        <span class="info-label">Keterangan</span>
                        <span class="info-val" style="white-space:pre-line">{{ $izin->keterangan }}</span>
                    </div>
                    @endif
                    @if($izin->nomor_surat)
                    <div class="info-row">
                        <span class="info-label">No. Surat</span>
                        <span class="info-val bold">{{ $izin->nomor_surat }}</span>
                    </div>
                    @endif
                </div>
            </div>

            @if($izin->catatan_piket)
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <span class="card-header-title">Catatan Piket</span>
                </div>
                <div class="card-body">
                    <p style="font-size:13.5px;color:var(--text2);white-space:pre-line;line-height:1.6">{{ $izin->catatan_piket }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT --}}
        <div>
            {{-- Proses Izin --}}
            @if($izin->status === 'menunggu')
            <div class="action-panel">
                <div class="action-panel-header">Proses Izin</div>
                <div class="action-panel-body">

                    {{-- Setujui --}}
                    <div>
                        <button type="button" class="btn btn-approve action-btn-full" onclick="toggleMiniForm('formSetujui')">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Setujui Izin
                        </button>
                        <div class="mini-form" id="formSetujui">
                            <form action="{{ route('admin.izin-keluar-siswa.setujui', $izin->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label>Catatan Piket (opsional)</label>
                                <textarea name="catatan_piket" placeholder="Tambahkan catatan jika diperlukan…"></textarea>
                                <div class="mini-form-actions">
                                    <button type="button" onclick="toggleMiniForm('formSetujui')"
                                        style="padding:5px 12px;border-radius:6px;border:1px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;cursor:pointer;color:var(--text2)">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        style="padding:5px 14px;border-radius:6px;border:none;background:#15803d;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer">
                                        Konfirmasi Setujui
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tolak --}}
                    <div>
                        <button type="button" class="btn btn-reject action-btn-full" onclick="toggleMiniForm('formTolak')">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Tolak Izin
                        </button>
                        <div class="mini-form" id="formTolak">
                            <form action="{{ route('admin.izin-keluar-siswa.tolak', $izin->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label>Alasan Penolakan <span style="color:#dc2626">*</span></label>
                                <textarea name="catatan_piket" required placeholder="Tuliskan alasan penolakan…"></textarea>
                                <div class="mini-form-actions">
                                    <button type="button" onclick="toggleMiniForm('formTolak')"
                                        style="padding:5px 12px;border-radius:6px;border:1px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;cursor:pointer;color:var(--text2)">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        style="padding:5px 14px;border-radius:6px;border:none;background:#dc2626;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer">
                                        Konfirmasi Tolak
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            {{-- Catat Kembali --}}
            @if($izin->status === 'disetujui')
            <div class="action-panel">
                <div class="action-panel-header">Catat Kembali</div>
                <div class="action-panel-body">
                    <button type="button" class="btn btn-kembali action-btn-full" onclick="toggleMiniForm('formKembali')">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 0 0-4-4H4"/></svg>
                        Catat Siswa Kembali
                    </button>
                    <div class="mini-form" id="formKembali">
                        <form action="{{ route('admin.izin-keluar-siswa.catat-kembali', $izin->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label>Jam Kembali Aktual <span style="color:#dc2626">*</span></label>
                            <input type="time" name="jam_kembali_aktual" value="{{ now()->format('H:i') }}" required>
                            <label style="margin-top:10px">Catatan Piket (opsional)</label>
                            <textarea name="catatan_piket" placeholder="Catatan tambahan saat kembali…">{{ $izin->catatan_piket }}</textarea>
                            <div class="mini-form-actions">
                                <button type="button" onclick="toggleMiniForm('formKembali')"
                                    style="padding:5px 12px;border-radius:6px;border:1px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;cursor:pointer;color:var(--text2)">
                                    Batal
                                </button>
                                <button type="submit"
                                    style="padding:5px 14px;border-radius:6px;border:none;background:#1f63db;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- Timeline --}}
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                    <span class="card-header-title">Riwayat</span>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="tl-item">
                            <div class="tl-dot-wrap">
                                <div class="tl-dot done"></div>
                                <div class="tl-line"></div>
                            </div>
                            <div class="tl-content">
                                <p class="tl-title">Izin Dibuat</p>
                                <p class="tl-sub">{{ $izin->created_at->isoFormat('D MMM Y, HH:mm') }}</p>
                            </div>
                        </div>

                        @if(in_array($izin->status, ['disetujui', 'ditolak', 'sudah_kembali']))
                        <div class="tl-item">
                            <div class="tl-dot-wrap">
                                <div class="tl-dot {{ $izin->status === 'ditolak' ? 'red' : 'green' }}"></div>
                                @if($izin->status === 'sudah_kembali')<div class="tl-line"></div>@endif
                            </div>
                            <div class="tl-content">
                                <p class="tl-title">{{ $izin->status === 'ditolak' ? 'Izin Ditolak' : 'Izin Disetujui' }}</p>
                                <p class="tl-sub">
                                    {{ $izin->diproses_pada ? $izin->diproses_pada->isoFormat('D MMM Y, HH:mm') : '—' }}
                                    @if($izin->diprosesOleh) · oleh {{ $izin->diprosesOleh->name }} @endif
                                </p>
                            </div>
                        </div>
                        @else
                        <div class="tl-item">
                            <div class="tl-dot-wrap">
                                <div class="tl-dot"></div>
                            </div>
                            <div class="tl-content">
                                <p class="tl-title" style="color:var(--text3)">Menunggu Proses</p>
                                <p class="tl-sub">Belum disetujui atau ditolak</p>
                            </div>
                        </div>
                        @endif

                        @if($izin->status === 'sudah_kembali')
                        <div class="tl-item">
                            <div class="tl-dot-wrap">
                                <div class="tl-dot done"></div>
                            </div>
                            <div class="tl-content">
                                <p class="tl-title">Siswa Telah Kembali</p>
                                <p class="tl-sub">
                                    {{ $izin->dicatat_kembali_pada ? $izin->dicatat_kembali_pada->isoFormat('D MMM Y, HH:mm') : '—' }}
                                    @if($izin->dicatatKembaliOleh) · oleh {{ $izin->dicatatKembaliOleh->name }} @endif
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function toggleMiniForm(id) {
    document.querySelectorAll('.mini-form.open').forEach(f => { if (f.id !== id) f.classList.remove('open'); });
    document.getElementById(id).classList.toggle('open');
}

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Izin?',
        html: `Data izin keluar <strong>{{ addslashes($izin->siswa->nama_lengkap ?? '') }}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>