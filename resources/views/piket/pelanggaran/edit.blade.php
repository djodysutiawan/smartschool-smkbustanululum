<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --red:#dc2626;
        --yellow-bg:#fefce8;--yellow-border:#fde68a;--yellow-text:#92400e;
    }

    .page { padding: 28px 28px 48px; max-width: 2000px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    .breadcrumb { display: flex; align-items: center; gap: 6px; margin-bottom: 20px; flex-wrap: wrap; }
    .breadcrumb a { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--brand-600); text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb-sep { color: var(--text3); font-size: 12px; }
    .breadcrumb-cur { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }

    /* Banner peringatan edit */
    .edit-banner {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 14px 18px; background: var(--yellow-bg);
        border: 1px solid var(--yellow-border); border-radius: var(--radius);
        margin-bottom: 20px; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 600; color: var(--yellow-text); line-height: 1.5;
    }
    .edit-banner svg { flex-shrink: 0; margin-top: 1px; }

    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-card-header { padding: 16px 24px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; gap: 10px; }
    .form-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 800; color: var(--text); }
    .form-card-body { padding: 24px; }
    .form-card-footer { padding: 16px 24px; border-top: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; justify-content: flex-end; gap: 8px; }

    .form-section-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); letter-spacing: .06em; text-transform: uppercase; padding-bottom: 10px; border-bottom: 1px solid var(--border); margin-bottom: 20px; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .form-grid .col-span-2 { grid-column: span 2; }

    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .form-label .req { color: var(--red); margin-left: 2px; }
    .form-control { height: 40px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface); outline: none; transition: border-color .15s, box-shadow .15s; width: 100%; box-sizing: border-box; }
    .form-control:focus { border-color: var(--brand-500); box-shadow: 0 0 0 3px rgba(53,130,240,.12); }
    .form-control.is-invalid { border-color: var(--red); background: #fff8f8; }
    .form-control:disabled { background: var(--surface3); color: var(--text3); cursor: not-allowed; }
    textarea.form-control { height: auto; padding: 10px 12px; resize: vertical; min-height: 96px; }
    select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; cursor: pointer; }
    .form-hint { font-size: 11.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .form-error { font-size: 11.5px; color: var(--red); display: flex; align-items: center; gap: 4px; font-family: 'DM Sans', sans-serif; }

    /* Siswa preview (read-only pada edit) */
    .siswa-readonly { display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); }
    .siswa-avatar { width: 34px; height: 34px; border-radius: 8px; background: var(--brand-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800; color: var(--brand-700); }
    .siswa-info .name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .siswa-info .meta { font-size: 11.5px; color: var(--text3); margin-top: 1px; font-family: 'DM Sans', sans-serif; }

    /* Kat preview */
    .kat-preview { display: none; margin-top: 6px; padding: 6px 10px; background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; color: var(--text2); }
    .kat-preview.show { display: block; }

    /* Poin indicator */
    .poin-indicator { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
    .poin-bar-track { flex: 1; height: 6px; background: var(--surface3); border-radius: 99px; overflow: hidden; }
    .poin-bar-fill { height: 100%; border-radius: 99px; transition: width .3s ease, background .3s ease; }
    .poin-label-right { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; min-width: 46px; text-align: right; transition: color .3s; }

    @media (max-width: 640px) {
        .page { padding: 16px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .col-span-2 { grid-column: span 1; }
    }
</style>

<div class="page">

    <nav class="breadcrumb" aria-label="Navigasi">
        <a href="{{ route('piket.pelanggaran.index') }}">Riwayat Pelanggaran</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('piket.pelanggaran.show', $pelanggaran->id) }}">Detail #{{ $pelanggaran->id }}</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Pelanggaran</h1>
            <p class="page-sub">
                Mengubah catatan pelanggaran #{{ $pelanggaran->id }}
                &middot; {{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('d F Y') }}
            </p>
        </div>
        <a href="{{ route('piket.pelanggaran.show', $pelanggaran->id) }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali ke Detail
        </a>
    </div>

    {{-- Banner: edit hanya bisa saat pending --}}
    <div class="edit-banner" role="alert">
        <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>
            Pelanggaran yang sudah berstatus <strong>Diproses</strong> atau lebih tidak dapat diedit.
            Perubahan hanya tersedia selama masih berstatus <strong>Pending</strong>.
        </span>
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            <span class="form-card-title">Edit Data Pelanggaran</span>
        </div>

        {{-- FIX: method PATCH bukan POST --}}
        <form action="{{ route('piket.pelanggaran.update', $pelanggaran->id) }}" method="POST" id="editForm" novalidate>
            @csrf
            @method('PATCH')

            <div class="form-card-body">

                {{-- ── Data Siswa (read-only pada edit — tidak boleh ganti siswa) ── --}}
                <p class="form-section-label">Data Siswa</p>
                <div class="form-grid">
                    <div class="form-group col-span-2">
                        <label class="form-label">Nama Siswa</label>
                        {{--
                            FIX: Siswa tidak boleh diubah saat edit — hanya tampilkan.
                            Kirim siswa_id via hidden input agar tetap lulus validasi.
                            Dropdown siswa tidak dirender untuk mencegah penggantian siswa
                            yang bisa merusak integritas data.
                        --}}
                        <input type="hidden" name="siswa_id" value="{{ $pelanggaran->siswa_id }}">
                        <div class="siswa-readonly">
                            <div class="siswa-avatar">
                                {{ strtoupper(substr($pelanggaran->siswa->nama_lengkap ?? '?', 0, 1)) }}
                            </div>
                            <div class="siswa-info">
                                <p class="name">{{ $pelanggaran->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="meta">
                                    NIS: {{ $pelanggaran->siswa->nis ?? '—' }}
                                    &middot; Kelas: {{ $pelanggaran->siswa->kelas->nama_kelas ?? '—' }}
                                </p>
                            </div>
                        </div>
                        <p class="form-hint">Siswa tidak dapat diubah setelah pelanggaran dicatat.</p>
                    </div>
                </div>

                {{-- ── Detail Pelanggaran ── --}}
                <p class="form-section-label" style="margin-top:8px">Detail Pelanggaran</p>
                <div class="form-grid">

                    {{-- Kategori --}}
                    <div class="form-group">
                        <label class="form-label" for="kategoriSelect">
                            Kategori Pelanggaran <span class="req">*</span>
                        </label>
                        <select name="kategori_pelanggaran_id" id="kategoriSelect"
                            class="form-control {{ $errors->has('kategori_pelanggaran_id') ? 'is-invalid' : '' }}"
                            onchange="onKategoriChange(this)">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}"
                                    data-nama="{{ e($kat->nama) }}"
                                    data-poin="{{ $kat->poin_default ?? '' }}"
                                    {{--
                                        FIX: old() untuk validation fail,
                                        fallback ke nilai tersimpan di DB.
                                    --}}
                                    {{ old('kategori_pelanggaran_id', $pelanggaran->kategori_pelanggaran_id) == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_pelanggaran_id')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="kat-preview" id="katPreview" aria-live="polite"></div>
                    </div>

                    {{-- Poin --}}
                    <div class="form-group">
                        <label class="form-label" for="poinInput">
                            Poin Pelanggaran <span class="req">*</span>
                        </label>
                        <input type="number" name="poin" id="poinInput"
                            class="form-control {{ $errors->has('poin') ? 'is-invalid' : '' }}"
                            value="{{ old('poin', $pelanggaran->poin) }}"
                            min="1" max="100"
                            oninput="updatePoinBar(this.value)">
                        @error('poin')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="poin-indicator">
                            <div class="poin-bar-track" role="progressbar" aria-valuemin="1" aria-valuemax="100" id="poinBar">
                                <div class="poin-bar-fill" id="poinBarFill"></div>
                            </div>
                            <span class="poin-label-right" id="poinLabel"></span>
                        </div>
                        <p class="form-hint">Rentang 1 – 100 poin</p>
                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group">
                        <label class="form-label" for="tanggalInput">
                            Tanggal Kejadian <span class="req">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggalInput"
                            class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                            value="{{ old('tanggal', \Carbon\Carbon::parse($pelanggaran->tanggal)->format('Y-m-d')) }}"
                            max="{{ now()->format('Y-m-d') }}">
                        @error('tanggal')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="form-hint">Tidak boleh melebihi hari ini</p>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label" for="statusSelect">
                            Status <span class="req">*</span>
                        </label>
                        <select name="status" id="statusSelect"
                            class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            @foreach($statusList as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $pelanggaran->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="form-hint">Piket hanya bisa set ke Pending atau Diproses</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group col-span-2">
                        <label class="form-label" for="deskripsiInput">
                            Deskripsi Pelanggaran <span class="req">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsiInput" rows="3"
                            class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                            placeholder="Jelaskan pelanggaran yang terjadi secara singkat dan jelas…"
                            maxlength="1000">{{ old('deskripsi', $pelanggaran->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tindakan --}}
                    <div class="form-group col-span-2">
                        <label class="form-label" for="tindakanInput">
                            Tindakan yang Diambil
                            <span style="font-weight:400;color:var(--text3)">(opsional)</span>
                        </label>
                        <textarea name="tindakan" id="tindakanInput" rows="2"
                            class="form-control {{ $errors->has('tindakan') ? 'is-invalid' : '' }}"
                            placeholder="Isi jika sudah ada tindakan awal yang diambil…"
                            maxlength="500">{{ old('tindakan', $pelanggaran->tindakan) }}</textarea>
                        @error('tindakan')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="form-hint">Bisa diisi nanti saat menyelesaikan pelanggaran</p>
                    </div>

                </div>
            </div>

            <div class="form-card-footer">
                <a href="{{ route('piket.pelanggaran.show', $pelanggaran->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    (function () {
        const errs = @json($errors->all());
        Swal.fire({
            icon: 'warning',
            title: 'Periksa Formulir',
            html: '<ul style="text-align:left;padding-left:20px;margin:0">' +
                  errs.map(e => '<li>' + e + '</li>').join('') +
                  '</ul>',
            confirmButtonColor: '#1f63db',
            confirmButtonText: 'Oke, perbaiki'
        });
    })();
    @endif

    function onKategoriChange(sel) {
        const opt     = sel.options[sel.selectedIndex];
        const preview = document.getElementById('katPreview');
        if (!sel.value) { preview.classList.remove('show'); return; }

        const nama = opt.dataset.nama || '';
        const poin = parseInt(opt.dataset.poin, 10);

        preview.textContent = 'Kategori: ' + nama;
        preview.classList.add('show');

        // Auto-isi poin dari poin_default — hanya jika valid
        if (!isNaN(poin) && poin >= 1 && poin <= 100) {
            document.getElementById('poinInput').value = poin;
            updatePoinBar(poin);
        }
    }

    function updatePoinBar(val) {
        const v    = Math.max(1, Math.min(100, parseInt(val, 10) || 1));
        const fill = document.getElementById('poinBarFill');
        const lbl  = document.getElementById('poinLabel');
        const bar  = document.getElementById('poinBar');

        let color;
        if (v <= 20)      { color = '#15803d'; }
        else if (v <= 50) { color = '#a16207'; }
        else              { color = '#dc2626'; }

        fill.style.width      = v + '%';
        fill.style.background = color;
        lbl.style.color       = color;
        lbl.textContent       = v + ' poin';
        bar.setAttribute('aria-valuenow', v);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Init poin bar dengan nilai yang sudah ada di form (old() atau DB)
        const poinVal = parseInt(document.getElementById('poinInput').value, 10) || 1;
        updatePoinBar(poinVal);

        // Init kategori preview jika sudah ada pilihan
        const katSel = document.getElementById('kategoriSelect');
        if (katSel.value) onKategoriChange(katSel);

        // Anti double-submit
        document.getElementById('editForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation:spin 1s linear infinite"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Menyimpan…';
        });
    });

    const style = document.createElement('style');
    style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
    document.head.appendChild(style);
</script>
</x-app-layout>