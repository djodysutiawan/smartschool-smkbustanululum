<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root{
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;--danger:#dc2626;
}
.page{padding:28px 28px 40px}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
.btn:hover{filter:brightness(.93)}
.btn-primary{background:var(--brand-600);color:#fff}
.btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
.btn-back:hover{background:var(--surface3);filter:none}

.form-grid{display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start}

.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
.card:last-child{margin-bottom:0}
.card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px}
.card-header-icon{width:32px;height:32px;border-radius:8px;background:var(--brand-50);display:flex;align-items:center;justify-content:center}
.card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}
.card-body{padding:20px}

.form-group{margin-bottom:16px}
.form-group:last-child{margin-bottom:0}
.form-label{display:block;margin-bottom:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
.form-label .req{color:var(--danger);margin-left:2px}
.form-label .opt{font-weight:500;color:var(--text3);font-size:11px;margin-left:4px;text-transform:uppercase;letter-spacing:.04em}
.form-control{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;box-sizing:border-box}
.form-control:focus{border-color:var(--brand-500);background:#fff}
.form-control::placeholder{color:var(--text3)}
.form-control.is-invalid{border-color:var(--danger)}
textarea.form-control{height:auto;padding:10px 12px;resize:vertical;min-height:90px}
.form-hint{font-size:11.5px;color:var(--text3);margin-top:5px}
.form-error{font-size:12px;color:var(--danger);margin-top:4px;font-weight:600}

.two-col{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.three-col{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}

.form-divider{border:none;border-top:1px solid var(--surface3);margin:16px 0}

.img-preview-wrap{width:100%;aspect-ratio:4/3;border-radius:var(--radius-sm);border:2px dashed var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:center;overflow:hidden;margin-bottom:12px;transition:border-color .15s}
.img-preview-wrap:hover{border-color:var(--brand-500)}
.img-preview-wrap img{width:100%;height:100%;object-fit:cover}
.img-placeholder{text-align:center;color:var(--text3)}
.img-placeholder p{font-size:12px;font-weight:600;margin-top:8px}
.img-placeholder small{font-size:11px}
.file-input-wrap{position:relative}
.file-input-wrap input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;z-index:2}
.file-input-btn{display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:9px;border-radius:var(--radius-sm);background:var(--surface2);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);cursor:pointer;transition:all .15s}
.file-input-btn:hover{background:var(--brand-50);border-color:var(--brand-100);color:var(--brand-700)}

.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--surface3)}
.toggle-row:last-child{border-bottom:none;padding-bottom:0}
.toggle-row:first-child{padding-top:0}
.toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
.toggle-sub{font-size:11.5px;color:var(--text3);margin-top:2px}
.switch{position:relative;width:40px;height:22px;flex-shrink:0}
.switch input{opacity:0;width:0;height:0}
.slider-sw{position:absolute;inset:0;background:var(--border2);border-radius:99px;cursor:pointer;transition:.2s}
.slider-sw:before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.2s}
.switch input:checked+.slider-sw{background:var(--brand-600)}
.switch input:checked+.slider-sw:before{transform:translateX(18px)}

.action-bar{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 20px;border-top:1px solid var(--border);background:var(--surface2)}

