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
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center}
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--text3)}
    .breadcrumb a{color:var(--text3);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}
    .breadcrumb a:hover{color:var(--text)}
    .breadcrumb-current{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text2)}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .form-layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field select,.field input[type=number],.field input[type=text],.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:80px}
    .field-hint{font-size:11.5px;color:var(--text3)}
    .field-error{font-size:11.5px;color:#dc2626;margin-top:2px}
    .field select.is-error,.field input.is-error,.field textarea.is-error{border-color:#dc2626;background:#fff8f8}

    .alert-error{background:#fff0f0;border:1px solid #fecaca;border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start}
    .alert-error-icon{flex-shrink:0;margin-top:1px;color:#dc2626}
    .alert-error ul{margin:0;padding:0 0 0 16px;font-size:13px;color:#dc2626;font-family:'DM Sans',sans-serif}
    .alert-error li{margin-bottom:3px}
    .alert-error li:last-child{margin-bottom:0}

    .btn-submit-full{width:100%;height:40px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .15s}
    .btn-submit-full:hover{background:var(--brand-700)}

    .preview-card{background:var(--surface2);border-radius:var(--radius-sm);padding:14px}
    .preview-row{display:flex;align-items:center;justify-content:space-between;padding:6px 0;border-bottom:1px solid var(--border)}
    .preview-row:last-child{border-bottom:none}
    .preview-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;color:var(--text3)}
    .preview-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}

    @media(max-width:900px){.form-layout{grid-template-columns:1fr}.form-grid{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('guru.nilai.index') }}">Input Nilai</a>
        <span>›</span>
        <span class="breadcrumb-current">Input Nilai Baru</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Input Nilai Baru</h1>
            <p class="page-sub">Masukkan komponen nilai siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Inline error banner (non-JS fallback) --}}
    @if($errors->any())
    <div class="alert-error">
        <svg class="alert-error-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('guru.nilai.store') }}" method="POST">
        @csrf
        <div class="form-layout">

            <div>
                {{-- Identitas --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span class="card-title">Identitas Siswa</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">
                            <div class="field">
                                <label>Siswa <span class="req">*</span></label>
                                <select name="siswa_id" required class="{{ $errors->has('siswa_id') ? 'is-error' : '' }}">
                                    <option value="">— Pilih Siswa —</option>
                                    @foreach($siswaList as $s)
                                        <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama_lengkap }} ({{ $s->nis ?? '—' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label>Kelas <span class="req">*</span></label>
                                <select name="kelas_id" required class="{{ $errors->has('kelas_id') ? 'is-error' : '' }}">
                                    <option value="">— Pilih Kelas —</option>
                                    @foreach($kelasList as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label>Mata Pelajaran <span class="req">*</span></label>
                                <select name="mata_pelajaran_id" required class="{{ $errors->has('mata_pelajaran_id') ? 'is-error' : '' }}">
                                    <option value="">— Pilih Mapel —</option>
                                    @foreach($mapelList as $m)
                                        <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                                @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label>Tahun Ajaran <span class="req">*</span></label>
                                <select name="tahun_ajaran_id" required class="{{ $errors->has('tahun_ajaran_id') ? 'is-error' : '' }}">
                                    <option value="">— Pilih Tahun Ajaran —</option>
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->tahun }} – {{ ucfirst($ta->semester) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Komponen Nilai --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        <span class="card-title">Komponen Nilai (0 – 100)</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid">
                            <div class="field">
                                <label>Nilai Tugas <span style="font-size:10.5px;color:var(--text3);font-weight:500">(bobot 20%)</span></label>
                                <input type="number" name="nilai_tugas" id="nt"
                                       value="{{ old('nilai_tugas') }}"
                                       min="0" max="100" step="0.01" placeholder="0 – 100"
                                       class="{{ $errors->has('nilai_tugas') ? 'is-error' : '' }}"
                                       oninput="updatePreview()">
                                @error('nilai_tugas')<span class="field-error">{{ $message }}</span>@enderror
                                <span class="field-hint">Opsional</span>
                            </div>
                            <div class="field">
                                <label>Nilai Harian <span style="font-size:10.5px;color:var(--text3);font-weight:500">(bobot 30%)</span></label>
                                <input type="number" name="nilai_harian" id="nh"
                                       value="{{ old('nilai_harian') }}"
                                       min="0" max="100" step="0.01" placeholder="0 – 100"
                                       class="{{ $errors->has('nilai_harian') ? 'is-error' : '' }}"
                                       oninput="updatePreview()">
                                @error('nilai_harian')<span class="field-error">{{ $message }}</span>@enderror
                                <span class="field-hint">Opsional</span>
                            </div>
                            <div class="field">
                                <label>Nilai UTS <span style="font-size:10.5px;color:var(--text3);font-weight:500">(bobot 20%)</span></label>
                                <input type="number" name="nilai_uts" id="nu"
                                       value="{{ old('nilai_uts') }}"
                                       min="0" max="100" step="0.01" placeholder="0 – 100"
                                       class="{{ $errors->has('nilai_uts') ? 'is-error' : '' }}"
                                       oninput="updatePreview()">
                                @error('nilai_uts')<span class="field-error">{{ $message }}</span>@enderror
                                <span class="field-hint">Opsional</span>
                            </div>
                            <div class="field">
                                <label>Nilai UAS <span style="font-size:10.5px;color:var(--text3);font-weight:500">(bobot 30%)</span></label>
                                <input type="number" name="nilai_uas" id="na"
                                       value="{{ old('nilai_uas') }}"
                                       min="0" max="100" step="0.01" placeholder="0 – 100"
                                       class="{{ $errors->has('nilai_uas') ? 'is-error' : '' }}"
                                       oninput="updatePreview()">
                                @error('nilai_uas')<span class="field-error">{{ $message }}</span>@enderror
                                <span class="field-hint">Opsional</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                        <span class="card-title">Catatan</span>
                    </div>
                    <div class="card-body">
                        <div class="field">
                            <label>Catatan Guru <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                            <textarea name="catatan" maxlength="500" placeholder="Catatan tambahan…"
                                      class="{{ $errors->has('catatan') ? 'is-error' : '' }}">{{ old('catatan') }}</textarea>
                            @error('catatan')<span class="field-error">{{ $message }}</span>@enderror
                            <span class="field-hint">Maksimal 500 karakter</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar: preview + submit --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        <span class="card-title">Preview Nilai Akhir</span>
                    </div>
                    <div class="card-body" style="padding:16px">
                        <div class="preview-card" style="margin-bottom:14px">
                            <div class="preview-row">
                                <span class="preview-label">Tugas (20%)</span>
                                <span class="preview-val" id="prev-nt">—</span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">Harian (30%)</span>
                                <span class="preview-val" id="prev-nh">—</span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">UTS (20%)</span>
                                <span class="preview-val" id="prev-nu">—</span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">UAS (30%)</span>
                                <span class="preview-val" id="prev-na">—</span>
                            </div>
                            <div class="preview-row" style="margin-top:4px;padding-top:10px;border-top:2px solid var(--border2)">
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text)">Nilai Akhir*</span>
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--brand-600)" id="prev-avg">—</span>
                            </div>
                            <p style="font-size:11px;color:var(--text3);margin-top:8px;line-height:1.5">
                                * Dihitung proporsional dari komponen yang diisi berdasarkan bobotnya.
                            </p>
                        </div>
                        <button type="submit" class="btn-submit-full">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Nilai
                        </button>
                        <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary" style="width:100%;justify-content:center;margin-top:8px;box-sizing:border-box">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- Data error disimpan di HTML attribute, bukan di dalam <script>, untuk menghindari ParseError Blade --}}
@if($errors->any())
@php
    $items = '';
    foreach ($errors->all() as $e) {
        $items .= '<li>' . e($e) . '</li>';
    }
    $errorHtml = '<ul style="text-align:left;padding-left:16px">' . $items . '</ul>';
@endphp
<div id="blade-errors" data-html="{{ e($errorHtml) }}" style="display:none"></div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var errEl = document.getElementById('blade-errors');
if (errEl) {
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian!',
        html: errEl.getAttribute('data-html'),
        confirmButtonColor: '#1f63db'
    });
}

const BOBOT = { nt: 0.20, nh: 0.30, nu: 0.20, na: 0.30 };

function updatePreview() {
    const fields = [
        { id: 'nt', prevId: 'prev-nt', bobot: BOBOT.nt },
        { id: 'nh', prevId: 'prev-nh', bobot: BOBOT.nh },
        { id: 'nu', prevId: 'prev-nu', bobot: BOBOT.nu },
        { id: 'na', prevId: 'prev-na', bobot: BOBOT.na },
    ];

    let totalNilai = 0, totalBobot = 0;

    fields.forEach(function(f) {
        const raw = document.getElementById(f.id).value;
        const val = parseFloat(raw);
        const el  = document.getElementById(f.prevId);

        if (raw !== '' && !isNaN(val)) {
            const clamped = Math.max(0, Math.min(100, val));
            el.textContent = clamped.toFixed(1);
            totalNilai += clamped * f.bobot;
            totalBobot += f.bobot;
        } else {
            el.textContent = '—';
        }
    });

    const avgEl = document.getElementById('prev-avg');
    if (totalBobot > 0) {
        avgEl.textContent = (totalNilai / totalBobot).toFixed(1);
    } else {
        avgEl.textContent = '—';
    }
}

updatePreview();
</script>
</x-app-layout>