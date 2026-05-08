<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Mono:wght@400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap');

/*
 * View  : admin.ujian.soal.koreksi-essay
 * Route : GET  admin/ujian/{ujian}/soal/{soal}/koreksi-essay
 *         POST admin/ujian/{ujian}/soal/{soal}/koreksi-essay/{jawaban}
 * Ctrl  : SoalUjianController@koreksiEssayIndex / @koreksiEssayStore
 * Vars  : $ujian, $soal, $jawabans (Collection<JawabanSiswa> with sesi.siswa),
 *         $stats [total, sudah_koreksi, belum_koreksi]
 *
 * Koreksi diproses AJAX → controller mendukung expectsJson().
 * Response JSON: { message, poin_didapat, adalah_benar }
 * Validasi: poin_didapat required|numeric|min:0|max:{bobot}
 *           catatan_koreksi nullable|string|max:1000
 */

:root {
    --brand: #1f63db;
    --brand-h: #3582f0;
    --brand-50: #eef6ff;
    --brand-100: #dbeafe;

    --surface: #fff;
    --surface2: #f8fafc;
    --surface3: #f1f5f9;
    --border: #e2e8f0;
    --border2: #cbd5e1;

    --text: #0f172a;
    --text2: #475569;
    --text3: #94a3b8;

    --green: #15803d;
    --green-h: #16a34a;
    --green-bg: #dcfce7;
    --green-bd: #bbf7d0;
    --green-50: #f0fdf4;

    --amber: #b45309;
    --amber-bg: #fef3c7;
    --amber-bd: #fde68a;
    --amber-50: #fffbeb;

    --red: #dc2626;
    --red-bg: #fee2e2;
    --red-bd: #fecaca;

    --purple: #7c3aed;
    --purple-bg: #ede9fe;

    --radius: 12px;
    --radius-sm: 8px;
    --radius-xs: 5px;

    --shadow-sm: 0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.05);
    --shadow-md: 0 4px 16px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.05);
}

*, *::before, *::after { box-sizing: border-box; }

.page {
    padding: 28px 28px 72px;
    max-width: 1200px;
    margin: 0 auto;
}

/* ── Breadcrumb ── */
.breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; font-weight: 600; color: var(--text3);
    margin-bottom: 22px; flex-wrap: wrap;
}
.breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
.breadcrumb a:hover { color: var(--brand); }
.breadcrumb .sep { color: var(--border2); }
.breadcrumb .current { color: var(--text2); }

/* ── Page Header ── */
.page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 16px;
    margin-bottom: 24px; flex-wrap: wrap;
}
.page-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 21px; font-weight: 800; color: var(--text);
    letter-spacing: -.02em;
}
.page-sub { font-size: 13px; color: var(--text3); margin-top: 3px; }

.btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 16px; border-radius: var(--radius-sm);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    cursor: pointer; border: none; text-decoration: none;
    transition: filter .15s, background .15s, box-shadow .15s;
    white-space: nowrap;
}
.btn:hover { filter: brightness(.93); }
.btn-back {
    background: var(--surface2); color: var(--text2);
    border: 1px solid var(--border); box-shadow: var(--shadow-sm);
}
.btn-back:hover { background: var(--surface3); filter: none; }

/* ── Stats Bar ── */
.stats-bar {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px; margin-bottom: 24px;
}
.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 20px;
    box-shadow: var(--shadow-sm);
    display: flex; align-items: center; gap: 14px;
    transition: box-shadow .2s;
}
.stat-card:hover { box-shadow: var(--shadow-md); }
.stat-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon.total   { background: var(--brand-50);  color: var(--brand); }
.stat-icon.selesai { background: var(--green-bg);   color: var(--green); }
.stat-icon.pending { background: var(--amber-bg);   color: var(--amber); }
.stat-num {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 26px; font-weight: 800; color: var(--text);
    line-height: 1;
}
.stat-lbl {
    font-size: 11.5px; color: var(--text3);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 600; margin-top: 2px;
}

/* ── Progress Bar ── */
.progress-wrap {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 14px 20px;
    margin-bottom: 24px; box-shadow: var(--shadow-sm);
}
.progress-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 10px;
}
.progress-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px; font-weight: 700; color: var(--text2);
}
.progress-pct {
    font-family: 'DM Mono', monospace;
    font-size: 12.5px; font-weight: 500; color: var(--brand);
}
.progress-track {
    height: 8px; background: var(--surface3);
    border-radius: 99px; overflow: hidden;
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--green-h), #22c55e);
    border-radius: 99px;
    transition: width .6s cubic-bezier(.4,0,.2,1);
}

