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
    .form-grid.col1{grid-template-columns:1fr}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field select,.field input[type=number],.field input[type=text],.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:80px}
    .field-hint{font-size:11.5px;color:var(--text3)}

    /* Nilai input with live preview */
    .nilai-input-wrap{position:relative}
    .nilai-preview{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3)}

    .btn-submit-full{width:100%;height:40px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .15s}
    .btn-submit-full:hover{background:var(--brand-700)}

    /* Live preview card */
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
                                <select name="siswa_id" required>
                                    <option value="">— Pilih Siswa —</option>
                                    @foreach($siswaList as $s)
                                        <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama_lengkap }} ({{ $s->nis ?? '—' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Kelas <span class="req">*</span></label>
                                <select name="kelas_id" required>
                                    <option value="">— Pilih Kelas —</option>
                                    @foreach($kelasList as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Mata Pelajaran <span class="req">*</span></label>
                                <select name="mata_pelajaran_id" required>
                                    <option value="">— Pilih Mapel —</option>
                                    @foreach($mapelList as $m)
                                        <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Tahun Ajaran <span class="req">*</span></label>
                                <select name="tahun_ajaran_id" required>
                                    <option value="">— Pilih Tahun Ajaran —</option>
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->nama ?? $ta->tahun }}</option>
                                    @endforeach
                                </select>
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
                                <label>Nilai Tugas</label>
                                <input type="number" name="nilai_tugas" id="nt" value="{{ old('nilai_tugas') }}" min="0" max="100" step="0.01" placeholder="0–100" oninput="updatePreview()">
                                <span class="field-hint">Opsional</span>
                            </div>
                            <div class="field">
                                <label>Nilai Harian</label>
                                <input type="number" name="nilai_harian" id="nh" value="{{ old('nilai_harian') }}" min="0" max="100" step="0.01" placeholder="0–100" oninput="updatePreview()">
                                <span class="field-hint">Opsional</span>
                            </div>
                            <div class="field">
                                <label>Nilai UTS</label>
                                <input type="number" name="nilai_uts" id="nu" value="{{ old('nilai_uts') }}" min="0" max="100" step="0.01" placeholder="0–100" oninput="updatePreview()">
                                <span class="field-hint">Opsional</span>
                            </div>
                            <div class="field">
                                <label>Nilai UAS</label>
                                <input type="number" name="nilai_uas" id="na" value="{{ old('nilai_uas') }}" min="0" max="100" step="0.01" placeholder="0–100" oninput="updatePreview()">
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
                            <label>Catatan Guru</label>
                            <textarea name="catatan" maxlength="500" placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar: preview + submit --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        <span class="card-title">Preview Rata-rata</span>
                    </div>
                    <div class="card-body" style="padding:16px">
                        <div class="preview-card" style="margin-bottom:14px">
                            <div class="preview-row">
                                <span class="preview-label">Tugas</span>
                                <span class="preview-val" id="prev-nt">—</span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">Harian</span>
                                <span class="preview-val" id="prev-nh">—</span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">UTS</span>
                                <span class="preview-val" id="prev-nu">—</span>
                            </div>
                            <div class="preview-row">
                                <span class="preview-label">UAS</span>
                                <span class="preview-val" id="prev-na">—</span>
                            </div>
                            <div class="preview-row" style="margin-top:4px;border-top:2px solid var(--border)">
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text)">Rata-rata</span>
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--brand-600)" id="prev-avg">—</span>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit-full">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Nilai
                        </button>
                        <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary" style="width:100%;justify-content:center;margin-top:8px">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

function updatePreview() {
    const fields = [
        { input: 'nt', preview: 'prev-nt' },
        { input: 'nh', preview: 'prev-nh' },
        { input: 'nu', preview: 'prev-nu' },
        { input: 'na', preview: 'prev-na' },
    ];
    let sum = 0, count = 0;
    fields.forEach(f => {
        const val = parseFloat(document.getElementById(f.input).value);
        const el  = document.getElementById(f.preview);
        if (!isNaN(val)) { el.textContent = val.toFixed(1); sum += val; count++; }
        else { el.textContent = '—'; }
    });
    document.getElementById('prev-avg').textContent = count > 0 ? (sum / count).toFixed(1) : '—';
}
updatePreview();
</script>
</x-app-layout>