<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-700:#1750c0;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-primary:hover{filter:brightness(.93);}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .info-banner{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px;}
    .info-banner p{font-size:13.5px;color:var(--text2);font-family:'DM Sans',sans-serif;}
    .info-banner strong{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .form-section{padding:20px 24px 24px;}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px;}
    .section-label-line{flex:1;height:1px;background:var(--border);}
    .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;}
    .col-span-2{grid-column:span 2;}
    .field{display:flex;flex-direction:column;gap:6px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .field input,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s;box-sizing:border-box;}
    .field textarea{height:auto;padding:10px 12px;resize:vertical;}
    .field input:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;}
    .nilai-preview{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:20px;margin-top:16px;flex-wrap:wrap;}
    .preview-block .lbl{font-size:11px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.05em;}
    .preview-block .num{font-family:'Plus Jakarta Sans',sans-serif;font-size:30px;font-weight:800;color:var(--brand);line-height:1;}
    .preview-sep{width:1px;height:44px;background:var(--border);}
    .preview-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;line-height:1.5;margin-left:auto;max-width:220px;}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @keyframes spin{to{transform:rotate(360deg);}}
    @media(max-width:680px){.page{padding:16px;}.form-grid-3{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.nilai.index') }}">Nilai Siswa</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.nilai.show', $nilai->id) }}">{{ Str::limit($nilai->siswa->nama_lengkap ?? 'Detail', 25) }}</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Nilai</h1>
            <p class="page-sub">Nilai akhir dan predikat akan dihitung ulang secara otomatis</p>
        </div>
        <a href="{{ route('admin.nilai.show', $nilai->id) }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="info-banner">
        <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
        <p>Mengedit nilai untuk <strong>{{ $nilai->siswa->nama_lengkap ?? '-' }}</strong>
            · Mapel: <strong>{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</strong>
            · Kelas: <strong>{{ $nilai->kelas->nama_kelas ?? '-' }}</strong>
            · TA: <strong>{{ $nilai->tahunAjaran->tahun ?? '-' }}</strong></p>
    </div>

    @if($errors->any())
        <div style="background:var(--red-bg,#fee2e2);border:1px solid #fecaca;border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;font-size:13.5px;color:var(--red)">
            <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Terdapat {{ $errors->count() }} kesalahan:</strong>
            <ul style="margin:6px 0 0 16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.nilai.update', $nilai->id) }}" method="POST" id="nilaiForm">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Input Nilai (0–100)
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid-3">
                    <div class="field">
                        <label>Nilai Tugas</label>
                        <input type="number" name="nilai_tugas" id="nilaiTugas" value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}" placeholder="0–100" min="0" max="100" step="0.01" oninput="calcPreview()">
                        @error('nilai_tugas')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nilai Harian</label>
                        <input type="number" name="nilai_harian" id="nilaiHarian" value="{{ old('nilai_harian', $nilai->nilai_harian) }}" placeholder="0–100" min="0" max="100" step="0.01" oninput="calcPreview()">
                        @error('nilai_harian')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nilai UTS</label>
                        <input type="number" name="nilai_uts" id="nilaiUts" value="{{ old('nilai_uts', $nilai->nilai_uts) }}" placeholder="0–100" min="0" max="100" step="0.01" oninput="calcPreview()">
                        @error('nilai_uts')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nilai UAS</label>
                        <input type="number" name="nilai_uas" id="nilaiUas" value="{{ old('nilai_uas', $nilai->nilai_uas) }}" placeholder="0–100" min="0" max="100" step="0.01" oninput="calcPreview()">
                        @error('nilai_uas')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Catatan</label>
                        <textarea name="catatan" rows="2" placeholder="Catatan tambahan (opsional)">{{ old('catatan', $nilai->catatan) }}</textarea>
                        @error('catatan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="nilai-preview">
                    <div class="preview-block">
                        <p class="lbl">Nilai Akhir (Estimasi)</p>
                        <p class="num" id="previewNum">{{ $nilai->nilai_akhir !== null ? number_format($nilai->nilai_akhir, 1) : '—' }}</p>
                    </div>
                    <div class="preview-sep"></div>
                    <div class="preview-block">
                        <p class="lbl">Predikat</p>
                        <p class="num" id="previewPred" style="font-size:28px">{{ $nilai->predikat ?? '—' }}</p>
                    </div>
                    <p class="preview-hint">Bobot: Tugas 20%, Harian 30%, UTS 20%, UAS 30%. Nilai akhir resmi dihitung ulang saat disimpan.</p>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.nilai.show', $nilai->id) }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    Swal.fire({icon:'error',title:'Terdapat Kesalahan',html:`<ul style="text-align:left;padding-left:16px;margin:0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,confirmButtonColor:'#1f63db'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif

    function calcPreview() {
        const t = parseFloat(document.getElementById('nilaiTugas').value) || 0;
        const h = parseFloat(document.getElementById('nilaiHarian').value) || 0;
        const u = parseFloat(document.getElementById('nilaiUts').value) || 0;
        const a = parseFloat(document.getElementById('nilaiUas').value) || 0;
        const avg = (t * 0.2) + (h * 0.3) + (u * 0.2) + (a * 0.3);
        document.getElementById('previewNum').textContent = avg.toFixed(1);
        let pred = '', col = '';
        if (avg >= 90) { pred = 'A'; col = '#15803d'; }
        else if (avg >= 80) { pred = 'B'; col = '#2563eb'; }
        else if (avg >= 70) { pred = 'C'; col = '#d97706'; }
        else if (avg >= 60) { pred = 'D'; col = '#dc2626'; }
        else { pred = 'E'; col = '#9f1239'; }
        document.getElementById('previewPred').textContent = pred;
        document.getElementById('previewPred').style.color = col;
        document.getElementById('previewNum').style.color = col;
    }
    calcPreview();

    document.getElementById('nilaiForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>