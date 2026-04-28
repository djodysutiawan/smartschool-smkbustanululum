<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#dbeafe;--brand-50:#eff6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --r:10px;--r-sm:7px;
        --error:#dc2626;--error-bg:#fef2f2;--error-border:#fca5a5;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
    }
    *, *::before, *::after { box-sizing: border-box; }

    .pg { padding: 28px 32px 48px; max-width: 2000px; }

    .back { display: inline-flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text4); text-decoration: none; margin-bottom: 22px; transition: color .15s; }
    .back:hover { color: var(--brand-600); }

    .pg-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 21px; font-weight: 800; color: var(--text); letter-spacing: -.3px; margin-bottom: 4px; }
    .pg-sub { font-size: 13px; color: var(--text4); margin-bottom: 26px; font-family: 'Plus Jakarta Sans', sans-serif; }

    .fc { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; margin-bottom: 16px; box-shadow: var(--shadow-sm); }
    .fc-head { padding: 13px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; gap: 9px; }
    .fc-head-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text2); }
    .fc-body { padding: 20px; }

    .fg { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .fgroup { display: flex; flex-direction: column; gap: 5px; }
    .fgroup.span2 { grid-column: span 2; }
    .flabel { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .02em; }
    .flabel .req { color: var(--error); }

    .fctl {
        height: 40px; padding: 0 12px; border: 1px solid var(--border);
        border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px; color: var(--text); background: var(--surface2);
        outline: none; width: 100%;
        transition: border-color .15s, background .15s, box-shadow .15s;
    }
    .fctl:focus { border-color: var(--brand-500); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.09); }
    .fctl.err { border-color: var(--error-border); background: var(--error-bg); }
    textarea.fctl { height: auto; padding: 10px 12px; resize: vertical; }
    .fhint { font-size: 11.5px; color: var(--text4); font-family: 'Plus Jakarta Sans', sans-serif; }
    .ferr { font-size: 11.5px; color: var(--error); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; }

    .fc-foot { display: flex; gap: 10px; align-items: center; padding: 15px 20px; border-top: 1px solid var(--border); background: var(--surface2); }

    .btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 20px; border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn-primary { background: var(--brand-600); color: #fff; box-shadow: 0 1px 4px rgba(31,99,219,.22); }
    .btn-primary:hover { background: var(--brand-700); filter: none; }
    .btn-secondary { background: var(--surface); color: var(--text3); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }

    @media(max-width:640px) {
        .pg { padding: 16px; }
        .fg { grid-template-columns: 1fr; }
        .fgroup.span2 { grid-column: span 1; }
    }
</style>

<div class="pg">
    <a href="{{ route('piket.izin-keluar-siswa.index') }}" class="back">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Daftar
    </a>

    <h1 class="pg-title">Buat Izin Keluar Baru</h1>
    <p class="pg-sub">Isi form di bawah untuk mencatat permohonan izin keluar siswa</p>

    <form action="{{ route('piket.izin-keluar-siswa.store') }}" method="POST" autocomplete="off">
        @csrf

        {{-- ── Data Siswa ── --}}
        <div class="fc">
            <div class="fc-head">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="fc-head-title">Data Siswa</span>
            </div>
            <div class="fc-body">
                <div class="fg">
                    <div class="fgroup span2">
                        <label class="flabel">Siswa <span class="req">*</span></label>
                        <select name="siswa_id" class="fctl {{ $errors->has('siswa_id') ? 'err' : '' }}" required>
                            <option value="">— Pilih Siswa —</option>
                            @foreach($siswas as $s)
                                <option value="{{ $s->id }}" @selected(old('siswa_id') == $s->id)>
                                    {{ $s->nama_lengkap }}{{ $s->kelas ? ' — ' . $s->kelas->nama_kelas : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')<p class="ferr">{{ $message }}</p>@enderror
                    </div>

                    <div class="fgroup">
                        <label class="flabel">Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="fctl {{ $errors->has('tahun_ajaran_id') ? 'err' : '' }}" required>
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" @selected(old('tahun_ajaran_id') == $ta->id)>
                                    {{ $ta->tahun }} / {{ ucfirst($ta->semester) }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<p class="ferr">{{ $message }}</p>@enderror
                    </div>

                    <div class="fgroup">
                        <label class="flabel">Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal"
                            value="{{ old('tanggal', today()->toDateString()) }}"
                            class="fctl {{ $errors->has('tanggal') ? 'err' : '' }}" required>
                        @error('tanggal')<p class="ferr">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Detail Izin ── --}}
        <div class="fc">
            <div class="fc-head">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="fc-head-title">Detail Izin</span>
            </div>
            <div class="fc-body">
                <div class="fg">

                    <div class="fgroup span2">
                        <label class="flabel">Tujuan / Keperluan <span class="req">*</span></label>
                        <input type="text" name="tujuan" value="{{ old('tujuan') }}"
                            maxlength="255"
                            placeholder="Contoh: Menjenguk orang tua di rumah sakit"
                            class="fctl {{ $errors->has('tujuan') ? 'err' : '' }}" required>
                        @error('tujuan')<p class="ferr">{{ $message }}</p>@enderror
                    </div>

                    <div class="fgroup">
                        <label class="flabel">Kategori <span class="req">*</span></label>
                        <select name="kategori" class="fctl {{ $errors->has('kategori') ? 'err' : '' }}" required>
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategoriList as $val => $label)
                                <option value="{{ $val }}" @selected(old('kategori') === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori')<p class="ferr">{{ $message }}</p>@enderror
                    </div>

                    {{-- Spacer --}}
                    <div class="fgroup"></div>

                    <div class="fgroup">
                        <label class="flabel">Jam Keluar <span class="req">*</span></label>
                        <input type="time" name="jam_keluar" value="{{ old('jam_keluar') }}"
                            class="fctl {{ $errors->has('jam_keluar') ? 'err' : '' }}" required>
                        @error('jam_keluar')<p class="ferr">{{ $message }}</p>@enderror
                    </div>

                    <div class="fgroup">
                        <label class="flabel">Jam Kembali (Estimasi)</label>
                        <input type="time" name="jam_kembali" value="{{ old('jam_kembali') }}"
                            class="fctl {{ $errors->has('jam_kembali') ? 'err' : '' }}">
                        <p class="fhint">Opsional — perkiraan siswa akan kembali</p>
                        @error('jam_kembali')<p class="ferr">{{ $message }}</p>@enderror
                    </div>

                    <div class="fgroup span2">
                        <label class="flabel">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="3" maxlength="1000"
                            placeholder="Informasi tambahan jika diperlukan…"
                            class="fctl {{ $errors->has('keterangan') ? 'err' : '' }}">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="ferr">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
            <div class="fc-foot">
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan &amp; Buat Izin
                </button>
                <a href="{{ route('piket.izin-keluar-siswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if($errors->any())
Swal.fire({
    icon: 'warning',
    title: 'Periksa kembali formulir',
    html: `{{ implode('<br>', array_map('e', $errors->all())) }}`,
    confirmButtonColor: '#1f63db'
});
@endif
</script>
</x-app-layout>