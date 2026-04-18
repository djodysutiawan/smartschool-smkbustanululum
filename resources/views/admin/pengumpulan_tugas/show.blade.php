<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-700: #1750c0; --brand-h: #3582f0;
        --brand-50: #eef6ff; --brand-100: #d9ebff;
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
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-back { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); filter: none; }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-danger { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: #fecaca; filter: none; }
    .btn-warning { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .btn-warning:hover { background: #ffedd5; filter: none; }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .detail-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .detail-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .detail-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; display: flex; align-items: center; gap: 7px; }
    .detail-body { padding: 20px; }
    .dl { display: grid; grid-template-columns: 150px 1fr; gap: 10px 16px; }
    .dl dt { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text3); align-self: start; padding-top: 1px; }
    .dl dd { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); margin: 0; }

    .status-pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .status-dot { width: 5px; height: 5px; border-radius: 50%; }
    .s-sudah_dinilai { background: #dcfce7; color: #15803d; }
    .s-sudah_dinilai .status-dot { background: #15803d; }
    .s-dikumpulkan { background: #dbeafe; color: #1d4ed8; }
    .s-dikumpulkan .status-dot { background: #1d4ed8; }
    .s-terlambat { background: #fee2e2; color: #dc2626; }
    .s-terlambat .status-dot { background: #dc2626; }
    .s-belum_dikumpulkan { background: #f1f5f9; color: #64748b; }
    .s-belum_dikumpulkan .status-dot { background: #64748b; }

    .konten-box { background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 14px 16px; font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text2); line-height: 1.7; white-space: pre-wrap; min-height: 80px; }
    .file-link { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; text-decoration: none; }
    .file-link:hover { background: var(--brand-100); }

    .nilai-form-card { background: var(--surface); border: 2px solid var(--brand-100); border-radius: var(--radius); overflow: hidden; }
    .nilai-form-header { padding: 14px 20px; border-bottom: 1px solid var(--brand-100); background: var(--brand-50); display: flex; align-items: center; gap: 8px; }
    .nilai-form-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--brand-700); }
    .nilai-form-body { padding: 20px; }
    .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .field:last-child { margin-bottom: 0; }
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .field label .req { color: var(--red); margin-left: 2px; }
    .field input, .field textarea { padding: 0 12px; height: 38px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); width: 100%; outline: none; transition: border-color .15s; box-sizing: border-box; }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus, .field textarea:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field-hint { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; }

    .nilai-sudah { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: var(--radius-sm); padding: 14px 16px; display: flex; align-items: flex-start; gap: 14px; margin-bottom: 16px; flex-wrap: wrap; }
    .nilai-sudah .ns-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: #15803d; }
    .nilai-sudah .ns-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 28px; font-weight: 800; color: #15803d; }

    .kembalikan-card { background: #fff7ed; border: 1px solid #fed7aa; border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .kembalikan-card p { font-family: 'DM Sans', sans-serif; font-size: 13px; color: #92400e; }

    @media (max-width: 860px) { .grid-2 { grid-template-columns: 1fr; } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.pengumpulan-tugas.index') }}">Pengumpulan Tugas</a>
        <span class="sep">›</span>
        <span class="current">Detail Pengumpulan</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengumpulan</h1>
            <p class="page-sub">{{ $pengumpulanTugas->siswa->nama_lengkap ?? '-' }} · {{ $pengumpulanTugas->tugas->judul ?? '-' }}</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.pengumpulan-tugas.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <form action="{{ route('admin.pengumpulan-tugas.destroy', $pengumpulanTugas->id) }}" method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-danger"
                    onclick="confirmDelete(document.getElementById('deleteForm'), '{{ addslashes($pengumpulanTugas->siswa->nama_lengkap ?? '') }}')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid-2">

        {{-- Kiri: Info siswa & tugas --}}
        <div style="display:flex;flex-direction:column;gap:16px">

            <div class="detail-card">
                <div class="detail-header">
                    <p class="detail-header-title">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        Data Siswa
                    </p>
                </div>
                <div class="detail-body">
                    <dl class="dl">
                        <dt>Nama Siswa</dt>
                        <dd style="font-weight:700">{{ $pengumpulanTugas->siswa->nama_lengkap ?? '-' }}</dd>
                        <dt>Kelas</dt>
                        <dd>{{ $pengumpulanTugas->siswa->kelas->nama_kelas ?? '-' }}</dd>
                        <dt>NIS</dt>
                        <dd style="color:var(--text3)">{{ $pengumpulanTugas->siswa->nis ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-header">
                    <p class="detail-header-title">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Info Tugas
                    </p>
                </div>
                <div class="detail-body">
                    <dl class="dl">
                        <dt>Judul Tugas</dt>
                        <dd style="font-weight:700">{{ $pengumpulanTugas->tugas->judul ?? '-' }}</dd>
                        <dt>Mata Pelajaran</dt>
                        <dd>{{ $pengumpulanTugas->tugas->mataPelajaran->nama_mapel ?? '-' }}</dd>
                        <dt>Batas Waktu</dt>
                        <dd style="color:var(--text2)">
                            {{ $pengumpulanTugas->tugas ? \Carbon\Carbon::parse($pengumpulanTugas->tugas->batas_waktu)->format('d M Y, H:i') : '-' }}
                        </dd>
                        <dt>Status</dt>
                        <dd>
                            <span class="status-pill s-{{ $pengumpulanTugas->status }}">
                                <span class="status-dot"></span>
                                {{ ucfirst(str_replace('_', ' ', $pengumpulanTugas->status)) }}
                            </span>
                        </dd>
                        <dt>Dikumpulkan</dt>
                        <dd style="color:var(--text2);font-size:12.5px">
                            {{ $pengumpulanTugas->dikumpulkan_pada
                                ? $pengumpulanTugas->dikumpulkan_pada->format('d M Y, H:i')
                                : ($pengumpulanTugas->created_at ? $pengumpulanTugas->created_at->format('d M Y, H:i') : '-') }}
                        </dd>
                        @if($pengumpulanTugas->dinilai_pada)
                        <dt>Dinilai Pada</dt>
                        <dd style="color:var(--text2);font-size:12.5px">{{ $pengumpulanTugas->dinilai_pada->format('d M Y, H:i') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        {{-- Kanan: Jawaban & form nilai --}}
        <div style="display:flex;flex-direction:column;gap:16px">

            <div class="detail-card">
                <div class="detail-header">
                    <p class="detail-header-title">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/></svg>
                        Jawaban / File Pengumpulan
                    </p>
                </div>
                <div class="detail-body">

                    @if($pengumpulanTugas->jawaban_teks)
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-bottom:8px">JAWABAN TEKS</p>
                        <div class="konten-box">{{ $pengumpulanTugas->jawaban_teks }}</div>
                    @endif

                    @if($pengumpulanTugas->url_link)
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-top:12px;margin-bottom:8px">LINK</p>
                        <a href="{{ $pengumpulanTugas->url_link }}" target="_blank" class="file-link">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Buka Link
                        </a>
                    @endif

                    @if($pengumpulanTugas->path_file)
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-top:12px;margin-bottom:8px">FILE</p>
                        <a href="{{ asset('storage/' . $pengumpulanTugas->path_file) }}" target="_blank" class="file-link">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Unduh File Pengumpulan
                        </a>
                    @endif

                    @if(!$pengumpulanTugas->jawaban_teks && !$pengumpulanTugas->url_link && !$pengumpulanTugas->path_file)
                        <p style="color:var(--text3);font-size:13px;font-style:italic">Tidak ada konten pengumpulan tersimpan.</p>
                    @endif
                </div>
            </div>

            {{-- Kembalikan nilai jika sudah dinilai --}}
            @if(in_array($pengumpulanTugas->status, ['sudah_dinilai', 'dikumpulkan', 'terlambat']))
            <div class="kembalikan-card">
                <p>Batalkan penilaian untuk mengizinkan siswa memperbaiki pengumpulan.</p>
                <form action="{{ route('admin.pengumpulan-tugas.kembalikan', $pengumpulanTugas->id) }}" method="POST" id="kembalikanForm">
                    @csrf @method('PATCH')
                    <button type="button" class="btn btn-warning" style="font-size:12.5px;padding:6px 14px"
                        onclick="confirmKembalikan(document.getElementById('kembalikanForm'))">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                        Kembalikan Penilaian
                    </button>
                </form>
            </div>
            @endif

            {{-- Form Beri Nilai --}}
            <div class="nilai-form-card">
                <div class="nilai-form-header">
                    <svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    <p class="nilai-form-header-title">Beri Nilai &amp; Umpan Balik</p>
                </div>
                <div class="nilai-form-body">

                    @if($pengumpulanTugas->status === 'sudah_dinilai' && $pengumpulanTugas->nilai !== null)
                        <div class="nilai-sudah">
                            <div>
                                <p class="ns-label">Nilai Saat Ini</p>
                                <p class="ns-val">{{ $pengumpulanTugas->nilai }}</p>
                            </div>
                            @if($pengumpulanTugas->umpan_balik)
                            <div style="border-left:2px solid #bbf7d0;padding-left:14px">
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#15803d;margin-bottom:4px">Umpan Balik</p>
                                <p style="font-family:'DM Sans',sans-serif;font-size:13px;color:#166534">{{ $pengumpulanTugas->umpan_balik }}</p>
                            </div>
                            @endif
                        </div>
                        <p style="font-size:12.5px;color:var(--text3);margin-bottom:12px">Isi form di bawah untuk memperbarui nilai.</p>
                    @endif

                    <form action="{{ route('admin.pengumpulan-tugas.beri-nilai', $pengumpulanTugas->id) }}" method="POST" id="nilaiForm">
                        @csrf @method('PATCH')

                        <div class="field">
                            <label>Nilai <span class="req">*</span></label>
                            <input type="number" name="nilai" min="0"
                                max="{{ $pengumpulanTugas->tugas->nilai_maksimal ?? 100 }}"
                                value="{{ old('nilai', $pengumpulanTugas->nilai) }}"
                                placeholder="0 – {{ $pengumpulanTugas->tugas->nilai_maksimal ?? 100 }}"
                                style="{{ $errors->has('nilai') ? 'border-color:#dc2626' : '' }}">
                            <span class="field-hint">Nilai maksimal: {{ $pengumpulanTugas->tugas->nilai_maksimal ?? 100 }}</span>
                            @error('nilai')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label>Umpan Balik / Komentar</label>
                            <textarea name="umpan_balik" rows="4"
                                placeholder="Tulis komentar, koreksi, atau apresiasi untuk siswa...">{{ old('umpan_balik', $pengumpulanTugas->umpan_balik) }}</textarea>
                            @error('umpan_balik')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div style="display:flex;justify-content:flex-end">
                            <button type="submit" class="btn btn-primary" id="btnNilai">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                {{ $pengumpulanTugas->status === 'sudah_dinilai' ? 'Perbarui Nilai' : 'Simpan Nilai' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: @json(session('success')), timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon: 'error', title: 'Gagal!', text: @json(session('error')), confirmButtonColor: '#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terdapat Kesalahan',
        html: `<ul style="text-align:left;padding-left:16px;margin:0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor: '#1f63db',
    });
    @endif

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Pengumpulan?',
            html: `Data pengumpulan dari <strong>${nama}</strong> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmKembalikan(form) {
        Swal.fire({
            title: 'Kembalikan Penilaian?',
            text: 'Nilai dan umpan balik akan dihapus. Status akan kembali ke sebelumnya.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c2410c',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    document.getElementById('nilaiForm').addEventListener('submit', function (e) {
        const nilaiVal = this.querySelector('[name="nilai"]').value;
        if (!nilaiVal) {
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Nilai Wajib Diisi', text: 'Masukkan nilai sebelum menyimpan.', confirmButtonColor: '#1f63db' });
            return;
        }
        const btn = document.getElementById('btnNilai');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>