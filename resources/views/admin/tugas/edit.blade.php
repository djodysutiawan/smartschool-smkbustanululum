<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-h: #3582f0;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --red: #dc2626; --red-bg: #fee2e2; --red-border: #fecaca;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 20px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn-back    { padding: 8px 14px; font-size: 13px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-cancel  { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
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
    .field input, .field select, .field textarea { height: 38px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); width: 100%; outline: none; transition: border-color .15s, background .15s; }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid, .field select.is-invalid, .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .toggle-row { display: flex; align-items: center; gap: 12px; }
    .toggle-switch { position: relative; display: inline-block; width: 42px; height: 24px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .toggle-slider { position: absolute; inset: 0; border-radius: 99px; background: var(--border2); cursor: pointer; transition: background .2s; }
    .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .toggle-switch input:checked + .toggle-slider { background: var(--brand); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }
    .toggle-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text2); }
    .file-existing { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); text-decoration: none; }
    .file-existing:hover { background: var(--surface3); }
    .form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border); }
    select:disabled { opacity: .55; cursor: not-allowed; }
    @media (max-width: 680px) { .page { padding: 16px 16px 40px; } .form-grid { grid-template-columns: 1fr; } .col-span-2 { grid-column: span 1; } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.tugas.index') }}">Manajemen Tugas</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.tugas.show', $tugas->id) }}">Detail Tugas</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Tugas</h1>
            <p class="page-sub">{{ $tugas->judul }}</p>
        </div>
        <a href="{{ route('admin.tugas.show', $tugas->id) }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data" id="tugasForm">
        @csrf @method('PUT')
        <div class="form-card">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Informasi Tugas
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Judul Tugas <span class="req">*</span></label>
                        <input type="text" name="judul"
                            value="{{ old('judul', $tugas->judul) }}"
                            class="{{ $errors->has('judul') ? 'is-invalid' : '' }}">
                        @error('judul')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Guru — perubahan guru akan reload mapel & kelas via AJAX --}}
                    <div class="field">
                        <label>Guru <span class="req">*</span></label>
                        <select name="guru_id" id="guruSelect"
                            class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}"
                                    {{ old('guru_id', $tugas->guru_id) == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id"
                            class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}"
                                    {{ old('tahun_ajaran_id', $tugas->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{--
                        Mata Pelajaran — di-preload dari $mapelList (controller edit()).
                        TIDAK disabled karena sudah ada data dari server.
                        AJAX hanya berjalan jika user mengganti guru.
                    --}}
                    <div class="field">
                        <label>Mata Pelajaran <span class="req">*</span></label>
                        <select name="mata_pelajaran_id" id="mapelSelect"
                            class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Mata Pelajaran —</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('mata_pelajaran_id', $tugas->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Kelas — di-preload dari $kelasList (controller edit()). --}}
                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" id="kelasSelect"
                            class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kelas_id', $tugas->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field col-span-2">
                        <label>Deskripsi / Instruksi</label>
                        <textarea name="deskripsi" rows="4"
                            class="{{ $errors->has('deskripsi') ? 'is-invalid' : '' }}">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                        @error('deskripsi')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Pengaturan Pengumpulan
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Jenis Pengumpulan <span class="req">*</span></label>
                        <select name="jenis_pengumpulan"
                            class="{{ $errors->has('jenis_pengumpulan') ? 'is-invalid' : '' }}">
                            @foreach($jenisPengumpulan as $jp)
                                <option value="{{ $jp }}"
                                    {{ old('jenis_pengumpulan', $tugas->jenis_pengumpulan) == $jp ? 'selected' : '' }}>
                                    {{ ucfirst($jp) }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_pengumpulan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Batas Waktu <span class="req">*</span></label>
                        {{--
                            Edit tidak perlu validasi 'after:now' (sudah di-override di update()),
                            tapi tetap tampilkan nilai yang tersimpan.
                        --}}
                        <input type="datetime-local" name="batas_waktu"
                            value="{{ old('batas_waktu', \Carbon\Carbon::parse($tugas->batas_waktu)->format('Y-m-d\TH:i')) }}"
                            class="{{ $errors->has('batas_waktu') ? 'is-invalid' : '' }}">
                        @error('batas_waktu')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Nilai Maksimal</label>
                        <input type="number" name="nilai_maksimal"
                            value="{{ old('nilai_maksimal', $tugas->nilai_maksimal ?? 100) }}"
                            min="0" max="100"
                            class="{{ $errors->has('nilai_maksimal') ? 'is-invalid' : '' }}">
                        @error('nilai_maksimal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Ganti File Soal</label>
                        @if($tugas->path_file_soal)
                            <a href="{{ asset('storage/'.$tugas->path_file_soal) }}" target="_blank" class="file-existing">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                File Soal Saat Ini
                            </a>
                        @endif
                        <input type="file" name="path_file_soal" accept=".pdf,.doc,.docx"
                            style="height:auto;padding:8px 12px"
                            class="{{ $errors->has('path_file_soal') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Kosongkan jika tidak ingin mengganti file. Format PDF/DOC/DOCX, maks. 10 MB.</span>
                        @error('path_file_soal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{--
                        FIX: Sama seperti create — hanya satu hidden input per toggle,
                        dikelola JS. Tidak ada double-name hidden+checkbox.
                    --}}
                    <div class="field">
                        <label>Izinkan Terlambat</label>
                        <div class="toggle-row" style="margin-top:8px">
                            @php $izinkanVal = old('izinkan_terlambat', $tugas->izinkan_terlambat ? '1' : '0'); @endphp
                            <input type="hidden" name="izinkan_terlambat" id="izinkanTerlambatHidden"
                                value="{{ $izinkanVal }}">
                            <label class="toggle-switch" for="izinkanTerlambatToggle">
                                <input type="checkbox" id="izinkanTerlambatToggle"
                                    {{ $izinkanVal == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="terlambatLabel">
                                {{ $izinkanVal == '1' ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label>Status Publikasi</label>
                        <div class="toggle-row" style="margin-top:8px">
                            @php $pubVal = old('dipublikasikan', $tugas->dipublikasikan ? '1' : '0'); @endphp
                            <input type="hidden" name="dipublikasikan" id="dipublikasikanHidden"
                                value="{{ $pubVal }}">
                            <label class="toggle-switch" for="dipublikasikanToggle">
                                <input type="checkbox" id="dipublikasikanToggle"
                                    {{ $pubVal == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="pubLabel">
                                {{ $pubVal == '1' ? 'Dipublikasikan' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.tugas.show', $tugas->id) }}" class="btn btn-cancel">Batal</a>
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
    // ── SweetAlert notifications ──────────────────────────────
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terdapat {{ $errors->count() }} Kesalahan',
        html: `<ul style="text-align:left;padding-left:16px;margin:0">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>`,
        confirmButtonColor: '#1f63db',
    });
    @endif

    // ── Toggle: izinkan terlambat ─────────────────────────────
    const izinkanCb     = document.getElementById('izinkanTerlambatToggle');
    const izinkanHidden = document.getElementById('izinkanTerlambatHidden');
    izinkanCb.addEventListener('change', function () {
        izinkanHidden.value = this.checked ? '1' : '0';
        document.getElementById('terlambatLabel').textContent = this.checked ? 'Ya' : 'Tidak';
    });

    // ── Toggle: status publikasi ──────────────────────────────
    const pubCb     = document.getElementById('dipublikasikanToggle');
    const pubHidden = document.getElementById('dipublikasikanHidden');
    pubCb.addEventListener('change', function () {
        pubHidden.value = this.checked ? '1' : '0';
        document.getElementById('pubLabel').textContent = this.checked ? 'Dipublikasikan' : 'Draft';
    });

    // ── Submit guard ──────────────────────────────────────────
    document.getElementById('tugasForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });

    // ── AJAX Dependent Dropdowns ──────────────────────────────
    const guruSelect  = document.getElementById('guruSelect');
    const mapelSelect = document.getElementById('mapelSelect');
    const kelasSelect = document.getElementById('kelasSelect');

    // ID guru yang tersimpan di DB — dipakai untuk deteksi apakah guru berubah
    const originalGuruId = '{{ $tugas->guru_id }}';

    // Nilai yang ingin di-preselect setelah reload AJAX
    // Prioritas: old() dari validasi gagal, lalu nilai dari $tugas
    const savedMapel = '{{ old('mata_pelajaran_id', $tugas->mata_pelajaran_id) }}';
    const savedKelas = '{{ old('kelas_id', $tugas->kelas_id) }}';

    function setLoading() {
        mapelSelect.innerHTML = '<option value="">Memuat…</option>';
        mapelSelect.disabled = true;
        kelasSelect.innerHTML = '<option value="">Memuat…</option>';
        kelasSelect.disabled = true;
    }

    function setReset() {
        mapelSelect.innerHTML = '<option value="">— Pilih Guru dulu —</option>';
        mapelSelect.disabled = true;
        kelasSelect.innerHTML = '<option value="">— Pilih Guru dulu —</option>';
        kelasSelect.disabled = true;
    }

    function populateSelect(selectEl, items, valueKey, labelKey, savedValue, emptyLabel) {
        selectEl.innerHTML = '';
        if (!items.length) {
            selectEl.innerHTML = `<option value="">${emptyLabel}</option>`;
            selectEl.disabled = true;
            return;
        }
        selectEl.innerHTML = `<option value="">— Pilih —</option>`;
        items.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item[valueKey];
            opt.textContent = item[labelKey];
            if (String(item[valueKey]) === String(savedValue)) opt.selected = true;
            selectEl.appendChild(opt);
        });
        selectEl.disabled = false;
    }

    async function loadDependents(guruId, selectedMapel = '', selectedKelas = '') {
        setLoading();
        try {
            const [mapelRes, kelasRes] = await Promise.all([
                fetch(`/admin/tugas/ajax/guru/${guruId}/mapel`),
                fetch(`/admin/tugas/ajax/guru/${guruId}/kelas`),
            ]);
            if (!mapelRes.ok || !kelasRes.ok) throw new Error('Server error');

            const [mapelData, kelasData] = await Promise.all([
                mapelRes.json(),
                kelasRes.json(),
            ]);

            populateSelect(mapelSelect, mapelData, 'id', 'nama_mapel', selectedMapel, '— Tidak ada mata pelajaran —');
            populateSelect(kelasSelect, kelasData, 'id', 'nama_kelas', selectedKelas, '— Tidak ada kelas —');
        } catch (e) {
            mapelSelect.innerHTML = '<option value="">Gagal memuat — coba lagi</option>';
            kelasSelect.innerHTML = '<option value="">Gagal memuat — coba lagi</option>';
            mapelSelect.disabled = true;
            kelasSelect.disabled = true;
        }
    }

    guruSelect.addEventListener('change', function () {
        if (!this.value) { setReset(); return; }

        const isSameGuru = (this.value === originalGuruId);
        // Jika guru sama (mis. user toggle lalu kembali), preselect nilai yang tersimpan.
        // Jika guru berbeda, biarkan kosong agar user pilih ulang mapel & kelas.
        loadDependents(
            this.value,
            isSameGuru ? savedMapel : '',
            isSameGuru ? savedKelas : ''
        );
    });

    /*
     * Saat halaman pertama kali load:
     * - Jika TIDAK ada old() (bukan redirect dari validasi gagal) → dropdown sudah
     *   di-preload server-side oleh controller edit(), TIDAK perlu AJAX.
     * - Jika ADA old() dan guru-nya BERBEDA dari original → AJAX diperlukan karena
     *   $mapelList / $kelasList yang dikirim server masih untuk guru asli.
     */
    @if(old('guru_id') && old('guru_id') != $tugas->guru_id)
        // Validasi gagal + user sempat ganti guru → perlu reload dengan guru baru
        loadDependents('{{ old('guru_id') }}', savedMapel, savedKelas);
    @endif
</script>
</x-app-layout>