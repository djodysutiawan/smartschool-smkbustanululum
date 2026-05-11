<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap');

    :root {
        --brand-800:#0f3d8c;--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-200:#bfdbfe;--brand-100:#dbeafe;--brand-50:#eff6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--surface4:#e9eef5;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --r:10px;--r-sm:7px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 12px rgba(0,0,0,.07),0 2px 4px rgba(0,0,0,.04);
    }
    *, *::before, *::after { box-sizing: border-box; }

    .pg { padding: 28px 32px 48px; max-width: 900px; }

    .back { display: inline-flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text4); text-decoration: none; margin-bottom: 22px; transition: color .15s; }
    .back:hover { color: var(--brand-600); }

    .pg-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .pg-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 21px; font-weight: 800; color: var(--text); letter-spacing: -.3px; line-height: 1.2; }
    .pg-sub { font-size: 13px; color: var(--text4); margin-top: 4px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .hdr-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

    /* Banner belum check-in */
    .banner-warn {
        display: flex; align-items: flex-start; gap: 10px;
        background: #fffbeb; border: 1px solid #fde68a; border-radius: var(--r-sm);
        padding: 11px 16px; margin-bottom: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: #92400e;
    }
    .banner-warn a { color: var(--brand-600); text-decoration: underline; }

    /* ── Info card ── */
    .info-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; margin-bottom: 16px; box-shadow: var(--shadow-sm); }
    .info-head { padding: 13px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .info-head-left { display: flex; align-items: center; gap: 9px; }
    .info-head-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text2); }
    .info-body { padding: 20px; }

    /* ── Detail grid ── */
    .dg { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 24px; }
    .dg.cols3 { grid-template-columns: 1fr 1fr 1fr; }
    .di { display: flex; flex-direction: column; gap: 3px; }
    .di.span2 { grid-column: span 2; }
    .di.span3 { grid-column: span 3; }
    .di-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700; color: var(--text4); text-transform: uppercase; letter-spacing: .05em; }
    .di-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 600; color: var(--text); }
    .di-val.mono { font-family: 'JetBrains Mono', monospace; font-size: 13px; }
    .di-val.muted { color: var(--text4); font-weight: 500; font-size: 13px; }

    /* ── Status badge ── */
    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; letter-spacing: .02em; }
    .bdot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .b-menunggu      { background: #fefce8; color: #92400e; border: 1px solid #fde68a; } .b-menunggu .bdot      { background: #d97706; }
    .b-disetujui     { background: #dcfce7; color: #14532d; border: 1px solid #86efac; } .b-disetujui .bdot     { background: #16a34a; }
    .b-ditolak       { background: #fee2e2; color: #7f1d1d; border: 1px solid #fca5a5; } .b-ditolak .bdot       { background: #dc2626; }
    .b-sudah_kembali { background: #dbeafe; color: #1e3a8a; border: 1px solid #93c5fd; } .b-sudah_kembali .bdot { background: #2563eb; }

    /* Nomor surat */
    .nsurat { font-family: 'JetBrains Mono', monospace; font-size: 13px; font-weight: 600; color: var(--text2); background: var(--surface3); padding: 4px 12px; border-radius: 6px; letter-spacing: .03em; display: inline-block; }

    /* Divider */
    .divider { height: 1px; background: var(--border); margin: 16px 0; }

    /* ── Buttons ── */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn-primary  { background: var(--brand-600); color: #fff; box-shadow: 0 1px 4px rgba(31,99,219,.22); }
    .btn-primary:hover { background: var(--brand-700); filter: none; }
    .btn-secondary { background: var(--surface); color: var(--text3); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-approve  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-approve:hover { background: #dcfce7; filter: none; }
    .btn-tolak    { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-tolak:hover { background: #fee2e2; filter: none; }
    .btn-konfirmasi { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .btn-konfirmasi:hover { background: #f3e8ff; filter: none; }
    .btn-cetak    { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
    .btn-cetak:hover { background: #e0f2fe; filter: none; }
    .btn-danger   { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-danger:hover { background: #fee2e2; filter: none; }
    .btn-disabled { opacity: .45; cursor: not-allowed; pointer-events: none; }

    /* ── Action panel ── */
    .action-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); padding: 16px 20px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; box-shadow: var(--shadow-sm); margin-bottom: 16px; }
    .action-panel-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text4); text-transform: uppercase; letter-spacing: .06em; margin-right: 4px; }
    .action-sep { flex: 1; }

    @media(max-width: 640px) {
        .pg { padding: 16px; }
        .dg, .dg.cols3 { grid-template-columns: 1fr; }
        .di.span2, .di.span3 { grid-column: span 1; }
        .hdr-actions { width: 100%; }
    }
</style>

<div class="pg">
    <a href="{{ route('piket.izin-keluar-siswa.index') }}" class="back">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Daftar
    </a>

    {{-- Banner belum check-in --}}
    @if(! $guruAktifId)
    <div class="banner-warn">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>Anda belum check-in sebagai petugas piket. Aksi setujui, tolak, dan konfirmasi kembali memerlukan check-in.
        <a href="{{ route('piket.log.checkin') }}">Check-in sekarang →</a></span>
    </div>
    @endif

    {{-- ── Header ── --}}
    <div class="pg-header">
        <div>
            <h1 class="pg-title">Detail Izin Keluar Siswa</h1>
            <p class="pg-sub">
                Dibuat {{ $izin->created_at->diffForHumans() }}
                &mdash;
                <span class="badge b-{{ $izin->status }}" style="font-size:11px;padding:2px 9px">
                    <span class="bdot"></span>{{ $izin->status_label }}
                </span>
            </p>
        </div>
        <div class="hdr-actions">
            {{-- Cetak surat hanya jika disetujui / sudah kembali --}}
            @if(in_array($izin->status, [\App\Models\IzinKeluarSiswa::STATUS_DISETUJUI, \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI]))
                <a href="{{ route('piket.izin-keluar-siswa.cetak-surat', $izin) }}" target="_blank" class="btn btn-cetak">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Surat
                </a>
            @endif

            @if($izin->isMenunggu())
                <a href="{{ route('piket.izin-keluar-siswa.edit', $izin) }}" class="btn btn-secondary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
            @endif
        </div>
    </div>

    {{-- ── Panel Aksi ── --}}
    @if($izin->isMenunggu() || $izin->isDisetujui())
    <div class="action-panel">
        <span class="action-panel-title">Aksi</span>

        @if($izin->isMenunggu())
            <button type="button"
                class="btn btn-approve {{ $guruAktifId ? '' : 'btn-disabled' }}"
                @if($guruAktifId)
                    onclick="doApprove({{ $izin->id }}, '{{ addslashes($izin->siswa->nama_lengkap ?? '') }}')"
                @else
                    title="Check-in terlebih dahulu"
                @endif>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Setujui Izin
            </button>
            <button type="button"
                class="btn btn-tolak {{ $guruAktifId ? '' : 'btn-disabled' }}"
                @if($guruAktifId)
                    onclick="doTolak({{ $izin->id }}, '{{ addslashes($izin->siswa->nama_lengkap ?? '') }}')"
                @else
                    title="Check-in terlebih dahulu"
                @endif>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Tolak Izin
            </button>
        @endif

        @if($izin->isDisetujui())
            <button type="button"
                class="btn btn-konfirmasi {{ $guruAktifId ? '' : 'btn-disabled' }}"
                @if($guruAktifId)
                    onclick="doKembali({{ $izin->id }}, '{{ addslashes($izin->siswa->nama_lengkap ?? '') }}')"
                @else
                    title="Check-in terlebih dahulu"
                @endif>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Konfirmasi Kembali
            </button>
        @endif

        <div class="action-sep"></div>

        {{-- Hapus hanya untuk status menunggu / ditolak --}}
        @if(! $izin->isDisetujui())
            <button type="button" class="btn btn-danger" onclick="doHapus({{ $izin->id }})">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                Hapus
            </button>
        @endif
    </div>
    @endif

    {{-- ── Data Siswa ── --}}
    <div class="info-card">
        <div class="info-head">
            <div class="info-head-left">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="info-head-title">Data Siswa</span>
            </div>
        </div>
        <div class="info-body">
            <div class="dg cols3">
                <div class="di">
                    <p class="di-label">Nama Siswa</p>
                    <p class="di-val">{{ $izin->siswa->nama_lengkap ?? '—' }}</p>
                </div>
                <div class="di">
                    <p class="di-label">Kelas</p>
                    <p class="di-val">{{ optional($izin->siswa->kelas)->nama_kelas ?? '—' }}</p>
                </div>
                <div class="di">
                    <p class="di-label">NIS</p>
                    <p class="di-val mono">{{ $izin->siswa->nis ?? '—' }}</p>
                </div>
                <div class="di">
                    <p class="di-label">Tahun Ajaran</p>
                    <p class="di-val">{{ optional($izin->tahunAjaran)->tahun ?? '—' }} / {{ optional($izin->tahunAjaran)->semester ? ucfirst($izin->tahunAjaran->semester) : '—' }}</p>
                </div>
                <div class="di">
                    <p class="di-label">Tanggal Izin</p>
                    <p class="di-val">{{ $izin->tanggal->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Detail Izin ── --}}
    <div class="info-card">
        <div class="info-head">
            <div class="info-head-left">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="info-head-title">Detail Izin</span>
            </div>
            <span class="badge b-{{ $izin->status }}">
                <span class="bdot"></span>{{ $izin->status_label }}
            </span>
        </div>
        <div class="info-body">
            <div class="dg">
                <div class="di span2">
                    <p class="di-label">Tujuan / Keperluan</p>
                    <p class="di-val">{{ $izin->tujuan }}</p>
                </div>
                <div class="di">
                    <p class="di-label">Kategori</p>
                    <p class="di-val">{{ $izin->kategori_label }}</p>
                </div>
                <div class="di">
                    <p class="di-label">Nomor Surat</p>
                    @if($izin->nomor_surat)
                        <p class="di-val"><span class="nsurat">{{ $izin->nomor_surat }}</span></p>
                    @else
                        <p class="di-val muted">— belum digenerate —</p>
                    @endif
                </div>
            </div>

            <div class="divider"></div>

            {{-- Jam --}}
            <div class="dg cols3">
                <div class="di">
                    <p class="di-label">Jam Keluar</p>
                    <p class="di-val mono">{{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }}</p>
                </div>
                <div class="di">
                    <p class="di-label">Jam Kembali (Estimasi)</p>
                    @if($izin->jam_kembali)
                        <p class="di-val mono" style="color:var(--text3)">~{{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }}</p>
                    @else
                        <p class="di-val muted">—</p>
                    @endif
                </div>
                <div class="di">
                    <p class="di-label">Jam Kembali Aktual</p>
                    @if($izin->jam_kembali_aktual)
                        <p class="di-val mono" style="color:#16a34a">{{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }}</p>
                        <p style="font-size:11.5px;color:var(--text4);margin-top:2px">Durasi: {{ $izin->durasi_formatted }}</p>
                    @else
                        <p class="di-val muted">—</p>
                    @endif
                </div>
            </div>

            @if($izin->keterangan)
            <div class="divider"></div>
            <div class="di">
                <p class="di-label">Keterangan</p>
                <p class="di-val" style="font-weight:500;line-height:1.6">{{ $izin->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- ── Riwayat Proses ── --}}
    <div class="info-card">
        <div class="info-head">
            <div class="info-head-left">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="info-head-title">Riwayat Proses</span>
            </div>
        </div>
        <div class="info-body">
            <div class="dg">
                <div class="di">
                    <p class="di-label">Dibuat Pada</p>
                    <p class="di-val" style="font-size:13px">{{ $izin->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="di">
                    <p class="di-label">Diproses Oleh</p>
                    @if($izin->diprosesOleh)
                        <p class="di-val" style="font-size:13px">{{ $izin->diprosesOleh->name }}</p>
                        <p style="font-size:11.5px;color:var(--text4);margin-top:2px">{{ $izin->diproses_pada?->format('d M Y H:i') }}</p>
                    @else
                        <p class="di-val muted">— belum diproses —</p>
                    @endif
                </div>

                @if($izin->catatan_piket)
                <div class="di span2">
                    <p class="di-label">Catatan Piket</p>
                    <p class="di-val" style="font-weight:500;line-height:1.6;font-size:13px">{{ $izin->catatan_piket }}</p>
                </div>
                @endif

                @if($izin->dicatatKembaliOleh)
                <div class="di">
                    <p class="di-label">Dicatat Kembali Oleh</p>
                    <p class="di-val" style="font-size:13px">{{ $izin->dicatatKembaliOleh->name }}</p>
                    <p style="font-size:11.5px;color:var(--text4);margin-top:2px">{{ $izin->dicatat_kembali_pada?->format('d M Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Hidden forms ── --}}
<form id="formApprove" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="catatan_piket" id="catatanApprove">
</form>
<form id="formTolak" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="catatan_piket" id="catatanTolak">
</form>
<form id="formKembali" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="jam_kembali_aktual" id="jamKembaliInput">
    <input type="hidden" name="catatan_piket"      id="catatanKembali">
</form>
<form id="formHapus" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const BASE_URL = '{{ rtrim(url('/'), '/') }}';

/* ── Flash ── */
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function escHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function doApprove(id, nama) {
    Swal.fire({
        title: 'Setujui Izin?',
        html: `Izin keluar <strong>${escHtml(nama)}</strong> akan disetujui dan nomor surat akan dibuat.`,
        icon: 'question',
        input: 'textarea',
        inputLabel: 'Catatan Piket (opsional)',
        inputPlaceholder: 'Tulis catatan jika perlu…',
        inputAttributes: { rows: 2, maxlength: 500 },
        showCancelButton: true,
        confirmButtonColor: '#15803d',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal',
    }).then(r => {
        if (!r.isConfirmed) return;
        const form = document.getElementById('formApprove');
        form.action = `${BASE_URL}/piket/izin-keluar-siswa/${id}/approve`;
        document.getElementById('catatanApprove').value = r.value || '';
        form.submit();
    });
}

function doTolak(id, nama) {
    Swal.fire({
        title: 'Tolak Izin?',
        html: `Izin keluar <strong>${escHtml(nama)}</strong> akan ditolak.`,
        icon: 'warning',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (wajib diisi)',
        inputPlaceholder: 'Tulis alasan penolakan…',
        inputAttributes: { rows: 2, maxlength: 500 },
        inputValidator: v => (!v || !v.trim()) ? 'Alasan penolakan wajib diisi.' : null,
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
    }).then(r => {
        if (!r.isConfirmed) return;
        const form = document.getElementById('formTolak');
        form.action = `${BASE_URL}/piket/izin-keluar-siswa/${id}/tolak`;
        document.getElementById('catatanTolak').value = r.value;
        form.submit();
    });
}

function doKembali(id, nama) {
    const now = new Date();
    const hh = String(now.getHours()).padStart(2,'0');
    const mm = String(now.getMinutes()).padStart(2,'0');

    Swal.fire({
        title: 'Konfirmasi Kembali',
        html: `
            <p style="font-size:13.5px;color:#475569;margin-bottom:14px">
                Catat bahwa <strong>${escHtml(nama)}</strong> telah kembali ke sekolah.
            </p>
            <div style="text-align:left;margin-bottom:10px">
                <label style="font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:4px">
                    Jam Kembali Aktual <span style="color:#dc2626">*</span>
                </label>
                <input type="time" id="swalJam" value="${hh}:${mm}"
                    style="width:100%;height:38px;padding:0 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:14px;font-family:inherit">
            </div>
            <div style="text-align:left">
                <label style="font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:4px">Catatan (opsional)</label>
                <textarea id="swalCatatan" rows="2" maxlength="500" placeholder="Tulis catatan jika perlu…"
                    style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;resize:none;font-family:inherit"></textarea>
            </div>`,
        showCancelButton: true,
        confirmButtonColor: '#7c3aed',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Konfirmasi Kembali',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const jam = document.getElementById('swalJam').value;
            if (!jam) { Swal.showValidationMessage('Jam kembali wajib diisi.'); return false; }
            return { jam, catatan: document.getElementById('swalCatatan').value };
        }
    }).then(r => {
        if (!r.isConfirmed) return;
        const form = document.getElementById('formKembali');
        form.action = `${BASE_URL}/piket/izin-keluar-siswa/${id}/konfirmasi-kembali`;
        document.getElementById('jamKembaliInput').value = r.value.jam;
        document.getElementById('catatanKembali').value  = r.value.catatan;
        form.submit();
    });
}

function doHapus(id) {
    Swal.fire({
        title: 'Hapus Izin?',
        text: 'Data izin akan dihapus secara permanen dan tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then(r => {
        if (!r.isConfirmed) return;
        const form = document.getElementById('formHapus');
        form.action = `${BASE_URL}/piket/izin-keluar-siswa/${id}`;
        form.submit();
    });
}
</script>
</x-app-layout>