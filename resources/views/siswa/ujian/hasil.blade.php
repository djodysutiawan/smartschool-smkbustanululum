<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:#cbd5e1}.breadcrumb .current{color:var(--text2)}
    /* ── Hero hasil ── */
    .hasil-hero{border-radius:var(--radius);padding:32px;margin-bottom:20px;text-align:center}
    .hasil-hero.lulus{background:linear-gradient(135deg,#14532d 0%,#15803d 100%)}
    .hasil-hero.tidak-lulus{background:linear-gradient(135deg,#7f1d1d 0%,#dc2626 100%)}
    .hasil-hero.habis-waktu{background:linear-gradient(135deg,#78350f 0%,#d97706 100%)}
    .hasil-icon{width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:32px}
    .hasil-status{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:rgba(255,255,255,.8);letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px}
    .hasil-nilai{font-family:'Plus Jakarta Sans',sans-serif;font-size:56px;font-weight:800;color:#fff;line-height:1;margin-bottom:8px}
    .hasil-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:rgba(255,255,255,.9)}
    /* ── Stat strip ── */
    .stat-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}.stat-icon.red{background:#fff0f0}.stat-icon.gray{background:var(--surface3)}.stat-icon.blue{background:var(--brand-50)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    /* ── Pembahasan ── */
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .section-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .soal-review-item{padding:20px 24px;border-bottom:1px solid var(--border)}
    .soal-review-item:last-child{border-bottom:none}
    .soal-review-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
    .soal-review-nomor{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .soal-review-pertanyaan{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);line-height:1.6;margin-bottom:14px;white-space:pre-wrap}
    .pilihan-review{display:flex;flex-direction:column;gap:8px}
    .pilihan-review-item{display:flex;align-items:flex-start;gap:10px;padding:10px 14px;border-radius:var(--radius-sm);border:1.5px solid var(--border)}
    .pr-benar{background:#f0fdf4;border-color:#bbf7d0}
    .pr-salah-pilih{background:#fff0f0;border-color:#fecaca}
    .pr-normal{background:var(--surface);border-color:var(--border)}
    .pilihan-review-kode{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;flex-shrink:0}
    .pkode-benar{background:#15803d;color:#fff}
    .pkode-salah{background:#dc2626;color:#fff}
    .pkode-normal{background:var(--surface3);color:var(--text3)}
    .pilihan-review-teks{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);padding-top:3px;line-height:1.5}
    .pr-benar .pilihan-review-teks{color:#15803d;font-weight:600}
    .pr-salah-pilih .pilihan-review-teks{color:#dc2626}
    .essay-display{background:var(--surface3);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.6;white-space:pre-wrap}
    .badge-hasil{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .bh-benar{background:#dcfce7;color:#15803d}
    .bh-salah{background:#fee2e2;color:#dc2626}
    .bh-kosong{background:var(--surface3);color:var(--text3)}
    .bh-essay{background:#dbeafe;color:#1d4ed8}
    /* ── Actions ── */
    .actions-bar{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-outline:hover{background:var(--surface2);filter:none}
    @media(max-width:640px){.stat-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('siswa.ujian.index') }}">Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('siswa.ujian.riwayat') }}">Riwayat</a>
        <span class="sep">›</span>
        <span class="current">Hasil Ujian</span>
    </nav>

    @php
        $lulus      = $sesi->lulus ?? false;
        $habisWkt   = $sesi->status === 'habis_waktu';
        $heroClass  = $habisWkt ? 'habis-waktu' : ($lulus ? 'lulus' : 'tidak-lulus');
        $nilaiAkhir = $sesi->nilai_akhir ?? 0;
    @endphp

    <div class="hasil-hero {{ $heroClass }}">
        <div class="hasil-icon">
            @if($habisWkt) ⏰
            @elseif($lulus) 🏆
            @else ❌
            @endif
        </div>
        <p class="hasil-status">
            @if($habisWkt) Waktu Habis
            @elseif($lulus) Selamat, Anda Lulus!
            @else Belum Lulus
            @endif
        </p>
        @if($tampilkanNilai)
        <p class="hasil-nilai">{{ number_format($nilaiAkhir, 1) }}</p>
        @if(isset($semuaSesi) && $semuaSesi->count() > 1)
        <p style="color:rgba(255,255,255,.8);font-family:'DM Sans',sans-serif;font-size:13px;margin-top:-4px;margin-bottom:4px">
            ★ Nilai Tertinggi dari {{ $semuaSesi->count() }} percobaan
        </p>
        @endif
        @endif
        <p class="hasil-judul">{{ $ujian->judul }}</p>
        @if($ujian->nilai_kkm && $tampilkanNilai)
        <p style="color:rgba(255,255,255,.75);font-family:'DM Sans',sans-serif;font-size:13px;margin-top:6px">KKM: {{ $ujian->nilai_kkm }}</p>
        @endif
    </div>

    <div class="stat-strip">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <p class="stat-label">Benar</p>
                <p class="stat-val" style="color:#15803d">{{ $sesi->total_benar ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </div>
            <div>
                <p class="stat-label">Salah</p>
                <p class="stat-val" style="color:#dc2626">{{ $sesi->total_salah ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gray">
                <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Kosong</p>
                <p class="stat-val">{{ $sesi->total_kosong ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Durasi</p>
                <p class="stat-val" style="font-size:16px">
                    @if($sesi->mulai_pada && $sesi->selesai_pada)
                        {{ gmdate('i:s', $sesi->mulai_pada->diffInSeconds($sesi->selesai_pada)) }}
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- ── Riwayat semua percobaan (hanya tampil jika >1 percobaan) ── --}}
    @if(isset($semuaSesi) && $semuaSesi->count() > 1)
    <div class="section-card" style="margin-bottom:20px">
        <div class="section-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3"/></svg>
            <span class="section-title">Riwayat Percobaan</span>
            <span style="margin-left:auto;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3)">Nilai yang dipakai: nilai tertinggi</span>
        </div>
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-family:'DM Sans',sans-serif;font-size:13.5px">
                <thead>
                    <tr style="background:var(--surface2)">
                        <th style="padding:10px 20px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)">Percobaan</th>
                        <th style="padding:10px 16px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)">Nilai</th>
                        <th style="padding:10px 16px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)">Benar</th>
                        <th style="padding:10px 16px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)">Salah</th>
                        <th style="padding:10px 16px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)">Kosong</th>
                        <th style="padding:10px 16px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)">Status</th>
                        <th style="padding:10px 20px;text-align:right;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)">Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaSesi as $i => $s)
                    @php $isBest = $s->id === $sesi->id; @endphp
                    <tr style="{{ $isBest ? 'background:#f0fdf4;' : '' }}border-bottom:1px solid var(--border)">
                        <td style="padding:12px 20px;color:var(--text2)">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text)">Percobaan {{ $i + 1 }}</span>
                            @if($isBest)
                                <span style="margin-left:8px;display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:99px;background:#dcfce7;color:#15803d;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700">
                                    🏆 Terbaik
                                </span>
                            @endif
                        </td>
                        <td style="padding:12px 16px;text-align:center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:{{ $isBest ? '#15803d' : 'var(--text)' }}">
                                {{ number_format($s->nilai_akhir, 1) }}
                            </span>
                        </td>
                        <td style="padding:12px 16px;text-align:center;color:#15803d;font-weight:700">{{ $s->total_benar }}</td>
                        <td style="padding:12px 16px;text-align:center;color:#dc2626;font-weight:700">{{ $s->total_salah }}</td>
                        <td style="padding:12px 16px;text-align:center;color:var(--text3);font-weight:600">{{ $s->total_kosong }}</td>
                        <td style="padding:12px 16px;text-align:center">
                            @if($s->lulus)
                                <span style="padding:2px 10px;border-radius:99px;background:#dcfce7;color:#15803d;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700">Lulus</span>
                            @else
                                <span style="padding:2px 10px;border-radius:99px;background:#fee2e2;color:#dc2626;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700">Belum Lulus</span>
                            @endif
                            @if($s->status === 'habis_waktu')
                                <span style="margin-left:4px;padding:2px 8px;border-radius:99px;background:#fff3cd;color:#a16207;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700">⏰ Habis Waktu</span>
                            @endif
                        </td>
                        <td style="padding:12px 20px;text-align:right;color:var(--text3);font-size:12.5px">{{ $s->selesai_pada?->format('d/m/Y H:i') ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($tampilkanNilai && $soalList->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/></svg>
            <span class="section-title">Pembahasan Soal</span>
        </div>

        @foreach($soalList as $idx => $soal)
        @php
            $jawabanSiswa = $jawabanMap[$soal->id] ?? null;
            $adalahBenar  = $isBenarMap[$soal->id] ?? null;
            $isEssay      = $soal->isEssay();
            $isPilihan    = $soal->isPilihanGanda() || $soal->isBenarSalah();

            // Pilihan yg dipilih siswa (ID-based)
            $pilihanDipilihId = $jawabanSiswa['pilihan_jawaban_id'] ?? null;
            $essayDijawab     = $jawabanSiswa['jawaban_essay'] ?? null;

            if ($isEssay) {
                $badgeClass = 'bh-essay'; $badgeLabel = 'Essay';
            } elseif ($adalahBenar === true) {
                $badgeClass = 'bh-benar'; $badgeLabel = 'Benar';
            } elseif ($adalahBenar === false) {
                $badgeClass = 'bh-salah'; $badgeLabel = 'Salah';
            } else {
                $badgeClass = 'bh-kosong'; $badgeLabel = 'Kosong';
            }
        @endphp
        <div class="soal-review-item">
            <div class="soal-review-top">
                <span class="soal-review-nomor">Soal {{ $idx + 1 }} · Bobot {{ $soal->bobot }} poin</span>
                <span class="badge-hasil {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>

            @if($soal->gambar_soal)
                <img src="{{ asset('storage/'.$soal->gambar_soal) }}" alt="" style="max-width:100%;border-radius:6px;border:1px solid var(--border);margin-bottom:10px;display:block">
            @endif

            <div class="soal-review-pertanyaan">{!! nl2br(e($soal->pertanyaan)) !!}</div>

            @if($isPilihan)
            <div class="pilihan-review">
                @foreach($soal->pilihan as $p)
                @php
                    $dipilih   = $pilihanDipilihId !== null && (int)$pilihanDipilihId === (int)$p->id;
                    $isBenarP  = (bool)$p->adalah_benar;
                    $itemClass = $isBenarP ? 'pr-benar' : ($dipilih && !$isBenarP ? 'pr-salah-pilih' : 'pr-normal');
                    $kodeClass = $isBenarP ? 'pkode-benar' : ($dipilih && !$isBenarP ? 'pkode-salah' : 'pkode-normal');
                @endphp
                <div class="pilihan-review-item {{ $itemClass }}">
                    <div class="pilihan-review-kode {{ $kodeClass }}">{{ $p->kode_pilihan }}</div>
                    <div class="pilihan-review-teks">
                        {{ $p->teks_pilihan }}
                        @if($isBenarP)
                            <span style="margin-left:6px;font-size:11.5px;color:#15803d;font-weight:700">✓ Jawaban Benar</span>
                        @endif
                        @if($dipilih && !$isBenarP)
                            <span style="margin-left:6px;font-size:11.5px;color:#dc2626;font-weight:700">← Jawaban Anda</span>
                        @endif
                        @if($dipilih && $isBenarP)
                            <span style="margin-left:6px;font-size:11.5px;color:#15803d;font-weight:700">← Jawaban Anda</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @elseif($isEssay)
            <div>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em">Jawaban Anda:</p>
                <div class="essay-display">{{ $essayDijawab ?? '(tidak dijawab)' }}</div>
                <p style="font-size:12px;color:#1d4ed8;margin-top:8px;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:5px">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Soal essay akan dikoreksi oleh guru
                </p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @elseif(!$tampilkanNilai)
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:32px;text-align:center;margin-bottom:16px">
        <svg width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);margin-bottom:4px">Nilai belum ditampilkan</p>
        <p style="font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif">Guru belum mengizinkan tampilan nilai untuk ujian ini.</p>
    </div>
    @endif

    <div class="actions-bar">
        <a href="{{ route('siswa.ujian.index') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Ujian
        </a>
        <a href="{{ route('siswa.ujian.riwayat') }}" class="btn btn-outline">
            Lihat Semua Riwayat
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('info'))
        Swal.fire({icon:'info',title:'Info',text:@json(session('info')),confirmButtonColor:'#1f63db'});
    @endif
    @if(session('warning'))
        Swal.fire({icon:'warning',title:'Perhatian',text:@json(session('warning')),confirmButtonColor:'#1f63db'});
    @endif
</script>
</x-app-layout>