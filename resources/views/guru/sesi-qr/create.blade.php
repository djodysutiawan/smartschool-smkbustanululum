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

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .form-card-body{padding:20px;display:grid;gap:16px}
    .grid-2{grid-template-columns:1fr 1fr}

    .field{display:flex;flex-direction:column;gap:5px}
    .field.span-2{grid-column:span 2}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field label .hint{font-weight:400;color:var(--text3);margin-left:4px}
    .field input,.field select{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field select:focus{border-color:var(--brand-500);background:#fff}
    .field .error{font-size:11.5px;color:#dc2626;margin-top:2px}
    .field input.is-invalid,.field select.is-invalid{border-color:#dc2626}

    .info-box{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 14px;display:flex;align-items:flex-start;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:var(--brand-700)}
    .info-box svg{flex-shrink:0;margin-top:1px}

    @media(max-width:640px){
        .page{padding:16px}
        .grid-2{grid-template-columns:1fr}
        .field.span-2{grid-column:span 1}
    }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Sesi QR Baru</h1>
            <p class="page-sub">QR code akan digenerate otomatis setelah disimpan</p>
        </div>
        <a href="{{ route('guru.sesi-qr.index') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('guru.sesi-qr.store') }}" method="POST">
        @csrf

        {{-- Info --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span class="form-card-title">Informasi Sesi</span>
            </div>
            <div class="form-card-body grid-2">
                <div class="field">
                    <label>Kelas <span class="req">*</span></label>
                    <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Mata Pelajaran <span class="hint">(opsional)</span></label>
                    <select name="mata_pelajaran_id">
                        <option value="">— Semua Mapel —</option>
                        @foreach($mataPelajaran as $m)
                            <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field span-2">
                    <label>Tanggal Sesi <span class="req">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', today()->format('Y-m-d')) }}"
                           class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}">
                    @error('tanggal')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Waktu Berlaku --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="form-card-title">Waktu Berlaku QR</span>
            </div>
            <div class="form-card-body grid-2">
                <div class="field">
                    <label>Berlaku Mulai <span class="req">*</span></label>
                    <input type="datetime-local" name="berlaku_mulai" value="{{ old('berlaku_mulai') }}"
                           class="{{ $errors->has('berlaku_mulai') ? 'is-invalid' : '' }}">
                    @error('berlaku_mulai')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label>Kadaluarsa Pada <span class="req">*</span></label>
                    <input type="datetime-local" name="kadaluarsa_pada" value="{{ old('kadaluarsa_pada') }}"
                           class="{{ $errors->has('kadaluarsa_pada') ? 'is-invalid' : '' }}">
                    @error('kadaluarsa_pada')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="field span-2">
                    <div class="info-box">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Siswa hanya dapat melakukan scan QR dalam rentang waktu berlaku mulai hingga kadaluarsa. Pastikan waktu sesuai dengan jam pelajaran berlangsung.
                    </div>
                </div>
            </div>
        </div>

        {{-- Radius --}}
        <div class="form-card">
            <div class="form-card-header">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                <span class="form-card-title">Batasan Lokasi <span style="font-weight:400;color:var(--text3)">(opsional)</span></span>
            </div>
            <div class="form-card-body">
                <div class="field" style="max-width:300px">
                    <label>Radius Lokasi <span class="hint">10–1000 meter</span></label>
                    <input type="number" name="radius_meter" value="{{ old('radius_meter') }}" min="10" max="1000" placeholder="Contoh: 50">
                    @error('radius_meter')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="info-box" style="max-width:480px">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Kosongkan jika tidak perlu batasan lokasi. Jika diisi, siswa harus berada dalam radius yang ditentukan saat scan QR.
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
            <a href="{{ route('guru.sesi-qr.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Buat Sesi QR
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if($errors->any())
Swal.fire({icon:'warning',title:'Perhatian!',html:`{!! implode('<br>', $errors->all()) !!}`,confirmButtonColor:'#1f63db'});
@endif
</script>
</x-app-layout>