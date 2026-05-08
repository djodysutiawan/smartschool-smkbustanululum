<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Soal Ujian — {{ $ujian->judul }}</title>
<style>
/*
 * View: admin.ujian.soal.export-pdf
 * Controller: SoalUjianController@exportPdf
 * Variabel: $ujian (Ujian), $soal (Collection<SoalUjian> with pilihan)
 * Library: barryvdh/laravel-dompdf, paper=a4 portrait
 *
 * FIX BUG LAMA:
 *   "counter-reset:page; @page{counter-increment:page;}" di luar @page
 *   adalah CSS tidak valid dan diabaikan DomPDF.
 *   DomPDF mendukung variabel page/pages melalui string konten khusus:
 *     content: counter(page)      → nomor halaman sekarang
 *     content: counter(pages)     → total halaman
 *   Keduanya hanya valid di dalam blok @page { } via elemen posisi fixed.
 */

/* ── Reset & Base ── */
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 11.5px;
    color: #1e293b;
    /* DomPDF: margin halaman diatur @page, bukan padding body */
    background: #fff;
}

/* ── @page: ukuran, margin, dan counter halaman ── */
@page {
    size: A4 portrait;
    margin: 18mm 16mm 22mm 16mm; /* top right bottom left — beri ruang footer */
}

/*
 * Nomor halaman DomPDF:
 * Elemen posisi fixed dengan content: counter(page)/counter(pages)
 * akan diulang setiap halaman. Ini pengganti cara @page counter yang
 * tidak didukung dengan baik di DomPDF.
 */
#page-footer {
    position: fixed;
    bottom: -16mm;   /* keluar dari area konten, masuk ke margin bawah @page */
    left: 0;
    right: 0;
    border-top: 1px solid #e2e8f0;
    padding-top: 6px;
    display: table;
    width: 100%;
    font-size: 9.5px;
    color: #94a3b8;
}
#page-footer .footer-left  { display: table-cell; text-align: left; }
#page-footer .footer-right { display: table-cell; text-align: right; }
#page-footer .page-num::before { content: "Halaman "; }
#page-footer .page-num        { content: counter(page); }
/* DomPDF mengganti teks "PAGE_NUM" dan "PAGE_COUNT" jika pakai cara lain,
   tapi cara paling andal adalah inline PHP di blade: */

/* ── Header Dokumen ── */
.doc-header {
    border-bottom: 2.5px solid #1f63db;
    padding-bottom: 10px;
    margin-bottom: 16px;
}
.school-name {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -.01em;
}
.doc-title {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 2px;
}

/* ── Info Box Ujian ── */
.ujian-info {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 10px 14px;
    margin-bottom: 18px;
    /* DomPDF tidak mendukung flexbox secara penuh → pakai display:table */
    display: table;
    width: 100%;
}
.info-row {
    display: table-row;
}
.info-cell {
    display: table-cell;
    padding: 2px 12px 2px 0;
    vertical-align: top;
    white-space: nowrap;
}
.info-key {
    font-size: 9.5px;
    color: #64748b;
    display: block;
    margin-bottom: 1px;
    text-transform: uppercase;
    letter-spacing: .05em;
}
.info-val {
    font-weight: 700;
    color: #0f172a;
    font-size: 11px;
    display: block;
}

/* ── Soal Item ── */
.soal-item {
    margin-bottom: 18px;
    page-break-inside: avoid;
}
.soal-header {
    display: table;
    width: 100%;
    margin-bottom: 4px;
}
.soal-num-cell {
    display: table-cell;
    vertical-align: top;
    width: 30px;
}
.soal-text-cell {
    display: table-cell;
    vertical-align: top;
}
.soal-num {
    display: inline-block;
    width: 24px;
    height: 24px;
    border-radius: 6px;
    background: #1f63db;
    color: #fff;
    font-weight: 800;
    font-size: 11px;
    text-align: center;
    line-height: 24px;
}
.soal-text {
    font-size: 12px;
    color: #0f172a;
    line-height: 1.65;
}
.soal-meta {
    font-size: 9.5px;
    color: #94a3b8;
    margin: 3px 0 7px 30px;
}

/* Gambar soal (jika ada) */
.soal-gambar {
    margin: 6px 0 8px 30px;
    max-width: 320px;
    max-height: 180px;
    border: 1px solid #e2e8f0;
    border-radius: 5px;
    display: block;
}

