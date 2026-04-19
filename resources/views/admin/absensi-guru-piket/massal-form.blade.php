<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3)}
    .btn-primary{background:var(--brand);color:#fff}.btn-primary:hover{filter:brightness(.93)}.btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-cancel:hover{background:var(--surface3)}
    .info-bar{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius);padding:12px 18px;margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--brand-700)}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    tbody tr{border-bottom:1px solid #f1f5f9}
    tbody tr:last-child{border-bottom:none}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    .guru-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .guru-nip{font-size:11.5px;color:var(--text3)}
    select.status-sel{height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:140px}
    select.status-sel:focus{border-color:var(--brand-h);background:#fff}
    input.jam-input{height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;width:110px}
    input.jam-input:focus{border-color:var(--brand-h);background:#fff}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 20px;background:var(--surface2);border-top:1px solid var(--border)}
    .toolbar{display:flex;gap:8px;align-items:center;flex-wrap:wrap;padding:12px 20px;background:var(--surface2);border-bottom:1px solid var(--border)}
    .toolbar label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .toolbar select{height:34px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface);outline:none}
    .toolbar-btn{height:34px;padding:0 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;background:var(--surface);color:var(--text2)}
    .toolbar-btn:hover{background:var(--surface2)}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}
    @keyframes spin{to{transform:rotate(360deg)}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span class="sep">›</span>
        <a href="{{ route('admin.absensi-guru-piket.dashboard') }}">Piket Guru</a><span class="sep">›</span>
        <span class="current">Absen Massal</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Absen Massal Guru</h1>
            <p class="page-sub">{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }} — Guru yang belum diabsen hari ini</p>
        </div>
        <a href="{{ route('admin.absensi-guru-piket.dashboard') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if($guruBelumAbsen->isEmpty())
    <div class="table-card">
        <div class="empty-state">
            <p class="empty-title">Semua Guru Sudah Diabsen</p>
            <p class="empty-sub">Tidak ada guru yang belum dicatat absensinya hari ini</p>
        </div>
    </div>
    @else
    <div class="info-bar">
        📋 {{ $guruBelumAbsen->count() }} guru belum diabsen — isi status dan simpan sekaligus
    </div>

    <form action="{{ route('admin.absensi-guru-piket.massal.store') }}" method="POST" id="massalForm">
        @csrf
        <div class="table-card">
            <div class="toolbar">
                <label>Isi Semua Status:</label>
                <select id="globalStatus">
                    <option value="">— Pilih —</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="button" class="toolbar-btn" onclick="applyAllStatus()">Terapkan ke Semua</button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:48px">#</th>
                            <th>Nama Guru</th>
                            <th>Status <span style="color:#dc2626">*</span></th>
                            <th>Jam Masuk</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guruBelumAbsen as $i => $g)
                        <tr>
                            <td style="color:var(--text3);font-weight:700;font-family:'Plus Jakarta Sans',sans-serif">{{ $i+1 }}</td>
                            <td>
                                <input type="hidden" name="absensi[{{ $i }}][guru_id]" value="{{ $g->id }}">
                                <p class="guru-name">{{ $g->nama_lengkap }}</p>
                                <p class="guru-nip">{{ $g->nip ?? '—' }}</p>
                            </td>
                            <td>
                                <select name="absensi[{{ $i }}][status]" class="status-sel status-select" required>
                                    <option value="">— Pilih —</option>
                                    @foreach($statusList as $s)
                                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="time" name="absensi[{{ $i }}][jam_masuk]" value="{{ now()->format('H:i') }}" class="jam-input">
                            </td>
                            <td>
                                <input type="text" name="absensi[{{ $i }}][keterangan]" placeholder="Opsional..." style="height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;width:100%;max-width:200px;box-sizing:border-box">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-footer">
                <a href="{{ route('admin.absensi-guru-piket.dashboard') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Semua ({{ $guruBelumAbsen->count() }} guru)
                </button>
            </div>
        </div>
    </form>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});@endif
    @if(session('error'))Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});@endif

    function applyAllStatus() {
        const val = document.getElementById('globalStatus').value;
        if (!val) return;
        document.querySelectorAll('.status-select').forEach(s => s.value = val);
    }

    document.getElementById('massalForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>