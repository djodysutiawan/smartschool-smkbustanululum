<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{
        --brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:6px 14px;font-size:12.5px}
    .btn-outline{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-outline:hover{background:var(--surface3);filter:none}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-lanjut{background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn-disabled{background:var(--surface3);color:var(--text3);cursor:not-allowed;pointer-events:none}
    .ujian-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:16px}
    .ujian-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s,transform .15s;display:flex;flex-direction:column}
    .ujian-card:hover{box-shadow:0 4px 20px rgba(31,99,219,.1);transform:translateY(-2px)}
    .ujian-card-top{padding:18px 20px 14px;flex:1}
    .ujian-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--brand);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px;display:flex;align-items:center;gap:6px}
    .ujian-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);margin-bottom:10px;line-height:1.35}
    .ujian-meta{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px}
    .meta-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;background:var(--surface2);border:1px solid var(--border);border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text2)}
    .ujian-info-row{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-top:1px solid var(--border);font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .ujian-guru{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text2)}
    .ujian-card-footer{padding:14px 20px;background:var(--surface2);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:10px}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-aktif{background:#dcfce7;color:#15803d}.b-aktif .badge-dot{background:#15803d}
    .b-berlangsung{background:#dbeafe;color:#1d4ed8}.b-berlangsung .badge-dot{background:#1d4ed8}
    .b-selesai{background:var(--surface3);color:var(--text3)}.b-selesai .badge-dot{background:var(--text3)}
    .jenis-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .j-ulangan_harian{background:#fef9c3;color:#a16207}
    .j-uts{background:var(--brand-50);color:var(--brand-700)}
    .j-uas{background:#f0fdf4;color:#15803d}
    .j-kuis,.j-quiz{background:#fdf4ff;color:#7c3aed}
    .j-remedial{background:#fff7ed;color:#ea580c}
    .empty-state{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:80px 20px;text-align:center}
    .empty-icon{width:64px;height:64px;background:var(--brand-50);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--text);margin-bottom:6px}
    .empty-sub{font-size:13px;color:var(--text3);max-width:320px;margin:0 auto;font-family:'DM Sans',sans-serif}
    .pag-wrap{display:flex;align-items:center;justify-content:center;margin-top:24px;gap:4px}
    .pag-btn{height:34px;min-width:34px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand);border-color:var(--brand);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}
    @media(max-width:640px){.page{padding:16px}.ujian-grid{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Ujian Tersedia</h1>
            <p class="page-sub">Daftar ujian yang dapat Anda kerjakan</p>
        </div>
        <a href="{{ route('siswa.ujian.riwayat') }}" class="btn btn-outline btn-sm">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Riwayat Ujian
        </a>
    </div>

    @if($ujian->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="28" height="28" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        </div>
        <p class="empty-title">Tidak ada ujian tersedia</p>
        <p class="empty-sub">Saat ini tidak ada ujian aktif untuk kelas Anda. Cek kembali nanti.</p>
    </div>
    @else
    <div class="ujian-grid">
        @foreach($ujian as $u)
        @php
            $jenisLabel    = ['ulangan_harian'=>'Ulangan Harian','uts'=>'UTS','uas'=>'UAS','kuis'=>'Kuis','quiz'=>'Quiz','remedial'=>'Remedial'][$u->jenis] ?? ucfirst($u->jenis);
            $sudahBerakhir = $u->sudahBerakhir();
            $jumlahSoal   = $u->soal()->count();
        @endphp
        <div class="ujian-card">
            <div class="ujian-card-top">
                <div class="ujian-mapel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    {{ $u->mataPelajaran->nama_mapel ?? '—' }}
                </div>
                <h3 class="ujian-judul">{{ $u->judul }}</h3>
                <div class="ujian-meta">
                    <span class="jenis-pill j-{{ $u->jenis }}">{{ $jenisLabel }}</span>
                    @if($u->durasi_menit)
                    <span class="meta-chip">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $u->durasi_menit }} menit
                    </span>
                    @endif
                    <span class="meta-chip">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
                        KKM {{ $u->nilai_kkm ?? 0 }}
                    </span>
                    <span class="meta-chip">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        {{ $jumlahSoal }} soal
                    </span>
                </div>
                <div class="ujian-info-row">
                    <span>Guru: <span class="ujian-guru">{{ $u->guru->nama_lengkap ?? '—' }}</span></span>
                    @if($u->tanggal)
                    <span>{{ \Carbon\Carbon::parse($u->tanggal)->translatedFormat('d M Y') }}</span>
                    @endif
                </div>
            </div>
            <div class="ujian-card-footer">
                <div>
                    @if($u->sesi_aktif)
                        <span class="badge b-berlangsung"><span class="badge-dot"></span>Berlangsung</span>
                    @elseif(! $u->boleh_ikut)
                        <span class="badge b-selesai"><span class="badge-dot"></span>Selesai ({{ $u->percobaan_ke }}x)</span>
                    @elseif($sudahBerakhir)
                        <span style="font-size:12px;color:#dc2626;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">Waktu habis</span>
                    @else
                        <span class="badge b-aktif"><span class="badge-dot"></span>Tersedia</span>
                    @endif
                </div>
                <div>
                    @if($u->sesi_aktif)
                        <a href="{{ route('siswa.ujian.kerjakan', $u->id) }}" class="btn btn-lanjut btn-sm">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            Lanjutkan
                        </a>
                    @elseif($u->boleh_ikut && ! $sudahBerakhir)
                        <a href="{{ route('siswa.ujian.mulai', $u->id) }}" class="btn btn-primary btn-sm">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            Mulai Ujian
                        </a>
                    @elseif(! $u->boleh_ikut)
                        <a href="{{ route('siswa.ujian.hasil', $u->id) }}" class="btn btn-outline btn-sm">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Lihat Hasil
                        </a>
                    @else
                        <span class="btn btn-disabled btn-sm">Tidak Tersedia</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($ujian->hasPages())
    <div class="pag-wrap">
        @if($ujian->onFirstPage())
            <span class="pag-btn disabled">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </span>
        @else
            <a href="{{ $ujian->previousPageUrl() }}" class="pag-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
        @endif
        @foreach($ujian->getUrlRange(1, $ujian->lastPage()) as $page => $url)
            @if($page == $ujian->currentPage())
                <span class="pag-btn active">{{ $page }}</span>
            @elseif($page == 1 || $page == $ujian->lastPage() || abs($page - $ujian->currentPage()) <= 1)
                <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
            @elseif(abs($page - $ujian->currentPage()) == 2)
                <span class="pag-ellipsis">…</span>
            @endif
        @endforeach
        @if($ujian->hasMorePages())
            <a href="{{ $ujian->nextPageUrl() }}" class="pag-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        @else
            <span class="pag-btn disabled">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </span>
        @endif
    </div>
    @endif
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
        Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
    @if(session('info'))
        Swal.fire({icon:'info',title:'Info',text:@json(session('info')),confirmButtonColor:'#1f63db'});
    @endif
    @if(session('warning'))
        Swal.fire({icon:'warning',title:'Perhatian',text:@json(session('warning')),confirmButtonColor:'#1f63db'});
    @endif
</script>
</x-app-layout>