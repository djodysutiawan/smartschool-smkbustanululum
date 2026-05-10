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

    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center}
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--text3)}
    .breadcrumb a{color:var(--text3);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}
    .breadcrumb a:hover{color:var(--text)}
    .breadcrumb-current{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text2)}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .form-layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .form-grid.col3{grid-template-columns:1fr 1fr 1fr}
    .form-grid.col1{grid-template-columns:1fr}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field select,
    .field input[type=text],
    .field input[type=date],
    .field input[type=time],
    .field input[type=number],
    .field textarea{
        padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);
        font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);
        background:var(--surface2);outline:none;transition:border-color .15s;
        width:100%;box-sizing:border-box
    }
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field select.is-invalid,.field input.is-invalid,.field textarea.is-invalid{border-color:#dc2626;background:#fff8f8}
    .field textarea{resize:vertical;min-height:90px}
    .field-hint{font-size:11.5px;color:var(--text3);margin-top:2px}
    .field-error{font-size:11.5px;color:#dc2626;margin-top:2px;font-weight:600}

    .toggle-row{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm)}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .toggle-sub{font-size:11.5px;color:var(--text3);margin-top:1px}
    .toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
    .toggle-switch input[type=checkbox]{opacity:0;width:0;height:0;position:absolute}
    .toggle-slider{position:absolute;inset:0;background:var(--border2);border-radius:99px;cursor:pointer;transition:background .2s}
    .toggle-slider:before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15)}
    .toggle-switch input[type=checkbox]:checked + .toggle-slider{background:#15803d}
    .toggle-switch input[type=checkbox]:checked + .toggle-slider:before{transform:translateX(18px)}

    .section-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;margin-bottom:12px}

    .btn-submit-full{width:100%;height:42px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .15s}
    .btn-submit-full:hover{background:var(--brand-700)}
    .btn-submit-full:disabled{opacity:.6;cursor:not-allowed}

    .char-counter{font-size:11px;color:var(--text3);text-align:right;margin-top:2px}

    @media(max-width:900px){
        .form-layout{grid-template-columns:1fr}
        .form-grid{grid-template-columns:1fr}
        .form-grid.col3{grid-template-columns:1fr 1fr}
        .page{padding:16px}
    }
</style>

