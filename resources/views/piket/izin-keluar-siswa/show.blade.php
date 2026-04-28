<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap');

    :root {
        --brand-800:#0f3d8c;
        --brand-700:#1750c0;
        --brand-600:#1f63db;
        --brand-500:#3582f0;
        --brand-200:#bfdbfe;
        --brand-100:#dbeafe;
        --brand-50:#eff6ff;
        --surface:#fff;
        --surface2:#f8fafc;
        --surface3:#f1f5f9;
        --border:#e2e8f0;
        --border2:#cbd5e1;
        --text:#0f172a;
        --text2:#334155;
        --text3:#64748b;
        --text4:#94a3b8;
        --r:10px;--r-sm:7px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 12px rgba(0,0,0,.07),0 2px 4px rgba(0,0,0,.04);
    }
    *, *::before, *::after { box-sizing: border-box; }

    .pg { padding: 28px 32px 48px; max-width: 2000px; }

    .back { display: inline-flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text4); text-decoration: none; margin-bottom: 22px; transition: color .15s; }
    .back:hover { color: var(--brand-600); }

    .det-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
    .det-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 21px; font-weight: 800; color: var(--text); letter-spacing: -.3px; }
    .det-meta { display: flex; align-items: center; gap: 8px; margin-top: 6px; flex-wrap: wrap; }
    .hdr-actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-approve { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
    .btn-approve:hover { background: #dcfce7; filter: none; }
    .btn-tolak { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
    .btn-tolak:hover { background: #fee2e2; filter: none; }
    .btn-konfirmasi { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .btn-konfirmasi:hover { background: #f3e8ff; filter: none; }
    .btn-edit { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-cetak { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-cetak:hover { background: #fef9c3; filter: none; }
    .btn-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
    .btn-danger:hover { background: #fee2e2; filter: none; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; letter-spacing: .02em; }
    .bdot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .b-menunggu      { background: #fefce8; color: #92400e; border: 1px solid #fde68a; } .b-menunggu .bdot      { background: #d97706; }
    .b-disetujui     { background: #dcfce7; color: #14532d; border: 1px solid #86efac; } .b-disetujui .bdot     { background: #16a34a; }
    .b-ditolak       { background: #fee2e2; color: #7f1d1d; border: 1px solid #fca5a5; } .b-ditolak .bdot       { background: #dc2626; }
    .b-sudah_kembali { background: #dbeafe; color: #1e3a8a; border: 1px solid #93c5fd; } .b-sudah_kembali .bdot { background: #2563eb; }

    .nsurat-box { background: var(--brand-50); border: 1px solid var(--brand-100); border-radius: var(--r-sm); padding: 10px 16px; display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
    .nsurat-num { font-family: 'JetBrains Mono', monospace; font-size: 16px; font-weight: 600; color: var(--brand-700); letter-spacing: .04em; }
    .nsurat-lbl { font-size: 11.5px; color: var(--brand-600); font-family: 'Plus Jakarta Sans', sans-serif; margin-top: 1px; }

    .igrid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .icard { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; box-shadow: var(--shadow-sm); }
    .icard.full { grid-column: span 2; }
    .icard-head { padding: 12px 18px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; gap: 8px; }
    .icard-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .icard-body { padding: 16px 18px; }

    .dl { display: grid; grid-template-columns: 150px 1fr; row-gap: 10px; column-gap: 14px; }
    .dl dt { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text4); padding-top: 1px; }
    .dl dd { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; color: var(--text); margin: 0; }
    .dl dd .mono { font-family: 'JetBrains Mono', monospace; font-size: 13px; }

    .tl { display: flex; flex-direction: column; gap: 0; }
    .tl-item { display: flex; gap: 14px; position: relative; }
    .tl-item:not(:last-child)::before { content: ''; position: absolute; left: 15px; top: 32px; width: 2px; height: calc(100% - 10px); background: var(--border); }
    .tl-dot { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; z-index: 1; }
    .tl-dot.gray    { background: var(--surface3); border: 2px solid var(--border2); }
    .tl-dot.green   { background: #f0fdf4; border: 2px solid #86efac; }
    .tl-dot.red     { background: #fef2f2; border: 2px solid #fca5a5; }
    .tl-dot.blue    { background: #eff6ff; border: 2px solid #93c5fd; }
    .tl-dot.amber   { background: #fefce8; border: 2px solid #fde68a; }
    .tl-body { padding-bottom: 16px; flex: 1; }
    .tl-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.3; }
    .tl-label .by { font-weight: 500; color: var(--text4); }
    .tl-time { font-size: 12px; color: var(--text4); margin-top: 2px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .tl-note { font-size: 12.5px; color: var(--text2); margin-top: 6px; background: var(--surface2); border-radius: 6px; padding: 7px 11px; border-left: 2px solid var(--border2); font-family: 'Plus Jakarta Sans', sans-serif; }

    @media(max-width:768px) {
        .pg { padding: 16px; }
        .igrid { grid-template-columns: 1fr; }
        .icard.full { grid-column: span 1; }
        .dl { grid-template-columns: 120px 1fr; }
        .hdr-actions { width: 100%; }
    }
</style>

<div class="pg">
    <a href="{{ route('piket.izin-keluar-siswa.index') }}" class="back">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Daftar
    </a>

    {{-- ── Header ── --}}
    <div class="det-header">
        <div>
            <h1 class="det-title">Detail Izin Keluar Siswa</h1>
            <div class="det-meta">
                <span class="badge b-{{ $izin->status }}">
                    <span class="bdot"></span>{{ $izin->status_label }}
                </span>
                @if($izin->nomor_surat)
                    <span style="font-family:'JetBrains Mono',monospace;font-size:11.5px;font-weight:500;color:var(--text4)">
                        {{ $izin->nomor_surat }}
                    </span>
                @endif
            </div>
        </div>
        <div class="hdr-actions">
            @if($izin->isMenunggu())
                <button type="button" class="btn btn-approve" onclick="doApprove()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Setujui
                </button>
                <button type="button" class="btn btn-tolak" onclick="doTolak()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Tolak
                </button>
                <a href="{{ route('piket.izin-keluar-siswa.edit', $izin) }}" class="btn btn-edit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <button type="button" class="btn btn-danger" onclick="doDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            @elseif($izin->isDisetujui())
                <button type="button" class="btn btn-konfirmasi" onclick="doKembali()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    Konfirmasi Kembali
                </button>
                <a href="{{ route('piket.izin-keluar-siswa.cetak-surat', $izin) }}" target="_blank" class="btn btn-cetak">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Surat
                </a>
            @elseif($izin->isSudahKembali())
                <a href="{{ route('piket.izin-keluar-siswa.cetak-surat', $izin) }}" target="_blank" class="btn btn-cetak">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Surat
                </a>
            @endif
        </div>
    </div>

    {{-- ── Nomor surat box ── --}}
    @if($izin->nomor_surat)
    <div class="nsurat-box">
        <svg width="20" height="20" fill="none" stroke="var(--brand-600)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <div>
            <p class="nsurat-num">{{ $izin->nomor_surat }}</p>
            <p class="nsurat-lbl">Nomor Surat Izin</p>
        </div>
    </div>
    @endif

    <div class="igrid">

        {{-- ── Data Siswa ── --}}
        <div class="icard">
            <div class="icard-head">
                <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="icard-title">Data Siswa</span>
            </div>
            <div class="icard-body">
                <dl class="dl">
                    <dt>Nama Lengkap</dt>
                    <dd><strong>{{ $izin->siswa->nama_lengkap ?? '—' }}</strong></dd>
                    <dt>Kelas</dt>
                    <dd>{{ $izin->siswa->kelas->nama_kelas ?? '—' }}</dd>
                    <dt>Tahun Ajaran</dt>
                    <dd>
                        @if($izin->tahunAjaran)
                            {{ $izin->tahunAjaran->tahun }} / {{ ucfirst($izin->tahunAjaran->semester) }}
                        @else
                            —
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        {{-- ── Detail Izin ── --}}
        <div class="icard">
            <div class="icard-head">
                <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span class="icard-title">Detail Izin</span>
            </div>
            <div class="icard-body">
                <dl class="dl">
                    <dt>Tanggal</dt>
                    <dd><strong>{{ $izin->tanggal->translatedFormat('d F Y') }}</strong></dd>
                    <dt>Kategori</dt>
                    <dd>{{ $izin->kategori_label }}</dd>
                    <dt>Tujuan</dt>
                    <dd>{{ $izin->tujuan }}</dd>
                    <dt>Jam Keluar</dt>
                    <dd><span class="mono">{{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }}</span> WIB</dd>
                    <dt>Jam Kembali</dt>
                    <dd>
                        @if($izin->jam_kembali_aktual)
                            <span class="mono" style="color:#16a34a;font-weight:700">{{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }}</span>
                            WIB
                            <span style="font-size:12px;color:var(--text4);margin-left:4px">(aktual · {{ $izin->durasi_formatted }})</span>
                        @elseif($izin->jam_kembali)
                            <span class="mono">{{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }}</span> WIB
                            <span style="font-size:12px;color:var(--text4);margin-left:4px">(estimasi)</span>
                        @else
                            <span style="color:var(--text4)">—</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        {{-- ── Keterangan ── --}}
        @if($izin->keterangan || $izin->catatan_piket)
        <div class="icard full">
            <div class="icard-head">
                <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                <span class="icard-title">Keterangan &amp; Catatan</span>
            </div>
            <div class="icard-body">
                <dl class="dl">
                    @if($izin->keterangan)
                    <dt>Keterangan</dt>
                    <dd>{{ $izin->keterangan }}</dd>
                    @endif
                    @if($izin->catatan_piket)
                    <dt>Catatan Piket</dt>
                    <dd>{{ $izin->catatan_piket }}</dd>
                    @endif
                </dl>
            </div>
        </div>
        @endif

        {{-- ── Riwayat Proses (Timeline) ── --}}
        <div class="icard full">
            <div class="icard-head">
                <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="icard-title">Riwayat Proses</span>
            </div>
            <div class="icard-body">
                <div class="tl">

                    {{-- 1. Dibuat --}}
                    <div class="tl-item">
                        <div class="tl-dot gray">
                            <svg width="12" height="12" fill="none" stroke="#64748b" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </div>
                        <div class="tl-body">
                            <p class="tl-label">Izin Dibuat</p>
                            <p class="tl-time">{{ $izin->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    {{-- 2. Menunggu --}}
                    @if($izin->isMenunggu())
                    <div class="tl-item">
                        <div class="tl-dot amber">
                            <svg width="12" height="12" fill="none" stroke="#d97706" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="tl-body">
                            <p class="tl-label" style="color:#d97706">Menunggu Persetujuan Piket</p>
                            <p class="tl-time">Belum diproses</p>
                        </div>
                    </div>
                    @endif

                    {{-- 3. Disetujui / Ditolak --}}
                    @if($izin->diproses_pada)
                    <div class="tl-item">
                        <div class="tl-dot {{ $izin->isDitolak() ? 'red' : 'green' }}">
                            @if($izin->isDitolak())
                                <svg width="12" height="12" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            @else
                                <svg width="12" height="12" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            @endif
                        </div>
                        <div class="tl-body">
                            <p class="tl-label">
                                {{ $izin->isDitolak() ? 'Izin Ditolak' : 'Izin Disetujui' }}
                                @if($izin->diprosesOleh)
                                    <span class="by">oleh {{ $izin->diprosesOleh->name }}</span>
                                @endif
                            </p>
                            <p class="tl-time">{{ $izin->diproses_pada->format('d M Y, H:i') }} WIB</p>
                            @if($izin->catatan_piket && ($izin->isDitolak() || $izin->isDisetujui()))
                                <p class="tl-note">{{ $izin->catatan_piket }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- 4. Sudah kembali --}}
                    @if($izin->isSudahKembali() && $izin->dicatat_kembali_pada)
                    <div class="tl-item">
                        <div class="tl-dot blue">
                            <svg width="12" height="12" fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </div>
                        <div class="tl-body">
                            <p class="tl-label">
                                Siswa Sudah Kembali
                                @if($izin->dicatatKembaliOleh)
                                    <span class="by">dicatat oleh {{ $izin->dicatatKembaliOleh->name }}</span>
                                @endif
                            </p>
                            <p class="tl-time">
                                {{ $izin->dicatat_kembali_pada->format('d M Y, H:i') }} WIB
                                @if($izin->jam_kembali_aktual)
                                    · Jam aktual: <strong>{{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }}</strong>
                                @endif
                                @if($izin->durasi_formatted && $izin->durasi_formatted !== '-')
                                    · Durasi: <strong>{{ $izin->durasi_formatted }}</strong>
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

    </div>{{-- /igrid --}}
</div>

{{-- ── Hidden Forms ── --}}
<form id="fApprove" action="{{ route('piket.izin-keluar-siswa.approve', $izin) }}" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="catatan_piket" id="catatanApprove">
</form>
<form id="fTolak" action="{{ route('piket.izin-keluar-siswa.tolak', $izin) }}" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="catatan_piket" id="catatanTolak">
</form>
<form id="fKembali" action="{{ route('piket.izin-keluar-siswa.konfirmasi-kembali', $izin) }}" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="jam_kembali_aktual" id="jamKembaliInput">
    <input type="hidden" name="catatan_piket"      id="catatanKembali">
</form>
<form id="fDelete" action="{{ route('piket.izin-keluar-siswa.destroy', $izin) }}" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function doApprove() {
    Swal.fire({
        title: 'Setujui Izin?',
        html: `Izin keluar <strong>{{ addslashes($izin->siswa->nama_lengkap ?? '') }}</strong> akan disetujui dan nomor surat digenerate.`,
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
        document.getElementById('catatanApprove').value = r.value || '';
        document.getElementById('fApprove').submit();
    });
}

function doTolak() {
    Swal.fire({
        title: 'Tolak Izin?',
        icon: 'warning',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (wajib diisi)',
        inputPlaceholder: 'Tulis alasan penolakan…',
        inputAttributes: { rows: 2, maxlength: 500 },
        inputValidator: v => !v?.trim() ? 'Alasan penolakan wajib diisi.' : null,
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
    }).then(r => {
        if (!r.isConfirmed) return;
        document.getElementById('catatanTolak').value = r.value;
        document.getElementById('fTolak').submit();
    });
}

function doKembali() {
    const now = new Date();
    const hh = String(now.getHours()).padStart(2,'0');
    const mm = String(now.getMinutes()).padStart(2,'0');
    Swal.fire({
        title: 'Konfirmasi Kembali',
        html: `
            <div style="text-align:left;margin-bottom:10px">
                <label style="font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:4px">Jam Kembali Aktual <span style="color:#dc2626">*</span></label>
                <input type="time" id="swalJam" value="${hh}:${mm}"
                    style="width:100%;height:38px;padding:0 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:14px">
            </div>
            <div style="text-align:left">
                <label style="font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:4px">Catatan (opsional)</label>
                <textarea id="swalCatatan" rows="2" maxlength="500" placeholder="Tulis catatan jika perlu…"
                    style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;resize:none"></textarea>
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
        document.getElementById('jamKembaliInput').value = r.value.jam;
        document.getElementById('catatanKembali').value  = r.value.catatan;
        document.getElementById('fKembali').submit();
    });
}

function doDelete() {
    Swal.fire({
        title: 'Hapus Data Izin?',
        text: 'Data izin keluar ini akan dihapus permanen dan tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then(r => {
        if (r.isConfirmed) document.getElementById('fDelete').submit();
    });
}
</script>
</x-app-layout>