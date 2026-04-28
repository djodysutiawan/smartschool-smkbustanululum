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
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .back-link{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:color .15s;margin-bottom:8px}
    .back-link:hover{color:var(--brand-600)}

    .alert-warning{display:flex;align-items:center;gap:10px;padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;background:#fffbeb;border:1px solid #fde68a;color:#92400e}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .form-section{padding:20px 24px;border-bottom:1px solid var(--border)}
    .form-section:last-of-type{border-bottom:none}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:16px;display:flex;align-items:center;gap:8px}
    .section-title svg{color:var(--brand-600)}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .form-grid.cols-1{grid-template-columns:1fr}
    .field{display:flex;flex-direction:column;gap:5px}
    .field.span-2{grid-column:span 2}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626;margin-left:2px}
    .field input,.field select,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field input.error,.field select.error,.field textarea.error{border-color:#dc2626}
    .field textarea{resize:vertical;min-height:80px}
    .field-hint{font-size:11.5px;color:var(--text3);margin-top:2px}
    .field-error{font-size:11.5px;color:#dc2626;margin-top:2px}

    .form-footer{display:flex;gap:10px;justify-content:flex-end;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border)}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .siswa-preview{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;margin-top:8px}
    .siswa-preview-inner{display:flex;align-items:center;gap:10px}
    .siswa-avatar{width:36px;height:36px;border-radius:8px;background:var(--brand-100);display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .siswa-meta{font-size:12px;color:var(--text3)}

    @media(max-width:640px){
        .form-grid{grid-template-columns:1fr}
        .field.span-2{grid-column:span 1}
        .page{padding:16px}
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <a href="{{ route('admin.izin-keluar-siswa.show', $izin->id) }}" class="back-link">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Detail
            </a>
            <h1 class="page-title">Edit Izin Keluar Siswa</h1>
            <p class="page-sub">Edit izin keluar — hanya izin berstatus <strong>Menunggu</strong> yang dapat diubah</p>
        </div>
    </div>

    <div class="alert-warning">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Setelah izin disetujui atau ditolak, data tidak dapat diedit lagi.
    </div>

    <form action="{{ route('admin.izin-keluar-siswa.update', $izin->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card">

            {{-- Data Siswa --}}
            <div class="form-section">
                <p class="section-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Data Siswa
                </p>
                <div class="form-grid cols-1">
                    <div class="field">
                        <label>Pilih Siswa <span class="req">*</span></label>
                        <select name="siswa_id" id="siswaSelect" class="{{ $errors->has('siswa_id') ? 'error' : '' }}" required>
                            <option value="">— Pilih Siswa —</option>
                            @foreach($siswas as $s)
                                <option value="{{ $s->id }}"
                                    data-kelas="{{ $s->kelas->nama_kelas ?? '—' }}"
                                    data-nis="{{ $s->nis ?? '—' }}"
                                    {{ old('siswa_id', $izin->siswa_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_lengkap }} — {{ $s->kelas->nama_kelas ?? '—' }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id') <p class="field-error">{{ $message }}</p> @enderror

                        <div class="siswa-preview" id="siswaPreview">
                            <div class="siswa-preview-inner">
                                <div class="siswa-avatar">
                                    <svg width="18" height="18" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <div>
                                    <p class="siswa-name" id="previewNama">{{ $izin->siswa->nama_lengkap ?? '—' }}</p>
                                    <p class="siswa-meta" id="previewMeta">Kelas: {{ $izin->siswa->kelas->nama_kelas ?? '—' }}  ·  NIS: {{ $izin->siswa->nis ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Waktu & Tanggal --}}
            <div class="form-section">
                <p class="section-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Waktu & Tanggal
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $izin->tanggal?->format('Y-m-d')) }}" class="{{ $errors->has('tanggal') ? 'error' : '' }}" required>
                        @error('tanggal') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'error' : '' }}" required>
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $izin->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->label }}{{ $ta->isAktif() ? ' (Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="field">
                        <label>Jam Keluar <span class="req">*</span></label>
                        <input type="time" name="jam_keluar" value="{{ old('jam_keluar', $izin->jam_keluar) }}" class="{{ $errors->has('jam_keluar') ? 'error' : '' }}" required>
                        @error('jam_keluar') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="field">
                        <label>Rencana Jam Kembali</label>
                        <input type="time" name="jam_kembali" value="{{ old('jam_kembali', $izin->jam_kembali) }}" class="{{ $errors->has('jam_kembali') ? 'error' : '' }}">
                        <p class="field-hint">Opsional — perkiraan waktu kembali</p>
                        @error('jam_kembali') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Detail Keperluan --}}
            <div class="form-section">
                <p class="section-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
                    Detail Keperluan
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Kategori <span class="req">*</span></label>
                        <select name="kategori" class="{{ $errors->has('kategori') ? 'error' : '' }}" required>
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategoriList as $val => $label)
                                <option value="{{ $val }}" {{ old('kategori', $izin->kategori) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="field span-2">
                        <label>Tujuan / Keperluan <span class="req">*</span></label>
                        <input type="text" name="tujuan" value="{{ old('tujuan', $izin->tujuan) }}" class="{{ $errors->has('tujuan') ? 'error' : '' }}" required maxlength="255">
                        @error('tujuan') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="field span-2">
                        <label>Keterangan Tambahan</label>
                        <textarea name="keterangan" maxlength="1000" class="{{ $errors->has('keterangan') ? 'error' : '' }}">{{ old('keterangan', $izin->keterangan) }}</textarea>
                        @error('keterangan') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.izin-keluar-siswa.show', $izin->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

const siswaSelect = document.getElementById('siswaSelect');
const previewNama = document.getElementById('previewNama');
const previewMeta = document.getElementById('previewMeta');

siswaSelect.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (opt && opt.value) {
        previewNama.textContent = opt.text.split(' — ')[0];
        previewMeta.textContent = 'Kelas: ' + (opt.dataset.kelas || '—') + '  ·  NIS: ' + (opt.dataset.nis || '—');
    }
});
</script>
</x-app-layout>