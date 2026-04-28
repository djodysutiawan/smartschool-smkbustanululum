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
    .page{padding:28px 28px 40px;max-width:2000px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .form-card-body{padding:20px;display:grid;gap:16px}
    .grid-2{grid-template-columns:1fr 1fr}
    .grid-3{grid-template-columns:1fr 1fr 1fr}

    .field{display:flex;flex-direction:column;gap:5px}
    .field.span-2{grid-column:span 2}
    .field.span-3{grid-column:span 3}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .hint{font-weight:400;color:var(--text3);margin-left:4px}
    .field input,.field select,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:80px}
    .field .error{font-size:11.5px;color:#dc2626;margin-top:2px}

    /* Info readonly */
    .info-readonly{padding:9px 12px;background:var(--surface3);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2)}
    .info-readonly small{display:block;font-size:11px;color:var(--text3);font-weight:400;margin-top:2px}

    .status-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:8px}
    .status-option{position:relative}
    .status-option input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .status-card{display:flex;flex-direction:column;align-items:center;gap:5px;padding:10px 6px;border:2px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;background:var(--surface2);text-align:center}
    .status-option input:checked + .status-card.hadir{border-color:#15803d;background:#f0fdf4;box-shadow:0 0 0 3px #bbf7d0}
    .status-option input:checked + .status-card.telat {border-color:#a16207;background:#fefce8;box-shadow:0 0 0 3px #fde68a}
    .status-option input:checked + .status-card.izin  {border-color:#1d4ed8;background:#eff6ff;box-shadow:0 0 0 3px #bfdbfe}
    .status-option input:checked + .status-card.sakit {border-color:#7c3aed;background:#faf5ff;box-shadow:0 0 0 3px #e9d5ff}
    .status-option input:checked + .status-card.alfa  {border-color:#dc2626;background:#fff0f0;box-shadow:0 0 0 3px #fecaca}
    .status-dot{width:10px;height:10px;border-radius:50%}
    .status-dot.hadir{background:#15803d}.status-dot.telat{background:#a16207}.status-dot.izin{background:#1d4ed8}.status-dot.sakit{background:#7c3aed}.status-dot.alfa{background:#dc2626}
    .status-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}

    .existing-file{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:8px}
    .existing-file-icon{width:32px;height:32px;background:var(--brand-50);border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0}

    .upload-area{border:2px dashed var(--border2);border-radius:var(--radius-sm);padding:20px;text-align:center;background:var(--surface2);cursor:pointer;transition:border-color .15s;position:relative}
    .upload-area:hover{border-color:var(--brand-500);background:#f8fbff}
    .upload-area input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
    .upload-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:3px}
    .upload-hint{font-size:12px;color:var(--text3)}
    .upload-filename{font-size:12.5px;color:var(--brand-600);margin-top:6px;font-weight:600;display:none}

    @media(max-width:640px){
        .page{padding:16px}
        .grid-2,.grid-3{grid-template-columns:1fr}
        .field.span-2,.field.span-3{grid-column:span 1}
        .status-grid{grid-template-columns:1fr 1fr}
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Absensi</h1>
            <p class="page-sub">{{ $absensi->siswa->nama_lengkap ?? '—' }} — {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</p>
        </div>
        <a href="{{ route('guru.absensi.show', $absensi->id) }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('guru.absensi.update', $absensi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Info (readonly) --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="form-card-title">Data Absensi <span style="font-weight:400;color:var(--text3);font-size:12px">(tidak dapat diubah)</span></span>
            </div>
            <div class="form-card-body grid-2">
                <div class="field">
                    <label>Siswa</label>
                    <div class="info-readonly">{{ $absensi->siswa->nama_lengkap ?? '—' }}<small>NIS: {{ $absensi->siswa->nis ?? '—' }}</small></div>
                </div>
                <div class="field">
                    <label>Kelas</label>
                    <div class="info-readonly">{{ $absensi->kelas->nama_kelas ?? '—' }}</div>
                </div>
                <div class="field">
                    <label>Tanggal</label>
                    <div class="info-readonly">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</div>
                </div>
                <div class="field">
                    <label>Jadwal Pelajaran</label>
                    <div class="info-readonly">{{ $absensi->jadwalPelajaran->mataPelajaran->nama_mapel ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span class="form-card-title">Status Kehadiran</span>
            </div>
            <div class="form-card-body">
                <div class="status-grid">
                    @foreach($statusList as $s)
                    <label class="status-option">
                        <input type="radio" name="status" value="{{ $s }}" {{ old('status', $absensi->status) === $s ? 'checked' : '' }}>
                        <div class="status-card {{ $s }}">
                            <span class="status-dot {{ $s }}"></span>
                            <span class="status-label">{{ ucfirst($s) }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('status')<span class="error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Detail Waktu --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="form-card-title">Detail Waktu & Metode</span>
            </div>
            <div class="form-card-body grid-3">
                <div class="field">
                    <label>Jam Masuk <span class="hint">(opsional)</span></label>
                    <input type="time" name="jam_masuk" value="{{ old('jam_masuk', $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '') }}">
                    @error('jam_masuk')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label>Jam Keluar <span class="hint">(opsional)</span></label>
                    <input type="time" name="jam_keluar" value="{{ old('jam_keluar', $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '') }}">
                    @error('jam_keluar')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label>Metode <span class="hint">(opsional)</span></label>
                    <select name="metode">
                        <option value="">— Pilih Metode —</option>
                        @foreach($metodeList as $m)
                            <option value="{{ $m }}" {{ old('metode', $absensi->metode) === $m ? 'selected' : '' }}>{{ $m === 'qr' ? 'QR Code' : ucfirst($m) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field span-3">
                    <label>Keterangan <span class="hint">(opsional)</span></label>
                    <textarea name="keterangan" placeholder="Catatan tambahan…">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Surat Izin --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="form-card-title">Surat Izin <span style="font-weight:400;color:var(--text3)">(opsional)</span></span>
            </div>
            <div class="form-card-body">
                @if($absensi->path_surat_izin)
                <div class="existing-file">
                    <div class="existing-file-icon"><svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                    <div style="flex:1;overflow:hidden">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ basename($absensi->path_surat_izin) }}</p>
                        <p style="font-size:11.5px;color:var(--text3)">Surat izin saat ini — upload baru untuk mengganti</p>
                    </div>
                    <a href="{{ Storage::url($absensi->path_surat_izin) }}" target="_blank" class="btn btn-secondary btn-sm">Lihat</a>
                </div>
                @endif
                <div class="field">
                    <label>{{ $absensi->path_surat_izin ? 'Ganti Surat' : 'Upload Surat' }} <span class="hint">PDF/JPG/PNG, maks. 2MB</span></label>
                    <div class="upload-area" onclick="document.getElementById('suratInput').click()">
                        <input type="file" name="path_surat_izin" id="suratInput" accept=".pdf,.jpg,.jpeg,.png" onchange="showFile(this,'suratLabel')">
                        <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 6px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <p class="upload-label">Klik untuk pilih file</p>
                        <p id="suratLabel" class="upload-filename"></p>
                    </div>
                    @error('path_surat_izin')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
            <a href="{{ route('guru.absensi.show', $absensi->id) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Perbarui Absensi
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({icon:'warning',title:'Perhatian!',html:`{!! implode('<br>', $errors->all()) !!}`,confirmButtonColor:'#1f63db'});
@endif
function showFile(input, labelId) {
    const lbl = document.getElementById(labelId);
    if (input.files[0]) { lbl.textContent = input.files[0].name; lbl.style.display = 'block'; }
}
</script>
</x-app-layout>