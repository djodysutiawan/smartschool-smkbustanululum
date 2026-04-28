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
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* Form card */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-body{padding:20px}

    /* Info readonly strip */
    .readonly-strip{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;display:flex;gap:24px;flex-wrap:wrap}
    .readonly-item .label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:2px}
    .readonly-item .val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}

    /* Fields */
    .fields-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field input[type=number],.field textarea,.field select{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;width:100%}
    .field input:focus,.field textarea:focus,.field select:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .field .hint{font-size:11.5px;color:var(--text3)}
    .field .error{font-size:11.5px;color:#dc2626;margin-top:2px}
    .field input.is-error,.field textarea.is-error{border-color:#dc2626;background:#fff8f8}

    /* Nilai preview live */
    .preview-bar{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:18px;display:flex;align-items:center;gap:20px;flex-wrap:wrap}
    .preview-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3)}
    .preview-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--brand-600);min-width:48px}
    .preview-predikat{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;padding:3px 14px;border-radius:99px}

    .form-actions{display:flex;gap:8px;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--border)}

    @media(max-width:768px){
        .fields-grid{grid-template-columns:repeat(2,1fr)}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Nilai</h1>
            <p class="page-sub">Perbarui komponen nilai siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.nilai.show', $nilai->id) }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Batal
            </a>
        </div>
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            <span class="form-card-title">Edit Nilai Siswa</span>
        </div>
        <div class="form-body">

            {{-- Readonly info --}}
            <div class="readonly-strip">
                <div class="readonly-item">
                    <p class="label">Siswa</p>
                    <p class="val">{{ $nilai->siswa->nama_lengkap ?? '—' }}</p>
                </div>
                <div class="readonly-item">
                    <p class="label">Kelas</p>
                    <p class="val">{{ $nilai->kelas->nama_kelas ?? '—' }}</p>
                </div>
                <div class="readonly-item">
                    <p class="label">Mata Pelajaran</p>
                    <p class="val">{{ $nilai->mataPelajaran->nama_mapel ?? '—' }}</p>
                </div>
                <div class="readonly-item">
                    <p class="label">Tahun Ajaran</p>
                    <p class="val">{{ $nilai->tahunAjaran->tahun ?? '—' }} / {{ $nilai->tahunAjaran->semester ?? '—' }}</p>
                </div>
            </div>

            {{-- Preview nilai live --}}
            <div class="preview-bar">
                <div>
                    <p class="preview-label">Rata-rata Sementara</p>
                    <p class="preview-val" id="previewNilai">—</p>
                </div>
                <div>
                    <p class="preview-label">Predikat</p>
                    <span class="preview-predikat" id="previewPredikat" style="background:var(--surface3);color:var(--text3)">—</span>
                </div>
                <p style="font-size:12px;color:var(--text3);margin-top:auto">* Dihitung dari rata-rata 4 komponen yang diisi</p>
            </div>

            <form action="{{ route('guru.nilai.update', $nilai->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="fields-grid">
                    <div class="field">
                        <label>Nilai Tugas <span style="font-size:11px;color:var(--text3)">(0–100)</span></label>
                        <input type="number" name="nilai_tugas" id="nilaiTugas" min="0" max="100" step="0.01"
                               value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}"
                               placeholder="Kosongkan jika belum ada"
                               class="{{ $errors->has('nilai_tugas') ? 'is-error' : '' }}"
                               oninput="updatePreview()">
                        @error('nilai_tugas')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nilai Harian <span style="font-size:11px;color:var(--text3)">(0–100)</span></label>
                        <input type="number" name="nilai_harian" id="nilaiHarian" min="0" max="100" step="0.01"
                               value="{{ old('nilai_harian', $nilai->nilai_harian) }}"
                               placeholder="Kosongkan jika belum ada"
                               class="{{ $errors->has('nilai_harian') ? 'is-error' : '' }}"
                               oninput="updatePreview()">
                        @error('nilai_harian')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nilai UTS <span style="font-size:11px;color:var(--text3)">(0–100)</span></label>
                        <input type="number" name="nilai_uts" id="nilaiUts" min="0" max="100" step="0.01"
                               value="{{ old('nilai_uts', $nilai->nilai_uts) }}"
                               placeholder="Kosongkan jika belum ada"
                               class="{{ $errors->has('nilai_uts') ? 'is-error' : '' }}"
                               oninput="updatePreview()">
                        @error('nilai_uts')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nilai UAS <span style="font-size:11px;color:var(--text3)">(0–100)</span></label>
                        <input type="number" name="nilai_uas" id="nilaiUas" min="0" max="100" step="0.01"
                               value="{{ old('nilai_uas', $nilai->nilai_uas) }}"
                               placeholder="Kosongkan jika belum ada"
                               class="{{ $errors->has('nilai_uas') ? 'is-error' : '' }}"
                               oninput="updatePreview()">
                        @error('nilai_uas')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="field" style="margin-bottom:18px">
                    <label>Catatan <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                    <textarea name="catatan" rows="3" maxlength="500"
                              placeholder="Catatan tambahan untuk nilai ini…"
                              class="{{ $errors->has('catatan') ? 'is-error' : '' }}"
                              style="resize:vertical">{{ old('catatan', $nilai->catatan) }}</textarea>
                    @error('catatan')<span class="error">{{ $message }}</span>@enderror
                    <span class="hint">Maksimal 500 karakter</span>
                </div>

                <div class="form-actions">
                    <a href="{{ route('guru.nilai.show', $nilai->id) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

const PREDIKAT_COLORS = {
    A: ['#dcfce7','#15803d'], B: ['#dbeafe','#1d4ed8'],
    C: ['#fefce8','#a16207'], D: ['#fff7ed','#c2410c'], E: ['#fee2e2','#dc2626']
};

function updatePreview() {
    const vals = [
        parseFloat(document.getElementById('nilaiTugas').value),
        parseFloat(document.getElementById('nilaiHarian').value),
        parseFloat(document.getElementById('nilaiUts').value),
        parseFloat(document.getElementById('nilaiUas').value),
    ].filter(v => !isNaN(v));

    if (vals.length === 0) {
        document.getElementById('previewNilai').textContent = '—';
        const p = document.getElementById('previewPredikat');
        p.textContent = '—'; p.style.background = 'var(--surface3)'; p.style.color = 'var(--text3)';
        return;
    }

    const avg = vals.reduce((a, b) => a + b, 0) / vals.length;
    document.getElementById('previewNilai').textContent = avg.toFixed(1);

    let predikat = avg >= 90 ? 'A' : avg >= 80 ? 'B' : avg >= 70 ? 'C' : avg >= 60 ? 'D' : 'E';
    const p = document.getElementById('previewPredikat');
    const [bg, fg] = PREDIKAT_COLORS[predikat];
    p.textContent = predikat; p.style.background = bg; p.style.color = fg;
}

// Init on load
document.addEventListener('DOMContentLoaded', updatePreview);
</script>
</x-app-layout>