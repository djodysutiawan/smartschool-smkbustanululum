<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;--danger:#dc2626;
}
.page{padding:28px 28px 48px;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
.breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px;}
.breadcrumb a{color:var(--brand-600);text-decoration:none;font-weight:600;}
.breadcrumb a:hover{text-decoration:underline;}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-primary{background:var(--brand-600);color:#fff;}
.btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
.btn-secondary:hover{background:var(--surface3);filter:none;}

.form-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;}
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
.card:last-child{margin-bottom:0;}
.card-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;background:var(--surface2);}
.card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);}
.card-body{padding:20px;}

.form-group{margin-bottom:18px;}
.form-group:last-child{margin-bottom:0;}
label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:6px;text-transform:uppercase;letter-spacing:.03em;}
label .req{color:var(--danger);margin-left:2px;}
label .hint{font-weight:400;color:var(--text3);font-size:11.5px;margin-left:4px;text-transform:none;}
.form-control{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,box-shadow .15s;box-sizing:border-box;}
.form-control:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.12);}
textarea.form-control{height:auto;padding:10px 12px;resize:vertical;}
select.form-control{cursor:pointer;}
.form-row{display:grid;gap:12px;}
.form-row.cols-2{grid-template-columns:1fr 1fr;}
.invalid-feedback{font-size:12px;color:var(--danger);margin-top:4px;}
.is-invalid{border-color:var(--danger)!important;}

.toggle-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:var(--surface2);border-radius:var(--radius-sm);border:1px solid var(--border);}
.toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
.toggle-sub{font-size:11.5px;color:var(--text3);margin-top:1px;}
.toggle{position:relative;width:42px;height:24px;flex-shrink:0;}
.toggle input{opacity:0;width:0;height:0;}
.slider-t{position:absolute;cursor:pointer;inset:0;background:#cbd5e1;border-radius:24px;transition:.25s;}
.slider-t:before{content:'';position:absolute;width:18px;height:18px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.25s;}
.toggle input:checked+.slider-t{background:var(--brand-600);}
.toggle input:checked+.slider-t:before{transform:translateX(18px);}

.color-picker-wrap{display:flex;align-items:center;gap:10px;}
.color-preview{width:40px;height:40px;border-radius:var(--radius-sm);border:1px solid var(--border);position:relative;overflow:hidden;cursor:pointer;flex-shrink:0;}
.color-preview-inner{width:100%;height:100%;}
.color-options{display:flex;gap:6px;flex-wrap:wrap;margin-top:8px;}
.color-opt{width:24px;height:24px;border-radius:6px;cursor:pointer;border:2px solid transparent;transition:all .15s;flex-shrink:0;}
.color-opt:hover,.color-opt.active{border-color:var(--text);transform:scale(1.1);}

.form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:4px;}

.alert-error{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius);font-size:13.5px;margin-bottom:20px;background:#fff0f0;border:1px solid #fecaca;color:var(--danger);}
.alert-error ul{margin:4px 0 0 16px;padding:0;}
.alert-error li{margin-top:2px;font-size:12.5px;}

@media(max-width:900px){.form-grid{grid-template-columns:1fr;}}
@media(max-width:640px){.page{padding:16px;}.form-row.cols-2{grid-template-columns:1fr;}}
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.agenda.index') }}">Agenda Sekolah</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Tambah Agenda</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Agenda</h1>
            <p class="page-sub">Buat jadwal atau agenda kegiatan sekolah baru</p>
        </div>
        <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div><strong>Terdapat kesalahan:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.agenda.store') }}">
        @csrf
        <div class="form-grid">
            {{-- Kolom Utama --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <p class="card-title">Informasi Agenda</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul Agenda <span class="req">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul') }}"
                                class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                                placeholder="Contoh: Upacara Bendera Hari Kemerdekaan">
                            @error('judul')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label>Deskripsi <span class="hint">(opsional)</span></label>
                            <textarea name="deskripsi" rows="4"
                                class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                                placeholder="Keterangan tambahan tentang agenda ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label>Lokasi <span class="hint">(opsional)</span></label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                                class="form-control {{ $errors->has('lokasi') ? 'is-invalid' : '' }}"
                                placeholder="Contoh: Aula Sekolah, Lapangan Upacara">
                            @error('lokasi')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <p class="card-title">Tanggal & Waktu</p>
                    </div>
                    <div class="card-body">
                        <div class="form-row cols-2" style="margin-bottom:16px;">
                            <div class="form-group" style="margin-bottom:0">
                                <label>Tanggal Mulai <span class="req">*</span></label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                    class="form-control {{ $errors->has('tanggal_mulai') ? 'is-invalid' : '' }}">
                                @error('tanggal_mulai')<p class="invalid-feedback">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label>Tanggal Selesai <span class="hint">(jika lebih 1 hari)</span></label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                    class="form-control {{ $errors->has('tanggal_selesai') ? 'is-invalid' : '' }}">
                                @error('tanggal_selesai')<p class="invalid-feedback">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="form-row cols-2">
                            <div class="form-group" style="margin-bottom:0">
                                <label>Jam Mulai <span class="hint">(opsional)</span></label>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                                    class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}">
                                @error('jam_mulai')<p class="invalid-feedback">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label>Jam Selesai <span class="hint">(opsional)</span></label>
                                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                                    class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}">
                                @error('jam_selesai')<p class="invalid-feedback">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        <p class="card-title">Pengaturan</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tipe Agenda</label>
                            <select name="tipe" class="form-control {{ $errors->has('tipe') ? 'is-invalid' : '' }}">
                                <option value="">— Pilih Tipe —</option>
                                @foreach($tipeList as $val => $label)
                                    <option value="{{ $val }}" {{ old('tipe') == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipe')<p class="invalid-feedback">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label>Warna Label <span class="hint">(untuk kalender)</span></label>
                            <div class="color-picker-wrap">
                                <div class="color-preview">
                                    <div class="color-preview-inner" id="colorPreview" style="background:{{ old('warna','#1f63db') }}"></div>
                                    <input type="color" id="colorPicker" value="{{ old('warna','#1f63db') }}"
                                        style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;">
                                </div>
                                <input type="text" name="warna" id="colorInput" value="{{ old('warna','#1f63db') }}"
                                    class="form-control" style="flex:1;" placeholder="#1f63db" maxlength="7">
                            </div>
                            <div class="color-options">
                                @foreach(['#1f63db','#15803d','#dc2626','#a16207','#7c3aed','#0891b2','#be185d','#ea580c','#475569'] as $c)
                                    <span class="color-opt {{ old('warna','#1f63db') == $c ? 'active' : '' }}"
                                        style="background:{{ $c }}" data-color="{{ $c }}"></span>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom:0">
                            <div class="toggle-wrap">
                                <div>
                                    <p class="toggle-label">Publikasikan</p>
                                    <p class="toggle-sub">Tampilkan di website sekolah</p>
                                </div>
                                <label class="toggle">
                                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                    <span class="slider-t"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Agenda
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const picker  = document.getElementById('colorPicker');
const input   = document.getElementById('colorInput');
const preview = document.getElementById('colorPreview');
const opts    = document.querySelectorAll('.color-opt');

function setColor(c) {
    preview.style.background = c;
    input.value  = c;
    picker.value = c;
    opts.forEach(o => o.classList.toggle('active', o.dataset.color === c));
}
picker.addEventListener('input', () => setColor(picker.value));
input.addEventListener('input', () => { if (/^#[0-9a-f]{6}$/i.test(input.value)) setColor(input.value); });
opts.forEach(o => o.addEventListener('click', () => setColor(o.dataset.color)));
</script>
</x-app-layout>