<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --danger:#dc2626;--danger-bg:#fef2f2;--danger-border:#fecaca;
        --warn-bg:#fffbeb;--warn-border:#fde68a;--warn-text:#92400e;
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    .page{padding:32px;max-width:2000px;}
    .breadcrumb{display:flex;align-items:center;gap:5px;font-size:12px;color:var(--text3);margin-bottom:22px;font-family:'Plus Jakarta Sans',sans-serif;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand-600);}
    .breadcrumb-sep{color:var(--border2);}
    .page-head{margin-bottom:24px;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);letter-spacing:-.3px;}
    .page-sub{font-size:13px;color:var(--text3);margin-top:4px;}

    /* Steps */
    .steps{display:flex;align-items:center;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 24px;margin-bottom:24px;gap:0;}
    .step{display:flex;align-items:center;gap:10px;}
    .step-num{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;flex-shrink:0;}
    .step.active .step-num{background:var(--brand-600);color:#fff;box-shadow:0 0 0 4px var(--brand-100);}
    .step.inactive .step-num{background:var(--surface3);color:var(--text3);}
    .step-tag{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--text3);}
    .step.active .step-tag{color:var(--brand-500);}
    .step-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);}
    .step.active .step-name{color:var(--text);}
    .step-line{flex:1;height:2px;margin:0 16px;background:var(--border);}

    /* Card */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:18px 24px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:12px;}
    .card-header-icon{width:34px;height:34px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .card-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);}
    .card-header-sub{font-size:12px;color:var(--text3);margin-top:1px;}
    .card-body{padding:28px;}

    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:12px;padding:14px 16px;border-radius:var(--radius-sm);margin-bottom:22px;}
    .alert-warn{background:var(--warn-bg);border:1px solid var(--warn-border);}
    .alert-danger{background:var(--danger-bg);border:1px solid var(--danger-border);}
    .alert-icon{flex-shrink:0;margin-top:1px;}
    .alert-body{font-size:13px;line-height:1.6;color:var(--warn-text);}
    .alert-danger .alert-body{color:var(--danger);}
    .alert-body strong{font-weight:700;}

    /* Fields */
    .field-row{display:grid;gap:20px;margin-bottom:20px;}
    .field-row.cols-2{grid-template-columns:1fr 1fr;}
    .field{display:flex;flex-direction:column;gap:6px;}
    .field-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);}
    .req{color:var(--danger);}
    .opt{font-weight:400;color:var(--text3);font-size:11px;margin-left:3px;}

    /* Select / Input styling */
    .field-control select,
    .field-control input {
        width:100%;
        padding:10px 14px;
        border:1.5px solid var(--border2);
        border-radius:var(--radius-sm);
        font-family:'DM Sans',sans-serif;
        font-size:13.5px;
        color:var(--text);
        background:var(--surface);
        outline:none;
        transition:border-color .15s,box-shadow .15s;
        -webkit-appearance:none;
        appearance:none;
    }
    .field-control select {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat:no-repeat;
        background-position:right 12px center;
        padding-right:36px;
        cursor:pointer;
    }
    .field-control select:focus,
    .field-control input:focus {
        border-color:var(--brand-500);
        box-shadow:0 0 0 3px var(--brand-100);
    }
    .field-hint{font-size:11.5px;color:var(--text3);}
    .field-error{font-size:11.5px;color:var(--danger);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;}

    /* Tingkat preview pill */
    .tingkat-pill{display:none;align-items:center;gap:6px;padding:6px 10px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:6px;margin-top:4px;}
    .tingkat-pill.show{display:inline-flex;}
    .tingkat-pill span{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand-700);}

    /* Divider with label */
    .section-label{display:flex;align-items:center;gap:10px;margin:24px 0 16px;}
    .section-label::before,.section-label::after{content:'';flex:1;height:1px;background:var(--border);}
    .section-label span{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;white-space:nowrap;}

    /* Syarat cards */
    .syarat-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;}
    .syarat-card{display:flex;align-items:center;gap:14px;padding:14px 18px;background:var(--surface2);border:1.5px solid var(--border);border-radius:var(--radius-sm);}
    .syarat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .syarat-icon.green{background:#dcfce7;}
    .syarat-icon.blue{background:#dbeafe;}
    .syarat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;}
    .syarat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text);margin-top:1px;}
    .syarat-desc{font-size:11px;color:var(--text3);}

    /* Footer */
    .card-footer{display:flex;align-items:center;justify-content:space-between;padding:16px 28px;border-top:1px solid var(--border);background:var(--surface2);}
    .footer-hint{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px;}

    /* Buttons */
    .btn{display:inline-flex;align-items:center;gap:7px;padding:10px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-primary:hover{background:var(--brand-700);}
    .btn-primary:disabled{opacity:.5;cursor:not-allowed;}
    .btn-ghost{background:transparent;color:var(--text2);border:1.5px solid var(--border2);}
    .btn-ghost:hover{background:var(--surface3);}

    @media(max-width:640px){
        .page{padding:16px;}
        .field-row.cols-2{grid-template-columns:1fr;}
        .syarat-grid{grid-template-columns:1fr;}
    }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.kenaikan-kelas.index') }}">Kenaikan Kelas</a>
        <span class="breadcrumb-sep">›</span>
        <span>Proses Baru</span>
    </nav>

    <div class="page-head">
        <h1 class="page-title">Proses Kenaikan Kelas Baru</h1>
        <p class="page-sub">Pilih parameter tahun ajaran dan tingkat untuk memulai evaluasi siswa</p>
    </div>

    {{-- Step indicator --}}
    <div class="steps">
        <div class="step active">
            <div class="step-num">1</div>
            <div>
                <p class="step-tag">Langkah 1</p>
                <p class="step-name">Parameter</p>
            </div>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-num">2</div>
            <div>
                <p class="step-tag">Langkah 2</p>
                <p class="step-name">Preview & Evaluasi</p>
            </div>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-num">3</div>
            <div>
                <p class="step-tag">Langkah 3</p>
                <p class="step-name">Konfirmasi</p>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger" style="margin-bottom:16px;">
        <svg class="alert-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div class="alert-body">{{ session('error') }}</div>
    </div>
    @endif

    <div class="form-card">
        <div class="card-header">
            <div class="card-header-icon">
                <svg width="16" height="16" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <div>
                <p class="card-header-title">Konfigurasi Proses</p>
                <p class="card-header-sub">Tentukan rentang tahun ajaran dan tingkat kelas yang akan diproses</p>
            </div>
        </div>

        {{--
            ACTION menuju route preview.
            Field 'catatan' dikirim ke sini agar bisa dioper
            sebagai hidden input di halaman preview → lalu ke store().
        --}}
        <form action="{{ route('admin.kenaikan-kelas.preview') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="alert alert-warn">
                    <svg class="alert-icon" width="16" height="16" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <div class="alert-body">
                        Pastikan <strong>tahun ajaran tujuan</strong> sudah dibuat dan memiliki kelas aktif sebelum memproses.
                        Siswa yang naik kelas akan dipindahkan ke kelas baru di tahun ajaran tujuan secara otomatis.
                    </div>
                </div>

                {{-- Tahun Ajaran Asal & Tujuan --}}
                <div class="field-row cols-2">
                    <div class="field">
                        <label class="field-label" for="taAsal">Tahun Ajaran Asal <span class="req">*</span></label>
                        <div class="field-control">
                            <select name="tahun_ajaran_asal_id" id="taAsal" required onchange="onTaChange()">
                                <option value="">— Pilih Tahun Ajaran Asal —</option>
                                @forelse($tahunAjarans as $ta)
                                    @php
                                        $labelTa = $ta->nama
                                            ?? $ta->tahun
                                            ?? (isset($ta->tahun_mulai, $ta->tahun_selesai) ? "{$ta->tahun_mulai}/{$ta->tahun_selesai}" : null)
                                            ?? "Tahun Ajaran #{$ta->id}";
                                        $isAktif = isset($ta->status) && $ta->status === 'aktif';
                                    @endphp
                                    <option value="{{ $ta->id }}"
                                        {{ old('tahun_ajaran_asal_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $labelTa }}{{ $isAktif ? ' (Aktif)' : '' }}
                                    </option>
                                @empty
                                    <option value="" disabled>Belum ada data tahun ajaran</option>
                                @endforelse
                            </select>
                        </div>
                        @error('tahun_ajaran_asal_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                        <span class="field-hint">Tahun ajaran tempat siswa saat ini terdaftar</span>
                    </div>

                    <div class="field">
                        <label class="field-label" for="taTujuan">Tahun Ajaran Tujuan <span class="req">*</span></label>
                        <div class="field-control">
                            <select name="tahun_ajaran_tujuan_id" id="taTujuan" required onchange="onTaChange()">
                                <option value="">— Pilih Tahun Ajaran Tujuan —</option>
                                @forelse($tahunAjarans as $ta)
                                    @php
                                        $labelTa = $ta->nama
                                            ?? $ta->tahun
                                            ?? (isset($ta->tahun_mulai, $ta->tahun_selesai) ? "{$ta->tahun_mulai}/{$ta->tahun_selesai}" : null)
                                            ?? "Tahun Ajaran #{$ta->id}";
                                        $isAktif = isset($ta->status) && $ta->status === 'aktif';
                                    @endphp
                                    <option value="{{ $ta->id }}"
                                        {{ old('tahun_ajaran_tujuan_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $labelTa }}{{ $isAktif ? ' (Aktif)' : '' }}
                                    </option>
                                @empty
                                    <option value="" disabled>Belum ada data tahun ajaran</option>
                                @endforelse
                            </select>
                        </div>
                        @error('tahun_ajaran_tujuan_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                        <span class="field-hint">Tahun ajaran berikutnya (harus berbeda dari asal)</span>
                    </div>
                </div>

                {{-- Alert sama TA --}}
                <div id="alertSamaTa" class="alert alert-danger" style="display:none;margin-top:-8px;margin-bottom:16px;">
                    <svg class="alert-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div class="alert-body">Tahun ajaran asal dan tujuan tidak boleh sama.</div>
                </div>

                {{-- Tingkat + Catatan --}}
                <div class="field-row cols-2">
                    <div class="field">
                        <label class="field-label" for="tingkatSel">Tingkat Kelas Asal <span class="req">*</span></label>
                        <div class="field-control">
                            <select name="dari_tingkat" id="tingkatSel" required onchange="onTingkatChange()">
                                <option value="">— Pilih Tingkat —</option>
                                <option value="X"   {{ old('dari_tingkat') === 'X'   ? 'selected' : '' }}>Kelas X</option>
                                <option value="XI"  {{ old('dari_tingkat') === 'XI'  ? 'selected' : '' }}>Kelas XI</option>
                                <option value="XII" {{ old('dari_tingkat') === 'XII' ? 'selected' : '' }}>Kelas XII</option>
                            </select>
                        </div>
                        @error('dari_tingkat')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                        <div class="tingkat-pill" id="tingkatPill">
                            <svg width="11" height="11" fill="none" stroke="var(--brand-600)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="13 17 18 12 13 7"/><path d="M6 12h12"/></svg>
                            <span id="tingkatPillText"></span>
                        </div>
                    </div>

                    <div class="field">
                        <label class="field-label" for="catatanInput">Catatan Proses <span class="opt">(opsional)</span></label>
                        <div class="field-control">
                            <input type="text" id="catatanInput" name="catatan"
                                   value="{{ old('catatan') }}"
                                   placeholder="Contoh: Kenaikan kelas genap 2024/2025">
                        </div>
                        <span class="field-hint">Catatan ini akan tersimpan di riwayat proses</span>
                    </div>
                </div>

                {{-- Syarat minimum --}}
                <div class="section-label"><span>Syarat Minimum Kenaikan Kelas</span></div>

                <div class="syarat-grid">
                    <div class="syarat-card">
                        <div class="syarat-icon green">
                            <svg width="20" height="20" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="syarat-label">Kehadiran Minimum</p>
                            <p class="syarat-val">≥ 75%</p>
                            <p class="syarat-desc">dari total pertemuan</p>
                        </div>
                    </div>
                    <div class="syarat-card">
                        <div class="syarat-icon blue">
                            <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </div>
                        <div>
                            <p class="syarat-label">Rata-rata Nilai Minimum</p>
                            <p class="syarat-val">≥ 65.0</p>
                            <p class="syarat-desc">dari seluruh mata pelajaran</p>
                        </div>
                    </div>
                </div>

                <p style="font-size:11.5px;color:var(--text3);margin-top:10px;line-height:1.6;">
                    💡 Rekomendasi diberikan otomatis — admin tetap dapat mengubah keputusan secara manual di tahap preview.
                </p>
            </div>

            <div class="card-footer">
                <span class="footer-hint">
                    <svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Data belum tersimpan hingga dikonfirmasi
                </span>
                <div style="display:flex;gap:10px;">
                    <a href="{{ route('admin.kenaikan-kelas.index') }}" class="btn btn-ghost">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" id="btnPreview">
                        Lihat Preview Siswa
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const tingkatMap = {
    'X':   'Kelas X  →  Kelas XI',
    'XI':  'Kelas XI  →  Kelas XII',
    'XII': 'Kelas XII  →  Lulus / Alumni',
};

function onTingkatChange() {
    const val  = document.getElementById('tingkatSel').value;
    const pill = document.getElementById('tingkatPill');
    const txt  = document.getElementById('tingkatPillText');
    if (val && tingkatMap[val]) {
        txt.textContent = tingkatMap[val];
        pill.classList.add('show');
    } else {
        pill.classList.remove('show');
    }
}

function onTaChange() {
    const asal    = document.getElementById('taAsal').value;
    const tujuan  = document.getElementById('taTujuan').value;
    const alertEl = document.getElementById('alertSamaTa');
    const btn     = document.getElementById('btnPreview');
    const same    = asal && tujuan && asal === tujuan;
    alertEl.style.display = same ? 'flex' : 'none';
    btn.disabled = same;
}

document.addEventListener('DOMContentLoaded', () => {
    onTingkatChange();
    onTaChange();
});
</script>
</x-app-layout>