/* ── Pilihan Jawaban ── */
.pilihan-list {
    margin-left: 30px;
    margin-top: 6px;
}
.pilihan-row {
    /* DomPDF: display:table untuk layout horizontal */
    display: table;
    width: 100%;
    margin-bottom: 4px;
}
.pilihan-kode-cell {
    display: table-cell;
    vertical-align: top;
    width: 26px;
}
.pilihan-teks-cell {
    display: table-cell;
    vertical-align: top;
}
.pilihan-kode {
    display: inline-block;
    width: 22px;
    height: 22px;
    border-radius: 5px;
    border: 1px solid #e2e8f0;
    text-align: center;
    line-height: 22px;
    font-weight: 700;
    font-size: 10px;
    color: #475569;
    background: #f8fafc;
}
.pilihan-kode.benar {
    background: #dcfce7;
    border-color: #86efac;
    color: #16a34a;
}
.pilihan-teks {
    font-size: 11.5px;
    line-height: 1.55;
    color: #334155;
    padding-top: 2px;  /* alignment vertikal dengan kode */
}

/* Gambar pilihan (jika ada) */
.pilihan-gambar {
    margin-top: 3px;
    max-width: 160px;
    max-height: 100px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    display: block;
}

/* ── Kotak jawaban essay ── */
.essay-box {
    margin: 8px 0 0 30px;
    border: 1px dashed #cbd5e1;
    border-radius: 6px;
    height: 60px;
    background: #f8fafc;
}

/* ── Garis pemisah antar soal ── */
.soal-divider {
    border: none;
    border-top: 1px solid #f1f5f9;
    margin: 0 0 18px 0;
}

/* ── Watermark / stamp "KUNCI" untuk PDF kunci jawaban ── */
/* (opsional, tidak dipakai saat ini) */
</style>
</head>
<body>

{{--
    Footer halaman: posisi fixed → muncul di tiap halaman DomPDF.
    Nomor halaman menggunakan script PHP inline karena DomPDF tidak
    mendukung CSS counter-reset / counter-increment di luar elemen @page
    dengan andal di semua versi.

    DomPDF v1.x mendukung penggantian teks "{PAGE_NUM}" dan "{PAGE_COUNT}"
    melalui metode setOption('isPhpEnabled', true) atau via canvas,
    tetapi cara paling portabel adalah pakai elemen fixed dengan
    content:counter(page) di dalam pseudo-elemen — sayangnya DomPDF
    tidak mendukung pseudo-elemen ::after secara penuh.

    Solusi paling andal untuk DomPDF: gunakan elemen span kosong dengan
    class khusus yang diganti via dompdf inline script:
--}}
<div id="page-footer">
    <div class="footer-left">{{ $ujian->judul }} · {{ $ujian->kelas->nama_kelas ?? '' }}</div>
    <div class="footer-right">
        Dicetak: {{ now()->translatedFormat('d F Y H:i') }} &nbsp;|&nbsp;
        Hal. <span class="dompdf-page-counter"></span>
    </div>
</div>

{{-- ── Header ── --}}
<div class="doc-header">
    <div class="school-name">Dokumen Soal Ujian</div>
    <div class="doc-title">
        {{ $ujian->judul }} &nbsp;·&nbsp; Dicetak {{ now()->translatedFormat('d F Y H:i') }}
    </div>
</div>

{{-- ── Info Box ── --}}
<div class="ujian-info">
    <div class="info-row">
        <div class="info-cell">
            <span class="info-key">Mata Pelajaran</span>
            <span class="info-val">{{ $ujian->mataPelajaran->nama_mapel ?? '-' }}</span>
        </div>
        <div class="info-cell">
            <span class="info-key">Kelas</span>
            <span class="info-val">{{ $ujian->kelas->nama_kelas ?? '-' }}</span>
        </div>
        <div class="info-cell">
            <span class="info-key">Jenis</span>
            <span class="info-val">{{ strtoupper(str_replace('_', ' ', $ujian->jenis)) }}</span>
        </div>
        <div class="info-cell">
            <span class="info-key">Tanggal</span>
            <span class="info-val">
                {{ $ujian->tanggal ? $ujian->tanggal->translatedFormat('d F Y') : '-' }}
            </span>
        </div>
        <div class="info-cell">
            <span class="info-key">Durasi</span>
            <span class="info-val">{{ $ujian->durasi_menit }} menit</span>
        </div>
        <div class="info-cell">
            <span class="info-key">KKM</span>
            <span class="info-val">{{ $ujian->nilai_kkm ?? '-' }}</span>
        </div>
        <div class="info-cell">
            <span class="info-key">Total Soal</span>
            <span class="info-val">{{ $soal->count() }}</span>
        </div>
        <div class="info-cell">
            <span class="info-key">Total Bobot</span>
            <span class="info-val">{{ $soal->sum('bobot') }}</span>
        </div>
    </div>
