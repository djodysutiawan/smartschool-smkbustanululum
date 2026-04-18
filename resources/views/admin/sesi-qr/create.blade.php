<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-700:#1750c0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-cancel:hover{background:var(--surface3);}
    .btn-primary{background:var(--brand);color:#fff;}.btn-primary:hover{filter:brightness(.93);}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    .info-box{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 16px;font-size:13px;color:var(--brand-700);font-family:'DM Sans',sans-serif;margin-bottom:16px;display:flex;align-items:flex-start;gap:8px;}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .form-section{padding:20px 24px 24px;}
    .section-divider{border:none;border-top:1px solid var(--border);margin:0;}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px;}
    .section-label-line{flex:1;height:1px;background:var(--border);}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .col-span-2{grid-column:span 2;}
    .field{display:flex;flex-direction:column;gap:6px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .field label .req{color:var(--brand);margin-left:2px;}
    .field label .opt{color:var(--text3);font-weight:400;margin-left:4px;font-size:11.5px;}
    .field input,.field select{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s;}
    .field input:focus,.field select:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field input::placeholder{color:var(--text3);}
    .field input.is-invalid,.field select.is-invalid{border-color:var(--red);background:#fff8f8;}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px;}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @media(max-width:680px){.page{padding:16px 16px 40px;}.form-grid{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.sesi-qr.index') }}">Sesi QR</a>
        <span class="sep">›</span>
        <span class="current">Buat Sesi Baru</span>
    </nav>
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Sesi QR Code</h1>
            <p class="page-sub">Buat sesi baru untuk absensi siswa via QR Code</p>
        </div>
        <a href="{{ route('admin.sesi-qr.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- ─── Error summary ──────────────────────────────────────────────────── --}}
    @if($errors->any())
    <div class="alert">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Terdapat {{ $errors->count() }} kesalahan:</strong>
            <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="info-box">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Setelah sesi dibuat, QR Code akan ditampilkan di halaman detail. Siswa dapat scan QR untuk absensi selama sesi masih aktif.
    </div>

    <form action="{{ route('admin.sesi-qr.store') }}" method="POST" id="sesiForm">
        @csrf
        <div class="form-card">

            {{-- ─── Kelas & Mata Pelajaran ─────────────────────────────────────── --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Kelas &amp; Mata Pelajaran
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    {{-- BUGFIX: controller mengirim $kelasList, bukan $kelas --}}
                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- BUGFIX: nullable di controller → label tidak pakai tanda * wajib --}}
                    <div class="field">
                        <label>Mata Pelajaran <span class="opt">(opsional)</span></label>
                        <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Mata Pelajaran —</option>
                            @foreach($mataPelajaran as $mp)
                                <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                    {{ $mp->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ─── Waktu Sesi ──────────────────────────────────────────────────── --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Waktu Sesi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    {{-- tanggal: type="date" → validasi 'date' di controller ✓ --}}
                    <div class="field col-span-2">
                        <label>Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal"
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}">
                        @error('tanggal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- berlaku_mulai: type="datetime-local" → validasi 'date' di controller ✓ --}}
                    <div class="field">
                        <label>Berlaku Mulai <span class="req">*</span></label>
                        <input type="datetime-local" name="berlaku_mulai"
                               value="{{ old('berlaku_mulai') }}"
                               class="{{ $errors->has('berlaku_mulai') ? 'is-invalid' : '' }}">
                        @error('berlaku_mulai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- kadaluarsa_pada: validasi 'after:berlaku_mulai' di controller ✓ --}}
                    <div class="field">
                        <label>Kadaluarsa Pada <span class="req">*</span></label>
                        <input type="datetime-local" name="kadaluarsa_pada"
                               value="{{ old('kadaluarsa_pada') }}"
                               class="{{ $errors->has('kadaluarsa_pada') ? 'is-invalid' : '' }}">
                        @error('kadaluarsa_pada')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- radius_meter: nullable integer min:10 max:1000 --}}
                    <div class="field col-span-2">
                        <label>Radius Lokasi (meter) <span class="opt">(opsional)</span></label>
                        <input type="number" name="radius_meter"
                               value="{{ old('radius_meter', 100) }}"
                               min="10" max="1000" placeholder="cth. 100"
                               class="{{ $errors->has('radius_meter') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Radius maksimal dari lokasi sekolah agar scan dianggap valid. Kosongkan jika tidak menggunakan validasi lokasi.</span>
                        @error('radius_meter')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.sesi-qr.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M20 14h.01M20 17h.01M20 20h.01M17 20h.01M14 20h.01"/></svg>
                    Buat Sesi QR
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ─── SweetAlert flash ────────────────────────────────────────────────────
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif

    // ─── Auto-isi kadaluarsa = berlaku_mulai + 30 menit ─────────────────────
    document.querySelector('[name=berlaku_mulai]').addEventListener('change', function () {
        const d = new Date(this.value);
        if (!isNaN(d)) {
            d.setMinutes(d.getMinutes() + 30);
            const pad = n => String(n).padStart(2, '0');
            const val = `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
            document.querySelector('[name=kadaluarsa_pada]').value = val;
        }
    });

    // ─── Loading state saat submit ───────────────────────────────────────────
    document.getElementById('sesiForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Membuat Sesi…`;
    });
</script>
</x-app-layout>