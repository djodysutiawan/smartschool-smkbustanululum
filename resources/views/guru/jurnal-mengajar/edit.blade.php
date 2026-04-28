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
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* Form card */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-body{padding:20px}

    /* Field */
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:16px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field input[type=text],.field input[type=date],.field input[type=number],
    .field select,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;width:100%}
    .field input:focus,.field textarea:focus,.field select:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .field .hint{font-size:11.5px;color:var(--text3)}
    .field .error-msg{font-size:11.5px;color:#dc2626;margin-top:2px}
    .field input.is-error,.field textarea.is-error,.field select.is-error{border-color:#dc2626;background:#fff8f8}

    .two-col{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .three-col{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}

    .form-section{margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid var(--border)}
    .form-section:last-of-type{border-bottom:none;margin-bottom:0;padding-bottom:0}
    .section-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:14px;display:flex;align-items:center;gap:7px}
    .section-label::after{content:'';flex:1;height:1px;background:var(--border)}

    .form-actions{display:flex;gap:8px;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--border)}

    .char-count{font-size:11.5px;color:var(--text3);text-align:right}

    @media(max-width:768px){
        .two-col,.three-col{grid-template-columns:1fr}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Jurnal Mengajar</h1>
            <p class="page-sub">Perbarui data jurnal pertemuan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.jurnal-mengajar.show', $jurnal->id) }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Batal
            </a>
        </div>
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            <span class="form-card-title">Edit Jurnal Mengajar</span>
        </div>
        <div class="form-body">
            <form action="{{ route('guru.jurnal-mengajar.update', $jurnal->id) }}" method="POST">
                @csrf @method('PUT')

                {{-- Sesi & Kelas --}}
                <div class="form-section">
                    <p class="section-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Sesi &amp; Kelas
                    </p>

                    <div class="three-col">
                        <div class="field">
                            <label>Kelas <span class="req">*</span></label>
                            <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-error' : '' }}">
                                <option value="">— Pilih Kelas —</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id', $jurnal->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Mata Pelajaran <span class="req">*</span></label>
                            <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id') ? 'is-error' : '' }}">
                                <option value="">— Pilih Mata Pelajaran —</option>
                                @foreach($mapelList as $m)
                                    <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $jurnal->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_pelajaran_id')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Jadwal Pelajaran <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                            <select name="jadwal_pelajaran_id">
                                <option value="">— Pilih Jadwal —</option>
                                @foreach($jadwalList as $jp)
                                    <option value="{{ $jp->id }}" {{ old('jadwal_pelajaran_id', $jurnal->jadwal_pelajaran_id) == $jp->id ? 'selected' : '' }}>
                                        {{ ucfirst($jp->hari) }} · {{ \Carbon\Carbon::parse($jp->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jp->jam_selesai)->format('H:i') }}
                                        · {{ $jp->kelas->nama_kelas ?? '' }} · {{ $jp->mataPelajaran->nama_mapel ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jadwal_pelajaran_id')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="two-col">
                        <div class="field">
                            <label>Tanggal <span class="req">*</span></label>
                            <input type="date" name="tanggal"
                                   value="{{ old('tanggal', $jurnal->tanggal) }}"
                                   max="{{ now()->toDateString() }}"
                                   class="{{ $errors->has('tanggal') ? 'is-error' : '' }}">
                            @error('tanggal')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Pertemuan Ke <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                            <input type="number" name="pertemuan_ke" min="1" max="52"
                                   value="{{ old('pertemuan_ke', $jurnal->pertemuan_ke) }}"
                                   placeholder="Contoh: 5"
                                   class="{{ $errors->has('pertemuan_ke') ? 'is-error' : '' }}">
                            @error('pertemuan_ke')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Materi & Metode --}}
                <div class="form-section">
                    <p class="section-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Materi &amp; Metode
                    </p>

                    <div class="field">
                        <label>Metode Pembelajaran <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                        <select name="metode_pembelajaran">
                            <option value="">— Pilih Metode —</option>
                            @foreach($metodeList as $mt)
                                <option value="{{ $mt }}" {{ old('metode_pembelajaran', $jurnal->metode_pembelajaran) === $mt ? 'selected' : '' }}>
                                    {{ ucfirst($mt) }}
                                </option>
                            @endforeach
                        </select>
                        @error('metode_pembelajaran')<span class="error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Materi Ajar <span class="req">*</span></label>
                        <textarea name="materi_ajar" id="materiAjar" rows="5" maxlength="2000"
                                  placeholder="Tuliskan materi yang diajarkan pada pertemuan ini…"
                                  class="{{ $errors->has('materi_ajar') ? 'is-error' : '' }}"
                                  oninput="charCount('materiAjar','materiCount',2000)"
                                  style="resize:vertical">{{ old('materi_ajar', $jurnal->materi_ajar) }}</textarea>
                        @error('materi_ajar')<span class="error-msg">{{ $message }}</span>@enderror
                        <span class="char-count" id="materiCount">0 / 2000</span>
                    </div>
                </div>

                {{-- Kehadiran --}}
                <div class="form-section">
                    <p class="section-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Kehadiran Siswa
                    </p>
                    <div class="two-col">
                        <div class="field">
                            <label>Jumlah Hadir <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                            <input type="number" name="jumlah_hadir" min="0"
                                   value="{{ old('jumlah_hadir', $jurnal->jumlah_hadir) }}"
                                   placeholder="0"
                                   class="{{ $errors->has('jumlah_hadir') ? 'is-error' : '' }}">
                            @error('jumlah_hadir')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Jumlah Tidak Hadir <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                            <input type="number" name="jumlah_tidak_hadir" min="0"
                                   value="{{ old('jumlah_tidak_hadir', $jurnal->jumlah_tidak_hadir) }}"
                                   placeholder="0"
                                   class="{{ $errors->has('jumlah_tidak_hadir') ? 'is-error' : '' }}">
                            @error('jumlah_tidak_hadir')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="form-section">
                    <p class="section-label">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Catatan
                    </p>
                    <div class="field">
                        <label>Catatan Kelas <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                        <textarea name="catatan_kelas" id="catatanKelas" rows="4" maxlength="2000"
                                  placeholder="Catatan khusus, kendala, atau hal-hal penting selama KBM…"
                                  oninput="charCount('catatanKelas','catatanCount',2000)"
                                  style="resize:vertical">{{ old('catatan_kelas', $jurnal->catatan_kelas) }}</textarea>
                        @error('catatan_kelas')<span class="error-msg">{{ $message }}</span>@enderror
                        <span class="char-count" id="catatanCount">0 / 2000</span>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('guru.jurnal-mengajar.show', $jurnal->id) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

function charCount(textareaId, counterId, max) {
    const len = document.getElementById(textareaId).value.length;
    document.getElementById(counterId).textContent = `${len} / ${max}`;
}

document.addEventListener('DOMContentLoaded', () => {
    charCount('materiAjar', 'materiCount', 2000);
    charCount('catatanKelas', 'catatanCount', 2000);
});
</script>
</x-app-layout>