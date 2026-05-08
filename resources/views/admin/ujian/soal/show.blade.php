<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');
:root {
    --brand:#1f63db; --brand-h:#3582f0; --brand-50:#eef6ff; --brand-100:#dbeafe;
    --surface:#fff; --surface2:#f8fafc; --surface3:#f1f5f9;
    --border:#e2e8f0; --border2:#cbd5e1;
    --text:#0f172a; --text2:#475569; --text3:#94a3b8;
    --green:#15803d; --green-bg:#dcfce7; --green-bd:#bbf7d0;
    --red:#dc2626; --red-bg:#fee2e2; --red-bd:#fecaca;
    --amber:#b45309; --amber-bg:#fef3c7; --amber-bd:#fde68a;
    --purple:#7c3aed; --purple-bg:#ede9fe; --purple-bd:#c4b5fd;
    --radius:12px; --radius-sm:8px; --radius-xs:5px;
    --shadow-sm:0 1px 3px rgba(0,0,0,.07),0 1px 2px rgba(0,0,0,.04);
    --shadow-md:0 4px 16px rgba(0,0,0,.08),0 1px 4px rgba(0,0,0,.04);
}
*{box-sizing:border-box;}
.page{padding:28px 28px 72px;max-width:960px;margin:0 auto;}

/* Breadcrumb */
.breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;flex-wrap:wrap;}
.breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s;}
.breadcrumb a:hover{color:var(--brand);}
.breadcrumb .sep{color:var(--border2);}
.breadcrumb .current{color:var(--text2);}

/* Page Header */
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text);letter-spacing:-.02em;}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
.header-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}

/* Buttons */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);box-shadow:var(--shadow-sm);}
.btn-back:hover{background:var(--surface3);filter:none;}
.btn-primary{background:var(--brand);color:#fff;}
.btn-primary:hover{filter:brightness(.9);}
.btn-warning{background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-bd);}
.btn-warning:hover{filter:brightness(.95);}
.btn-danger{background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);}
.btn-danger:hover{filter:brightness(.95);}
.btn-essay{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-bd);}
.btn-essay:hover{filter:brightness(.95);}

/* Flash */
.alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;}
.alert-success{background:var(--green-bg);color:var(--green);border:1px solid var(--green-bd);}
.alert-error{background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);}

/* Nomor badge besar */
.nomor-hero{display:flex;align-items:center;gap:14px;margin-bottom:20px;}
.nomor-circle{width:52px;height:52px;border-radius:14px;background:var(--brand);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(31,99,219,.3);}
.nomor-meta{display:flex;flex-direction:column;gap:4px;}
.nomor-ujian{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);}

/* Badge jenis */
.badge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
.badge-pg{background:var(--brand-50);color:var(--brand);border:1px solid var(--brand-100);}
.badge-essay{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-bd);}
.badge-bs{background:var(--green-bg);color:var(--green);border:1px solid var(--green-bd);}

/* Bobot chip */
.bobot-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;background:var(--brand);color:#fff;font-family:'DM Mono',monospace;font-size:12px;font-weight:500;}

/* Card */
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;box-shadow:var(--shadow-sm);}
.card-header{padding:14px 20px;background:var(--surface2);border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
.card-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;}
.card-body{padding:20px 22px;}

/* Pertanyaan */
.pertanyaan-text{font-family:'DM Sans',sans-serif;font-size:15px;line-height:1.75;color:var(--text);white-space:pre-wrap;word-break:break-word;}

/* Gambar soal */
.gambar-soal{margin-top:16px;}
.gambar-soal img{max-width:100%;max-height:320px;border-radius:var(--radius-sm);border:1px solid var(--border);display:block;}
.gambar-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:8px;}

/* Pilihan jawaban */
.pilihan-list{display:flex;flex-direction:column;gap:8px;}
.pilihan-item{display:flex;align-items:center;gap:12px;padding:11px 14px;border:1.5px solid var(--border);border-radius:var(--radius-sm);background:var(--surface2);transition:border-color .15s,background .15s;}
.pilihan-item.is-benar{border-color:var(--green-bd);background:var(--green-bg);}
.pilihan-kode{width:34px;height:34px;border-radius:9px;background:var(--surface3);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text2);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.pilihan-item.is-benar .pilihan-kode{background:var(--green);color:#fff;border-color:var(--green);}
.pilihan-teks{flex:1;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);line-height:1.5;}
.pilihan-item.is-benar .pilihan-teks{color:var(--green);font-weight:600;}
.pilihan-benar-tag{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;background:var(--green);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;flex-shrink:0;}
.pilihan-img{max-width:80px;max-height:60px;border-radius:5px;border:1px solid var(--border);object-fit:cover;flex-shrink:0;}

