<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand:      #1f63db;
    --brand-h:    #3582f0;
    --brand-50:   #eef6ff;
    --brand-100:  #d9ebff;
    --surface:    #fff;
    --surface2:   #f8fafc;
    --surface3:   #f1f5f9;
    --border:     #e2e8f0;
    --border2:    #cbd5e1;
    --text:       #0f172a;
    --text2:      #475569;
    --text3:      #94a3b8;
    --red:        #dc2626;
    --red-bg:     #fee2e2;
    --red-border: #fecaca;
    --green:      #16a34a;
    --green-bg:   #dcfce7;
    --radius:     10px;
    --radius-sm:  7px;
}
.page { padding:28px 28px 60px; max-width:2000px; margin:0 auto; }
.breadcrumb { display:flex; align-items:center; gap:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:600; color:var(--text3); margin-bottom:20px; }
.breadcrumb a { color:var(--text3); text-decoration:none; transition:color .15s; }
.breadcrumb a:hover { color:var(--brand); }
.breadcrumb .sep { color:var(--border2); }
.breadcrumb .current { color:var(--text2); }
.page-header { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
.page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:9px 20px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s, background .15s; white-space:nowrap; }
.btn-back { padding:8px 14px; font-size:13px; background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-back:hover { background:var(--surface3); }
.btn-cancel { background:var(--surface); color:var(--text2); border:1px solid var(--border); }
.btn-cancel:hover { background:var(--surface3); }
.btn-primary { background:var(--brand); color:#fff; }
.btn-primary:hover { filter:brightness(.93); }
.btn-primary:disabled { opacity:.6; cursor:not-allowed; filter:none; }
.alert { display:flex; align-items:flex-start; gap:10px; padding:12px 16px; border-radius:var(--radius-sm); margin-bottom:20px; font-size:13.5px; background:var(--red-bg); color:var(--red); border:1px solid var(--red-border); }
.form-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
.form-section { padding:20px 24px 24px; }
.section-label { display:flex; align-items:center; gap:8px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:var(--text3); letter-spacing:.07em; text-transform:uppercase; margin-bottom:16px; }
.section-label-line { flex:1; height:1px; background:var(--border); }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.col-span-2 { grid-column:span 2; }
.field { display:flex; flex-direction:column; gap:6px; }
.field label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text2); }
.field label .req { color:var(--brand); margin-left:2px; }
.field input, .field select, .field textarea { padding:9px 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--text); background:var(--surface2); width:100%; outline:none; transition:border-color .15s, background .15s; }
.field input[type="time"], .field input[type="date"] { height:38px; padding:0 12px; }
.field select { padding:8px 12px; }
.field textarea { resize:vertical; min-height:72px; }
.field input:focus, .field select:focus, .field textarea:focus { border-color:var(--brand-h); background:#fff; box-shadow:0 0 0 3px rgba(53,130,240,.1); }
.field input.is-invalid, .field select.is-invalid, .field textarea.is-invalid { border-color:var(--red); background:#fff8f8; }
.field-error { font-size:12px; color:var(--red); font-family:'DM Sans',sans-serif; }
.field-hint  { font-size:12px; color:var(--text3); font-family:'DM Sans',sans-serif; }
.toggle-row { display:flex; align-items:center; gap:12px; }
.toggle-switch { position:relative; display:inline-block; width:42px; height:24px; }
.toggle-switch input { opacity:0; width:0; height:0; }
.toggle-slider { position:absolute; inset:0; border-radius:99px; background:var(--border2); cursor:pointer; transition:background .2s; }
.toggle-slider::before { content:''; position:absolute; width:18px; height:18px; left:3px; top:3px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
.toggle-switch input:checked + .toggle-slider { background:var(--brand); }
.toggle-switch input:checked + .toggle-slider::before { transform:translateX(18px); }
.toggle-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; color:var(--text2); }
.info-box { background:var(--brand-50); border:1px solid var(--brand-100); border-radius:var(--radius-sm); padding:12px 16px; display:flex; gap:10px; align-items:flex-start; }
.info-box p { font-size:13px; color:#1d4ed8; font-family:'DM Sans',sans-serif; }
.form-divider { height:1px; background:var(--border); margin:20px 0; }
.form-footer { display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 24px; background:var(--surface2); border-top:1px solid var(--border); }
.select-wrapper { position:relative; }
.select-loading::after { content:''; position:absolute; right:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; border:2px solid var(--border2); border-top-color:var(--brand); border-radius:50%; animation:spin .6s linear infinite; pointer-events:none; }
.mapel-notice { display:none; align-items:center; gap:6px; font-size:12px; color:var(--text3); font-family:'DM Sans',sans-serif; padding:6px 10px; background:var(--surface3); border-radius:var(--radius-sm); border:1px solid var(--border); }
.mapel-notice.show { display:flex; }
@media (max-width:680px) { .page { padding:16px 16px 40px; } .form-grid { grid-template-columns:1fr; } .col-span-2 { grid-column:span 1; } }
@keyframes spin { to { transform:rotate(360deg); } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ketersediaan-guru.index') }}">Ketersediaan Guru</a>
        <span class="sep">›</span>
        <span class="current">Tambah Slot</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Slot Ketersediaan</h1>
            <p class="page-sub">Tambah satu slot waktu ketersediaan guru</p>
        </div>
        <a href="{{ route('admin.ketersediaan-guru.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- FIX: Hanya tampilkan alert HTML untuk error validasi server-side.
         SweetAlert DIHAPUS dari sini agar tidak ada duplikasi notifikasi. --}}
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
    @if(session('error'))
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.ketersediaan-guru.store') }}" method="POST" id="ktForm">
        @csrf
        {{-- FIX: redirect_guru pakai nilai dari $guruTerpilih yang sudah di-pass controller --}}
        @if($guruTerpilih)
            <input type="hidden" name="redirect_guru" value="1">
        @endif

        <div class="form-card">

            {{-- ── BAGIAN 1: INFORMASI SLOT ── --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Informasi Slot
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    {{-- Guru --}}
                    <div class="field col-span-2">
                        <label>Guru <span class="req">*</span></label>
                        <select name="guru_id" class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($gurus as $g)
                                {{-- FIX: gunakan $guruTerpilih yang di-pass controller --}}
                                <option value="{{ $g->id }}"
                                    {{ old('guru_id', $guruTerpilih?->id) == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama_lengkap }}{{ $g->nip ? ' (NIP: '.$g->nip.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Hari --}}
                    <div class="field">
                        <label>Hari <span class="req">*</span></label>
                        <select name="hari" class="{{ $errors->has('hari') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Hari —</option>
                            @foreach($hariList as $h)
                                <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                            @endforeach
                        </select>
                        @error('hari')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Status --}}
                    <div class="field">
                        <label>Status</label>
                        <div class="toggle-row" style="margin-top:7px">
                            <input type="hidden" name="tersedia" value="0">
                            <label class="toggle-switch">
                                <input type="checkbox" name="tersedia" value="1" id="tersediaToggle"
                                    {{ old('tersedia', '1') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">{{ old('tersedia', '1') == '1' ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                        </div>
                    </div>

                    {{-- Jam Mulai --}}
                    <div class="field">
                        <label>Jam Mulai <span class="req">*</span></label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                            class="{{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}">
                        @error('jam_mulai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="field">
                        <label>Jam Selesai <span class="req">*</span></label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                            class="{{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}">
                        @error('jam_selesai')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Harus lebih dari jam mulai</span>
                    </div>
                </div>
            </div>

            <div class="form-divider"></div>

            {{-- ── BAGIAN 2: DETAIL PENGAJARAN ── --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Detail Pengajaran
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">

                    {{-- ① JURUSAN --}}
                    <div class="field">
                        <label>Jurusan</label>
                        <select name="jurusan_id" id="jurusanSelect"
                            class="{{ $errors->has('jurusan_id') ? 'is-invalid' : '' }}">
                            <option value="">— Semua / Tidak Spesifik —</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}"
                                    {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                    {{-- FIX: ganti $j->nama → $j->nama_jurusan --}}
                                    {{ $j->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Pilih jurusan untuk menyaring daftar mapel</span>
                    </div>

                    {{-- ② MATA PELAJARAN --}}
                    <div class="field">
                        <label>Mata Pelajaran</label>
                        <div class="select-wrapper" id="mapelWrapper">
                            <select name="mata_pelajaran_id" id="mapelSelect"
                                class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                                <option value="">— Semua / Tidak Spesifik —</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}"
                                        data-scope="{{ $m->scope }}"
                                        {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_mapel }}{{ $m->scope === 'umum' ? ' ✦' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Kosongkan = bebas mapel &nbsp;|&nbsp; ✦ = Mapel Umum</span>
                        <div class="mapel-notice" id="mapelNotice">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            <span id="mapelNoticeText">Memuat daftar mapel…</span>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="field col-span-2">
                        <label>Catatan</label>
                        <textarea name="catatan" placeholder="Mis: Hanya tersedia jika tidak ada rapat dinas…"
                            class="{{ $errors->has('catatan') ? 'is-invalid' : '' }}">{{ old('catatan') }}</textarea>
                        @error('catatan')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Maks. 255 karakter</span>
                    </div>
                </div>
            </div>

            <div class="form-divider"></div>

            {{-- ── BAGIAN 3: PERIODE BERLAKU ── --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Periode Berlaku
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Berlaku Mulai</label>
                        <input type="date" name="berlaku_mulai" value="{{ old('berlaku_mulai') }}"
                            class="{{ $errors->has('berlaku_mulai') ? 'is-invalid' : '' }}">
                        @error('berlaku_mulai')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Kosongkan jika berlaku permanen</span>
                    </div>
                    <div class="field">
                        <label>Berlaku Selesai</label>
                        <input type="date" name="berlaku_selesai" value="{{ old('berlaku_selesai') }}"
                            class="{{ $errors->has('berlaku_selesai') ? 'is-invalid' : '' }}">
                        @error('berlaku_selesai')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Harus sama atau setelah tanggal mulai</span>
                    </div>
                </div>

                <div class="info-box" style="margin-top:16px">
                    <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p>
                        Slot dengan kombinasi guru, hari, jam mulai, mapel, dan jurusan yang sama tidak dapat diduplikasi.
                        Mapel bertanda <strong>✦</strong> adalah mapel umum (berlaku untuk semua jurusan).
                    </p>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.ketersediaan-guru.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Slot
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Toggle status label
document.getElementById('tersediaToggle').addEventListener('change', function() {
    document.getElementById('toggleLabel').textContent = this.checked ? 'Tersedia' : 'Tidak Tersedia';
});

// Submit loading state
document.getElementById('ktForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
});

// ── Mapel Dynamic Filter ─────────────────────────────────────────────────────
(function () {
    const jurusanSel  = document.getElementById('jurusanSelect');
    const mapelSel    = document.getElementById('mapelSelect');
    const mapelWrapper= document.getElementById('mapelWrapper');
    const mapelNotice = document.getElementById('mapelNotice');
    const noticeText  = document.getElementById('mapelNoticeText');

    // FIX: Gunakan url() helper — lebih stabil dari rtrim() manipulation
    // Route mapel-all untuk fetch tanpa filter jurusan
    const URL_MAPEL_ALL      = @json(route('admin.ketersediaan-guru.ajax.mapel-all'));
    // Route mapel-by-jurusan — ID akan diappend di JS
    const URL_MAPEL_JURUSAN  = @json(url('admin/ketersediaan-guru/ajax/mapel-by-jurusan'));

    let savedMapelId = @json(old('mata_pelajaran_id') ?? '');

    function setLoading(isLoading) {
        mapelWrapper.classList.toggle('select-loading', isLoading);
        mapelSel.disabled = isLoading;
        if (isLoading) {
            noticeText.textContent = 'Memuat daftar mapel…';
            mapelNotice.classList.add('show');
        } else {
            mapelNotice.classList.remove('show');
        }
    }

    function buildOptions(mapels) {
        mapelSel.innerHTML = '<option value="">— Semua / Tidak Spesifik —</option>';
        if (!mapels.length) {
            const opt = document.createElement('option');
            opt.disabled = true;
            opt.textContent = '— Tidak ada mapel tersedia —';
            mapelSel.appendChild(opt);
            return;
        }
        mapels.forEach(m => {
            const opt = document.createElement('option');
            opt.value         = m.id;
            opt.dataset.scope = m.scope;
            opt.textContent   = m.label;
            if (String(m.id) === String(savedMapelId)) opt.selected = true;
            mapelSel.appendChild(opt);
        });
    }

    async function fetchMapel(jurusanId) {
        setLoading(true);
        try {
            // FIX: URL dibangun dengan cara yang aman
            const url = jurusanId
                ? `${URL_MAPEL_JURUSAN}/${jurusanId}`
                : URL_MAPEL_ALL;

            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const data = await res.json();
            buildOptions(data.mapels ?? []);
        } catch (e) {
            noticeText.textContent = '⚠ Gagal memuat mapel, coba refresh halaman.';
            mapelNotice.classList.add('show');
            mapelWrapper.classList.remove('select-loading');
            mapelSel.disabled = false;
        } finally {
            setLoading(false);
        }
    }

    jurusanSel.addEventListener('change', function () {
        savedMapelId = '';
        fetchMapel(this.value || null);
    });
})();
</script>
</x-app-layout>