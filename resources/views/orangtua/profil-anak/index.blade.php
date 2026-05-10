<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand: #1f63db;
        --brand-50: #eef6ff;
        --brand-100: #d9ebff;
        --brand-700: #1750c0;
        --surface: #fff;
        --surface2: #f8fafc;
        --surface3: #f1f5f9;
        --border: #e2e8f0;
        --border2: #cbd5e1;
        --text: #0f172a;
        --text2: #475569;
        --text3: #94a3b8;
        --radius: 12px;
        --radius-sm: 8px;
        --green: #15803d;
        --green-bg: #f0fdf4;
        --red: #dc2626;
        --red-bg: #fff0f0;
    }

    .page { padding: 28px 28px 64px; max-width: 1200px; margin: 0 auto; }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .page-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.3px;
    }
    .page-sub { font-size: 13px; color: var(--text3); margin-top: 4px; }

    /* Grid */
    .anak-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 18px;
    }

    /* Card */
    .anak-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s, transform .18s, border-color .18s;
    }
    .anak-card:hover {
        box-shadow: 0 6px 28px rgba(31,99,219,.12);
        transform: translateY(-3px);
        border-color: var(--brand-100);
    }

    .anak-card-top {
        padding: 22px 22px 18px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .anak-avatar {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--brand) 0%, #3b82f6 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px;
        font-weight: 800;
        flex-shrink: 0;
        letter-spacing: -.5px;
    }
    .anak-avatar.perempuan {
        background: linear-gradient(135deg, #db2777 0%, #f472b6 100%);
    }

    .anak-info { flex: 1; min-width: 0; }
    .anak-nama {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 800;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 3px;
    }
    .anak-meta { font-size: 12px; color: var(--text3); margin-bottom: 8px; }
    .anak-kelas-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        background: var(--brand-50);
        border: 1px solid var(--brand-100);
        border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        color: var(--brand-700);
    }

    /* Stats bar */
    .anak-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-top: 1px solid var(--border);
    }
    .anak-stat {
        padding: 13px 8px;
        text-align: center;
        border-right: 1px solid var(--border);
    }
    .anak-stat:last-child { border-right: none; }
    .as-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
    }
    .as-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 600;
        color: var(--text3);
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-top: 3px;
    }

    /* Footer */
    .anak-card-footer {
        padding: 11px 20px;
        background: var(--surface2);
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
    }
    .footer-cta {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--brand);
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .footer-gender {
        font-size: 12px;
        color: var(--text3);
    }

    /* Empty state */
    .empty-state {
        background: var(--surface);
        border: 1px dashed var(--border2);
        border-radius: var(--radius);
        padding: 80px 20px;
        text-align: center;
    }
    .empty-icon {
        width: 64px;
        height: 64px;
        background: var(--brand-50);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .empty-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 16px;
        color: var(--text);
        margin-bottom: 8px;
    }
    .empty-sub { font-size: 13.5px; color: var(--text3); max-width: 360px; margin: 0 auto; line-height: 1.6; }

    @media (max-width: 640px) {
        .page { padding: 16px 16px 48px; }
        .anak-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Profil Anak</h1>
            <p class="page-sub">Data dan ringkasan perkembangan anak Anda</p>
        </div>
    </div>

    @if($anakList->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <p class="empty-title">Belum ada data anak</p>
            <p class="empty-sub">Akun Anda belum terhubung dengan data siswa. Hubungi pihak sekolah untuk menghubungkan akun.</p>
        </div>
    @else
        <div class="anak-grid">
            @foreach($anakList as $anak)
                @php
                    $inisial = collect(explode(' ', $anak->nama_lengkap))
                        ->map(fn($w) => strtoupper($w[0] ?? ''))
                        ->filter()
                        ->take(2)
                        ->implode('');
                    $isPerempuan = $anak->jenis_kelamin !== 'L';
                    $namaKelas = $anak->kelas->nama_kelas ?? $anak->kelas->nama ?? '—';
                    $adaPelanggaran = ($anak->total_pelanggaran_tahun_ini ?? 0) > 0;
                @endphp
                <a href="{{ route('ortu.profil-anak.show', $anak->id) }}" class="anak-card">
                    <div class="anak-card-top">
                        <div class="anak-avatar {{ $isPerempuan ? 'perempuan' : '' }}">{{ $inisial }}</div>
                        <div class="anak-info">
                            <p class="anak-nama">{{ $anak->nama_lengkap }}</p>
                            <p class="anak-meta">
                                NIS: {{ $anak->nis ?? '—' }}
                                @if($anak->nisn) · NISN: {{ $anak->nisn }} @endif
                            </p>
                            <span class="anak-kelas-chip">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                </svg>
                                {{ $namaKelas }}
                            </span>
                        </div>
                    </div>

                    <div class="anak-stats">
                        <div class="anak-stat">
                            <p class="as-val" style="color: #15803d">{{ $anak->total_absensi_bulan_ini ?? 0 }}</p>
                            <p class="as-label">Hadir Bln Ini</p>
                        </div>
                        <div class="anak-stat">
                            <p class="as-val">
                                {{ $anak->rata_rata_nilai ? number_format($anak->rata_rata_nilai, 1) : '—' }}
                            </p>
                            <p class="as-label">Rata-rata Nilai</p>
                        </div>
                        <div class="anak-stat">
                            <p class="as-val" style="{{ $adaPelanggaran ? 'color:#dc2626' : '' }}">
                                {{ $anak->total_pelanggaran_tahun_ini ?? 0 }}
                            </p>
                            <p class="as-label">Pelanggaran</p>
                        </div>
                    </div>

                    <div class="anak-card-footer">
                        <span class="footer-cta">
                            Lihat Detail
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </span>
                        <span class="footer-gender">
                            {{ $isPerempuan ? '👧 Perempuan' : '👦 Laki-laki' }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>