<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-h: #3582f0; --brand-50: #eef6ff; --brand-100: #d9ebff; --brand-700: #1750c0;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --red: #dc2626; --red-bg: #fee2e2; --red-border: #fecaca;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 20px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn-back { padding: 8px 14px; font-size: 13px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-cancel { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }
    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }
    .section-label { display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px; }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .col-span-2 { grid-column: span 2; }
    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input, .field select, .field textarea { height: 38px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); width: 100%; outline: none; transition: border-color .15s, background .15s; box-sizing: border-box; }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid, .field select.is-invalid, .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .toggle-row { display: flex; align-items: center; gap: 12px; }
    .toggle-switch { position: relative; display: inline-block; width: 42px; height: 24px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; border-radius: 99px; background: var(--border2); cursor: pointer; transition: background .2s; }
    .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .toggle-switch input:checked + .toggle-slider { background: var(--brand); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }
    .toggle-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text2); }
    .checkbox-item { display: flex; align-items: center; gap: 10px; cursor: pointer; margin-top: 4px; }
    .checkbox-item input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--brand); cursor: pointer; flex-shrink: 0; }
    .checkbox-item span { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text2); }
    .form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border); }
    .scope-tabs { display: flex; gap: 0; border: 1px solid var(--border); border-radius: var(--radius-sm); overflow: hidden; width: fit-content; }
    .scope-tab { position: relative; cursor: pointer; }
    .scope-tab input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .scope-tab-label { display: flex; align-items: center; gap: 7px; padding: 9px 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text2); background: var(--surface2); cursor: pointer; transition: all .15s; border-right: 1px solid var(--border); user-select: none; }
    .scope-tab:last-child .scope-tab-label { border-right: none; }
    .scope-tab input:checked + .scope-tab-label { background: var(--brand); color: #fff; }
    .scope-tab input:checked + .scope-tab-label svg { stroke: #fff; }
    #jurusanSection { display: none; }
    #jurusanSection.visible { display: block; }
    .jurusan-grid { display: flex; flex-direction: column; gap: 10px; }
    .jurusan-item { border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface2); transition: border-color .15s, background .15s; }
    .jurusan-item.selected { border-color: var(--brand); background: var(--brand-50); }
    .jurusan-item-header { display: flex; align-items: center; padding: 12px 16px; }
    .jurusan-check-label { display: flex; align-items: center; gap: 12px; flex: 1; cursor: pointer; min-width: 0; }
    .jurusan-check-label input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--brand); flex-shrink: 0; cursor: pointer; }
    .jurusan-item-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); flex: 1; min-width: 0; word-break: break-word; overflow: visible; }
    .jurusan-item-toggle { font-size: 11.5px; font-weight: 600; color: var(--text3); font-family: 'DM Sans', sans-serif; white-space: nowrap; flex-shrink: 0; margin-left: auto; padding-left: 8px; }
    .jurusan-item-body { display: none; padding: 0 16px 14px; }
    .jurusan-item.selected .jurusan-item-body { display: block; }
    .jurusan-sub-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .no-jurusan { padding: 20px; text-align: center; color: var(--text3); font-size: 13px; font-family: 'DM Sans', sans-serif; border: 1px dashed var(--border2); border-radius: var(--radius-sm); }
    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .col-span-2 { grid-column: span 1; }
        .jurusan-sub-grid { grid-template-columns: 1fr; }
        .scope-tabs { width: 100%; }
        .scope-tab-label { flex: 1; justify-content: center; }
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.mata-pelajaran.index') }}">Mata Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah Mata Pelajaran</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Mata Pelajaran</h1>
            <p class="page-sub">Isi semua data dengan benar, lalu klik Simpan Data. Kolom bertanda <span style="color:var(--brand)">*</span> wajib diisi.</p>
        </div>
        <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST" id="mapelForm">
        @csrf
        <div class="form-card">

            {{-- SECTION 1: Informasi Dasar --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Informasi Mata Pelajaran
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Nama Mata Pelajaran <span class="req">*</span></label>
                        <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}"
                            placeholder="cth. Pemrograman Web, Basis Data, Jaringan Komputer"
                            class="{{ $errors->has('nama_mapel') ? 'is-invalid' : '' }}">
                        @error('nama_mapel')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kode Mata Pelajaran <span class="req">*</span></label>
                        <input type="text" name="kode_mapel" value="{{ old('kode_mapel') }}"
                            placeholder="cth. PWB, BSD, JKO"
                            class="{{ $errors->has('kode_mapel') ? 'is-invalid' : '' }}">
                        @error('kode_mapel')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kelompok Mata Pelajaran</label>
                        <select name="kelompok" class="{{ $errors->has('kelompok') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelompok —</option>
                            @foreach($kelompoks as $k)
                                <option value="{{ $k }}" {{ old('kelompok') == $k ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $k)) }}
                                </option>
                            @endforeach
                        </select>
                        <span class="field-hint">Pilih kelompok sesuai kurikulum</span>
                        @error('kelompok')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field" style="justify-content:flex-end;padding-bottom:4px">
                        <label>Status Aktif</label>
                        {{-- FIX #16: hidden input value="0" memastikan is_active selalu terkirim --}}
                        <div class="toggle-row" style="margin-top:8px">
                            <label class="toggle-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" id="isActiveToggle"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">
                                {{ old('is_active', '1') == '1' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- SECTION 2: Scope --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
                    Cakupan (Scope) Mata Pelajaran
                    <span class="section-label-line"></span>
                </p>

                <div class="field" style="margin-bottom:16px">
                    <label style="margin-bottom:8px">Pilih cakupan mapel <span class="req">*</span></label>
                    <div class="scope-tabs">
                        <label class="scope-tab">
                            <input type="radio" name="scope" value="umum"
                                {{ old('scope', 'umum') === 'umum' ? 'checked' : '' }}>
                            <span class="scope-tab-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                Umum (Semua Jurusan)
                            </span>
                        </label>
                        <label class="scope-tab">
                            <input type="radio" name="scope" value="jurusan"
                                {{ old('scope') === 'jurusan' ? 'checked' : '' }}>
                            <span class="scope-tab-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Spesifik Jurusan
                            </span>
                        </label>
                    </div>
                    <span class="field-hint" style="margin-top:6px">
                        <strong>Umum:</strong> Mapel wajib untuk semua siswa. &nbsp;
                        <strong>Spesifik Jurusan:</strong> Hanya untuk jurusan tertentu yang dipilih.
                    </span>
                    @error('scope')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div id="jurusanSection" class="{{ old('scope') === 'jurusan' ? 'visible' : '' }}">
                    <div style="margin-bottom:10px">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);margin-bottom:3px">
                            Pilih Jurusan &amp; Konfigurasi
                        </p>
                        <p class="field-hint">Centang jurusan yang menggunakan mapel ini, lalu atur jam dan tingkat kelas.</p>
                    </div>
                    @error('jurusan_ids')<span class="field-error" style="display:block;margin-bottom:8px">{{ $message }}</span>@enderror
                    @error('jurusan_ids.*')<span class="field-error" style="display:block;margin-bottom:8px">{{ $message }}</span>@enderror

                    <div class="jurusan-grid">
                        @forelse($jurusans as $jurusan)
                        @php
                            $oldIds      = old('jurusan_ids', []);
                            $isChecked   = in_array((string)$jurusan->id, array_map('strval', (array)$oldIds));
                            $namaJurusan = $jurusan->nama_jurusan ?? ($jurusan->nama ?? ('Jurusan ' . $jurusan->id));
                        @endphp
                        <div class="jurusan-item {{ $isChecked ? 'selected' : '' }}"
                             id="jItem-{{ $jurusan->id }}"
                             data-jurusan-id="{{ $jurusan->id }}">
                            <div class="jurusan-item-header">
                                <label class="jurusan-check-label" for="jCheck-{{ $jurusan->id }}">
                                    <input type="checkbox"
                                        name="jurusan_ids[]"
                                        value="{{ $jurusan->id }}"
                                        id="jCheck-{{ $jurusan->id }}"
                                        {{ $isChecked ? 'checked' : '' }}>
                                    <span class="jurusan-item-name">{{ $namaJurusan }}</span>
                                    <span class="jurusan-item-toggle" id="jToggleLabel-{{ $jurusan->id }}">
                                        {{ $isChecked ? 'Konfigurasi ▲' : 'Pilih untuk konfigurasi ▼' }}
                                    </span>
                                </label>
                            </div>
                            <div class="jurusan-item-body">
                                <div class="jurusan-sub-grid">
                                    <div class="field">
                                        <label>Jam Per Minggu <span style="font-weight:400;color:var(--text3)">(jurusan ini)</span></label>
                                        <input type="number"
                                            name="jam_jurusan[{{ $jurusan->id }}]"
                                            value="{{ old("jam_jurusan.{$jurusan->id}") }}"
                                            min="1" max="20" placeholder="cth. 4">
                                        <span class="field-hint">Kosongkan untuk pakai default mapel</span>
                                    </div>
                                    <div class="field">
                                        <label>Tingkat Kelas</label>
                                        <select name="tingkat_jurusan[{{ $jurusan->id }}]">
                                            <option value="">Semua Tingkat</option>
                                            <option value="10" {{ old("tingkat_jurusan.{$jurusan->id}") == '10' ? 'selected' : '' }}>Kelas 10</option>
                                            <option value="11" {{ old("tingkat_jurusan.{$jurusan->id}") == '11' ? 'selected' : '' }}>Kelas 11</option>
                                            <option value="12" {{ old("tingkat_jurusan.{$jurusan->id}") == '12' ? 'selected' : '' }}>Kelas 12</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="no-jurusan">
                            Belum ada jurusan aktif. Tambahkan jurusan terlebih dahulu.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- SECTION 3: Jam & Durasi --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Pengaturan Jam &amp; Durasi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Jam Per Minggu (default) <span class="req">*</span></label>
                        <input type="number" name="jam_per_minggu" value="{{ old('jam_per_minggu', 2) }}"
                            min="1" max="20"
                            class="{{ $errors->has('jam_per_minggu') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Total jam pelajaran default dalam satu minggu (1–20)</span>
                        @error('jam_per_minggu')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Durasi Per Sesi (menit) <span class="req">*</span></label>
                        <input type="number" name="durasi_per_sesi" value="{{ old('durasi_per_sesi', 45) }}"
                            min="30" max="180"
                            class="{{ $errors->has('durasi_per_sesi') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Durasi satu sesi pelajaran (30–180 menit)</span>
                        @error('durasi_per_sesi')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Opsi Tambahan</label>
                        {{-- FIX #17: hidden input value="0" sebelum checkbox --}}
                        <label class="checkbox-item">
                            <input type="hidden" name="perlu_lab" value="0">
                            <input type="checkbox" name="perlu_lab" value="1" {{ old('perlu_lab') ? 'checked' : '' }}>
                            <span>Mata pelajaran ini membutuhkan laboratorium</span>
                        </label>
                        @error('perlu_lab')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="3" placeholder="Catatan tambahan tentang mata pelajaran ini (opsional)..."
                            class="{{ $errors->has('keterangan') ? 'is-invalid' : '' }}">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    {{-- FIX #18: Gunakan @json() untuk encode error messages — cegah XSS di template literal --}}
    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terdapat {{ $errors->count() }} Kesalahan',
        html: '<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">'
            + @json(collect($errors->all())->map(fn($e) => '<li>' . e($e) . '</li>')->implode(''))
            + '</ul>',
        confirmButtonColor: '#1f63db',
    });
    @endif

    // Toggle label aktif/nonaktif
    document.getElementById('isActiveToggle').addEventListener('change', function () {
        document.getElementById('toggleLabel').textContent = this.checked ? 'Aktif' : 'Nonaktif';
    });

    // Toggle scope → tampilkan/sembunyikan jurusan section
    document.querySelectorAll('input[name="scope"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            var sec = document.getElementById('jurusanSection');
            if (this.value === 'jurusan') {
                sec.classList.add('visible');
            } else {
                sec.classList.remove('visible');
                // Uncheck + reset semua jurusan saat beralih ke umum
                document.querySelectorAll('.jurusan-item').forEach(function (item) {
                    var id  = item.dataset.jurusanId;
                    var chk = document.getElementById('jCheck-' + id);
                    if (chk && chk.checked) {
                        chk.checked = false;
                        syncJurusanState(id, false);
                    }
                });
            }
        });
    });

    // Checkbox change handler
    document.querySelectorAll('.jurusan-item input[type="checkbox"][name="jurusan_ids[]"]').forEach(function (chk) {
        chk.addEventListener('change', function () {
            syncJurusanState(this.value, this.checked);
        });
    });

    function syncJurusanState(id, isChecked) {
        var item  = document.getElementById('jItem-' + id);
        var label = document.getElementById('jToggleLabel-' + id);
        if (!item || !label) return;
        item.classList.toggle('selected', isChecked);
        label.textContent = isChecked ? 'Konfigurasi ▲' : 'Pilih untuk konfigurasi ▼';
    }

    // Submit loading state
    document.getElementById('mapelForm').addEventListener('submit', function () {
        var btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…';
    });
</script>
</x-app-layout>