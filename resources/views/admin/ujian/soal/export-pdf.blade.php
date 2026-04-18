<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Soal Ujian — {{ $ujian->judul }}</title>
<style>
    body{font-family:'DejaVu Sans',Arial,sans-serif;font-size:12px;color:#1e293b;margin:0;padding:24px;}
    .header{border-bottom:2px solid #1f63db;padding-bottom:12px;margin-bottom:20px;}
    .school-name{font-size:16px;font-weight:700;color:#0f172a;}
    .doc-title{font-size:13px;color:#64748b;margin-top:2px;}
    .ujian-info{background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:12px 16px;margin-bottom:20px;display:flex;gap:24px;flex-wrap:wrap;}
    .info-item{font-size:11px;color:#64748b;}<br>
    .info-val{font-weight:700;color:#0f172a;display:block;font-size:12px;}
    .soal-item{margin-bottom:20px;page-break-inside:avoid;}
    .soal-num{display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:7px;background:#1f63db;color:#fff;font-weight:800;font-size:12px;vertical-align:middle;margin-right:8px;}
    .soal-text{font-size:12.5px;color:#0f172a;line-height:1.6;display:inline;}
    .soal-meta{font-size:10.5px;color:#94a3b8;margin:4px 0 8px 34px;}
    .pilihan-list{margin-left:34px;margin-top:8px;display:flex;flex-direction:column;gap:5px;}
    .pilihan-row{display:flex;align-items:flex-start;gap:8px;font-size:12px;}
    .pilihan-kode{width:22px;height:22px;border-radius:6px;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0;}
    .pilihan-kode.benar{background:#dcfce7;border-color:#86efac;color:#16a34a;}
    .pilihan-teks{line-height:1.5;color:#334155;}
    .essay-box{margin:8px 34px 0;border:1px dashed #cbd5e1;border-radius:6px;height:64px;background:#f8fafc;}
    .footer{position:fixed;bottom:16px;left:24px;right:24px;border-top:1px solid #e2e8f0;padding-top:8px;display:flex;justify-content:space-between;font-size:10px;color:#94a3b8;}
    .page-num:after{content:counter(page);}
    @page{margin:16mm;} counter-reset:page; @page{counter-increment:page;}
</style>
</head>
<body>
    <div class="header">
        <div class="school-name">Dokumen Soal Ujian</div>
        <div class="doc-title">{{ $ujian->judul }} · Dicetak {{ now()->translatedFormat('d F Y H:i') }}</div>
    </div>

    <div class="ujian-info">
        <div class="info-item">Mata Pelajaran<span class="info-val">{{ $ujian->mataPelajaran->nama_mapel ?? '-' }}</span></div>
        <div class="info-item">Kelas<span class="info-val">{{ $ujian->kelas->nama_kelas ?? '-' }}</span></div>
        <div class="info-item">Jenis<span class="info-val">{{ strtoupper(str_replace('_',' ',$ujian->jenis)) }}</span></div>
        <div class="info-item">Tanggal<span class="info-val">{{ $ujian->tanggal ? $ujian->tanggal->translatedFormat('d F Y') : '-' }}</span></div>
        <div class="info-item">Durasi<span class="info-val">{{ $ujian->durasi_menit }} menit</span></div>
        <div class="info-item">KKM<span class="info-val">{{ $ujian->nilai_kkm ?? '-' }}</span></div>
        <div class="info-item">Total Soal<span class="info-val">{{ $soal->count() }}</span></div>
        <div class="info-item">Total Bobot<span class="info-val">{{ $soal->sum('bobot') }}</span></div>
    </div>

    @foreach($soal as $s)
    <div class="soal-item">
        <div>
            <span class="soal-num">{{ $s->nomor_soal }}</span>
            <span class="soal-text">{!! nl2br(e($s->pertanyaan)) !!}</span>
        </div>
        <div class="soal-meta">
            {{ $s->jenis_soal === 'pilihan_ganda' ? 'Pilihan Ganda' : ($s->jenis_soal === 'essay' ? 'Essay' : 'Benar/Salah') }}
            · Bobot: {{ $s->bobot }} poin
        </div>

        @if($s->jenis_soal !== 'essay')
        <div class="pilihan-list">
            @foreach($s->pilihan as $p)
            <div class="pilihan-row">
                <div class="pilihan-kode {{ $p->adalah_benar ? 'benar' : '' }}">{{ $p->kode_pilihan }}</div>
                <div class="pilihan-teks">{{ $p->teks_pilihan }}</div>
            </div>
            @endforeach
        </div>
        @else
        <div class="essay-box"></div>
        @endif
    </div>
    @endforeach

    <div class="footer">
        <span>{{ $ujian->judul }} · {{ $ujian->kelas->nama_kelas ?? '' }}</span>
        <span>Halaman <span class="page-num"></span></span>
    </div>
</body>
</html>