</div>

{{-- ── Daftar Soal ── --}}
@foreach($soal as $loop_soal)

@if(!$loop->first)
<hr class="soal-divider">
@endif

<div class="soal-item">

    {{-- Nomor + Teks Pertanyaan --}}
    <div class="soal-header">
        <div class="soal-num-cell">
            <span class="soal-num">{{ $loop_soal->nomor_soal }}</span>
        </div>
        <div class="soal-text-cell">
            {{--
                nl2br + e() untuk menjaga baris baru dari teks dan mencegah XSS.
                Controller tidak meng-strip HTML, jadi escape selalu diperlukan.
            --}}
            <span class="soal-text">{!! nl2br(e($loop_soal->pertanyaan)) !!}</span>
        </div>
    </div>

    {{-- Meta (jenis + bobot) --}}
    <div class="soal-meta">
        @if($loop_soal->jenis_soal === 'pilihan_ganda')
            Pilihan Ganda
        @elseif($loop_soal->jenis_soal === 'essay')
            Essay
        @else
            Benar / Salah
        @endif
        &nbsp;·&nbsp; Bobot: {{ $loop_soal->bobot }} poin
    </div>

    {{-- Gambar Soal (jika ada) --}}
    @if($loop_soal->gambar_soal)
    <img src="{{ storage_path('app/public/' . $loop_soal->gambar_soal) }}"
         class="soal-gambar"
         alt="Gambar soal {{ $loop_soal->nomor_soal }}">
    {{--
        FIX: DomPDF membaca gambar dari filesystem, bukan URL publik.
        Gunakan storage_path() bukan asset('storage/...').
        Pastikan 'storage/app/public' dapat dibaca oleh PHP process.
    --}}
    @endif

    {{-- Pilihan (PG & benar_salah) --}}
    @if($loop_soal->jenis_soal !== 'essay')
        @if($loop_soal->pilihan->isNotEmpty())
        <div class="pilihan-list">
            @foreach($loop_soal->pilihan as $p)
            <div class="pilihan-row">
                <div class="pilihan-kode-cell">
                    <span class="pilihan-kode {{ $p->adalah_benar ? 'benar' : '' }}">
                        {{ $p->kode_pilihan }}
                    </span>
                </div>
                <div class="pilihan-teks-cell">
                    <div class="pilihan-teks">{{ $p->teks_pilihan }}</div>
                    @if($p->gambar_pilihan)
                    <img src="{{ storage_path('app/public/' . $p->gambar_pilihan) }}"
                         class="pilihan-gambar"
                         alt="Gambar pilihan {{ $p->kode_pilihan }}">
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="font-size:10.5px;color:#f59e0b;margin-left:30px;margin-top:6px;">
            ⚠ Soal ini belum memiliki pilihan jawaban.
        </p>
        @endif
    @else
        {{-- Essay: kotak kosong untuk jawaban tulis tangan --}}
        <div class="essay-box"></div>
    @endif

</div>
@endforeach

{{--
    Script nomor halaman DomPDF:
    DomPDF mendukung inline script PHP jika setOption('isPhpEnabled', true)
    diset di controller — namun ini risiko keamanan.
    Cara aman: gunakan canvas callback di DomPDF v2 atau cukup
    tampilkan total soal saja tanpa nomor halaman dinamis.

    Jika isPhpEnabled diaktifkan, ganti span.dompdf-page-counter dengan:
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->getFont("DejaVu Sans", "normal");
                $pdf->text(740, 810, "Hal. " . $PAGE_NUM . " / " . $PAGE_COUNT, $font, 9, [0.58, 0.63, 0.69]);
            ');
        }
    </script>

    Karena isPhpEnabled biasanya off, kita hilangkan nomor halaman dinamis
    dan cukup tampilkan info statis di footer.
--}}

</body>
</html>