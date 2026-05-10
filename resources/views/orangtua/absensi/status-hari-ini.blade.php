<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#0f766e;--brand-50:#f0fdfa;--brand-100:#ccfbf1;--brand-600:#0d9488;--brand-700:#0f766e;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --hadir:#dcfce7;--hadir-text:#15803d;--hadir-border:#bbf7d0;
        --telat:#fff3cd;--telat-text:#a16207;--telat-border:#fde68a;
        --izin:#dbeafe;--izin-text:#1d4ed8;--izin-border:#bfdbfe;
        --sakit:#fce7f3;--sakit-text:#be185d;--sakit-border:#fbcfe8;
        --alfa:#fee2e2;--alfa-text:#dc2626;--alfa-border:#fecaca;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1200px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:13px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Selector anak */
    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .anak-avatar{width:24px;height:24px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    /* Hero grid */
    .hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px}
    .hero-card{border-radius:var(--radius);padding:24px 28px;position:relative;overflow:hidden}
    .hero-card-hari{background:linear-gradient(135deg,var(--brand-700) 0%,#0d9488 100%);color:#fff}
    .hero-card-status{background:var(--surface);border:1px solid var(--border)}
    .hero-deco{position:absolute;right:-20px;bottom:-20px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.07)}
    .hero-deco2{position:absolute;right:60px;bottom:-50px;width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,.05)}
    .hc-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;margin-bottom:8px;opacity:.75}
    .hc-label-dark{color:var(--text3);opacity:1}
    .hc-value{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;line-height:1.1}
    .hc-sub{font-size:13px;opacity:.8;margin-top:6px;font-family:'DM Sans',sans-serif}
    .hc-anak{font-size:12px;font-weight:600;opacity:.7;margin-top:10px;display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif}

    /* Status display */
    .status-display{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:120px;gap:10px;padding:8px 0}
    .status-icon-big{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:26px}
    .status-label-big{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800}
    .status-sub{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3)}

    .s-hadir .status-icon-big{background:var(--hadir)} .s-hadir .status-label-big{color:var(--hadir-text)}
    .s-telat .status-icon-big{background:var(--telat)} .s-telat .status-label-big{color:var(--telat-text)}
    .s-izin  .status-icon-big{background:var(--izin)}  .s-izin  .status-label-big{color:var(--izin-text)}
    .s-sakit .status-icon-big{background:var(--sakit)} .s-sakit .status-label-big{color:var(--sakit-text)}
    .s-alfa  .status-icon-big{background:var(--alfa)}  .s-alfa  .status-label-big{color:var(--alfa-text)}
    .s-belum .status-icon-big{background:var(--surface3)} .s-belum .status-label-big{color:var(--text3)}

    /* Section card */
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .section-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}

    /* Detail rows */
    .detail-row{display:flex;align-items:flex-start;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border)}
    .detail-row:last-child{border-bottom:none}
    .dr-label{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3);min-width:130px;padding-right:12px}
    .dr-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text);text-align:right;word-break:break-word;max-width:280px}

    /* Absensi per-mapel table */
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafffe}
    td{padding:11px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .b-hadir{background:var(--hadir);color:var(--hadir-text)}
    .b-telat{background:var(--telat);color:var(--telat-text)}
    .b-izin{background:var(--izin);color:var(--izin-text)}
    .b-sakit{background:var(--sakit);color:var(--sakit-text)}
    .b-alfa{background:var(--alfa);color:var(--alfa-text)}

    /* Rekap mini strip */
    .rekap-mini{display:flex;gap:10px;flex-wrap:wrap;padding:16px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .rm-item{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .rm-dot{width:10px;height:10px;border-radius:50%}
    .rm-count{font-size:16px;font-weight:800}

    /* Empty */
    .empty-box{background:var(--surface2);border:1.5px dashed var(--border2);border-radius:var(--radius);padding:48px 20px;text-align:center;margin-bottom:16px}
    .empty-icon{font-size:40px;margin-bottom:12px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif;line-height:1.6}

    /* Quick nav */
    .quick-nav{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}
    .qn-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none;transition:filter .15s}
    .qn-btn:hover{filter:brightness(.93)}
    .qn-primary{background:var(--brand-700);color:#fff}
    .qn-outline{background:var(--surface);color:var(--text2);border:1.5px solid var(--border)}
    .qn-outline:hover{background:var(--surface2);filter:none}

    @media(max-width:640px){.page{padding:16px}.hero-grid{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Status Kehadiran Hari Ini</h1>
            <p class="page-sub">Pantau kehadiran anak Anda di kelas secara real-time</p>
        </div>
        <a href="{{ route('ortu.absensi.riwayat', ['siswa_id' => $anak->id]) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);background:var(--surface2);color:var(--text2);border:1.5px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Riwayat Kehadiran
        </a>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.absensi.status-hari-ini', ['siswa_id' => $a->id]) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
        </a>
        @endforeach
    </div>
    @endif

    @php
        // Gunakan $absensiHariIni (collection) — tentukan status dominan untuk hero card
        // Prioritas: alfa > sakit > izin > telat > hadir > belum
        $prioritas   = ['alfa' => 5, 'sakit' => 4, 'izin' => 3, 'telat' => 2, 'hadir' => 1];
        $statusDominan = 'belum';
        if ($absensiHariIni->isNotEmpty()) {
            $statusDominan = $absensiHariIni
                ->sortByDesc(fn($a) => $prioritas[$a->status] ?? 0)
                ->first()->status;
        }
        $statusEmoji = [
            'hadir' => '✅', 'telat' => '⏰',
            'izin'  => '📋', 'sakit' => '🤒',
            'alfa'  => '❌', 'belum' => '❓',
        ][$statusDominan] ?? '❓';
        $statusLabel = [
            'hadir' => 'Hadir',   'telat' => 'Telat',
            'izin'  => 'Izin',    'sakit' => 'Sakit',
            'alfa'  => 'Alfa',    'belum' => 'Belum Tercatat',
        ][$statusDominan] ?? '—';

        // Rekap per status hari ini
        $rekapHariIni = [
            'hadir' => $absensiHariIni->whereIn('status', ['hadir','telat'])->count(),
            'izin'  => $absensiHariIni->where('status', 'izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'sakit')->count(),
            'alfa'  => $absensiHariIni->where('status', 'alfa')->count(),
        ];

        // Jam masuk pertama yang tercatat hari ini
        $jamMasukPertama = $absensiHariIni->whereNotNull('jam_masuk')->sortBy('jam_masuk')->first()?->jam_masuk;
    @endphp

    {{-- Hero grid --}}
    <div class="hero-grid">
        <div class="hero-card hero-card-hari">
            <div class="hero-deco"></div>
            <div class="hero-deco2"></div>
            <p class="hc-label">Hari Ini</p>
            <p class="hc-value">{{ now()->translatedFormat('l') }}</p>
            <p class="hc-sub">{{ now()->translatedFormat('d F Y') }}</p>
            <p class="hc-anak">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                {{ $anak->nama_lengkap }}
                @if($anak->kelas)
                    &mdash; {{ $anak->kelas->nama_kelas ?? $anak->kelas->nama }}
                @endif
            </p>
        </div>

        <div class="hero-card hero-card-status">
            <p class="hc-label hc-label-dark">Status Dominan Hari Ini</p>
            <div class="status-display s-{{ $statusDominan }}">
                <div class="status-icon-big">{{ $statusEmoji }}</div>
                <div class="status-label-big">{{ $statusLabel }}</div>
                @if($jamMasukPertama)
                    <div class="status-sub">Jam masuk: {{ \Carbon\Carbon::parse($jamMasukPertama)->format('H:i') }} WIB</div>
                @elseif($absensiHariIni->isNotEmpty())
                    <div class="status-sub">{{ $absensiHariIni->count() }} catatan absensi hari ini</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Jika ada absensi --}}
    @if($absensiHariIni->isNotEmpty())

    {{-- Rekap mini + tabel per mapel --}}
    <div class="section-card">
        <div class="section-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span class="section-title">Absensi Per Mata Pelajaran — Hari Ini ({{ $absensiHariIni->count() }} sesi)</span>
        </div>

        {{-- Rekap mini --}}
        <div class="rekap-mini">
            @if($rekapHariIni['hadir'] > 0)
            <div class="rm-item">
                <div class="rm-dot" style="background:var(--hadir-text)"></div>
                <span style="color:var(--text3)">Hadir/Telat</span>
                <span class="rm-count" style="color:var(--hadir-text)">{{ $rekapHariIni['hadir'] }}</span>
            </div>
            @endif
            @if($rekapHariIni['izin'] > 0)
            <div class="rm-item">
                <div class="rm-dot" style="background:var(--izin-text)"></div>
                <span style="color:var(--text3)">Izin</span>
                <span class="rm-count" style="color:var(--izin-text)">{{ $rekapHariIni['izin'] }}</span>
            </div>
            @endif
            @if($rekapHariIni['sakit'] > 0)
            <div class="rm-item">
                <div class="rm-dot" style="background:var(--sakit-text)"></div>
                <span style="color:var(--text3)">Sakit</span>
                <span class="rm-count" style="color:var(--sakit-text)">{{ $rekapHariIni['sakit'] }}</span>
            </div>
            @endif
            @if($rekapHariIni['alfa'] > 0)
            <div class="rm-item">
                <div class="rm-dot" style="background:var(--alfa-text)"></div>
                <span style="color:var(--text3)">Alfa</span>
                <span class="rm-count" style="color:var(--alfa-text)">{{ $rekapHariIni['alfa'] }}</span>
            </div>
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th class="center">Status</th>
                        <th>Jam Masuk</th>
                        <th>Metode</th>
                        <th>Dicatat Oleh</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensiHariIni as $ab)
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">
                            {{ $ab->jadwalPelajaran?->mataPelajaran?->nama_mapel ?? '—' }}
                            @if($ab->jadwalPelajaran)
                                <div style="font-weight:400;font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:2px">
                                    {{ $ab->jadwalPelajaran->jam_mulai ?? '' }}
                                    @if($ab->jadwalPelajaran->jam_mulai && $ab->jadwalPelajaran->jam_selesai)
                                        – {{ $ab->jadwalPelajaran->jam_selesai }}
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="center">
                            <span class="badge b-{{ $ab->status }}">{{ $ab->label_status }}</span>
                        </td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;color:var(--text)">
                            {{ $ab->jam_masuk ? \Carbon\Carbon::parse($ab->jam_masuk)->format('H:i') : '—' }}
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)">
                            {{ $ab->label_metode ?? '—' }}
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)">
                            {{ $ab->dicatatOleh?->name ?? '—' }}
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);max-width:200px">
                            @if($ab->keterangan)
                                {{ $ab->keterangan }}
                            @elseif($ab->path_surat_izin)
                                {{-- PERBAIKAN: accessor yang benar adalah path_surat_izin_url --}}
                                <a href="{{ $ab->path_surat_izin_url }}" target="_blank"
                                   style="color:var(--brand-700);font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;text-decoration:none">
                                    Lihat Surat →
                                </a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @else

    <div class="empty-box">
        <div class="empty-icon">📅</div>
        <p class="empty-title">Belum ada data absensi hari ini</p>
        <p class="empty-sub">
            Data kehadiran {{ $anak->nama_lengkap }}<br>
            pada {{ now()->translatedFormat('l, d F Y') }} belum tercatat di sistem.
        </p>
    </div>

    @endif

    {{-- Quick nav --}}
    <div class="quick-nav">
        <a href="{{ route('ortu.absensi.riwayat', ['siswa_id' => $anak->id]) }}" class="qn-btn qn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Riwayat Kehadiran
        </a>
        <a href="{{ route('ortu.absensi.rekap', ['siswa_id' => $anak->id]) }}" class="qn-btn qn-outline">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Rekap Bulanan
        </a>
        <a href="{{ route('ortu.kehadiran-gerbang.status-hari-ini', ['siswa_id' => $anak->id]) }}" class="qn-btn qn-outline">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Status Gerbang
        </a>
    </div>
</div>
</x-app-layout>