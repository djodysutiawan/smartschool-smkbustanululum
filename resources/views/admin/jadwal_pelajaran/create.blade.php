<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --amber:#b45309;--amber-bg:#fffbeb;--amber-border:#fde68a;
        --green:#16a34a;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3)}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-cancel:hover{background:var(--surface3)}
    .btn-primary{background:var(--brand);color:#fff}.btn-primary:hover{filter:brightness(.93)}.btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .form-section{padding:20px 24px 24px}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px}
    .section-label-line{flex:1;height:1px;background:var(--border)}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .col-span-2{grid-column:span 2}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand);margin-left:2px}
    .field input,.field select{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s,opacity .15s}
    .field input:focus,.field select:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field input.is-invalid,.field select.is-invalid{border-color:var(--red);background:#fff8f8}
    .field select:disabled{opacity:.55;cursor:not-allowed;background:var(--surface3)}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .kuota-badge{display:none;align-items:center;gap:6px;padding:6px 10px;border-radius:var(--radius-sm);font-size:12px;font-family:'DM Sans',sans-serif;margin-top:4px}
    .kuota-badge.show{display:flex}
    .kuota-badge.ok{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .kuota-badge.warn{background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border)}
    .kuota-badge.full{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .toggle-row{display:flex;align-items:center;gap:12px}
    .toggle-switch{position:relative;display:inline-block;width:42px;height:24px}
    .toggle-switch input{opacity:0;width:0;height:0}
    .toggle-slider{position:absolute;inset:0;border-radius:99px;background:var(--border2);cursor:pointer;transition:background .2s}
    .toggle-slider::before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
    .toggle-switch input:checked + .toggle-slider{background:var(--brand)}
    .toggle-switch input:checked + .toggle-slider::before{transform:translateX(18px)}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2)}
    .conflict-hint{display:none;padding:10px 14px;border-radius:var(--radius-sm);background:#fff7ed;border:1px solid #fed7aa;color:#c2410c;font-size:13px;font-family:'DM Sans',sans-serif;margin-top:8px}
    .conflict-hint.show{display:block}
    .select-loader{position:relative}
    .select-loader::after{content:'';display:none;position:absolute;right:28px;top:50%;transform:translateY(-50%);width:14px;height:14px;border:2px solid var(--border2);border-top-color:var(--brand);border-radius:50%;animation:spin .6s linear infinite}
    .select-loader.loading::after{display:block}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border)}
    @media(max-width:680px){.page{padding:16px 16px 40px}.form-grid{grid-template-columns:1fr}.col-span-2{grid-column:span 1}}
    @keyframes spin{to{transform:rotate(360deg)}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.jadwal-pelajaran.index') }}">Jadwal Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah Jadwal</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Jadwal Pelajaran</h1>
            <p class="page-sub">Pilih kelas terlebih dahulu, mata pelajaran akan menyesuaikan otomatis</p>
        </div>
        <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.jadwal-pelajaran.store') }}" method="POST" id="formJP">
        @csrf
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Informasi Jadwal
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">

                    {{-- Tahun Ajaran --}}
                    <div class="field">
                        <label for="tahunAjaranSelect">Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" id="tahunAjaranSelect"
                                class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}"
                                    {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }}{{ $ta->semester ? ' – ' . ucfirst($ta->semester) : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="field">
                        <label for="kelasSelect">Kelas <span class="req">*</span></label>
                        <select name="kelas_id" id="kelasSelect"
                                class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}"
                                    data-jurusan="{{ $k->jurusan?->nama ?? '' }}"
                                    data-tingkat="{{ $k->tingkat }}"
                                    {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                    @if($k->jurusan) ({{ $k->jurusan->nama }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint" id="kelasHint"></span>
                    </div>

                    {{-- Hari --}}
                    <div class="field">
                        <label for="hariSelect">Hari <span class="req">*</span></label>
                        <select name="hari" id="hariSelect"
                                class="{{ $errors->has('hari') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Hari —</option>
                            @foreach($hariList as $h)
                                <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>
                                    {{ ucfirst($h) }}
                                </option>
                            @endforeach
                        </select>
                        @error('hari')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Mata Pelajaran (via AJAX) --}}
                    <div class="field">
                        <label for="mapelSelect">Mata Pelajaran <span class="req">*</span></label>
                        <div class="select-loader" id="mapelLoader">
                            <select name="mata_pelajaran_id" id="mapelSelect" disabled
                                    class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                                <option value="">— Pilih Kelas &amp; Tahun Ajaran dulu —</option>
                            </select>
                        </div>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                        <div class="kuota-badge" id="kuotaBadge"></div>
                    </div>

                    {{-- Guru --}}
                    <div class="field">
                        <label for="guruSelect">Guru <span class="req">*</span></label>
                        <select name="guru_id" id="guruSelect"
                                class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Ruang --}}
                    <div class="field">
                        <label for="ruangSelect">Ruang</label>
                        <select name="ruang_id" id="ruangSelect"
                                class="{{ $errors->has('ruang_id') ? 'is-invalid' : '' }}">
                            <option value="">— Tanpa Ruang —</option>
                            @foreach($ruangList as $r)
                                <option value="{{ $r->id }}" {{ old('ruang_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama_ruang }}
                                    @if($r->gedung) ({{ $r->gedung->nama_gedung }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('ruang_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Jam Mulai --}}
                    <div class="field">
                        <label for="jamMulai">Jam Mulai <span class="req">*</span></label>
                        <input type="time" name="jam_mulai" id="jamMulai"
                               value="{{ old('jam_mulai') }}"
                               class="{{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}">
                        @error('jam_mulai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="field">
                        <label for="jamSelesai">Jam Selesai <span class="req">*</span></label>
                        <input type="time" name="jam_selesai" id="jamSelesai"
                               value="{{ old('jam_selesai') }}"
                               class="{{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}">
                        @error('jam_selesai')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint" id="durasiHint"></span>
                    </div>

                    {{-- Pertemuan Ke --}}
                    <div class="field">
                        <label for="pertemuanKe">Pertemuan Ke</label>
                        <input type="number" name="pertemuan_ke" id="pertemuanKe"
                               value="{{ old('pertemuan_ke') }}" placeholder="cth. 1" min="1"
                               class="{{ $errors->has('pertemuan_ke') ? 'is-invalid' : '' }}">
                        @error('pertemuan_ke')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Sumber Jadwal --}}
                    <div class="field">
                        <label for="sumberJadwal">Sumber Jadwal</label>
                        <select name="sumber_jadwal" id="sumberJadwal"
                                class="{{ $errors->has('sumber_jadwal') ? 'is-invalid' : '' }}">
                            <option value="manual"   {{ old('sumber_jadwal', 'manual') == 'manual'   ? 'selected' : '' }}>Manual</option>
                            <option value="otomatis" {{ old('sumber_jadwal') == 'otomatis' ? 'selected' : '' }}>Otomatis</option>
                        </select>
                        @error('sumber_jadwal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="field col-span-2">
                        <label>Status Aktif</label>
                        <div class="toggle-row" style="margin-top:4px">
                            <input type="hidden" name="is_active" value="0">
                            <label class="toggle-switch">
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

                <div class="conflict-hint" id="conflictHint">
                    ⚠️ Pastikan guru dan kelas tidak memiliki jadwal lain pada hari dan jam ini. Sistem akan memvalidasi saat disimpan.
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Jadwal
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function () {
    'use strict';

    @if(session('error'))
    Swal.fire({ icon:'error', title:'Bentrok Jadwal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon: 'error', title: 'Terdapat Kesalahan',
        html: `<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>`,
        confirmButtonColor: '#1f63db'
    });
    @endif

    const elTA      = document.getElementById('tahunAjaranSelect');
    const elKelas   = document.getElementById('kelasSelect');
    const elHari    = document.getElementById('hariSelect');
    const elMapel   = document.getElementById('mapelSelect');
    const elLoader  = document.getElementById('mapelLoader');
    const elGuru    = document.getElementById('guruSelect');
    const elMulai   = document.getElementById('jamMulai');
    const elSelesai = document.getElementById('jamSelesai');
    const elKuota   = document.getElementById('kuotaBadge');
    const elDurasi  = document.getElementById('durasiHint');
    const elKelasH  = document.getElementById('kelasHint');

    const MAPEL_ROUTE = "{{ route('admin.jadwal-pelajaran.get-mapel-by-kelas') }}";
    const OLD_MAPEL   = "{{ old('mata_pelajaran_id') }}";

    function hitungDurasi(mulai, selesai) {
        if (!mulai || !selesai) return 0;
        const [h1, m1] = mulai.split(':').map(Number);
        const [h2, m2] = selesai.split(':').map(Number);
        return (h2 * 60 + m2) - (h1 * 60 + m1);
    }

    function renderDurasi() {
        const menit = hitungDurasi(elMulai.value, elSelesai.value);
        if (menit > 0) {
            const jam  = Math.floor(menit / 60);
            const sisa = menit % 60;
            elDurasi.textContent = `Durasi: ${jam > 0 ? jam + ' jam ' : ''}${sisa > 0 ? sisa + ' menit' : ''}`;
        } else {
            elDurasi.textContent = '';
        }
    }

    function renderKelasHint() {
        const opt = elKelas.selectedOptions[0];
        if (opt && opt.value) {
            const jurusan = opt.dataset.jurusan;
            const tingkat = opt.dataset.tingkat;
            elKelasH.textContent = jurusan
                ? `Jurusan: ${jurusan} — Tingkat: ${tingkat}`
                : `Tingkat: ${tingkat}`;
        } else {
            elKelasH.textContent = '';
        }
    }

    // ── FIX: badge kuota kini menggunakan terpakai_menit yang dikembalikan AJAX ──
    function renderKuotaBadge() {
        const opt = elMapel.selectedOptions[0];
        if (!opt || !opt.value || !opt.dataset.jamMinggu) {
            elKuota.className   = 'kuota-badge';
            elKuota.textContent = '';
            return;
        }

        const jamMinggu     = parseFloat(opt.dataset.jamMinggu)  || 0;
        const durasiPerSesi = parseFloat(opt.dataset.durasiSesi) || 45;
        const kuotaMenit    = jamMinggu * durasiPerSesi;
        const terpakai      = parseFloat(opt.dataset.terpakai)   || 0;  // dari server (akurat)
        const durBaru       = hitungDurasi(elMulai.value, elSelesai.value);
        const totalNanti    = terpakai + durBaru;

        if (jamMinggu <= 0) return;

        const persen = Math.round(totalNanti / kuotaMenit * 100);
        let cls = 'kuota-badge show ok', ikon = '✓';
        let msg = `Kuota ${jamMinggu} jam/minggu — terpakai ${Math.round(terpakai/60*10)/10} jam`;

        if (persen >= 100) {
            cls = 'kuota-badge show full'; ikon = '✕';
            msg = `Kuota penuh! ${Math.round(terpakai/60*10)/10}/${jamMinggu} jam/minggu`;
        } else if (persen >= 80) {
            cls = 'kuota-badge show warn'; ikon = '⚠';
            msg = `Hampir penuh (${persen}%) — sisa ${Math.round((kuotaMenit-terpakai)/60*10)/10} jam`;
        }

        elKuota.className   = cls;
        elKuota.textContent = `${ikon} ${msg}`;
    }

    function loadMapel() {
        const kelasId = elKelas.value;
        const taId    = elTA.value;
        const hariVal = elHari.value;

        if (!kelasId || !taId) {
            elMapel.innerHTML = '<option value="">— Pilih Kelas &amp; Tahun Ajaran dulu —</option>';
            elMapel.disabled  = true;
            elLoader.classList.remove('loading');
            elKuota.className = 'kuota-badge';
            return;
        }

        const params = new URLSearchParams({ kelas_id: kelasId, tahun_ajaran_id: taId });
        if (hariVal) params.append('hari', hariVal);

        elMapel.disabled = true;
        elLoader.classList.add('loading');
        elMapel.innerHTML = '<option value="">Memuat…</option>';
        elKuota.className = 'kuota-badge';

        fetch(`${MAPEL_ROUTE}?${params}`)
            .then(r => { if (!r.ok) throw new Error('Network error'); return r.json(); })
            .then(data => {
                elLoader.classList.remove('loading');
                elMapel.disabled = false;

                if (!data.length) {
                    elMapel.innerHTML = '<option value="">Tidak ada mapel tersedia</option>';
                    return;
                }

                elMapel.innerHTML = '<option value="">— Pilih Mata Pelajaran —</option>';
                data.forEach(m => {
                    const label    = m.nama_mapel + (m.kode_mapel ? ` (${m.kode_mapel})` : '');
                    const selected = OLD_MAPEL && String(OLD_MAPEL) === String(m.id);
                    const opt      = document.createElement('option');
                    opt.value              = m.id;
                    opt.textContent        = label;
                    opt.dataset.jamMinggu  = m.jam_per_minggu   || 0;
                    opt.dataset.durasiSesi = m.durasi_per_sesi  || 45;
                    opt.dataset.terpakai   = m.terpakai_menit   || 0; // dari server
                    if (selected) opt.selected = true;
                    elMapel.appendChild(opt);
                });
                renderKuotaBadge();
            })
            .catch(() => {
                elLoader.classList.remove('loading');
                elMapel.disabled  = false;
                elMapel.innerHTML = '<option value="">Gagal memuat, coba lagi</option>';
            });
    }

    function updateConflictHint() {
        const show = !!(elGuru.value && elHari.value && elMulai.value);
        document.getElementById('conflictHint').classList.toggle('show', show);
    }

    elTA.addEventListener('change',    loadMapel);
    elKelas.addEventListener('change', () => { renderKelasHint(); loadMapel(); });
    elHari.addEventListener('change',  loadMapel);
    elMapel.addEventListener('change',  renderKuotaBadge);
    elMulai.addEventListener('change',  () => { renderDurasi(); renderKuotaBadge(); updateConflictHint(); });
    elSelesai.addEventListener('change',() => { renderDurasi(); renderKuotaBadge(); });
    elGuru.addEventListener('change',   updateConflictHint);

    document.getElementById('isActiveToggle').addEventListener('change', function () {
        document.getElementById('toggleLabel').textContent = this.checked ? 'Aktif' : 'Nonaktif';
    });

    document.getElementById('formJP').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
            style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });

    if (elKelas.value && elTA.value) { renderKelasHint(); loadMapel(); }
    renderDurasi();

}());
</script>
</x-app-layout>