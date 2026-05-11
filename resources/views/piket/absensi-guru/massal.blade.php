<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--yellow:#a16207;--blue:#1d4ed8;--purple:#7c3aed;--red:#dc2626;--orange:#c2410c;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:22px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}

    /* ── Filter date card ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
    .filter-card label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .filter-card input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-card input[type=date]:focus{border-color:var(--brand-500);background:#fff}

    /* ── Piket info banner ── */
    .piket-banner{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
    .piket-banner-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand-700)}
    .piket-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);background:var(--surface);border:1px solid var(--brand-100);border-radius:5px;padding:2px 8px}

    /* ── Bulk action bar ── */
    .bulk-bar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;background:var(--surface2);border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .bulk-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .bulk-actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
    .bulk-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;border:2px solid;transition:all .15s}
    .bulk-btn.hadir{border-color:var(--green);background:#f0fdf4;color:var(--green)}
    .bulk-btn.telat{border-color:var(--yellow);background:#fefce8;color:var(--yellow)}
    .bulk-btn.izin {border-color:var(--blue);background:#eff6ff;color:var(--blue)}
    .bulk-btn.sakit{border-color:var(--purple);background:#fdf4ff;color:var(--purple)}
    .bulk-btn.alfa {border-color:var(--red);background:#fff0f0;color:var(--red)}
    .bulk-btn.cuti {border-color:var(--orange);background:#fff7ed;color:var(--orange)}
    .bulk-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
    .bulk-dot.hadir{background:var(--green)} .bulk-dot.telat{background:var(--yellow)}
    .bulk-dot.izin{background:var(--blue)}   .bulk-dot.sakit{background:var(--purple)}
    .bulk-dot.alfa{background:var(--red)}    .bulk-dot.cuti{background:var(--orange)}

    /* ── Table ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse}
    thead tr{background:var(--surface2);border-bottom:2px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    tbody tr.row-hadir{border-left:3px solid var(--green)}
    tbody tr.row-telat{border-left:3px solid var(--yellow)}
    tbody tr.row-izin {border-left:3px solid var(--blue)}
    tbody tr.row-sakit{border-left:3px solid var(--purple)}
    tbody tr.row-alfa {border-left:3px solid var(--red)}
    tbody tr.row-cuti {border-left:3px solid var(--orange)}
    tbody tr.row-dinas_luar{border-left:3px solid #059669}
    tbody tr.already-recorded{background:#f8fafc;opacity:.75}
    td{padding:9px 14px;vertical-align:middle}
    .name-col{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .sub-col{font-size:11.5px;color:var(--text3);margin-top:1px}

    /* ── Pills radio ── */
    .status-pills{display:flex;gap:4px;flex-wrap:wrap}
    .status-pill{position:relative}
    .status-pill input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .pill-label{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;cursor:pointer;border:2px solid var(--border);background:var(--surface2);color:var(--text3);transition:all .12s;white-space:nowrap;user-select:none}
    .pill-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .pill-dot.hadir{background:var(--green)} .pill-dot.telat{background:var(--yellow)}
    .pill-dot.izin{background:var(--blue)}   .pill-dot.sakit{background:var(--purple)}
    .pill-dot.alfa{background:var(--red)}    .pill-dot.cuti{background:var(--orange)}
    .pill-dot.dinas_luar{background:#059669}
    .status-pill input:checked + .pill-label.hadir{border-color:var(--green);background:#dcfce7;color:var(--green)}
    .status-pill input:checked + .pill-label.telat{border-color:var(--yellow);background:#fef9c3;color:var(--yellow)}
    .status-pill input:checked + .pill-label.izin {border-color:var(--blue);background:#dbeafe;color:var(--blue)}
    .status-pill input:checked + .pill-label.sakit{border-color:var(--purple);background:#f3e8ff;color:var(--purple)}
    .status-pill input:checked + .pill-label.alfa {border-color:var(--red);background:#fee2e2;color:var(--red)}
    .status-pill input:checked + .pill-label.cuti {border-color:var(--orange);background:#ffedd5;color:var(--orange)}
    .status-pill input:checked + .pill-label.dinas_luar{border-color:#059669;background:#d1fae5;color:#065f46}

    /* ── Inline inputs ── */
    .table-input{height:32px;padding:0 9px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;min-width:78px}
    .table-input:focus{border-color:var(--brand-500);background:#fff}
    .table-textarea{padding:5px 9px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;min-width:130px;resize:none;height:32px}
    .table-textarea:focus{border-color:var(--brand-500);background:#fff;height:56px}

    /* ── Already badge ── */
    .already-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--surface3);color:var(--text3);border:1px solid var(--border)}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir{background:#dcfce7;color:var(--green)} .badge-hadir .badge-dot{background:var(--green)}
    .badge-telat{background:#fefce8;color:var(--yellow)} .badge-telat .badge-dot{background:var(--yellow)}
    .badge-izin {background:#eff6ff;color:var(--blue)}  .badge-izin  .badge-dot{background:#3b82f6}
    .badge-sakit{background:#fdf4ff;color:var(--purple)} .badge-sakit .badge-dot{background:#a855f7}
    .badge-alfa {background:#fee2e2;color:var(--red)}   .badge-alfa  .badge-dot{background:var(--red)}
    .badge-cuti {background:#ffedd5;color:var(--orange)} .badge-cuti  .badge-dot{background:var(--orange)}
    .badge-dinas_luar{background:#d1fae5;color:#065f46} .badge-dinas_luar .badge-dot{background:#059669}
    .badge-qr{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;font-size:10.5px;padding:2px 7px}

    /* ── Count strip ── */
    .count-strip{display:flex;gap:8px;flex-wrap:wrap}
    .count-chip{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .count-chip.hadir{background:#dcfce7;color:var(--green)}
    .count-chip.telat{background:#fef9c3;color:var(--yellow)}
    .count-chip.izin {background:#dbeafe;color:var(--blue)}
    .count-chip.sakit{background:#f3e8ff;color:var(--purple)}
    .count-chip.alfa {background:#fee2e2;color:var(--red)}
    .count-chip.cuti {background:#ffedd5;color:var(--orange)}

    /* ── Submit bar ── */
    .submit-bar{position:sticky;bottom:0;background:var(--surface);border-top:1px solid var(--border);padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;z-index:50;box-shadow:0 -4px 20px rgba(0,0,0,.06)}

    @media(max-width:768px){.page{padding:16px 16px 60px}}
    @media(max-width:480px){.status-pills{gap:2px}.pill-label{padding:3px 8px;font-size:10.5px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Absensi Massal Guru</h1>
            <p class="page-sub">Catat kehadiran semua guru dalam satu halaman</p>
        </div>
        <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Filter tanggal --}}
    <div class="filter-card">
        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <form method="GET" action="{{ route('piket.absensi-guru.massal.form') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <label>Tanggal Absensi:</label>
            <input type="date" name="tanggal"
                   value="{{ $tanggal }}"
                   min="{{ $tanggalMin }}"
                   max="{{ $tanggalMax }}"
                   onchange="this.form.submit()">
        </form>
        <div style="margin-left:auto;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">
            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    {{-- Info piket hari ini --}}
    @if($guruPiketHariIni->count())
    <div class="piket-banner">
        <svg width="13" height="13" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        <span class="piket-banner-label">Piket Hari Ini:</span>
        @foreach($guruPiketHariIni as $p)
            <span class="piket-name">{{ $p->guru->nama_lengkap ?? '—' }}</span>
        @endforeach
    </div>
    @endif

    {{-- Catatan untuk guru yang sudah via QR --}}
    @if($absensiExisting->where('metode','qr')->count())
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:16px;display:flex;align-items:center;gap:8px;font-size:13px;color:#15803d;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ $absensiExisting->where('metode','qr')->count() }} guru sudah absen via QR — hanya jam keluar &amp; keterangan yang bisa diperbarui untuk mereka.
    </div>
    @endif

    <form action="{{ route('piket.absensi-guru.massal.store') }}" method="POST" id="massalForm">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="table-card">
            {{-- Bulk bar --}}
            <div class="bulk-bar">
                <div class="bulk-title">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Daftar Guru
                    <span style="background:var(--surface3);color:var(--text3);font-size:11px;padding:2px 8px;border-radius:99px;font-weight:700">{{ $guruList->count() }}</span>
                </div>
                <div class="bulk-actions">
                    <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)">Tandai semua:</span>
                    @foreach(['hadir','telat','izin','sakit','alfa','cuti'] as $s)
                    <button type="button" class="bulk-btn {{ $s }}" onclick="setAll('{{ $s }}')">
                        <span class="bulk-dot {{ $s }}"></span>{{ ucfirst($s) }}
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Nama Guru</th>
                            <th style="min-width:320px">Status Kehadiran</th>
                            <th style="min-width:86px">Jam Masuk</th>
                            <th style="min-width:86px">Jam Keluar</th>
                            <th style="min-width:160px">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="guruTableBody">
                        @foreach($guruList as $idx => $g)
                        @php
                            $existing  = $absensiExisting->get($g->id);
                            $isQr      = $existing && $existing->metode === 'qr';
                            $curStatus = $existing ? $existing->status : 'hadir';
                        @endphp
                        <tr id="row-{{ $g->id }}" class="row-{{ $curStatus }} {{ $existing ? 'already-recorded' : '' }}">
                            <td style="font-size:12px;color:var(--text3);font-weight:700">{{ $idx + 1 }}</td>
                            <td>
                                <input type="hidden" name="absensi[{{ $idx }}][guru_id]" value="{{ $g->id }}">
                                <p class="name-col">{{ $g->nama_lengkap }}</p>
                                <p class="sub-col">
                                    {{ $g->nip ?: 'NIP—' }}
                                    @if($isQr)
                                        <span class="badge-qr" style="display:inline-flex;align-items:center;gap:3px;margin-left:4px;padding:1px 6px;border-radius:4px;background:#ecfdf5;color:#065f46;font-weight:700;font-size:10.5px;border:1px solid #a7f3d0">
                                            <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                            QR
                                        </span>
                                    @endif
                                </p>
                            </td>
                            <td>
                                @if($isQr)
                                    {{-- QR: tampilkan status tapi locked, tetap kirim value --}}
                                    <input type="hidden" name="absensi[{{ $idx }}][status]" value="{{ $existing->status }}">
                                    <span class="badge badge-{{ $existing->status }}">
                                        <span class="badge-dot"></span>{{ ucfirst($existing->status) }}
                                    </span>
                                    <small style="font-size:11px;color:var(--text3);display:block;margin-top:3px">Status dikunci (via QR)</small>
                                @else
                                    <div class="status-pills">
                                        @foreach($statusList as $st)
                                        <label class="status-pill">
                                            <input type="radio"
                                                   name="absensi[{{ $idx }}][status]"
                                                   value="{{ $st }}"
                                                   {{ $curStatus === $st ? 'checked' : '' }}
                                                   onchange="onStatusChange({{ $g->id }}, '{{ $st }}')">
                                            <span class="pill-label {{ $st }}">
                                                <span class="pill-dot {{ $st }}"></span>{{ ucfirst($st) }}
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td>
                                <input type="time" name="absensi[{{ $idx }}][jam_masuk]"
                                       class="table-input"
                                       value="{{ $existing ? \Carbon\Carbon::parse($existing->jam_masuk)->format('H:i') : '' }}"
                                       {{ $isQr ? 'readonly style=opacity:.5' : '' }}>
                            </td>
                            <td>
                                <input type="time" name="absensi[{{ $idx }}][jam_keluar]"
                                       class="table-input"
                                       value="{{ $existing && $existing->jam_keluar ? \Carbon\Carbon::parse($existing->jam_keluar)->format('H:i') : '' }}">
                            </td>
                            <td>
                                <textarea name="absensi[{{ $idx }}][keterangan]"
                                          class="table-textarea"
                                          placeholder="Catatan…"
                                          oninput="autoResize(this)"
                                          rows="1">{{ $existing->keterangan ?? '' }}</textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Sticky submit --}}
            <div class="submit-bar">
                <div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2)">
                        <span style="color:var(--brand-600);font-size:16px;font-weight:800">{{ $guruList->count() }}</span> guru akan diperbarui
                    </p>
                    <div class="count-strip" style="margin-top:6px" id="countStrip">
                        @foreach(['hadir','telat','izin','sakit','alfa','cuti'] as $s)
                        <span class="count-chip {{ $s }}" id="cnt-{{ $s }}">0 {{ ucfirst($s) }}</span>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex;gap:8px">
                    <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                        Simpan Absensi
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif
@if($errors->any())
Swal.fire({icon:'warning',title:'Perhatian!',html:@json(implode('<br>',$errors->all())),confirmButtonColor:'#1f63db'});
@endif

const STATUS_LIST = {!! json_encode($statusList) !!};

function setAll(status) {
    document.querySelectorAll(`input[type=radio][value="${status}"]`).forEach(r => {
        if (!r.closest('tr').classList.contains('already-recorded') || !r.closest('tr').querySelector('input[type=hidden][name*=status]')) {
            if (!r.readOnly) { r.checked = true; }
        }
    });
    // Re-check all — set all non-QR rows
    document.querySelectorAll('tbody tr:not(.already-recorded) input[type=radio][value="' + status + '"]').forEach(r => {
        r.checked = true;
        const guruId = r.closest('tr').id.replace('row-', '');
        setRowClass(guruId, status);
    });
    updateCounts();
}

function onStatusChange(guruId, status) {
    setRowClass(guruId, status);
    updateCounts();
}

function setRowClass(guruId, status) {
    const row = document.getElementById(`row-${guruId}`);
    if (!row) return;
    STATUS_LIST.forEach(s => row.classList.remove(`row-${s}`));
    row.classList.add(`row-${status}`);
}

function updateCounts() {
    const counts = {};
    STATUS_LIST.forEach(s => counts[s] = 0);

    // Count checked radios (non-QR rows)
    document.querySelectorAll('input[type=radio]:checked').forEach(r => {
        if (STATUS_LIST.includes(r.value)) counts[r.value]++;
    });
    // Count hidden inputs (QR rows)
    document.querySelectorAll('input[type=hidden][name*="[status]"]').forEach(h => {
        if (STATUS_LIST.includes(h.value)) counts[h.value]++;
    });

    STATUS_LIST.forEach(s => {
        const el = document.getElementById(`cnt-${s}`);
        if (el) el.textContent = `${counts[s]} ${s.charAt(0).toUpperCase()+s.slice(1)}`;
    });
}

function autoResize(el) {
    el.style.height = '32px';
    el.style.height = Math.min(el.scrollHeight, 72) + 'px';
}

document.getElementById('massalForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const total = {{ $guruList->count() }};
    Swal.fire({
        title: 'Simpan Absensi?',
        html: `Absensi <strong>${total} guru</strong> untuk tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong> akan disimpan.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1f63db',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Cek Lagi',
    }).then(r => { if (r.isConfirmed) form.submit(); });
});

document.addEventListener('DOMContentLoaded', () => {
    // Init row classes from existing data
    document.querySelectorAll('input[type=radio]:checked').forEach(r => {
        const guruId = r.closest('tr')?.id?.replace('row-', '');
        if (guruId) setRowClass(guruId, r.value);
    });
    updateCounts();
});
</script>
</x-app-layout>