/* ── Soal Box (pertanyaan yang sedang dikoreksi) ── */
.soal-box {
    background: var(--brand-50);
    border: 1.5px solid var(--brand-100);
    border-radius: var(--radius);
    padding: 18px 22px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-sm);
}
.soal-box-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 10.5px; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: var(--brand);
    margin-bottom: 8px; display: flex; align-items: center; gap: 6px;
}
.soal-box-text {
    font-family: 'Lora', serif;
    font-size: 14px; line-height: 1.75; color: var(--text);
}
.soal-box-meta {
    display: flex; align-items: center; gap: 12px;
    margin-top: 12px; padding-top: 12px;
    border-top: 1px solid var(--brand-100);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11.5px; font-weight: 600; color: var(--text2);
}
.soal-box-meta .bobot-chip {
    background: var(--brand); color: #fff;
    padding: 3px 10px; border-radius: 99px;
    font-size: 11px; font-weight: 700;
}

/* ── Alert ── */
.alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: var(--radius-sm);
    margin-bottom: 20px; font-size: 13px;
}
.alert-success { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-bd); }
.alert-error   { background: var(--red-bg);   color: var(--red);   border: 1px solid var(--red-bd); }
.alert-warn    { background: var(--amber-bg);  color: var(--amber); border: 1px solid var(--amber-bd); }

/* ── Filter Tab ── */
.filter-tabs {
    display: flex; gap: 6px; margin-bottom: 16px;
}
.filter-tab {
    padding: 7px 14px; border-radius: var(--radius-xs);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px; font-weight: 700; cursor: pointer;
    border: 1.5px solid var(--border); background: var(--surface);
    color: var(--text3); transition: all .15s;
}
.filter-tab.active {
    background: var(--brand); color: #fff; border-color: var(--brand);
}
.filter-tab:hover:not(.active) {
    border-color: var(--brand-h); color: var(--brand);
    background: var(--brand-50);
}

/* ── Jawaban List ── */
.jawaban-list { display: flex; flex-direction: column; gap: 12px; }

/* ── Jawaban Card ── */
.jawaban-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: box-shadow .2s, border-color .2s;
}
.jawaban-card:hover { box-shadow: var(--shadow-md); }
.jawaban-card.sudah-koreksi { border-color: var(--green-bd); }
.jawaban-card.belum-koreksi { border-color: var(--amber-bd); }
.jawaban-card[data-hidden="true"] { display: none; }

/* Card Header */
.card-header {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px;
    background: var(--surface2);
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    user-select: none;
}
.card-header:hover { background: var(--surface3); }

.siswa-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: var(--brand); color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; letter-spacing: -.01em;
}
.jawaban-card.sudah-koreksi .siswa-avatar { background: var(--green-h); }
.jawaban-card.belum-koreksi .siswa-avatar { background: var(--amber); }

.siswa-info { flex: 1; min-width: 0; }
.siswa-nama {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px; font-weight: 700; color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.siswa-meta {
    font-size: 11.5px; color: var(--text3);
    font-family: 'Plus Jakarta Sans', sans-serif;
    margin-top: 1px;
}

.status-chip {
    padding: 4px 10px; border-radius: 99px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px; font-weight: 700; white-space: nowrap;
    flex-shrink: 0;
}
.chip-sudah { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-bd); }
.chip-belum { background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber-bd); }

.poin-display {
    font-family: 'DM Mono', monospace;
    font-size: 13px; font-weight: 500;
    color: var(--text2); flex-shrink: 0;
    padding: 0 8px;
}
.poin-display.has-poin { color: var(--green); font-weight: 600; }

.chevron {
    color: var(--text3); flex-shrink: 0;
    transition: transform .2s;
}
.jawaban-card.expanded .chevron { transform: rotate(180deg); }

/* Card Body */
.card-body {
    display: none;
    padding: 20px 20px 18px;
}
.jawaban-card.expanded .card-body { display: block; }

/* Jawaban teks siswa */
.jawaban-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 10.5px; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: var(--text3);
    margin-bottom: 8px;
}
.jawaban-text {
    font-family: 'Lora', serif;
    font-size: 13.5px; line-height: 1.8; color: var(--text);
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 14px 16px;
    min-height: 64px;
    white-space: pre-wrap;
    word-break: break-word;
}
.jawaban-text.kosong {
    color: var(--text3);
    font-style: italic;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
}

