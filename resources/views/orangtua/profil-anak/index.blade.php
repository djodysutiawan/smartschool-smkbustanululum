<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:1200px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .anak-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px}
    .anak-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s,transform .15s;text-decoration:none;display:block}
    .anak-card:hover{box-shadow:0 4px 20px rgba(31,99,219,.1);transform:translateY(-2px)}
    .anak-card-top{padding:24px 22px;display:flex;align-items:center;gap:16px}
    .anak-avatar-big{width:62px;height:62px;border-radius:16px;background:linear-gradient(135deg,var(--brand) 0%,#3b82f6 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;flex-shrink:0}
    .anak-nama{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--text);margin-bottom:4px}
    .anak-nisn{font-size:12px;color:var(--text3)}
    .anak-kelas-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--brand-700);margin-top:6px}
    .anak-stats{display:grid;grid-template-columns:repeat(3,1fr);border-top:1px solid var(--border)}
    .anak-stat{padding:12px 0;text-align:center;border-right:1px solid var(--border)}
    .anak-stat:last-child{border-right:none}
    .as-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text)}
    .as-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:600;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-top:2px}
    .anak-card-footer{padding:12px 20px;background:var(--surface2);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
    .footer-link{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--brand);display:flex;align-items:center;gap:4px}
    .empty-state{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:80px 20px;text-align:center}
    .empty-icon{width:64px;height:64px;background:var(--brand-50);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--text);margin-bottom:6px}
    .empty-sub{font-size:13px;color:var(--text3)}
    @media(max-width:640px){.page{padding:16px}.anak-grid{grid-template-columns:1fr}}
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
            <svg width="28" height="28" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
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
        @endphp
        <a href="{{ route('ortu.profil-anak.show', $anak->id) }}" class="anak-card">
            <div class="anak-card-top">
                <div class="anak-avatar-big">{{ $inisial }}</div>
                <div>
                    <p class="anak-nama">{{ $anak->nama_lengkap }}</p>
                    <p class="anak-nisn">NIS: {{ $anak->nis ?? '—' }} · NISN: {{ $anak->nisn ?? '—' }}</p>
                    <span class="anak-kelas-chip">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        {{-- Sesuaikan dengan nama kolom kelas di model Kelas --}}
                        {{ $anak->kelas->nama_kelas ?? $anak->kelas->nama ?? '—' }}
                    </span>
                </div>
            </div>
            <div class="anak-stats">
                <div class="anak-stat">
                    <p class="as-val" style="color:#15803d">{{ $anak->total_absensi_bulan_ini ?? 0 }}</p>
                    <p class="as-label">Hadir Bulan Ini</p>
                </div>
                <div class="anak-stat">
                    <p class="as-val">{{ $anak->rata_rata_nilai ? number_format($anak->rata_rata_nilai, 1) : '—' }}</p>
                    <p class="as-label">Rata-rata Nilai</p>
                </div>
                <div class="anak-stat">
                    <p class="as-val" style="{{ ($anak->total_pelanggaran_tahun_ini ?? 0) > 0 ? 'color:#dc2626' : '' }}">
                        {{ $anak->total_pelanggaran_tahun_ini ?? 0 }}
                    </p>
                    <p class="as-label">Pelanggaran</p>
                </div>
            </div>
            <div class="anak-card-footer">
                <span class="footer-link">
                    Lihat Detail Profil
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </span>
                <span style="font-size:11.5px;color:var(--text3)">
                    {{ $anak->jenis_kelamin === 'L' ? '👦 Laki-laki' : '👧 Perempuan' }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
</x-app-layout>