.tingkat-select-hint{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}
.tingkat-chip{padding:3px 10px;border-radius:99px;font-size:11.5px;font-weight:700;cursor:pointer;border:1px solid transparent;transition:all .15s}
.tingkat-chip.sekolah{background:#f0fdf4;color:#15803d;border-color:#bbf7d0}
.tingkat-chip.kecamatan{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe}
.tingkat-chip.kabupaten{background:#faf5ff;color:#7c3aed;border-color:#e9d5ff}
.tingkat-chip.provinsi{background:#fff7ed;color:#c2410c;border-color:#fed7aa}
.tingkat-chip.nasional{background:#fef9c3;color:#a16207;border-color:#fde68a}
.tingkat-chip.internasional{background:#fdf2f8;color:#be185d;border-color:#fbcfe8}

@media(max-width:900px){.form-grid{grid-template-columns:1fr}.two-col,.three-col{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Prestasi Baru</h1>
            <p class="page-sub">Isi data lengkap prestasi siswa, guru, atau sekolah</p>
        </div>
        <a href="{{ route('admin.prestasi.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.prestasi.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">

            {{-- ── KOLOM KIRI ── --}}
            <div>
                {{-- Informasi Utama --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                        </div>
                        <p class="card-title">Informasi Utama</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Judul Prestasi <span class="req">*</span></label>
                            <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                                value="{{ old('judul') }}" placeholder="Contoh: Juara 1 Olimpiade Matematika Nasional" required>
                            @error('judul') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div class="two-col">
                            <div class="form-group">
                                <label class="form-label">Tingkat <span class="req">*</span></label>
                                <select name="tingkat" id="tingkatSelect" class="form-control {{ $errors->has('tingkat') ? 'is-invalid' : '' }}" required onchange="highlightTingkat(this.value)">
                                    <option value="">-- Pilih Tingkat --</option>
                                    @foreach(['sekolah','kecamatan','kabupaten','provinsi','nasional','internasional'] as $t)
                                        <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                    @endforeach
                                </select>
                                <div class="tingkat-select-hint">
                                    @foreach(['sekolah','kecamatan','kabupaten','provinsi','nasional','internasional'] as $t)
                                        <span class="tingkat-chip {{ $t }}" onclick="selectTingkat('{{ $t }}')">{{ ucfirst($t) }}</span>
                                    @endforeach
                                </div>
                                @error('tingkat') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Peringkat / Penghargaan <span class="opt">opsional</span></label>
                                <input type="text" name="peringkat" class="form-control"
                                    value="{{ old('peringkat') }}" placeholder="Contoh: Juara 1, Medali Emas">
                            </div>
                        </div>

                        <div class="two-col">
                            <div class="form-group">
                                <label class="form-label">Bidang <span class="opt">opsional</span></label>
                                <input type="text" name="bidang" class="form-control"
                                    value="{{ old('bidang') }}" placeholder="Contoh: Matematika, Olahraga">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control"
                                    value="{{ old('tahun', date('Y')) }}" min="2000" max="{{ date('Y') }}">
                            </div>
                        </div>

                        <div class="two-col">
                            <div class="form-group">
                                <label class="form-label">Nama Event <span class="opt">opsional</span></label>
                                <input type="text" name="nama_event" class="form-control"
                                    value="{{ old('nama_event') }}" placeholder="Nama kompetisi / kegiatan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal <span class="opt">opsional</span></label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ old('tanggal') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Penyelenggara <span class="opt">opsional</span></label>
                            <input type="text" name="penyelenggara" class="form-control"
                                value="{{ old('penyelenggara') }}" placeholder="Contoh: Kemendikbud, Pemprov Jawa Barat">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi <span class="opt">opsional</span></label>
                            <textarea name="deskripsi" class="form-control" rows="4"
                                placeholder="Ceritakan detail prestasi ini...">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Penerima --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <p class="card-title">Informasi Penerima</p>
                    </div>
                    <div class="card-body">
                        <div class="two-col">
                            <div class="form-group">
                                <label class="form-label">Tipe Penerima <span class="req">*</span></label>
                                <select name="tipe_penerima" class="form-control {{ $errors->has('tipe_penerima') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach(['siswa','tim','guru','sekolah'] as $tp)
                                        <option value="{{ $tp }}" {{ old('tipe_penerima') == $tp ? 'selected' : '' }}>{{ ucfirst($tp) }}</option>
                                    @endforeach
                                </select>
                                @error('tipe_penerima') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jurusan <span class="opt">opsional</span></label>
                                <select name="jurusan_id" class="form-control">
                                    <option value="">-- Semua Jurusan --</option>
                                    @foreach($jurusan as $j)
                                        <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Penerima <span class="opt">opsional</span></label>
                            <input type="text" name="nama_penerima" class="form-control"
                                value="{{ old('nama_penerima') }}" placeholder="Nama siswa, guru, atau tim">
                        </div>
                    </div>
                </div>

                {{-- Foto & Sertifikat --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <p class="card-title">Foto & Sertifikat</p>
                    </div>
                    <div class="card-body">
                        <div class="two-col">
                            <div>
                                <label class="form-label">Foto Prestasi <span class="opt">opsional</span></label>
                                <div class="img-preview-wrap" id="fotoPreviewWrap">
                                    <img id="fotoPreviewImg" src="" style="display:none" alt="">
                                    <div class="img-placeholder" id="fotoPlaceholder">
                                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        <p>Preview foto</p>
                                        <small>Maks 2 MB</small>
                                    </div>
                                </div>
                                <div class="file-input-wrap">
                                    <input type="file" name="foto" accept="image/*" onchange="previewImg(this,'fotoPreviewImg','fotoPlaceholder')">
                                    <div class="file-input-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>Pilih Foto</div>
                                </div>
                                @error('foto') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Sertifikat <span class="opt">opsional</span></label>
                                <div class="img-preview-wrap" style="align-items:center;flex-direction:column;gap:8px" id="sertifWrap">
                                    <svg width="36" height="36" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    <span id="sertifName" style="font-size:12px;color:var(--text3);font-weight:600">Belum dipilih</span>
                                </div>
                                <div class="file-input-wrap">
                                    <input type="file" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png" onchange="showFileName(this,'sertifName')">
                                    <div class="file-input-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>Pilih File</div>
                                </div>
                                <p class="form-hint">PDF, JPG, PNG. Maks 5 MB.</p>
                                @error('sertifikat') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:14px">
                            <label class="form-label">URL Foto <span class="opt">opsional — jika tidak upload file</span></label>
                            <input type="url" name="foto_url" class="form-control"
                                value="{{ old('foto_url') }}" placeholder="https://...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── KOLOM KANAN ── --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">
                            <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-2.82 1.17V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 2.82 1.17l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <p class="card-title">Pengaturan</p>
                    </div>
                    <div class="card-body">
                        <div class="toggle-row">
                            <div>
                                <p class="toggle-label">Publikasikan</p>
                                <p class="toggle-sub">Tampilkan di halaman publik</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                                <span class="slider-sw"></span>
                            </label>
                        </div>
                        <div class="toggle-row">
                            <div>
                                <p class="toggle-label">Unggulan</p>
                                <p class="toggle-sub">Tampil di sorotan beranda</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="slider-sw"></span>
                            </label>
                        </div>
                        <div style="margin-top:16px">
                            <label class="form-label">Urutan Tampil <span class="opt">opsional</span></label>
                            <input type="number" name="urutan" class="form-control" min="0"
                                value="{{ old('urutan', 0) }}">
                            <p class="form-hint">Angka lebih kecil tampil lebih dulu.</p>
                        </div>
                    </div>
                    <div class="action-bar">
                        <a href="{{ route('admin.prestasi.index') }}" class="btn btn-back">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    Swal.fire({icon:'error',title:'Periksa Form',text:'Ada beberapa field yang perlu diperbaiki.',confirmButtonColor:'#1f63db'});
    @endif

    function previewImg(input, imgId, placeholderId) {
        if (input.files && input.files[0]) {
            const r = new FileReader();
            r.onload = e => {
                const img = document.getElementById(imgId);
                img.src = e.target.result;
                img.style.display = 'block';
                document.getElementById(placeholderId).style.display = 'none';
            };
            r.readAsDataURL(input.files[0]);
        }
    }
    function showFileName(input, spanId) {
        document.getElementById(spanId).textContent = input.files[0]?.name ?? 'Belum dipilih';
    }
    function selectTingkat(val) {
        document.getElementById('tingkatSelect').value = val;
        highlightTingkat(val);
    }
    function highlightTingkat(val) {
        document.querySelectorAll('.tingkat-chip').forEach(c => {
            c.style.boxShadow = c.classList.contains(val) ? '0 0 0 2px currentColor' : '';
            c.style.opacity   = c.classList.contains(val) ? '1' : '0.6';
        });
    }
</script>
</x-app-layout>