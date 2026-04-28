<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --pk-700:#1750c0;--pk-600:#1f63db;--pk-500:#3582f0;--pk-100:#d9ebff;--pk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 88px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-primary{background:var(--pk-600);color:#fff}
    .btn-primary:hover{background:var(--pk-700)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}

    /* Tanggal bar */
    .tanggal-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:13px 20px;margin-bottom:14px;display:flex;align-items:center;gap:14px;flex-wrap:wrap}
    .tanggal-bar label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);display:flex;align-items:center;gap:7px}
    .tanggal-bar input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .tanggal-bar input[type=date]:focus{border-color:var(--pk-500);background:#fff}
    .tanggal-bar .tanggal-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--pk-600)}

    /* Info banner */
    .info-banner{display:flex;align-items:center;gap:10px;background:var(--pk-50);border:1px solid var(--pk-100);border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--pk-700)}

    /* Table card */
    .tbl-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .tbl-topbar{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .tbl-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .tbl-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .tbl-wrap{overflow-x:auto}

    table{width:100%;border-collapse:collapse}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;background:var(--surface2);border-bottom:1px solid var(--border);white-space:nowrap}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    tbody tr.row-existing{background:#fffbeb}
    tbody tr.row-existing:hover{background:#fef9c3}
    td{padding:10px 14px;vertical-align:middle;color:var(--text)}

    /* Table inputs */
    .tbl-sel{height:34px;padding:0 9px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;width:100%;transition:border-color .15s,background .15s,color .15s}
    .tbl-sel:focus{border-color:var(--pk-500);background:#fff}
    .tbl-inp{height:34px;padding:0 9px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;width:100%;transition:border-color .15s}
    .tbl-inp:focus{border-color:var(--pk-500);background:#fff}
    .tbl-ta{padding:6px 9px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface2);outline:none;width:100%;resize:none;min-height:50px;transition:border-color .15s}
    .tbl-ta:focus{border-color:var(--pk-500);background:#fff}

    /* Status color variants */
    .s-hadir{border-color:#86efac !important;background:#f0fdf4 !important;color:#15803d !important}
    .s-telat{border-color:#fde68a !important;background:#fefce8 !important;color:#a16207 !important}
    .s-izin{border-color:#bfdbfe !important;background:#eff6ff !important;color:#1d4ed8 !important}
    .s-sakit{border-color:#e9d5ff !important;background:#fdf4ff !important;color:#7c3aed !important}
    .s-alfa{border-color:#fecaca !important;background:#fff0f0 !important;color:#dc2626 !important}

    /* Existing badge */
    .badge-ex{display:inline-flex;align-items:center;gap:3px;padding:2px 7px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;background:#fffbeb;color:#a16207;border:1px solid #fde68a;margin-top:3px}

    /* Two line */
    .two-line .prim{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .two-line .sec{font-size:11.5px;color:var(--text3);margin-top:1px;font-family:'DM Sans',sans-serif}

    /* No col */
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}

    /* Bulk bar */
    .bulk-bar{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .bulk-bar label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .bulk-sel{height:32px;padding:0 10px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .btn-bulk{height:32px;padding:0 14px;background:var(--pk-50);color:var(--pk-700);border:1px solid var(--pk-100);border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-bulk:hover{background:var(--pk-100)}

    /* Sticky footer */
    .sticky-foot{position:sticky;bottom:0;left:0;right:0;background:#fff;border-top:1px solid var(--border);padding:13px 28px;display:flex;align-items:center;justify-content:space-between;gap:12px;z-index:50;box-shadow:0 -6px 20px rgba(0,0,0,.06);flex-wrap:wrap}
    .foot-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2)}
    .foot-info strong{color:var(--text)}
    .foot-actions{display:flex;gap:8px}

    @media(max-width:640px){.page{padding:16px 16px 90px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Input Absensi Massal</h1>
            <p class="page-sub">Catat kehadiran semua guru sekaligus dalam satu form</p>
        </div>
        <div>
            <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Tanggal picker --}}
    <div class="tanggal-bar">
        <label>
            <svg width="15" height="15" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Tanggal:
        </label>
        <form method="GET" action="{{ route('piket.absensi-guru.massal.form') }}" style="display:flex;align-items:center;gap:8px">
            <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
        </form>
        <span class="tanggal-label">
            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </span>
        @if($tanggal === today()->toDateString())
            <span style="background:#dcfce7;color:#15803d;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700">Hari Ini</span>
        @endif
    </div>

    {{-- Info jika ada data existing --}}
    @if($absensiExisting->count() > 0)
    <div class="info-banner">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ $absensiExisting->count() }} guru sudah memiliki data absensi pada tanggal ini. Baris berwarna kuning menandakan data yang akan diperbarui.</span>
    </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('piket.absensi-guru.massal.store') }}" method="POST" id="formMassal">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="tbl-card">
            <div class="tbl-topbar">
                <p class="tbl-info">
                    Daftar Guru
                    <span>{{ $guruList->count() }} guru aktif</span>
                </p>
                {{-- Bulk status --}}
                <div class="bulk-bar">
                    <label>Set semua:</label>
                    <select class="bulk-sel" id="bulkStatusSel">
                        <option value="">— pilih status —</option>
                        @foreach($statusList as $s)
                            <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn-bulk" onclick="applyBulk()">Terapkan</button>
                </div>
            </div>

            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:42px">#</th>
                            <th style="min-width:180px">Nama Guru</th>
                            <th style="min-width:130px">Status <span style="color:#dc2626">*</span></th>
                            <th style="min-width:108px">Jam Masuk</th>
                            <th style="min-width:108px">Jam Keluar</th>
                            <th style="min-width:190px">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guruList as $i => $guru)
                        @php $ex = $absensiExisting->get($guru->id); @endphp
                        <tr class="{{ $ex ? 'row-existing' : '' }}">
                            <td>
                                <span class="no-col">{{ $i + 1 }}</span>
                                <input type="hidden" name="absensi[{{ $i }}][guru_id]" value="{{ $guru->id }}">
                            </td>
                            <td>
                                <div class="two-line">
                                    <p class="prim">{{ $guru->nama_lengkap }}</p>
                                    <p class="sec">NIP: {{ $guru->nip ?? '—' }}</p>
                                </div>
                                @if($ex)
                                    <span class="badge-ex">
                                        <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3"/></svg>
                                        Akan diperbarui
                                    </span>
                                @endif
                            </td>
                            <td>
                                <select name="absensi[{{ $i }}][status]"
                                        class="tbl-sel s-sel s-{{ $ex?->status ?? 'hadir' }}"
                                        onchange="onStatusChange(this)"
                                        required>
                                    @foreach($statusList as $s)
                                        <option value="{{ $s }}" {{ ($ex?->status ?? 'hadir') === $s ? 'selected' : '' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="time" name="absensi[{{ $i }}][jam_masuk]" class="tbl-inp"
                                    value="{{ $ex?->jam_masuk ? \Carbon\Carbon::parse($ex->jam_masuk)->format('H:i') : '' }}">
                            </td>
                            <td>
                                <input type="time" name="absensi[{{ $i }}][jam_keluar]" class="tbl-inp"
                                    value="{{ $ex?->jam_keluar ? \Carbon\Carbon::parse($ex->jam_keluar)->format('H:i') : '' }}">
                            </td>
                            <td>
                                <textarea name="absensi[{{ $i }}][keterangan]" class="tbl-ta"
                                    placeholder="Opsional…">{{ $ex?->keterangan }}</textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>

</div>

{{-- Sticky footer --}}
<div class="sticky-foot">
    <p class="foot-info">
        Tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM Y') }}</strong>
        &nbsp;·&nbsp; Total: <strong>{{ $guruList->count() }} guru</strong>
        @if($absensiExisting->count() > 0)
        &nbsp;·&nbsp; <span style="color:#a16207">{{ $absensiExisting->count() }} akan diperbarui</span>
        @endif
    </p>
    <div class="foot-actions">
        <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">Batal</a>
        <button type="button" class="btn btn-primary" onclick="konfirmasiSimpan()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Simpan Absensi
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ── Status color ── */
const S_CLS = ['s-hadir','s-telat','s-izin','s-sakit','s-alfa'];

function onStatusChange(sel) {
    S_CLS.forEach(c => sel.classList.remove(c));
    if (sel.value) sel.classList.add('s-' + sel.value);
}

// Init colors on load
document.querySelectorAll('.s-sel').forEach(onStatusChange);

/* ── Bulk apply ── */
function applyBulk() {
    const val = document.getElementById('bulkStatusSel').value;
    if (!val) {
        Swal.fire({icon:'info',title:'Pilih Status',text:'Pilih status yang ingin diterapkan ke semua guru.',confirmButtonColor:'#1f63db',toast:true,position:'top-end',timer:2000,showConfirmButton:false});
        return;
    }
    document.querySelectorAll('.s-sel').forEach(sel => {
        sel.value = val;
        onStatusChange(sel);
    });
}

/* ── Konfirmasi simpan ── */
function konfirmasiSimpan() {
    Swal.fire({
        title: 'Simpan Absensi?',
        html: `Absensi untuk <strong>{{ $guruList->count() }} guru</strong><br>tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM Y') }}</strong><br>akan disimpan.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1f63db',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Periksa Lagi',
    }).then(r => { if (r.isConfirmed) document.getElementById('formMassal').submit(); });
}

/* ── Flash ── */
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if($errors->any())
Swal.fire({icon:'warning',title:'Ada Kesalahan',html:`{!! implode('<br>', $errors->all()) !!}`,confirmButtonColor:'#1f63db'});
@endif
</script>
</x-app-layout>