/* Koreksi Form */
.koreksi-form {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}
.koreksi-row {
    display: grid;
    grid-template-columns: 160px 1fr;
    gap: 12px; align-items: flex-start;
}
.field { display: flex; flex-direction: column; gap: 5px; }
.field label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; font-weight: 700; color: var(--text2);
}
.req { color: var(--brand); margin-left: 2px; }
.field input[type=number], .field textarea {
    padding: 9px 12px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: 'DM Mono', monospace;
    font-size: 14px; color: var(--text);
    background: var(--surface2); width: 100%; outline: none;
    transition: border-color .15s, background .15s, box-shadow .15s;
    -moz-appearance: textfield;
}
.field textarea {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; resize: vertical; min-height: 70px;
    line-height: 1.6;
}
.field input:focus, .field textarea:focus {
    border-color: var(--brand-h); background: #fff;
    box-shadow: 0 0 0 3px rgba(53,130,240,.12);
}
.field input.is-invalid, .field textarea.is-invalid {
    border-color: var(--red); background: #fff8f8;
}
.field-hint { font-size: 11.5px; color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; }
.field-error { font-size: 11.5px; color: var(--red); font-family: 'Plus Jakarta Sans', sans-serif; }

/* Poin slider visual */
.poin-track-wrap { margin-top: 6px; }
.poin-track {
    height: 6px; background: var(--surface3);
    border-radius: 99px; overflow: hidden; margin-bottom: 4px;
}
.poin-track-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--brand), var(--green-h));
    border-radius: 99px; width: 0%;
    transition: width .25s ease;
}
.poin-minmax {
    display: flex; justify-content: space-between;
    font-family: 'DM Mono', monospace;
    font-size: 10.5px; color: var(--text3);
}

/* Submit button per card */
.btn-koreksi {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 20px; border-radius: var(--radius-sm);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    background: var(--brand); color: #fff;
    border: none; cursor: pointer;
    transition: filter .15s; margin-top: 14px;
}
.btn-koreksi:hover { filter: brightness(.9); }
.btn-koreksi:disabled { opacity: .6; cursor: not-allowed; filter: none; }
.btn-koreksi.loading svg { animation: spin .7s linear infinite; }

/* Toast notifikasi */
#toast-wrap {
    position: fixed; bottom: 24px; right: 24px;
    display: flex; flex-direction: column; gap: 8px;
    z-index: 9999; pointer-events: none;
}
.toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: var(--radius-sm);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600;
    box-shadow: var(--shadow-md);
    pointer-events: auto;
    animation: slideInToast .25s ease;
}
.toast-success { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-bd); }
.toast-error   { background: var(--red-bg);   color: var(--red);   border: 1px solid var(--red-bd); }
@keyframes slideInToast {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Kosong state */
.empty-state {
    text-align: center; padding: 56px 24px;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); box-shadow: var(--shadow-sm);
}
.empty-icon { font-size: 40px; margin-bottom: 12px; }
.empty-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px; font-weight: 700; color: var(--text2);
}
.empty-sub { font-size: 13px; color: var(--text3); margin-top: 4px; }

/* Hasil koreksi sebelumnya (readonly) */
.koreksi-result {
    margin-top: 14px; padding: 12px 16px;
    background: var(--green-50);
    border: 1px solid var(--green-bd);
    border-radius: var(--radius-sm);
    display: flex; align-items: flex-start; gap: 12px;
}
.koreksi-result-poin {
    font-family: 'DM Mono', monospace;
    font-size: 22px; font-weight: 500;
    color: var(--green); line-height: 1; flex-shrink: 0;
}
.koreksi-result-detail { flex: 1; min-width: 0; }
.koreksi-result-lbl {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 10.5px; font-weight: 700; color: var(--green);
    text-transform: uppercase; letter-spacing: .06em;
}
.koreksi-result-catatan {
    font-size: 13px; color: var(--text2);
    margin-top: 4px; font-style: italic;
    font-family: 'Lora', serif;
    line-height: 1.6;
}
.btn-edit-koreksi {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; font-weight: 700;
    color: var(--brand); background: none; border: none;
    cursor: pointer; padding: 0; text-decoration: underline;
    text-underline-offset: 2px; margin-top: 6px; display: inline-block;
}
.btn-edit-koreksi:hover { color: var(--brand-h); }

@media(max-width: 720px) {
    .page { padding: 16px 16px 64px; }
    .stats-bar { grid-template-columns: 1fr; gap: 8px; }
    .koreksi-row { grid-template-columns: 1fr; }
    .filter-tabs { flex-wrap: wrap; }
}
</style>

