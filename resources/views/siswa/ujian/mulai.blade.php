<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .ujian-hero{background:linear-gradient(135deg,var(--brand) 0%,#3b82f6 100%);border-radius:var(--radius);padding:28px 32px;color:#fff;margin-bottom:20px}
    .ujian-hero-mapel{font-size:12px;font-weight:700;opacity:.8;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;font-family:'Plus Jakarta Sans',sans-serif;display:flex;align-items:center;gap:5px}
    .ujian-hero-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;margin-bottom:8px;line-height:1.3}
    .ujian-hero-guru{font-size:13px;opacity:.85;font-family:'DM Sans',sans-serif}
    .jenis-pill-hero{display:inline-block;padding:3px 12px;border-radius:99px;background:rgba(255,255,255,.2);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;margin-top:12px}
    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px}
    .info-box{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px}
    .info-box-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .ib-blue{background:var(--brand-50)}.ib-green{background:#f0fdf4}.ib-purple{background:#faf5ff}.ib-yellow{background:#fef9c3}.ib-orange{background:#fff7ed}
    .info-box-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);text-transform:uppercase;letter-spacing:.03em}
    .info-box-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text);margin-top:2px;line-height:1}
    .info-box-unit{font-size:11.5px;font-weight:600;color:var(--text3);margin-left:3px}
    /* Banner percobaan */
    .attempt-banner{border-radius:var(--radius);padding:14px 20px;margin-bottom:16px;display:flex;align-items:center;gap:12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .attempt-banner.fresh{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
    .attempt-banner.retry{background:#fff3cd;border:1px solid #fde68a;color:#a16207}
    .attempt-banner.last{background:#fee2e2;border:1px solid #fecaca;color:#dc2626}
    .time-banner{background:#fff3cd;border:1px solid #fde68a;border-radius:var(--radius);padding:12px 18px;margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:#a16207;font-weight:600;display:flex;align-items:center;gap:8px}
    .rules-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px}
    .rules-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .rules-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .rules-body{padding:6px 20px}
    .rule-item{display:flex;align-items:flex-start;gap:10px;padding:10px 0;border-bottom:1px solid var(--border)}
    .rule-item:last-child{border-bottom:none}
    .rule-icon{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
    .ri-ok{background:#dcfce7}.ri-warn{background:#fff3cd}
    .rule-text{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.5}
    .action-area{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 24px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-lanjut{background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn:disabled{opacity:.6;cursor:not-allowed;filter:none}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:600px){.info-grid{grid-template-columns:1fr}.page{padding:16px}.action-area{flex-direction:column;align-items:stretch}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('siswa.ujian.index') }}">Ujian</a>
        <span class="sep">›</span>
        <span class="current">{{ $sesiAktif ? 'Lanjutkan Ujian' : 'Mulai Ujian' }}</span>
    </nav>

    <div class="ujian-hero">
        <p class="ujian-hero-mapel">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="opacity:.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            {{ $ujian->mataPelajaran->nama_mapel ?? '—' }}
        </p>
        <h1 class="ujian-hero-judul">{{ $ujian->judul }}</h1>
        <p class="ujian-hero-guru">Guru: {{ $ujian->guru->nama_lengkap ?? '—' }}</p>
        @php
            $jenisLabel = ['ulangan_harian'=>'Ulangan Harian','uts'=>'UTS','uas'=>'UAS','kuis'=>'Kuis','quiz'=>'Quiz','remedial'=>'Remedial'][$ujian->jenis] ?? ucfirst($ujian->jenis);
        @endphp
        <span class="jenis-pill-hero">{{ $jenisLabel }}</span>
    </div>

    {{-- ── Banner info percobaan ── --}}
    @php
        $maksPercobaan  = $ujian->maks_percobaan ?? 1;
        $sisaPercobaan  = $maksPercobaan - $percobaanKe;
        $isPercobaan1   = $percobaanKe === 0;
        $isLastAttempt  = $sisaPercobaan === 1 && !$sesiAktif;
        $bannerClass    = $isPercobaan1 ? 'fresh' : ($isLastAttempt ? 'last' : 'retry');
    @endphp

    @if(!$sesiAktif)
    <div class="attempt-banner {{ $bannerClass }}">
        @if($isPercobaan1)
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Ini adalah percobaan pertama Anda. Semangat!
        @elseif($isLastAttempt)
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Percobaan ke-{{ $percobaanKe + 1 }} dari {{ $maksPercobaan }} — ini percobaan terakhir Anda!
            @if($nilaiTertinggi !== null)
                &nbsp;Nilai terbaik saat ini: <strong>{{ number_format($nilaiTertinggi, 1) }}</strong>
            @endif
        @else
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3"/></svg>
            Percobaan ke-{{ $percobaanKe + 1 }} dari {{ $maksPercobaan }}.
            @if($nilaiTertinggi !== null)
                &nbsp;Nilai terbaik saat ini: <strong>{{ number_format($nilaiTertinggi, 1) }}</strong>
            @endif
        @endif
    </div>
    @endif

    <div class="info-grid">
        <div class="info-box">
            <div class="info-box-icon ib-blue">
                <svg width="20" height="20" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </div>
            <div>
                <p class="info-box-label">Total Soal</p>
                <p class="info-box-val">{{ $totalSoal }}<span class="info-box-unit">soal</span></p>
            </div>
        </div>
        <div class="info-box">
            <div class="info-box-icon ib-yellow">
                <svg width="20" height="20" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="info-box-label">Durasi</p>
                <p class="info-box-val">
                    @if($ujian->durasi_menit)
                        {{ $ujian->durasi_menit }}<span class="info-box-unit">menit</span>
                    @else
                        <span style="font-size:14px">Tidak terbatas</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="info-box">
            <div class="info-box-icon ib-green">
                <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
            </div>
            <div>
                <p class="info-box-label">KKM</p>
                <p class="info-box-val">{{ $ujian->nilai_kkm ?? 0 }}</p>
            </div>
        </div>
        <div class="info-box">
            <div class="info-box-icon ib-purple">
                <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="info-box-label">Maks. Percobaan</p>
                <p class="info-box-val">{{ $percobaanKe }}<span class="info-box-unit">/ {{ $maksPercobaan }}x</span></p>
            </div>
        </div>
    </div>

    @if($ujian->waktu_mulai)
    <div class="time-banner">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Waktu ujian: {{ $ujian->waktu_mulai->translatedFormat('d M Y, H:i') }}
        @if($ujian->waktu_berakhir) – {{ $ujian->waktu_berakhir->format('H:i') }} WIB @endif
    </div>
    @elseif($ujian->tanggal)
    <div class="time-banner">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Tanggal ujian: {{ \Carbon\Carbon::parse($ujian->tanggal)->translatedFormat('d M Y') }}
        @if($ujian->jam_mulai) pukul {{ \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i') }} WIB @endif
    </div>
    @endif

    <div class="rules-card">
        <div class="rules-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="rules-title">Ketentuan Ujian</span>
        </div>
        <div class="rules-body">
            <div class="rule-item">
                <div class="rule-icon ri-ok"><svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                <p class="rule-text">Pastikan koneksi internet Anda stabil sebelum memulai ujian.</p>
            </div>
            <div class="rule-item">
                <div class="rule-icon ri-ok"><svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                <p class="rule-text">Jawaban disimpan <strong>otomatis</strong> setiap soal dijawab. Jangan tutup tab browser saat ujian berlangsung.</p>
            </div>
            @if($ujian->durasi_menit)
            <div class="rule-item">
                <div class="rule-icon ri-warn"><svg width="12" height="12" fill="none" stroke="#a16207" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                <p class="rule-text">Ujian akan <strong>otomatis dikumpulkan</strong> ketika waktu {{ $ujian->durasi_menit }} menit habis.</p>
            </div>
            @endif
            @if($maksPercobaan > 1)
            <div class="rule-item">
                <div class="rule-icon ri-ok"><svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                <p class="rule-text">Ujian ini dapat dikerjakan maksimal <strong>{{ $maksPercobaan }} kali</strong>. Nilai yang diambil adalah <strong>nilai tertinggi</strong> dari semua percobaan.</p>
            </div>
            @endif
            @if($ujian->acak_soal)
            <div class="rule-item">
                <div class="rule-icon ri-ok"><svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                <p class="rule-text">Urutan soal <strong>diacak</strong> untuk setiap percobaan.</p>
            </div>
            @endif
            @if($ujian->keterangan)
            <div class="rule-item">
                <div class="rule-icon ri-ok"><svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                <p class="rule-text">{{ $ujian->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="action-area">
        <a href="{{ route('siswa.ujian.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>

        @if($sesiAktif)
            {{-- Lanjutkan sesi yang sedang berjalan --}}
            <a href="{{ route('siswa.ujian.kerjakan', $ujian->id) }}" class="btn btn-lanjut">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                Lanjutkan Ujian
                @if($sisaDetik)
                    <span style="background:rgba(29,78,216,.15);border-radius:4px;padding:1px 6px;font-size:11.5px">{{ gmdate('i:s', $sisaDetik) }}</span>
                @endif
            </a>
        @else
            {{-- POST ke siswa.ujian.START (bukan mulai) — buat sesi baru --}}
            <form action="{{ route('siswa.ujian.start', $ujian->id) }}" method="POST" id="mulaiForm">
                @csrf
                <button type="button" class="btn btn-primary" id="btnMulai" onclick="konfirmasiMulai()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    {{ $percobaanKe > 0 ? 'Coba Lagi' : 'Mulai Ujian Sekarang' }}
                </button>
            </form>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiMulai() {
        const isCoba = {{ $percobaanKe > 0 ? 'true' : 'false' }};
        const nilaiTerbaik = {{ $nilaiTertinggi !== null ? $nilaiTertinggi : 'null' }};
        let extraHtml = '';
        if (isCoba && nilaiTerbaik !== null) {
            extraHtml = `<br><span style="color:#475569">Nilai terbaik Anda saat ini: <strong>${nilaiTerbaik.toFixed(1)}</strong>. Nilai yang digunakan adalah yang tertinggi.</span>`;
        }
        Swal.fire({
            title: isCoba ? 'Coba Lagi?' : 'Mulai Ujian?',
            html: `<p style="font-size:14px;color:#475569;font-family:'DM Sans',sans-serif">
                Anda akan memulai ujian <strong>{{ addslashes($ujian->judul) }}</strong>.<br>
                @if($ujian->durasi_menit)⏱ Waktu ujian <strong>{{ $ujian->durasi_menit }} menit</strong>.<br>@endif
                ${extraHtml}
                Pastikan koneksi internet stabil dan Anda siap mengerjakan.</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1f63db',
            cancelButtonColor: '#64748b',
            confirmButtonText: isCoba ? 'Ya, Coba Lagi!' : 'Ya, Mulai!',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (result.isConfirmed) {
                const btn = document.getElementById('btnMulai');
                btn.disabled = true;
                btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Memulai…`;
                document.getElementById('mulaiForm').submit();
            }
        });
    }
</script>
<style>@keyframes spin{to{transform:rotate(360deg)}}</style>
</x-app-layout>