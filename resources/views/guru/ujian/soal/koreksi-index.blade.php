<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --green:#15803d;--red:#dc2626;--purple:#7c3aed;--yellow:#a16207;
    --radius:10px;--radius-sm:7px;
}
*{box-sizing:border-box}
.page{padding:28px 28px 48px;max-width:1100px;margin:0 auto}

/* Breadcrumb */
.breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;flex-wrap:wrap}
.breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}
.breadcrumb a:hover{color:var(--text)}
.breadcrumb .sep{color:var(--border2)}
.breadcrumb .cur{color:var(--text2)}

/* Header */
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

/* Buttons */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
.btn:hover{filter:brightness(.93)}
.btn-primary{background:var(--brand-600);color:#fff}
.btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
.btn-secondary:hover{background:var(--surface3);filter:none}
.btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
.btn-save{background:#f0fdf4;color:var(--green);border:1.5px solid #86efac}
.btn-save:hover{background:#dcfce7;filter:none}

/* Stats strip */
.stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px}
.stat-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.stat-icon.purple{background:#faf5ff}
.stat-icon.green{background:#f0fdf4}
.stat-icon.blue{background:#eff6ff}
.stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
.stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1}

/* Alert */
.alert-success{background:#f0fdf4;border:1px solid #86efac;border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start}
.alert-success p{font-size:12.5px;color:var(--green);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}

/* Soal group header */
.soal-group{margin-bottom:20px}
.soal-group-header{display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius) var(--radius) 0 0;border-bottom:none}
.soal-no-badge{min-width:28px;height:28px;background:var(--purple);color:#fff;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;padding:0 6px}
.soal-bobot-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--purple);background:#faf5ff;border:1px solid #e9d5ff;border-radius:99px;padding:2px 10px}
.soal-teks{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);flex:1;line-height:1.5}

/* Jawaban cards */
.jawaban-list{border:1px solid var(--border);border-radius:0 0 var(--radius) var(--radius);overflow:hidden}
.jawaban-item{padding:16px 20px;border-bottom:1px solid #f1f5f9;background:var(--surface)}
.jawaban-item:last-child{border-bottom:none}
.jawaban-item.sudah-koreksi{background:#fafffe}

/* Siswa info */
.siswa-row{display:flex;align-items:center;gap:10px;margin-bottom:10px;flex-wrap:wrap}
.siswa-avatar{width:32px;height:32px;border-radius:99px;background:var(--brand-50);border:1.5px solid var(--brand-100);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--brand-700);flex-shrink:0}
.siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
.siswa-meta{font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
.status-pill{display:inline-flex;padding:2px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
.status-pill.belum{background:#faf5ff;color:var(--purple);border:1px solid #e9d5ff}
.status-pill.sudah{background:#f0fdf4;color:var(--green);border:1px solid #bbf7d0}

/* Jawaban teks box */
.jawaban-box{background:var(--surface2);border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);line-height:1.7;margin-bottom:12px;white-space:pre-wrap;word-break:break-word}
.jawaban-empty{font-style:italic;color:var(--text3)}

/* Koreksi form */
.koreksi-form{display:flex;align-items:flex-start;gap:10px;flex-wrap:wrap}
.poin-wrap{display:flex;align-items:center;gap:6px}
.poin-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);white-space:nowrap}
.poin-input{width:72px;padding:7px 10px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);text-align:center;outline:none;transition:border-color .15s}
.poin-input:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.12)}
.poin-max{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;white-space:nowrap}
.catatan-input{flex:1;min-width:180px;padding:7px 10px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);outline:none;resize:none;height:38px;transition:border-color .15s}
.catatan-input:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.12)}

/* Poin sudah dikoreksi display */
.poin-display{display:inline-flex;align-items:center;gap:6px}
.poin-display .val{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--green)}
.poin-display .max{font-size:12px;color:var(--text3)}
.catatan-display{margin-top:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);font-style:italic}

/* Empty state */
.empty-state{padding:60px 20px;text-align:center;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)}
.empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
.empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
.empty-sub{font-size:13px;color:var(--text3)}

