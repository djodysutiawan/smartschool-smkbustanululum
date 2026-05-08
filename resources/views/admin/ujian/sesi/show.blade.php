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
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fef9c3;--yellow-border:#fde68a;
        --purple:#7c3aed;--purple-bg:#fdf4ff;--purple-border:#e9d5ff;
        --orange:#c2410c;--orange-bg:#fff7ed;--orange-border:#fed7aa;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 40px;max-width:1100px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:16px;font-size:12.5px;color:var(--text3);}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s;}
    .breadcrumb a:hover{color:var(--brand-600);}
    .breadcrumb-sep{color:var(--border2);}
    .breadcrumb-cur{color:var(--text2);font-weight:600;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);filter:none;}
    .btn-essay{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border);}
    .btn-essay:hover{background:#ede9fe;filter:none;}

    /* Info Grid */
    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;}
    .info-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 20px;}
    .info-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid var(--border);}
    .info-row{display:flex;align-items:flex-start;gap:8px;margin-bottom:10px;}
    .info-row:last-child{margin-bottom:0;}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);min-width:130px;flex-shrink:0;}
    .info-val{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);}

    /* Nilai Hero */
    .nilai-hero{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:20px;display:flex;align-items:center;gap:24px;flex-wrap:wrap;}
    .nilai-circle{width:100px;height:100px;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;position:relative;}
    .nilai-circle-ring{position:absolute;inset:0;border-radius:50%;}
    .nilai-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;position:relative;z-index:1;}
    .nilai-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;position:relative;z-index:1;opacity:.7;}
    .nilai-info{flex:1;min-width:200px;}
    .nilai-info-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--text);margin-bottom:8px;}
    .nilai-meta{display:flex;gap:20px;flex-wrap:wrap;}
    .nilai-meta-item{display:flex;flex-direction:column;gap:2px;}
    .nilai-meta-label{font-size:11.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;}
    .nilai-meta-val{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:18px;color:var(--text);}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-selesai{background:var(--green-bg);color:var(--green);}.badge-selesai .badge-dot{background:var(--green);}
    .badge-berlangsung{background:var(--brand-50);color:var(--brand-700);}.badge-berlangsung .badge-dot{background:var(--brand-600);}
    .badge-habis_waktu{background:var(--red-bg);color:var(--red);}.badge-habis_waktu .badge-dot{background:var(--red);}
    .badge-belum_mulai{background:var(--surface2);color:var(--text3);}.badge-belum_mulai .badge-dot{background:var(--text3);}
    .badge-lulus{background:var(--green-bg);color:var(--green);}
    .badge-gagal{background:var(--red-bg);color:var(--red);}
    .badge-benar{background:var(--green-bg);color:var(--green);}
    .badge-salah{background:var(--red-bg);color:var(--red);}
    .badge-essay{background:var(--purple-bg);color:var(--purple);}
    .badge-pending{background:var(--yellow-bg);color:var(--yellow);}

    /* Essay warning */
    .essay-warning{background:var(--yellow-bg);border:1px solid var(--yellow-border);border-radius:var(--radius);padding:12px 18px;margin-bottom:16px;display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--yellow);}

    /* Jawaban list */
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);letter-spacing:.04em;text-transform:uppercase;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--border);}
    .jawaban-list{display:flex;flex-direction:column;gap:10px;}
    .jawaban-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:border-color .15s;}
    .jawaban-card:hover{border-color:var(--border2);}
    .jawaban-card.benar{border-left:3px solid var(--green);}
    .jawaban-card.salah{border-left:3px solid var(--red);}
    .jawaban-card.essay-done{border-left:3px solid var(--purple);}
    .jawaban-card.essay-pending{border-left:3px solid var(--yellow);}
    .jawaban-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;padding:12px 16px;cursor:pointer;user-select:none;}
    .jawaban-head-left{display:flex;align-items:flex-start;gap:10px;flex:1;min-width:0;}
    .nomor-soal{width:28px;height:28px;border-radius:7px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text2);flex-shrink:0;}
    .soal-text{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);line-height:1.5;}
    .soal-gambar{max-width:200px;max-height:100px;object-fit:cover;border-radius:5px;margin-top:6px;border:1px solid var(--border);}
    .jawaban-meta{display:flex;align-items:center;gap:8px;flex-shrink:0;flex-wrap:wrap;}
    .bobot-pill{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);background:var(--surface2);border:1px solid var(--border);padding:2px 8px;border-radius:5px;}
    .poin-pill{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;padding:2px 8px;border-radius:5px;}
    .poin-green{background:var(--green-bg);color:var(--green);}
    .poin-red{background:var(--red-bg);color:var(--red);}
    .poin-purple{background:var(--purple-bg);color:var(--purple);}
    .poin-yellow{background:var(--yellow-bg);color:var(--yellow);}
    .chevron{transition:transform .2s;flex-shrink:0;color:var(--text3);}
    .chevron.open{transform:rotate(180deg);}
    .jawaban-body{display:none;padding:0 16px 14px;}
    .jawaban-body.open{display:block;}
    .pilihan-list{display:flex;flex-direction:column;gap:5px;margin-bottom:8px;}
    .pilihan-item{display:flex;align-items:center;gap:8px;padding:7px 10px;border-radius:7px;border:1px solid var(--border);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);}
    .pilihan-item.dipilih.benar{background:var(--green-bg);border-color:var(--green-border);color:var(--green);}
    .pilihan-item.dipilih.salah{background:var(--red-bg);border-color:var(--red-border);color:var(--red);}
    .pilihan-item.kunci{background:var(--green-bg);border-color:var(--green-border);color:var(--green);opacity:.7;}
    .kode-pilihan{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:12px;min-width:20px;}
    .essay-box{background:var(--surface2);border:1px solid var(--border);border-radius:7px;padding:10px 14px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);line-height:1.6;min-height:60px;white-space:pre-wrap;}
    .catatan-koreksi{background:var(--purple-bg);border:1px solid var(--purple-border);border-radius:7px;padding:8px 12px;font-size:12.5px;color:var(--purple);margin-top:8px;font-family:'DM Sans',sans-serif;}
    .divider{border:none;border-top:1px solid var(--border);margin:10px 0;}
    .link-koreksi{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--purple);text-decoration:none;display:inline-flex;align-items:center;gap:4px;}
    .link-koreksi:hover{text-decoration:underline;}

    @media(max-width:768px){.info-grid{grid-template-columns:1fr;}.nilai-hero{flex-direction:column;align-items:flex-start;}}
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.ujian.index') }}">Ujian</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 35) }}</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.ujian.sesi.index-admin', $ujian) }}">Monitor Sesi</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">{{ $sesi->siswa->nama_lengkap ?? 'Detail Sesi' }}</span>
    </div>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Jawaban Siswa</h1>
            <p class="page-sub">{{ $sesi->siswa->nama_lengkap ?? '-' }} — {{ $ujian->judul }}</p>
        </div>
        <div class="header-actions">
            @if($essayBelumKoreksi > 0)
            <a href="{{ route('admin.ujian.soal.koreksi-essay.index', [$ujian, $sesi->jawaban->where('soal.jenis_soal', 'essay')->first()?->soal]) }}"
               class="btn btn-sm btn-essay">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                </svg>
                Koreksi Essay ({{ $essayBelumKoreksi }})
            </a>
            @endif
            <a href="{{ route('admin.ujian.sesi.index-admin', $ujian) }}" class="btn btn-sm btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Essay Warning --}}
    @if($essayBelumKoreksi > 0)
    <div class="essay-warning">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        {{ $essayBelumKoreksi }} soal essay belum dikoreksi — nilai akhir bisa berubah setelah koreksi.
    </div>
    @endif

    {{-- Info Grid --}}
    <div class="info-grid">
        {{-- Info Siswa --}}
        <div class="info-card">
            <p class="info-card-title">Informasi Siswa</p>
            <div class="info-row">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-val">{{ $sesi->siswa->nama_lengkap ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NIS</span>
                <span class="info-val">{{ $sesi->siswa->nis ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kelas</span>
                <span class="info-val">{{ $sesi->siswa->kelas->nama_kelas ?? '-' }}</span>
            </div>
        </div>

        {{-- Info Sesi --}}
        <div class="info-card">
            <p class="info-card-title">Informasi Sesi</p>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-val">
                    <span class="badge badge-{{ $sesi->status }}">
                        <span class="badge-dot"></span>
                        @switch($sesi->status)
                            @case('selesai') Selesai @break
                            @case('berlangsung') Sedang Berlangsung @break
                            @case('habis_waktu') Habis Waktu @break
                            @case('belum_mulai') Belum Mulai @break
                            @default {{ $sesi->status }}
                        @endswitch
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Mulai Pada</span>
                <span class="info-val">
                    {{ $sesi->mulai_pada
                        ? \Carbon\Carbon::parse($sesi->mulai_pada)->format('d M Y, H:i:s')
                        : '—' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Selesai Pada</span>
                <span class="info-val">
                    {{ $sesi->selesai_pada
                        ? \Carbon\Carbon::parse($sesi->selesai_pada)->format('d M Y, H:i:s')
                        : '—' }}
                </span>
            </div>
            @if($sesi->mulai_pada && $sesi->selesai_pada)
            <div class="info-row">
                <span class="info-label">Durasi Dikerjakan</span>
                <span class="info-val">
                    {{ \Carbon\Carbon::parse($sesi->mulai_pada)->diffInMinutes(\Carbon\Carbon::parse($sesi->selesai_pada)) }} menit
                </span>
            </div>
            @endif
        </div>
    </div>

    {{-- Nilai Hero --}}
    @if(in_array($sesi->status, ['selesai', 'habis_waktu']))
    @php
        $lulus = $sesi->lulus;
        $heroColor = $lulus ? '#15803d' : '#dc2626';
        $heroBg    = $lulus ? '#f0fdf4' : '#fff0f0';
        $totalSoal = $sesi->jawaban->count();
        $jawabanBenar = $sesi->jawaban->where('adalah_benar', true)->count();
        $totalPoin = $sesi->jawaban->sum('poin_didapat');
    @endphp
    <div class="nilai-hero">
        <div class="nilai-circle" style="background:{{ $heroBg }};border:3px solid {{ $heroColor }}30;">
            <span class="nilai-num" style="color:{{ $heroColor }}">
                {{ number_format($sesi->nilai_akhir ?? 0, 0) }}
            </span>
            <span class="nilai-label" style="color:{{ $heroColor }}">NILAI</span>
        </div>
        <div class="nilai-info">
            <p class="nilai-info-title">
                @if(!is_null($sesi->lulus))
                    <span class="badge {{ $lulus ? 'badge-lulus' : 'badge-gagal' }}" style="font-size:13.5px;padding:4px 14px;">
                        {{ $lulus ? '✓ Lulus' : '✗ Tidak Lulus' }}
                    </span>
                @else
                    <span class="badge badge-pending">Menunggu Koreksi Essay</span>
                @endif
            </p>
            <div class="nilai-meta" style="margin-top:10px;">
                <div class="nilai-meta-item">
                    <span class="nilai-meta-label">KKM</span>
                    <span class="nilai-meta-val">{{ $ujian->nilai_kkm ?? '—' }}</span>
                </div>
                <div class="nilai-meta-item">
                    <span class="nilai-meta-label">Total Soal</span>
                    <span class="nilai-meta-val">{{ $totalSoal }}</span>
                </div>
                <div class="nilai-meta-item">
                    <span class="nilai-meta-label">Dijawab Benar</span>
                    <span class="nilai-meta-val" style="color:var(--green)">{{ $jawabanBenar }}</span>
                </div>
                <div class="nilai-meta-item">
                    <span class="nilai-meta-label">Total Poin</span>
                    <span class="nilai-meta-val">{{ number_format($totalPoin, 1) }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Daftar Jawaban --}}
    <p class="section-title">Rincian Jawaban ({{ $sesi->jawaban->count() }} soal)</p>

    @if($sesi->jawaban->isEmpty())
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:40px;text-align:center;">
        <p style="color:var(--text3);font-size:13px;">Siswa belum menjawab soal apapun.</p>
    </div>
    @else
    <div class="jawaban-list">
        @foreach($sesi->jawaban->sortBy('soal.nomor_soal') as $idx => $jawaban)
        @php
            $soal = $jawaban->soal;
            $jenisClass = 'belum';
            if ($soal->jenis_soal === 'essay') {
                $jenisClass = is_null($jawaban->poin_didapat) ? 'essay-pending' : 'essay-done';
            } elseif (!is_null($jawaban->adalah_benar)) {
                $jenisClass = $jawaban->adalah_benar ? 'benar' : 'salah';
            }
            $poinColor = 'poin-yellow';
            if ($soal->jenis_soal === 'essay') {
                $poinColor = is_null($jawaban->poin_didapat) ? 'poin-yellow' : 'poin-purple';
            } elseif (!is_null($jawaban->adalah_benar)) {
                $poinColor = $jawaban->adalah_benar ? 'poin-green' : 'poin-red';
            }
        @endphp
        <div class="jawaban-card {{ $jenisClass }}">
            <div class="jawaban-head" onclick="toggleJawaban({{ $idx }})">
                <div class="jawaban-head-left">
                    <span class="nomor-soal">{{ $soal->nomor_soal ?? ($idx + 1) }}</span>
                    <div>
                        <div class="soal-text">
                            {!! Str::limit(strip_tags($soal->pertanyaan), 150) !!}
                        </div>
                        <div style="margin-top:4px;display:flex;align-items:center;gap:6px;">
                            @if($soal->jenis_soal === 'essay')
                                <span class="badge badge-essay" style="font-size:10.5px;padding:1px 8px;">Essay</span>
                            @elseif($soal->jenis_soal === 'benar_salah')
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;background:var(--orange-bg);color:var(--orange);border:1px solid var(--orange-border);padding:1px 8px;border-radius:5px;">Benar/Salah</span>
                            @else
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);padding:1px 8px;border-radius:5px;">Pilihan Ganda</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="jawaban-meta">
                    <span class="bobot-pill">Bobot: {{ $soal->bobot }}</span>
                    @if(!is_null($jawaban->poin_didapat))
                        <span class="poin-pill {{ $poinColor }}">+{{ number_format($jawaban->poin_didapat, 1) }}</span>
                    @elseif($soal->jenis_soal === 'essay')
                        <span class="poin-pill poin-yellow">Belum dikoreksi</span>
                    @else
                        <span class="poin-pill poin-red">0</span>
                    @endif
                    @if($soal->jenis_soal !== 'essay')
                        @if($jawaban->adalah_benar)
                            <span class="badge badge-benar" style="font-size:10.5px;padding:1px 8px;">✓ Benar</span>
                        @elseif(!is_null($jawaban->adalah_benar))
                            <span class="badge badge-salah" style="font-size:10.5px;padding:1px 8px;">✗ Salah</span>
                        @endif
                    @endif
                    <svg class="chevron" id="chev-{{ $idx }}" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
            </div>

            <div class="jawaban-body" id="body-{{ $idx }}">
                {{-- Gambar soal --}}
                @if($soal->gambar_soal)
                <div style="margin-bottom:10px;">
                    <img src="{{ Storage::url($soal->gambar_soal) }}" alt="Gambar Soal" class="soal-gambar">
                </div>
                @endif

                {{-- PG / Benar-Salah --}}
                @if(in_array($soal->jenis_soal, ['pilihan_ganda', 'benar_salah']))
                <div class="pilihan-list">
                    @foreach($soal->pilihan as $pilihan)
                    @php
                        $dipilih = $jawaban->pilihan_jawaban_id == $pilihan->id;
                        $isBenar = $pilihan->adalah_benar;
                        $itemClass = '';
                        if ($dipilih) $itemClass = $isBenar ? 'dipilih benar' : 'dipilih salah';
                        elseif ($isBenar) $itemClass = 'kunci';
                    @endphp
                    <div class="pilihan-item {{ $itemClass }}">
                        <span class="kode-pilihan">{{ $pilihan->kode_pilihan }}</span>
                        <span style="flex:1;">{{ $pilihan->teks_pilihan }}</span>
                        @if($dipilih)
                            <span style="font-size:11px;font-weight:700;">{{ $isBenar ? '✓ Dipilih (Benar)' : '✗ Dipilih (Salah)' }}</span>
                        @elseif($isBenar)
                            <span style="font-size:11px;font-weight:700;opacity:.7;">Kunci Jawaban</span>
                        @endif
                    </div>
                    @endforeach
                    @if(!$jawaban->pilihan_jawaban_id)
                    <div style="color:var(--text3);font-size:12.5px;padding:6px 4px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;">
                        ⚠ Tidak dijawab
                    </div>
                    @endif
                </div>

                {{-- Essay --}}
                @elseif($soal->jenis_soal === 'essay')
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-bottom:6px;">Jawaban Siswa:</p>
                @if($jawaban->jawaban_essay)
                    <div class="essay-box">{{ $jawaban->jawaban_essay }}</div>
                @else
                    <div class="essay-box" style="color:var(--text3);font-style:italic;">Tidak dijawab</div>
                @endif

                @if($jawaban->catatan_koreksi)
                <div class="catatan-koreksi">
                    <strong>Catatan Guru:</strong> {{ $jawaban->catatan_koreksi }}
                </div>
                @endif

                <hr class="divider">
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:var(--text2);">
                        @if(!is_null($jawaban->poin_didapat))
                            Poin diberikan: <strong>{{ number_format($jawaban->poin_didapat, 1) }} / {{ $soal->bobot }}</strong>
                        @else
                            <span style="color:var(--yellow);">Belum dikoreksi</span>
                        @endif
                    </div>
                    <a href="{{ route('admin.ujian.soal.koreksi-essay.index', [$ujian, $soal]) }}"
                       class="link-koreksi">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                        </svg>
                        Koreksi Essay
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleJawaban(idx) {
    const body = document.getElementById('body-' + idx);
    const chev = document.getElementById('chev-' + idx);
    const isOpen = body.classList.contains('open');
    body.classList.toggle('open', !isOpen);
    chev.classList.toggle('open', !isOpen);
}

// Buka otomatis soal yang salah / belum dikoreksi
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.jawaban-card.salah, .jawaban-card.essay-pending').forEach(card => {
        const body = card.querySelector('.jawaban-body');
        const chev = card.querySelector('.chevron');
        if (body) body.classList.add('open');
        if (chev) chev.classList.add('open');
    });
});

@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
@endif
</script>
</x-app-layout>