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
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* Readonly identity strip */
    .readonly-strip{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;gap:24px;flex-wrap:wrap}
    .readonly-item .label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:2px}
    .readonly-item .val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}

    /* Status badge strip */
    .status-strip{display:flex;align-items:center;gap:10px;margin-bottom:20px;padding:12px 16px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);flex-wrap:wrap}
    .badge{display:inline-flex;align-items:center;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .badge-belum{background:#f1f5f9;color:#64748b}
    .badge-dikumpulkan{background:#dbeafe;color:#1d4ed8}
    .badge-terlambat{background:#fff7ed;color:#c2410c}
    .badge-dinilai{background:#dcfce7;color:#15803d}
    .status-strip-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .status-strip-sub{font-size:12px;color:var(--text3)}

    /* Form layout */
    .form-layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    /* Fields */
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:16px}
    .field:last-child{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field input[type=number],.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .field textarea{resize:vertical;min-height:100px}
    .field-hint{font-size:11.5px;color:var(--text3)}
    .field-error{font-size:11.5px;color:#dc2626;margin-top:2px}
    .field input.is-error,.field textarea.is-error{border-color:#dc2626;background:#fff8f8}

    /* Slider untuk input nilai */
    .nilai-slider-wrap{display:flex;flex-direction:column;gap:8px}
    .nilai-display{font-family:'Plus Jakarta Sans',sans-serif;font-size:48px;font-weight:800;line-height:1;text-align:center;color:var(--brand-600);margin-bottom:4px}
    input[type=range]{width:100%;accent-color:var(--brand-600);height:6px;border-radius:3px;cursor:pointer;border:none;background:none;padding:0}
    .slider-labels{display:flex;justify-content:space-between;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;color:var(--text3);margin-top:4px}

    /* Preview sidebar */
    .preview-card{background:var(--surface2);border-radius:var(--radius-sm);padding:14px;margin-bottom:14px}
    .preview-row{display:flex;align-items:center;justify-content:space-between;padding:6px 0;border-bottom:1px solid var(--border)}
    .preview-row:last-child{border-bottom:none}
    .preview-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;color:var(--text3)}
    .preview-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}

    .btn-submit-full{width:100%;height:40px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .15s}
    .btn-submit-full:hover{background:var(--brand-700)}

    /* Referensi konten siswa (mini) */
    .ref-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;margin-top:12px}
    .ref-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px}
    .ref-item{display:flex;align-items:center;gap:8px;padding:6px 0;border-bottom:1px solid var(--border);font-size:13px}
    .ref-item:last-child{border-bottom:none}
    .ref-item a{color:var(--brand-600);font-weight:700;text-decoration:none}
    .ref-item a:hover{text-decoration:underline}

    @media(max-width:900px){.form-layout{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            {{--
                FIX #1: Variable name diubah dari $pengumpulanTugas → $pengumpulan
                sesuai dengan yang di-pass controller: compact('pengumpulan')
            --}}
            <h1 class="page-title">{{ $pengumpulan->status === 'dinilai' ? 'Edit Nilai' : 'Beri Nilai' }}</h1>
            <p class="page-sub">
                {{ $pengumpulan->status === 'dinilai' ? 'Perbarui nilai pengumpulan tugas siswa' : 'Berikan nilai untuk pengumpulan tugas siswa' }}
            </p>
        </div>
        <div class="header-actions">
            {{--
                FIX #2: Route name diubah dari 'guru.pengumpulan-tugas.show' → 'pengumpulan-tugas.show'
                FIX #3: Parameter diubah dari $pengumpulan->id → $pengumpulan
                        (Laravel model binding cukup pass model-nya langsung)
            --}}
            <a href="{{ route('guru.pengumpulan-tugas.show', $pengumpulan) }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Error global --}}
    @if($errors->any())
    <div style="background:#fff0f0;border:1px solid #fecaca;border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start">
        <svg style="flex-shrink:0;color:#dc2626;margin-top:1px" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <ul style="margin:0;padding:0 0 0 16px;font-size:13px;color:#dc2626;font-family:'DM Sans',sans-serif">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Identitas siswa --}}
    {{-- FIX #1 (berlanjut): semua $pengumpulanTugas → $pengumpulan --}}
    <div class="readonly-strip">
        <div class="readonly-item">
            <p class="label">Siswa</p>
            <p class="val">{{ $pengumpulan->siswa->nama_lengkap ?? '—' }}</p>
        </div>
        <div class="readonly-item">
            <p class="label">NIS</p>
            <p class="val">{{ $pengumpulan->siswa->nis ?? '—' }}</p>
        </div>
        <div class="readonly-item">
            <p class="label">Judul Tugas</p>
            <p class="val">{{ Str::limit($pengumpulan->tugas->judul ?? '—', 50) }}</p>
        </div>
        <div class="readonly-item">
            <p class="label">Dikumpulkan</p>
            <p class="val">
                {{ $pengumpulan->dikumpulkan_pada
                    ? \Carbon\Carbon::parse($pengumpulan->dikumpulkan_pada)->locale('id')->isoFormat('D MMM Y, HH:mm')
                    : '—' }}
            </p>
        </div>
    </div>

    {{-- Status strip --}}
    @php
        $badgeClass = [
            'belum_dikumpulkan' => 'badge-belum',
            'dikumpulkan'       => 'badge-dikumpulkan',
            'terlambat'         => 'badge-terlambat',
            'dinilai'           => 'badge-dinilai',
        ][$pengumpulan->status] ?? 'badge-belum';

        $statusLabel = [
            'belum_dikumpulkan' => 'Belum Dikumpulkan',
            'dikumpulkan'       => 'Dikumpulkan',
            'terlambat'         => 'Terlambat',
            'dinilai'           => 'Sudah Dinilai',
        ][$pengumpulan->status] ?? $pengumpulan->status;
    @endphp
    <div class="status-strip">
        <span class="status-strip-label">Status saat ini:</span>
        <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
        @if($pengumpulan->status === 'terlambat')
        <span class="status-strip-sub">· Siswa mengumpulkan melebihi batas waktu</span>
        @endif
        @if($pengumpulan->status === 'dinilai' && $pengumpulan->nilai !== null)
        <span class="status-strip-sub">· Nilai sebelumnya: <strong>{{ number_format($pengumpulan->nilai, 1) }}</strong></span>
        @endif
    </div>

    {{--
        FIX #2: action route diubah dari 'guru.pengumpulan-tugas.simpan-nilai' → 'pengumpulan-tugas.simpan-nilai'
        FIX #3: parameter diubah dari $pengumpulan->id → $pengumpulan (model binding)
        FIX #4: method tetap PUT — sudah sesuai Route::put('/{pengumpulan}/nilai', ...)
    --}}
    <form action="{{ route('guru.pengumpulan-tugas.simpan-nilai', $pengumpulan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-layout">

            <div>
                {{-- Input Nilai --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        <span class="card-title">Nilai (0 – 100)</span>
                    </div>
                    <div class="card-body">
                        {{-- Display besar + slider --}}
                        <div class="nilai-slider-wrap" style="margin-bottom:16px">
                            <p class="nilai-display" id="nilaiDisplay">
                                {{ old('nilai', $pengumpulan->nilai ?? 0) }}
                            </p>
                            <input type="range" id="nilaiSlider"
                                   min="0" max="100" step="1"
                                   value="{{ old('nilai', $pengumpulan->nilai ?? 0) }}"
                                   oninput="syncNilai(this.value, 'slider')">
                            <div class="slider-labels"><span>0</span><span>50</span><span>100</span></div>
                        </div>

                        {{-- Input angka langsung --}}
                        <div class="field">
                            <label>Atau ketik langsung <span class="req">*</span></label>
                            <input type="number" name="nilai" id="nilaiInput"
                                   min="0" max="100" step="0.1"
                                   value="{{ old('nilai', $pengumpulan->nilai ?? '') }}"
                                   placeholder="0 – 100"
                                   class="{{ $errors->has('nilai') ? 'is-error' : '' }}"
                                   oninput="syncNilai(this.value, 'input')">
                            @error('nilai')<span class="field-error">{{ $message }}</span>@enderror
                            <span class="field-hint">Wajib diisi, desimal boleh (contoh: 87.5)</span>
                        </div>
                    </div>
                </div>

                {{-- Umpan Balik --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span class="card-title">Umpan Balik</span>
                    </div>
                    <div class="card-body">
                        <div class="field">
                            <label>Catatan / Umpan Balik untuk Siswa <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                            <textarea name="umpan_balik" maxlength="1000"
                                      placeholder="Tuliskan komentar, koreksi, atau apresiasi untuk siswa…"
                                      class="{{ $errors->has('umpan_balik') ? 'is-error' : '' }}">{{ old('umpan_balik', $pengumpulan->umpan_balik) }}</textarea>
                            @error('umpan_balik')<span class="field-error">{{ $message }}</span>@enderror
                            <span class="field-hint">Maksimal 1000 karakter. Umpan balik akan terlihat oleh siswa.</span>
                        </div>
                    </div>
                </div>

                {{-- Referensi pengumpulan siswa (baca saja) --}}
                @if($pengumpulan->path_file || $pengumpulan->url_link || $pengumpulan->jawaban_teks)
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <span class="card-title">Konten Pengumpulan Siswa</span>
                    </div>
                    <div class="card-body" style="padding:16px">
                        <div class="ref-box" style="margin-top:0">
                            <p class="ref-title">Lampiran / Jawaban</p>
                            @if($pengumpulan->path_file)
                            <div class="ref-item">
                                <svg width="13" height="13" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <a href="{{ asset('storage/' . $pengumpulan->path_file) }}" target="_blank">
                                    {{ basename($pengumpulan->path_file) }}
                                </a>
                                <span style="font-size:11px;color:var(--text3)">(file)</span>
                            </div>
                            @endif
                            @if($pengumpulan->url_link)
                            <div class="ref-item">
                                <svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                <a href="{{ $pengumpulan->url_link }}" target="_blank" rel="noopener noreferrer">
                                    {{ Str::limit($pengumpulan->url_link, 60) }}
                                </a>
                                <span style="font-size:11px;color:var(--text3)">(link)</span>
                            </div>
                            @endif
                            @if($pengumpulan->jawaban_teks)
                            <div class="ref-item" style="flex-direction:column;align-items:flex-start;gap:4px">
                                <span style="display:flex;align-items:center;gap:6px">
                                    <svg width="13" height="13" fill="none" stroke="#475569" stroke-width="2" viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/></svg>
                                    <span style="font-size:12px;color:var(--text2);font-weight:600">Jawaban Teks:</span>
                                </span>
                                <div style="background:#fff;border:1px solid var(--border);border-radius:6px;padding:10px 12px;font-size:13px;color:var(--text2);line-height:1.6;max-height:100px;overflow-y:auto;width:100%;box-sizing:border-box;white-space:pre-wrap">{{ Str::limit($pengumpulan->jawaban_teks, 300) }}</div>
                                @if(strlen($pengumpulan->jawaban_teks) > 300)
                                {{-- FIX #2 + #3: route & parameter disesuaikan --}}
                                <a href="{{ route('guru.pengumpulan-tugas.show', $pengumpulan) }}" target="_blank" style="font-size:12px;color:var(--brand-600);font-weight:700">Lihat selengkapnya →</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        <span class="card-title">Ringkasan Penilaian</span>
                    </div>
                    <div class="card-body" style="padding:16px">
                        <div class="preview-card" style="margin-bottom:14px">
                            <div class="preview-row">
                                <span class="preview-label">Siswa</span>
                                <span class="preview-val" style="font-size:12px;max-width:160px;text-align:right">{{ Str::limit($pengumpulan->siswa->nama_lengkap ?? '—', 22) }}</span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">Status Baru</span>
                                <span class="preview-val" style="font-size:11.5px;color:#15803d">Dinilai</span>
                            </div>
                            <div class="preview-row" style="margin-top:4px;padding-top:10px;border-top:2px solid var(--border2)">
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text)">Nilai</span>
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--brand-600)" id="sidebarNilai">
                                    {{ old('nilai', $pengumpulan->nilai ?? '—') }}
                                </span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">Predikat</span>
                                <span class="preview-val" id="sidebarPredikat">—</span>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit-full">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Nilai
                        </button>
                        <a href="{{ route('guru.pengumpulan-tugas.show', $pengumpulan) }}"
                           class="btn btn-secondary"
                           style="width:100%;justify-content:center;margin-top:8px;box-sizing:border-box">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({
    icon:'warning', title:'Perhatian!',
    html: @json('<ul style="text-align:left;padding-left:16px">' . implode('', array_map(fn($e) => '<li>' . e($e) . '</li>', $errors->all())) . '</ul>'),
    confirmButtonColor:'#1f63db'
});
@endif

function getPredikat(val) {
    if (val === '' || isNaN(val)) return '—';
    val = parseFloat(val);
    if (val >= 90) return 'A';
    if (val >= 80) return 'B';
    if (val >= 70) return 'C';
    if (val >= 60) return 'D';
    return 'E';
}

function getWarna(val) {
    if (val === '' || isNaN(val)) return 'var(--brand-600)';
    val = parseFloat(val);
    if (val >= 75) return '#15803d';
    if (val >= 60) return '#a16207';
    return '#dc2626';
}

function syncNilai(rawVal, source) {
    var val     = parseFloat(rawVal);
    var clamped = Math.max(0, Math.min(100, isNaN(val) ? 0 : val));

    var displayEl = document.getElementById('nilaiDisplay');
    displayEl.textContent = rawVal === '' ? '—' : clamped;
    displayEl.style.color = getWarna(rawVal === '' ? '' : clamped);

    var sidebarEl = document.getElementById('sidebarNilai');
    sidebarEl.textContent = rawVal === '' ? '—' : clamped.toFixed(1);
    sidebarEl.style.color = getWarna(rawVal === '' ? '' : clamped);

    document.getElementById('sidebarPredikat').textContent = getPredikat(rawVal === '' ? '' : clamped);

    if (source === 'input') {
        if (!isNaN(val)) document.getElementById('nilaiSlider').value = Math.round(clamped);
    } else {
        document.getElementById('nilaiInput').value = clamped;
    }
}

// Init on load
(function () {
    var v = document.getElementById('nilaiInput').value;
    if (v !== '') syncNilai(v, 'input');
})();
</script>
</x-app-layout>