@media(max-width:700px){
    .stats-strip{grid-template-columns:1fr 1fr}
    .koreksi-form{flex-direction:column}
    .catatan-input{min-width:100%;width:100%}
    .page{padding:16px}
}
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('guru.ujian.index') }}">Kelola Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('guru.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 35) }}</a>
        <span class="sep">›</span>
        <a href="{{ route('guru.ujian.soal.index', $ujian) }}">Bank Soal</a>
        <span class="sep">›</span>
        <span class="cur">Koreksi Essay</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Koreksi Essay</h1>
            <p class="page-sub">{{ $ujian->judul }} &middot; {{ $ujian->mataPelajaran->nama_mapel ?? '—' }} &middot; {{ $ujian->kelas->nama_kelas ?? '—' }}</p>
        </div>
        <a href="{{ route('guru.ujian.soal.index', $ujian) }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="15" height="15" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div>
                <p class="stat-label">Belum Dikoreksi</p>
                <p class="stat-val" style="color:var(--purple)">{{ $stats['belum_dikoreksi'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sudah Dikoreksi</p>
                <p class="stat-val" style="color:var(--green)">{{ $stats['sudah_dikoreksi'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Jawaban</p>
                <p class="stat-val">{{ $stats['belum_dikoreksi'] + $stats['sudah_dikoreksi'] }}</p>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="alert-success">
        <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    {{-- Content --}}
    @if($jawabanList->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <p class="empty-title">Semua essay sudah dikoreksi</p>
            <p class="empty-sub">Tidak ada jawaban essay yang menunggu koreksi saat ini.</p>
        </div>
    @else

    {{-- Group by soal --}}
    @php
        $grouped = $jawabanList->groupBy('soal_ujian_id');
    @endphp

    @foreach($grouped as $soalId => $jawabanGroup)
    @php $soal = $jawabanGroup->first()->soal; @endphp

    <div class="soal-group">
        {{-- Soal header --}}
        <div class="soal-group-header">
            <div class="soal-no-badge">{{ $soal->nomor_soal }}</div>
            <p class="soal-teks">{{ Str::limit(strip_tags($soal->pertanyaan), 120) }}</p>
            <span class="soal-bobot-badge">Bobot: {{ $soal->bobot }}</span>
        </div>

        {{-- Jawaban list --}}
        <div class="jawaban-list">
            @foreach($jawabanGroup as $jawaban)
            @php
                $siswa     = $jawaban->sesi->siswa ?? null;
                $namaInisial = $siswa ? collect(explode(' ', $siswa->nama_lengkap ?? 'S'))->map(fn($w) => strtoupper($w[0]))->take(2)->join('') : 'S';
                $sudahKoreksi = $jawaban->poin_didapat !== null;
            @endphp

            <div class="jawaban-item {{ $sudahKoreksi ? 'sudah-koreksi' : '' }}">

                {{-- Siswa info --}}
                <div class="siswa-row">
                    <div class="siswa-avatar">{{ $namaInisial }}</div>
                    <div style="flex:1">
                        <p class="siswa-name">{{ $siswa->nama_lengkap ?? 'Siswa tidak diketahui' }}</p>
                        <p class="siswa-meta">{{ $siswa->nis ?? '—' }} &middot; {{ $jawaban->sesi->mulai_at?->format('d M Y, H:i') ?? '—' }}</p>
                    </div>
                    <span class="status-pill {{ $sudahKoreksi ? 'sudah' : 'belum' }}">
                        {{ $sudahKoreksi ? '✓ Sudah Dikoreksi' : '⏳ Belum Dikoreksi' }}
                    </span>
                </div>

                {{-- Teks Jawaban --}}
                <div class="jawaban-box">
                    @if($jawaban->jawaban_teks)
                        {{ $jawaban->jawaban_teks }}
                    @else
                        <span class="jawaban-empty">— Siswa tidak menulis jawaban —</span>
                    @endif
                </div>

                {{-- Koreksi area --}}
                @if($sudahKoreksi)
                    {{-- Tampilkan hasil koreksi --}}
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                        <div class="poin-display">
                            <svg width="14" height="14" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span class="val">{{ $jawaban->poin_didapat }}</span>
                            <span class="max">/ {{ $soal->bobot }} poin</span>
                        </div>
                        @if($jawaban->catatan_koreksi)
                        <p class="catatan-display">"{{ $jawaban->catatan_koreksi }}"</p>
                        @endif
                        {{-- Re-koreksi form --}}
                        <form action="{{ route('guru.ujian.soal.koreksi.store', [$ujian, $jawaban]) }}" method="POST"
                              style="display:inline;margin-left:auto">
                            @csrf
                            <button type="button" class="btn btn-sm btn-secondary"
                                onclick="bukaRekoreksi(this, {{ $jawaban->id }}, {{ $jawaban->poin_didapat ?? 0 }}, '{{ addslashes($jawaban->catatan_koreksi ?? '') }}', {{ $soal->bobot }})">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit Nilai
                            </button>
                        </form>
                    </div>

                    {{-- Inline re-koreksi form (hidden by default) --}}
                    <form action="{{ route('guru.ujian.soal.koreksi.store', [$ujian, $jawaban]) }}" method="POST"
                          id="rekoreksiForm-{{ $jawaban->id }}" style="display:none;margin-top:10px">
                        @csrf
                        <div class="koreksi-form">
                            <div class="poin-wrap">
                                <span class="poin-label">Poin</span>
                                <input type="number" name="poin_didapat" class="poin-input"
                                       min="0" max="{{ $soal->bobot }}" step="0.5"
                                       value="{{ $jawaban->poin_didapat }}" required>
                                <span class="poin-max">/ {{ $soal->bobot }}</span>
                            </div>
                            <textarea name="catatan_koreksi" class="catatan-input"
                                      placeholder="Catatan (opsional)…">{{ $jawaban->catatan_koreksi }}</textarea>
                            <button type="submit" class="btn btn-sm btn-save">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                                Simpan
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                onclick="tutupRekoreksi({{ $jawaban->id }})">Batal</button>
                        </div>
                    </form>

                @else
                    {{-- Form koreksi baru --}}
                    <form action="{{ route('guru.ujian.soal.koreksi.store', [$ujian, $jawaban]) }}" method="POST">
                        @csrf
                        <div class="koreksi-form">
                            <div class="poin-wrap">
                                <span class="poin-label">Beri Poin</span>
                                <input type="number" name="poin_didapat" class="poin-input"
                                       min="0" max="{{ $soal->bobot }}" step="0.5"
                                       placeholder="0" required>
                                <span class="poin-max">/ {{ $soal->bobot }}</span>
                            </div>
                            <textarea name="catatan_koreksi" class="catatan-input"
                                      placeholder="Catatan koreksi (opsional)…"></textarea>
                            <button type="submit" class="btn btn-sm btn-save">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                                Simpan Koreksi
                            </button>
                        </div>
                    </form>
                @endif

            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function bukaRekoreksi(btn, id, poin, catatan, maxBobot) {
    document.getElementById('rekoreksiForm-' + id).style.display = 'block';
    btn.closest('div').style.display = 'none';
}
function tutupRekoreksi(id) {
    const form = document.getElementById('rekoreksiForm-' + id);
    form.style.display = 'none';
    form.previousElementSibling.style.display = 'flex';
}
</script>
</x-app-layout>