/* Essay info box */
.essay-info{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:14px 16px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--brand);line-height:1.6;}
.essay-info strong{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;}

/* Meta grid */
.meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.meta-item{display:flex;flex-direction:column;gap:3px;}
.meta-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;}
.meta-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500;}

/* Divider */
hr.divider{border:none;border-top:1px solid var(--border);margin:0;}

/* Delete form inline */
.delete-form{display:inline;}

/* Action bar bawah */
.action-bar{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;box-shadow:var(--shadow-sm);}
.action-bar-left{display:flex;align-items:center;gap:8px;}
.action-bar-right{display:flex;align-items:center;gap:8px;}

@media(max-width:640px){
    .page{padding:16px 16px 64px;}
    .meta-grid{grid-template-columns:1fr;}
    .action-bar{flex-direction:column;align-items:stretch;}
    .action-bar-left,.action-bar-right{flex-wrap:wrap;}
    .header-actions{flex-wrap:wrap;}
}
</style>

<div class="page">

    {{-- ── Breadcrumb ── --}}
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.index') }}">Data Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 25) }}</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.soal.index', $ujian) }}">Bank Soal</a>
        <span class="sep">›</span>
        <span class="current">Soal #{{ $soal->nomor_soal }}</span>
    </nav>

    {{-- ── Flash ── --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Soal</h1>
            <p class="page-sub">{{ Str::limit($ujian->judul, 50) }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ujian.soal.index', $ujian) }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.ujian.soal.edit', [$ujian, $soal]) }}" class="btn btn-warning">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Soal
            </a>
            @if($soal->jenis_soal === 'essay')
            <a href="{{ route('admin.ujian.soal.koreksi-essay.index', [$ujian, $soal]) }}" class="btn btn-essay">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                Koreksi Essay
            </a>
            @endif
        </div>
    </div>

    {{-- ── Nomor Hero ── --}}
    <div class="nomor-hero">
        <div class="nomor-circle">{{ $soal->nomor_soal }}</div>
        <div class="nomor-meta">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                @if($soal->jenis_soal === 'pilihan_ganda')
                    <span class="badge badge-pg">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                        Pilihan Ganda
                    </span>
                @elseif($soal->jenis_soal === 'essay')
                    <span class="badge badge-essay">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                        Essay
                    </span>
                @else
                    <span class="badge badge-bs">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Benar / Salah
                    </span>
                @endif
                <span class="bobot-chip">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    {{ $soal->bobot }} Poin
                </span>
            </div>
            <div class="nomor-ujian">{{ $ujian->judul }}</div>
        </div>
    </div>

    {{-- ── Pertanyaan ── --}}
    <div class="card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span class="card-header-title">Teks Pertanyaan</span>
        </div>
        <div class="card-body">
            <div class="pertanyaan-text">{{ $soal->pertanyaan }}</div>

            @if($soal->gambar_soal)
            <div class="gambar-soal">
                <div class="gambar-label">Gambar Soal</div>
                <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Gambar soal #{{ $soal->nomor_soal }}">
            </div>
            @endif
        </div>
    </div>

    {{-- ── Pilihan Jawaban (PG & Benar/Salah) ── --}}
    @if($soal->jenis_soal !== 'essay')
    <div class="card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <span class="card-header-title">Pilihan Jawaban</span>
            <span style="margin-left:auto;font-family:'DM Mono',monospace;font-size:11.5px;color:var(--text3);">
                {{ $soal->pilihan->count() }} opsi
            </span>
        </div>
        <div class="card-body">
            @if($soal->pilihan->isEmpty())
                <p style="font-size:13.5px;color:var(--text3);font-family:'DM Sans',sans-serif;">
                    Belum ada pilihan jawaban.
                </p>
            @else
            <div class="pilihan-list">
                @foreach($soal->pilihan as $p)
                <div class="pilihan-item {{ $p->adalah_benar ? 'is-benar' : '' }}">
                    <div class="pilihan-kode">{{ $p->kode_pilihan }}</div>

                    @if($p->gambar_pilihan)
                    <img class="pilihan-img"
                         src="{{ asset('storage/' . $p->gambar_pilihan) }}"
                         alt="Gambar pilihan {{ $p->kode_pilihan }}">
                    @endif

                    <div class="pilihan-teks">{{ $p->teks_pilihan }}</div>

                    @if($p->adalah_benar)
                    <span class="pilihan-benar-tag">
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Benar
                    </span>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ── Info Essay ── --}}
    @if($soal->jenis_soal === 'essay')
    <div class="card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
            <span class="card-header-title">Informasi Essay</span>
        </div>
        <div class="card-body">
            <div class="essay-info">
                <strong>Soal Essay</strong> — Jawaban siswa dikoreksi secara manual oleh guru/admin
                melalui menu <em>Koreksi Essay</em> setelah ujian selesai.
                Bobot maksimal soal ini adalah <strong>{{ $soal->bobot }} poin</strong>.
            </div>
        </div>
    </div>
    @endif

    {{-- ── Metadata ── --}}
    <div class="card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="card-header-title">Informasi Soal</span>
        </div>
        <div class="card-body">
            <div class="meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Nomor Soal</span>
                    <span class="meta-value">{{ $soal->nomor_soal }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Bobot / Poin</span>
                    <span class="meta-value">{{ $soal->bobot }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Jenis Soal</span>
                    <span class="meta-value">{{ ucwords(str_replace('_', ' ', $soal->jenis_soal)) }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Gambar Soal</span>
                    <span class="meta-value">{{ $soal->gambar_soal ? 'Ada' : 'Tidak Ada' }}</span>
                </div>
                @if($soal->jenis_soal !== 'essay')
                <div class="meta-item">
                    <span class="meta-label">Jumlah Pilihan</span>
                    <span class="meta-value">{{ $soal->pilihan->count() }} opsi</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Jawaban Benar</span>
                    <span class="meta-value">
                        {{ $soal->pilihan->where('adalah_benar', true)->pluck('kode_pilihan')->join(', ') ?: '—' }}
                    </span>
                </div>
                @endif
                <div class="meta-item">
                    <span class="meta-label">Dibuat</span>
                    <span class="meta-value">{{ $soal->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Diperbarui</span>
                    <span class="meta-value">{{ $soal->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Action Bar ── --}}
    <div class="action-bar">
        <div class="action-bar-left">
            {{-- Navigasi prev/next soal --}}
            @php
                $allSoal = $ujian->soal()->orderBy('nomor_soal')->pluck('id');
                $currentIdx = $allSoal->search($soal->id);
                $prevId = $currentIdx > 0 ? $allSoal[$currentIdx - 1] : null;
                $nextId = $currentIdx < $allSoal->count() - 1 ? $allSoal[$currentIdx + 1] : null;
            @endphp
            @if($prevId)
            <a href="{{ route('admin.ujian.soal.show', [$ujian, $prevId]) }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Soal Sebelumnya
            </a>
            @endif
            @if($nextId)
            <a href="{{ route('admin.ujian.soal.show', [$ujian, $nextId]) }}" class="btn btn-back">
                Soal Berikutnya
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            @endif
        </div>
        <div class="action-bar-right">
            @if($soal->jenis_soal === 'essay')
            <a href="{{ route('admin.ujian.soal.koreksi-essay.index', [$ujian, $soal]) }}" class="btn btn-essay">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                Koreksi Essay
            </a>
            @endif
            <a href="{{ route('admin.ujian.soal.edit', [$ujian, $soal]) }}" class="btn btn-warning">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Soal
            </a>
            <form action="{{ route('admin.ujian.soal.destroy', [$ujian, $soal]) }}"
                  method="POST" class="delete-form">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Hapus soal #{{ $soal->nomor_soal }}?\nSemua jawaban siswa terkait akan ikut terhapus.')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus Soal
                </button>
            </form>
        </div>
    </div>

</div>
</x-app-layout>