<div class="page">

    {{-- ── Breadcrumb ── --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.index') }}">Data Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 25) }}</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.soal.index', $ujian) }}">Bank Soal</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.soal.show', [$ujian, $soal]) }}">Soal #{{ $soal->nomor_soal }}</a>
        <span class="sep">›</span>
        <span class="current">Koreksi Essay</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Koreksi Essay</h1>
            <p class="page-sub">Soal #{{ $soal->nomor_soal }} &nbsp;·&nbsp; {{ Str::limit($ujian->judul, 40) }}</p>
        </div>
        <a href="{{ route('admin.ujian.soal.index', $ujian) }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Bank Soal
        </a>
    </div>

    {{-- Flash message (fallback non-AJAX) --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Stats Bar ── --}}
    {{--
        $stats dari controller:
          total         = $jawabans->count()
          sudah_koreksi = $jawabans->whereNotNull('poin_didapat')->count()
          belum_koreksi = $jawabans->whereNull('poin_didapat')->count()
    --}}
    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-icon total">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="stat-num" id="statTotal">{{ $stats['total'] }}</div>
                <div class="stat-lbl">Total Jawaban</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon selesai">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div class="stat-num" id="statSudah" style="color:var(--green)">{{ $stats['sudah_koreksi'] }}</div>
                <div class="stat-lbl">Sudah Dikoreksi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="stat-num" id="statBelum" style="color:var(--amber)">{{ $stats['belum_koreksi'] }}</div>
                <div class="stat-lbl">Belum Dikoreksi</div>
            </div>
        </div>
    </div>

    {{-- ── Progress Bar ── --}}
    @php
        $pct = $stats['total'] > 0
            ? round($stats['sudah_koreksi'] / $stats['total'] * 100)
            : 0;
    @endphp
    <div class="progress-wrap">
        <div class="progress-header">
            <span class="progress-title">Progress Koreksi</span>
            <span class="progress-pct" id="progressPct">{{ $pct }}%</span>
        </div>
        <div class="progress-track">
            <div class="progress-fill" id="progressFill" style="width:{{ $pct }}%"></div>
        </div>
    </div>

    {{-- ── Soal Box ── --}}
    <div class="soal-box">
        <div class="soal-box-label">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Soal #{{ $soal->nomor_soal }} — Essay
        </div>
        <div class="soal-box-text">{{ $soal->pertanyaan }}</div>
        @if($soal->gambar_soal)
        <img src="{{ asset('storage/' . $soal->gambar_soal) }}"
             style="max-width:280px;max-height:160px;border-radius:6px;border:1px solid var(--brand-100);margin-top:10px;display:block;"
             alt="Gambar soal">
        @endif
        <div class="soal-box-meta">
            <span class="bobot-chip">Bobot Maks: {{ $soal->bobot }} poin</span>
            <span>Nilai min 0 — maks {{ $soal->bobot }}</span>
        </div>
    </div>

    {{-- ── Filter Tabs ── --}}
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterJawaban('semua', this)">
            Semua ({{ $stats['total'] }})
        </button>
        <button class="filter-tab" onclick="filterJawaban('belum', this)">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Belum Dikoreksi ({{ $stats['belum_koreksi'] }})
        </button>
        <button class="filter-tab" onclick="filterJawaban('sudah', this)">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Sudah Dikoreksi ({{ $stats['sudah_koreksi'] }})
        </button>
    </div>

    {{-- ── Daftar Jawaban ── --}}
    @if($jawabans->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <div class="empty-title">Belum ada jawaban</div>
        <div class="empty-sub">Belum ada siswa yang mengumpulkan ujian ini.</div>
    </div>
    @else

    <div class="jawaban-list" id="jawabanList">
        @foreach($jawabans as $jawaban)
        @php
            /*
             * $jawaban = JawabanSiswa dengan relasi:
             *   sesi  → SesiUjian (status: selesai|habis_waktu)
             *   siswa → (melalui sesi.siswa)
             * Field penting:
             *   $jawaban->jawaban_essay    → teks jawaban siswa
             *   $jawaban->poin_didapat     → null jika belum dikoreksi
             *   $jawaban->catatan_koreksi  → nullable
             *   $jawaban->adalah_benar     → bool (di-set oleh koreksiEssay())
             */
            $sudahKoreksi = !is_null($jawaban->poin_didapat);
            $siswa        = $jawaban->sesi->siswa;
            $inisial      = collect(explode(' ', $siswa->nama ?? 'S'))
                                ->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
        @endphp

        <div class="jawaban-card {{ $sudahKoreksi ? 'sudah-koreksi' : 'belum-koreksi' }}"
             id="card_{{ $jawaban->id }}"
             data-status="{{ $sudahKoreksi ? 'sudah' : 'belum' }}">

            {{-- ── Card Header (klik untuk expand) ── --}}
            <div class="card-header" onclick="toggleCard({{ $jawaban->id }})">
                <div class="siswa-avatar">{{ $inisial }}</div>
                <div class="siswa-info">
                    <div class="siswa-nama">{{ $siswa->nama ?? 'Siswa tidak ditemukan' }}</div>
                    <div class="siswa-meta">
                        {{ $siswa->nis ?? '-' }}
                        @if($jawaban->sesi->selesai_pada)
                            &nbsp;·&nbsp; Dikumpulkan {{ $jawaban->sesi->selesai_pada->diffForHumans() }}
                        @endif
                        @if($jawaban->sesi->status === 'habis_waktu')
                            &nbsp;·&nbsp; <span style="color:var(--amber);font-weight:700">Waktu habis</span>
                        @endif
                    </div>
                </div>

                {{-- Tampilkan poin jika sudah dikoreksi --}}
                <div class="poin-display {{ $sudahKoreksi ? 'has-poin' : '' }}"
                     id="poinDisplay_{{ $jawaban->id }}">
                    @if($sudahKoreksi)
                        {{ $jawaban->poin_didapat }} / {{ $soal->bobot }}
                    @else
                        — / {{ $soal->bobot }}
                    @endif
                </div>

                <span class="status-chip {{ $sudahKoreksi ? 'chip-sudah' : 'chip-belum' }}"
                      id="chipStatus_{{ $jawaban->id }}">
                    @if($sudahKoreksi)
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right:3px"><polyline points="20 6 9 17 4 12"/></svg>
                        Sudah
                    @else
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right:3px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Belum
                    @endif
                </span>

                <svg class="chevron" width="16" height="16" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>

            {{-- ── Card Body ── --}}
            <div class="card-body">

                {{-- Jawaban Essay Siswa --}}
                <div class="jawaban-label">Jawaban Siswa</div>
                @if($jawaban->jawaban_essay)
                    <div class="jawaban-text">{{ $jawaban->jawaban_essay }}</div>
                @else
                    <div class="jawaban-text kosong">— Siswa tidak memberikan jawaban —</div>
                @endif

                {{-- Hasil koreksi (jika sudah) --}}
                @if($sudahKoreksi)
                <div class="koreksi-result" id="hasilKoreksi_{{ $jawaban->id }}">
                    <div class="koreksi-result-poin">
                        {{ $jawaban->poin_didapat }}<span style="font-size:13px;color:var(--text3)">/{{ $soal->bobot }}</span>
                    </div>
                    <div class="koreksi-result-detail">
                        <div class="koreksi-result-lbl">
                            @if($jawaban->adalah_benar)
                                ✓ Dinilai Benar
                            @else
                                ✗ Dinilai Tidak Benar
                            @endif
                        </div>
                        @if($jawaban->catatan_koreksi)
                        <div class="koreksi-result-catatan">
                            "{{ $jawaban->catatan_koreksi }}"
                        </div>
                        @else
                        <div class="koreksi-result-catatan" style="color:var(--text3)">Tidak ada catatan.</div>
                        @endif
                        <button class="btn-edit-koreksi"
                                onclick="editKoreksi({{ $jawaban->id }})">
                            Edit Koreksi
                        </button>
                    </div>
                </div>
                @endif

                {{-- Form Koreksi --}}
                {{--
                    Route  : POST admin/ujian/{ujian}/soal/{soal}/koreksi-essay/{jawaban}
                    Name   : admin.ujian.soal.koreksi-essay.store
                    Fields : poin_didapat (required|numeric|min:0|max:{bobot})
                             catatan_koreksi (nullable|string|max:1000)
                    AJAX   : header Accept: application/json → response JSON
                             { message, poin_didapat, adalah_benar }
                --}}
                <div class="koreksi-form" id="formWrap_{{ $jawaban->id }}"
                     style="{{ $sudahKoreksi ? 'display:none' : '' }}">
                    <div class="jawaban-label" style="margin-bottom:12px">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right:4px;vertical-align:middle"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                        Input Koreksi
                    </div>

                    <div class="koreksi-row">
                        {{-- Poin --}}
                        <div class="field">
                            <label for="poin_{{ $jawaban->id }}">
                                Poin <span class="req">*</span>
                            </label>
                            <input type="number"
                                   id="poin_{{ $jawaban->id }}"
                                   min="0" max="{{ $soal->bobot }}" step="0.5"
                                   value="{{ $sudahKoreksi ? $jawaban->poin_didapat : '' }}"
                                   placeholder="0 – {{ $soal->bobot }}"
                                   oninput="updatePoinTrack(this, {{ $jawaban->id }}, {{ $soal->bobot }})">
                            <span class="field-hint">Min 0 — Maks {{ $soal->bobot }}</span>

                            {{-- Mini progress track visual --}}
                            <div class="poin-track-wrap">
                                <div class="poin-track">
                                    <div class="poin-track-fill" id="poinTrack_{{ $jawaban->id }}"
                                         style="width:{{ $sudahKoreksi ? round($jawaban->poin_didapat / $soal->bobot * 100) : 0 }}%"></div>
                                </div>
                                <div class="poin-minmax">
                                    <span>0</span><span>{{ $soal->bobot }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="field">
                            <label for="catatan_{{ $jawaban->id }}">Catatan Koreksi</label>
                            <textarea id="catatan_{{ $jawaban->id }}"
                                      placeholder="Komentar / masukan untuk siswa (opsional, maks 1000 karakter)…"
                                      maxlength="1000"
                                      rows="3">{{ $sudahKoreksi ? $jawaban->catatan_koreksi : '' }}</textarea>
                            <span class="field-hint" id="catatanCounter_{{ $jawaban->id }}">0 / 1000</span>
                        </div>
                    </div>

                    {{-- Error display --}}
                    <div id="formError_{{ $jawaban->id }}"
                         class="alert alert-error"
                         style="display:none;margin-top:10px;margin-bottom:0"></div>

                    <button type="button" class="btn-koreksi"
                            id="btnKoreksi_{{ $jawaban->id }}"
                            onclick="submitKoreksi({{ $jawaban->id }}, {{ $soal->bobot }})">
                        <svg width="14" height="14" fill="none" stroke="currentColor"
                             stroke-width="2.5" viewBox="0 0 24 24"
                             id="btnIcon_{{ $jawaban->id }}">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan Koreksi
                    </button>
                </div>

            </div>{{-- /card-body --}}
        </div>{{-- /jawaban-card --}}
        @endforeach
    </div>{{-- /jawaban-list --}}

    @endif

</div>{{-- /page --}}

{{-- Toast container --}}
<div id="toast-wrap"></div>

<script>
// ─────────────────────────────────────────────────────────────────────────────
// Konstanta dari Blade (aman karena integer / string tervalidasi server)
// ─────────────────────────────────────────────────────────────────────────────
const CSRF_TOKEN = '{{ csrf_token() }}';
const BOBOT_MAX  = {{ (int) $soal->bobot }};

/*
 * URL base untuk koreksi:
 * Route: admin.ujian.soal.koreksi-essay.store
 *   → POST /admin/ujian/{ujian}/soal/{soal}/koreksi-essay/{jawaban}
 * Kita buat base URL tanpa jawaban ID, lalu tambahkan di submitKoreksi().
 */
const URL_BASE = '{{ route('admin.ujian.soal.koreksi-essay.store', [$ujian, $soal, '__ID__']) }}'
    .replace('/__ID__', '');   // hasilkan base URL tanpa trailing slash + ID

// ─────────────────────────────────────────────────────────────────────────────
// toggleCard(jawabanId) — buka/tutup card body
// ─────────────────────────────────────────────────────────────────────────────
function toggleCard(id) {
    var card = document.getElementById('card_' + id);
    if (!card) return;
    card.classList.toggle('expanded');
}

// ─────────────────────────────────────────────────────────────────────────────
// filterJawaban(type, btnEl) — tampilkan/sembunyikan card berdasarkan status
// ─────────────────────────────────────────────────────────────────────────────
function filterJawaban(type, btnEl) {
    document.querySelectorAll('.filter-tab').forEach(function(b) {
        b.classList.remove('active');
    });
    btnEl.classList.add('active');

    document.querySelectorAll('.jawaban-card').forEach(function(card) {
        var status = card.getAttribute('data-status'); // 'sudah' | 'belum'
        if (type === 'semua') {
            card.setAttribute('data-hidden', 'false');
            card.style.display = '';
        } else {
            var show = (status === type);
            card.setAttribute('data-hidden', show ? 'false' : 'true');
            card.style.display = show ? '' : 'none';
        }
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// editKoreksi(id) — sembunyikan hasil, tampilkan form untuk edit ulang
// ─────────────────────────────────────────────────────────────────────────────
function editKoreksi(id) {
    var hasilEl = document.getElementById('hasilKoreksi_' + id);
    var formEl  = document.getElementById('formWrap_' + id);
    if (hasilEl) hasilEl.style.display = 'none';
    if (formEl)  formEl.style.display  = '';
}

// ─────────────────────────────────────────────────────────────────────────────
// updatePoinTrack(input, id, max) — update visual track saat input berubah
// ─────────────────────────────────────────────────────────────────────────────
function updatePoinTrack(input, id, max) {
    var val   = parseFloat(input.value) || 0;
    val       = Math.min(Math.max(val, 0), max);
    var pct   = max > 0 ? (val / max * 100) : 0;
    var track = document.getElementById('poinTrack_' + id);
    if (track) track.style.width = pct + '%';
}

// ─────────────────────────────────────────────────────────────────────────────
// Karakter counter untuk textarea catatan
// ─────────────────────────────────────────────────────────────────────────────
document.querySelectorAll('[id^="catatan_"]').forEach(function(ta) {
    var idNum    = ta.id.replace('catatan_', '');
    var counter  = document.getElementById('catatanCounter_' + idNum);
    function update() {
        if (counter) counter.textContent = ta.value.length + ' / 1000';
    }
    ta.addEventListener('input', update);
    update(); // inisialisasi
});

// ─────────────────────────────────────────────────────────────────────────────
// submitKoreksi(jawabanId, bobotMax)
//
// AJAX POST ke: /admin/ujian/{ujian}/soal/{soal}/koreksi-essay/{jawaban}
// Header: Accept: application/json → controller akan return JSON
// Body  : poin_didapat, catatan_koreksi, _token, _method tidak perlu
//         (POST biasa, bukan PUT/PATCH)
//
// Response sukses: { message, poin_didapat, adalah_benar }
// Response error:  { errors: { field: [msg] } } atau { message }
// ─────────────────────────────────────────────────────────────────────────────
function submitKoreksi(jawabanId, bobotMax) {
    var poinInput  = document.getElementById('poin_' + jawabanId);
    var catatanEl  = document.getElementById('catatan_' + jawabanId);
    var errorEl    = document.getElementById('formError_' + jawabanId);
    var btn        = document.getElementById('btnKoreksi_' + jawabanId);
    var iconEl     = document.getElementById('btnIcon_' + jawabanId);

    // ── Validasi sisi klien (mirror validasi controller) ──
    var poin = poinInput.value.trim();

    if (poin === '') {
        showFormError(errorEl, 'Poin wajib diisi.');
        poinInput.classList.add('is-invalid');
        poinInput.focus();
        return;
    }

    var poinNum = parseFloat(poin);

    if (isNaN(poinNum) || poinNum < 0) {
        showFormError(errorEl, 'Poin minimal 0.');
        poinInput.classList.add('is-invalid');
        poinInput.focus();
        return;
    }

    if (poinNum > bobotMax) {
        showFormError(errorEl, 'Poin maksimal ' + bobotMax + ' (sesuai bobot soal).');
        poinInput.classList.add('is-invalid');
        poinInput.focus();
        return;
    }

    poinInput.classList.remove('is-invalid');
    hideFormError(errorEl);

    // ── Loading state ──
    btn.disabled = true;
    if (iconEl) iconEl.outerHTML =
        '<svg id="btnIcon_' + jawabanId + '" width="14" height="14" fill="none" stroke="currentColor"' +
        ' stroke-width="2" viewBox="0 0 24 24" style="animation:spin .7s linear infinite">' +
        '<path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>';

    // ── Build URL: base + jawabanId ──
    var url = URL_BASE + '/' + jawabanId;

    var body = new FormData();
    body.append('_token',          CSRF_TOKEN);
    body.append('poin_didapat',    poinNum);
    body.append('catatan_koreksi', catatanEl ? catatanEl.value : '');

    fetch(url, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: body,
    })
    .then(function(res) {
        return res.json().then(function(data) {
            return { status: res.status, data: data };
        });
    })
    .then(function(result) {
        btn.disabled = false;
        // Restore icon
        document.getElementById('btnIcon_' + jawabanId) &&
            (document.getElementById('btnIcon_' + jawabanId).outerHTML =
                '<svg id="btnIcon_' + jawabanId + '" width="14" height="14" fill="none" stroke="currentColor"' +
                ' stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>');

        if (result.status === 200 || result.status === 201) {
            // ── Sukses ──
            var poinDapat  = result.data.poin_didapat;
            var adalahBenar = result.data.adalah_benar;

            // Update card UI
            updateCardSukses(jawabanId, poinDapat, adalahBenar, bobotMax,
                catatanEl ? catatanEl.value : '');

            // Update stats & progress
            updateStats();

            showToast('Koreksi jawaban berhasil disimpan.', 'success');
        } else {
            // ── Error dari server ──
            var msg = 'Terjadi kesalahan.';
            if (result.data && result.data.errors) {
                var errs = Object.values(result.data.errors).flat();
                msg = errs.join(' ');
            } else if (result.data && result.data.message) {
                msg = result.data.message;
            }
            showFormError(errorEl, msg);
            showToast(msg, 'error');
        }
    })
    .catch(function(err) {
        btn.disabled = false;
        showFormError(errorEl, 'Gagal menghubungi server. Periksa koneksi Anda.');
        showToast('Gagal menghubungi server.', 'error');
        console.error('Koreksi fetch error:', err);
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// updateCardSukses — perbarui tampilan card setelah koreksi berhasil
// ─────────────────────────────────────────────────────────────────────────────
function updateCardSukses(id, poin, adalahBenar, max, catatan) {
    var card    = document.getElementById('card_' + id);
    var chipEl  = document.getElementById('chipStatus_' + id);
    var poinEl  = document.getElementById('poinDisplay_' + id);
    var formEl  = document.getElementById('formWrap_' + id);
    var hasilEl = document.getElementById('hasilKoreksi_' + id);

    if (!card) return;

    // Ubah status card
    card.setAttribute('data-status', 'sudah');
    card.classList.remove('belum-koreksi');
    card.classList.add('sudah-koreksi');

    // Chip
    if (chipEl) {
        chipEl.className = 'status-chip chip-sudah';
        chipEl.innerHTML =
            '<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right:3px"><polyline points="20 6 9 17 4 12"/></svg>Sudah';
    }

    // Poin display di header
    if (poinEl) {
        poinEl.className = 'poin-display has-poin';
        poinEl.textContent = poin + ' / ' + max;
    }

    // Sembunyikan form, tampilkan hasil
    if (formEl) formEl.style.display = 'none';

    // Buat / update elemen hasil koreksi
    if (!hasilEl) {
        // Buat elemen baru
        hasilEl = document.createElement('div');
        hasilEl.id = 'hasilKoreksi_' + id;
        hasilEl.className = 'koreksi-result';
        if (formEl && formEl.parentNode) {
            formEl.parentNode.insertBefore(hasilEl, formEl);
        }
    }
    hasilEl.style.display = '';
    hasilEl.innerHTML =
        '<div class="koreksi-result-poin">' + poin +
            '<span style="font-size:13px;color:var(--text3)">/' + max + '</span></div>' +
        '<div class="koreksi-result-detail">' +
            '<div class="koreksi-result-lbl">' +
                (adalahBenar ? '✓ Dinilai Benar' : '✗ Dinilai Tidak Benar') +
            '</div>' +
            (catatan
                ? '<div class="koreksi-result-catatan">"' + escHtml(catatan) + '"</div>'
                : '<div class="koreksi-result-catatan" style="color:var(--text3)">Tidak ada catatan.</div>') +
            '<button class="btn-edit-koreksi" onclick="editKoreksi(' + id + ')">Edit Koreksi</button>' +
        '</div>';

    // Update avatar color
    var avatar = card.querySelector('.siswa-avatar');
    if (avatar) avatar.style.background = 'var(--green-h)';
}

// ─────────────────────────────────────────────────────────────────────────────
// updateStats — hitung ulang stats dari DOM dan perbarui angka + progress
// ─────────────────────────────────────────────────────────────────────────────
function updateStats() {
    var semua  = document.querySelectorAll('.jawaban-card').length;
    var sudah  = document.querySelectorAll('.jawaban-card.sudah-koreksi').length;
    var belum  = semua - sudah;
    var pct    = semua > 0 ? Math.round(sudah / semua * 100) : 0;

    var elTotal = document.getElementById('statTotal');
    var elSudah = document.getElementById('statSudah');
    var elBelum = document.getElementById('statBelum');
    var elFill  = document.getElementById('progressFill');
    var elPct   = document.getElementById('progressPct');

    if (elTotal) elTotal.textContent = semua;
    if (elSudah) elSudah.textContent = sudah;
    if (elBelum) elBelum.textContent = belum;
    if (elFill)  elFill.style.width  = pct + '%';
    if (elPct)   elPct.textContent   = pct + '%';
}

// ─────────────────────────────────────────────────────────────────────────────
// Toast helper
// ─────────────────────────────────────────────────────────────────────────────
function showToast(msg, type) {
    var wrap  = document.getElementById('toast-wrap');
    var toast = document.createElement('div');
    toast.className = 'toast toast-' + (type || 'success');
    var icon = type === 'error'
        ? '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
        : '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>';
    toast.innerHTML = icon + escHtml(msg);
    wrap.appendChild(toast);
    setTimeout(function() {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity .3s';
        setTimeout(function() { toast.remove(); }, 300);
    }, 3200);
}

// ─────────────────────────────────────────────────────────────────────────────
// Form error helpers
// ─────────────────────────────────────────────────────────────────────────────
function showFormError(el, msg) {
    if (!el) return;
    el.style.display = 'flex';
    el.innerHTML =
        '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' +
        '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>' +
        '<line x1="12" y1="16" x2="12.01" y2="16"/></svg> ' + escHtml(msg);
}
function hideFormError(el) {
    if (!el) return;
    el.style.display = 'none';
    el.innerHTML = '';
}

// ─────────────────────────────────────────────────────────────────────────────
// Escape HTML untuk output dinamis
// ─────────────────────────────────────────────────────────────────────────────
function escHtml(str) {
    return String(str)
        .replace(/&/g,  '&amp;')
        .replace(/</g,  '&lt;')
        .replace(/>/g,  '&gt;')
        .replace(/"/g,  '&quot;')
        .replace(/'/g,  '&#39;');
}

// ─────────────────────────────────────────────────────────────────────────────
// Init: buka card pertama yang belum dikoreksi secara otomatis
// ─────────────────────────────────────────────────────────────────────────────
(function initFirstOpen() {
    var first = document.querySelector('.jawaban-card.belum-koreksi');
    if (first) {
        first.classList.add('expanded');
    }
})();
</script>
</x-app-layout>