<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('guru.ujian.index') }}">Kelola Ujian</a>
        <span>›</span>
        <span class="breadcrumb-current">Buat Ujian Baru</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Ujian Baru</h1>
            <p class="page-sub">Isi detail ujian yang akan diberikan kepada siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.ujian.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('guru.ujian.store') }}" method="POST" id="ujianForm">
        @csrf
        <div class="form-layout">

            {{-- Kolom Utama --}}
            <div>

                {{-- Informasi Dasar --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <span class="card-title">Informasi Dasar</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid col1" style="margin-bottom:14px">
                            <div class="field">
                                <label for="judul">Judul Ujian <span class="req">*</span></label>
                                <input type="text" id="judul" name="judul"
                                    value="{{ old('judul') }}"
                                    placeholder="contoh: Ulangan Harian Bab 3"
                                    maxlength="255" required autocomplete="off"
                                    class="{{ $errors->has('judul') ? 'is-invalid' : '' }}">
                                @error('judul')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="field">
                                <label for="mata_pelajaran_id">Mata Pelajaran <span class="req">*</span></label>
                                <select id="mata_pelajaran_id" name="mata_pelajaran_id" required
                                    class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Pilih Mapel —</option>
                                    @foreach($mapelList as $m)
                                        <option value="{{ $m->id }}"
                                            {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="kelas_id">Kelas <span class="req">*</span></label>
                                <select id="kelas_id" name="kelas_id" required
                                    class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Pilih Kelas —</option>
                                    @foreach($kelasList as $k)
                                        <option value="{{ $k->id }}"
                                            {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="tahun_ajaran_id">Tahun Ajaran <span class="req">*</span></label>
                                <select id="tahun_ajaran_id" name="tahun_ajaran_id" required
                                    class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Pilih Tahun Ajaran —</option>
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}"
                                            {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama ?? $ta->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="jenis">Jenis Ujian <span class="req">*</span></label>
                                <select id="jenis" name="jenis" required
                                    class="{{ $errors->has('jenis') ? 'is-invalid' : '' }}">
                                    <option value="">— Pilih Jenis —</option>
                                    @foreach($jenisList as $j)
                                        <option value="{{ $j }}"
                                            {{ old('jenis') === $j ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $j)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Waktu Pelaksanaan --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span class="card-title">Waktu Pelaksanaan</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid col3">
                            <div class="field">
                                <label for="tanggal">Tanggal <span class="req">*</span></label>
                                <input type="date" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal') }}" required
                                    class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}">
                                @error('tanggal')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="jam_mulai">Jam Mulai</label>
                                <input type="time" id="jam_mulai" name="jam_mulai"
                                    value="{{ old('jam_mulai') }}"
                                    class="{{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}">
                                <span class="field-hint">Opsional</span>
                                @error('jam_mulai')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="durasi_menit">Durasi (menit) <span class="req">*</span></label>
                                <input type="number" id="durasi_menit" name="durasi_menit"
                                    value="{{ old('durasi_menit', 60) }}"
                                    min="1" max="480" required
                                    class="{{ $errors->has('durasi_menit') ? 'is-invalid' : '' }}">
                                @error('durasi_menit')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pengaturan Ujian --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                        <span class="card-title">Pengaturan Ujian</span>
                    </div>
                    <div class="card-body">
                        <div class="form-grid" style="margin-bottom:18px">
                            <div class="field">
                                <label for="nilai_kkm">Nilai KKM</label>
                                <input type="number" id="nilai_kkm" name="nilai_kkm"
                                    value="{{ old('nilai_kkm', 75) }}"
                                    min="0" max="100"
                                    class="{{ $errors->has('nilai_kkm') ? 'is-invalid' : '' }}">
                                <span class="field-hint">Opsional, 0–100. Jika diisi, digunakan untuk menentukan lulus/tidak.</span>
                                @error('nilai_kkm')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="maks_percobaan">Maks. Percobaan</label>
                                <input type="number" id="maks_percobaan" name="maks_percobaan"
                                    value="{{ old('maks_percobaan', 1) }}"
                                    min="1" max="10"
                                    class="{{ $errors->has('maks_percobaan') ? 'is-invalid' : '' }}">
                                <span class="field-hint">Berapa kali siswa boleh mengulang ujian (1–10).</span>
                                @error('maks_percobaan')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <p class="section-label">Opsi Tampilan &amp; Acak</p>
                        <div style="display:flex;flex-direction:column;gap:8px">
                            <div class="toggle-row">
                                <div>
                                    <p class="toggle-label">Acak Soal</p>
                                    <p class="toggle-sub">Urutan soal diacak berbeda tiap siswa</p>
                                </div>
                                <label class="toggle-switch">
                                    {{-- Hidden input HARUS sebelum checkbox agar nilai 0 terkirim saat unchecked --}}
                                    <input type="hidden" name="acak_soal" value="0">
                                    <input type="checkbox" name="acak_soal" value="1"
                                        {{ old('acak_soal', '0') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="toggle-row">
                                <div>
                                    <p class="toggle-label">Acak Pilihan</p>
                                    <p class="toggle-sub">Pilihan jawaban diacak untuk setiap soal</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="hidden" name="acak_pilihan" value="0">
                                    <input type="checkbox" name="acak_pilihan" value="1"
                                        {{ old('acak_pilihan', '0') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="toggle-row">
                                <div>
                                    <p class="toggle-label">Tampilkan Nilai</p>
                                    <p class="toggle-sub">Siswa dapat melihat nilainya setelah selesai</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="hidden" name="tampilkan_nilai" value="0">
                                    <input type="checkbox" name="tampilkan_nilai" value="1"
                                        {{ old('tampilkan_nilai', '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Keterangan --}}
                <div class="card">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                        <span class="card-title">Keterangan / Instruksi</span>
                    </div>
                    <div class="card-body">
                        <div class="field">
                            <label for="keterangan">Keterangan untuk Siswa</label>
                            <textarea id="keterangan" name="keterangan" maxlength="1000"
                                placeholder="Tulis instruksi atau keterangan ujian yang akan ditampilkan ke siswa…"
                                class="{{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                                oninput="updateCounter(this, 'ctrKet', 1000)">{{ old('keterangan') }}</textarea>
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:3px">
                                <span class="field-hint">Opsional, maks. 1000 karakter</span>
                                <span class="char-counter" id="ctrKet">{{ strlen(old('keterangan','')) }}/1000</span>
                            </div>
                            @error('keterangan')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="card" style="position:sticky;top:20px">
                    <div class="card-header">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                        <span class="card-title">Status &amp; Simpan</span>
                    </div>
                    <div class="card-body">
                        <div class="toggle-row" style="margin-bottom:16px">
                            <div>
                                <p class="toggle-label">Aktifkan Ujian</p>
                                <p class="toggle-sub">Siswa langsung bisa mengakses</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', '0') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <button type="submit" class="btn-submit-full" id="submitBtn">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Ujian
                        </button>
                        <a href="{{ route('guru.ujian.index') }}" class="btn btn-secondary"
                            style="width:100%;justify-content:center;margin-top:8px;box-sizing:border-box">
                            Batal
                        </a>
                    </div>
                </div>

                {{-- Info Card --}}
                <div class="card" style="background:var(--brand-50);border-color:var(--brand-100);margin-top:12px">
                    <div class="card-body" style="padding:14px 16px">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand-700);margin-bottom:8px;display:flex;align-items:center;gap:5px">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Langkah Selanjutnya
                        </p>
                        <p style="font-size:12px;color:var(--brand-600);line-height:1.65">
                            Setelah menyimpan, Anda dapat menambahkan soal melalui halaman <strong>Detail Ujian</strong>.
                            Ujian tanpa soal tidak dapat dikerjakan siswa.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ── Validasi error dari server ── */
@if($errors->any())
Swal.fire({
    icon: 'warning',
    title: 'Perhatian!',
    html: `{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonColor: '#1f63db'
});
@endif

/* ── Counter karakter textarea ── */
function updateCounter(el, id, max) {
    const counter = document.getElementById(id);
    if (counter) counter.textContent = el.value.length + '/' + max;
}
// Init on page load
document.getElementById('keterangan')?.dispatchEvent(new Event('input'));

/* ── Prevent double submit ── */
document.getElementById('ujianForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation:spin 1s linear infinite">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        Menyimpan…`;
});

/* ── CSS spin keyframe ── */
const style = document.createElement('style');
style.textContent = '@keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}';
document.head.appendChild(style);
</script>
</x-app-layout>