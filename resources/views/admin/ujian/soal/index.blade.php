<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-soft:#eff6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#16a34a;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --yellow:#d97706;--yellow-bg:#fef3c7;--yellow-border:#fde68a;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --purple:#7c3aed;--purple-bg:#ede9fe;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 60px;max-width:1300px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;font-family:'Plus Jakarta Sans',sans-serif;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-primary:hover{background:var(--brand-h);}
    .btn-export{background:var(--surface);color:var(--text2);border:1px solid var(--border);font-size:12.5px;padding:8px 14px;}
    .btn-export:hover{background:var(--surface2);}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;}
    .alert-success{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);}
    .alert-error{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    /* Stats strip */
    .stats-strip{display:flex;align-items:stretch;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;}
    .strip-item{flex:1;padding:16px 20px;border-right:1px solid var(--border);text-align:center;}
    .strip-item:last-child{border-right:none;}
    .strip-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);}
    .strip-label{font-size:11.5px;color:var(--text3);font-weight:600;margin-top:2px;}
    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-toolbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);}
    .toolbar-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);}
    table{width:100%;border-collapse:collapse;}
    thead th{padding:11px 16px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;background:var(--surface2);border-bottom:1px solid var(--border);}
    tbody tr{border-bottom:1px solid var(--border);transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:var(--surface2);}
    tbody td{padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);vertical-align:middle;}
    .nomor-cell{width:48px;text-align:center;}
    .nomor-badge{width:32px;height:32px;border-radius:9px;background:var(--brand-soft);color:var(--brand);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto;}
    .soal-preview{max-width:420px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.5;color:var(--text);}
    .badge{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:99px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
    .badge-pg{background:var(--brand-soft);color:var(--brand);}
    .badge-essay{background:var(--purple-bg);color:var(--purple);}
    .badge-bs{background:var(--green-bg);color:var(--green);}
    .bobot-cell{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--brand);}
    .action-cell{display:flex;align-items:center;gap:4px;}
    .icon-btn{width:30px;height:30px;border-radius:var(--radius-xs);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .12s;text-decoration:none;border:none;background:transparent;color:var(--text3);}
    .icon-btn:hover{background:var(--surface3);color:var(--text);}
    .icon-btn.edit:hover{background:var(--yellow-bg);color:var(--yellow);}
    .icon-btn.del:hover{background:var(--red-bg);color:var(--red);}
    .empty-state{padding:56px 24px;text-align:center;}
    .empty-icon{width:60px;height:60px;border-radius:16px;background:var(--surface3);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--text);margin-bottom:6px;}
    .empty-sub{font-size:13px;color:var(--text3);margin-bottom:20px;}
    /* Import modal */
    .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);display:flex;align-items:center;justify-content:center;z-index:999;opacity:0;pointer-events:none;transition:opacity .2s;}
    .modal-overlay.open{opacity:1;pointer-events:all;}
    .modal{background:var(--surface);border-radius:var(--radius);padding:28px;width:440px;max-width:90vw;transform:scale(.96);transition:transform .2s;}
    .modal-overlay.open .modal{transform:scale(1);}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--text);margin-bottom:4px;}
    .modal-sub{font-size:12.5px;color:var(--text3);margin-bottom:20px;}
    .field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
    .field label{font-size:12.5px;font-weight:700;color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;}
    .field input[type=file]{padding:8px;border:1px dashed var(--border2);border-radius:var(--radius-sm);font-size:13px;background:var(--surface2);}
    .modal-footer{display:flex;justify-content:flex-end;gap:10px;margin-top:8px;}
    @media(max-width:768px){.page{padding:16px;}.stats-strip{flex-wrap:wrap;}.strip-item{flex:0 0 50%;}.table-card{overflow-x:auto;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.index') }}">Data Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 30) }}</a>
        <span class="sep">›</span>
        <span class="current">Kelola Soal</span>
    </nav>

    @if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Soal — {{ Str::limit($ujian->judul, 45) }}</h1>
            <p class="page-sub">{{ $ujian->kelas->nama_kelas ?? '-' }} · {{ strtoupper(str_replace('_',' ',$ujian->jenis)) }} · {{ $ujian->durasi_menit }} menit</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ujian.show', $ujian) }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            @if($stats['total_soal'] > 0)
            <a href="{{ route('admin.ujian.soal.export.pdf', $ujian) }}" class="btn btn-export">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.ujian.soal.export.excel', $ujian) }}" class="btn btn-export">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Excel
            </a>
            @endif
            <button onclick="document.getElementById('modalImport').classList.add('open')" class="btn btn-export">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10" style="transform:rotate(180deg);transform-origin:center"/></svg>
                Import
            </button>
            <a href="{{ route('admin.ujian.soal.create', $ujian) }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Soal
            </a>
        </div>
    </div>

    {{-- Stats Strip --}}
    <div class="stats-strip">
        <div class="strip-item">
            <div class="strip-val">{{ $stats['total_soal'] }}</div>
            <div class="strip-label">Total Soal</div>
        </div>
        <div class="strip-item">
            <div class="strip-val">{{ $stats['total_bobot'] }}</div>
            <div class="strip-label">Total Bobot</div>
        </div>
        <div class="strip-item">
            <div class="strip-val" style="color:var(--brand)">{{ $stats['pg'] }}</div>
            <div class="strip-label">Pilihan Ganda</div>
        </div>
        <div class="strip-item">
            <div class="strip-val" style="color:var(--purple)">{{ $stats['essay'] }}</div>
            <div class="strip-label">Essay</div>
        </div>
        <div class="strip-item">
            <div class="strip-val" style="color:var(--green)">{{ $stats['benar_salah'] }}</div>
            <div class="strip-label">Benar/Salah</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-toolbar">
            <span class="toolbar-title">{{ $stats['total_soal'] }} Soal Tersedia</span>
            @if($stats['total_soal'] > 1)
            <span style="font-size:12px;color:var(--text3);">Drag baris untuk ubah urutan</span>
            @endif
        </div>

        @if($soal->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="26" height="26" fill="none" stroke="var(--text3)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
            </div>
            <div class="empty-title">Belum ada soal</div>
            <div class="empty-sub">Mulai tambahkan soal untuk ujian ini.</div>
            <a href="{{ route('admin.ujian.soal.create', $ujian) }}" class="btn btn-primary" style="margin:0 auto;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Soal Pertama
            </a>
        </div>
        @else
        <table id="soalTable">
            <thead>
                <tr>
                    <th class="nomor-cell">No.</th>
                    <th>Pertanyaan</th>
                    <th>Jenis</th>
                    <th>Pilihan</th>
                    <th>Bobot</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="soalBody">
                @foreach($soal as $s)
                <tr data-id="{{ $s->id }}" style="cursor:grab;">
                    <td class="nomor-cell">
                        <div class="nomor-badge">{{ $s->nomor_soal }}</div>
                    </td>
                    <td>
                        <div class="soal-preview">{!! Str::limit(strip_tags($s->pertanyaan), 100) !!}</div>
                    </td>
                    <td>
                        @if($s->jenis_soal === 'pilihan_ganda')
                            <span class="badge badge-pg">Pilihan Ganda</span>
                        @elseif($s->jenis_soal === 'essay')
                            <span class="badge badge-essay">Essay</span>
                        @else
                            <span class="badge badge-bs">Benar/Salah</span>
                        @endif
                    </td>
                    <td style="color:var(--text3);font-size:13px;">
                        {{ $s->jenis_soal !== 'essay' ? $s->pilihan->count().' opsi' : '—' }}
                    </td>
                    <td><span class="bobot-cell">{{ $s->bobot }}</span></td>
                    <td>
                        @if($s->gambar_soal)
                            <svg width="14" height="14" fill="none" stroke="var(--green)" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        @else
                            <span style="color:var(--text3)">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-cell">
                            <a href="{{ route('admin.ujian.soal.edit', [$ujian, $s]) }}" class="icon-btn edit" title="Edit">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('admin.ujian.soal.destroy', [$ujian, $s]) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn del" title="Hapus"
                                    onclick="return confirm('Hapus soal no.{{ $s->nomor_soal }}? Semua jawaban siswa terkait akan ikut terhapus.')">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- Import Modal --}}
<div class="modal-overlay" id="modalImport">
    <div class="modal">
        <div class="modal-title">Import Soal dari Excel</div>
        <div class="modal-sub">Gunakan template yang tersedia untuk format yang benar.</div>
        <form action="{{ route('admin.ujian.soal.import', $ujian) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label>File Excel (.xlsx / .xls)</label>
                <input type="file" name="file" accept=".xlsx,.xls" required>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.ujian.soal.import.template', $ujian) }}" class="btn btn-export">
                    Download Template
                </a>
                <button type="button" onclick="document.getElementById('modalImport').classList.remove('open')" class="btn btn-back">Batal</button>
                <button type="submit" class="btn btn-primary">Import Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
// Drag-drop reorder
const tbody = document.getElementById('soalBody');
if (tbody) {
    new Sortable(tbody, {
        animation: 150,
        ghostClass: 'bg-blue-50',
        onEnd: function() {
            const urutan = [...tbody.querySelectorAll('tr')].map(r => r.dataset.id);
            fetch('{{ route("admin.ujian.soal.reorder", $ujian) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ urutan })
            }).then(r => r.json()).then(() => {
                // Update nomor tampilan
                tbody.querySelectorAll('tr').forEach((r, i) => {
                    r.querySelector('.nomor-badge').textContent = i + 1;
                });
            });
        }
    });
}
// Close modal on overlay click
document.getElementById('modalImport').addEventListener('click', function(e){
    if(e.target === this) this.classList.remove('open');
});
</script>
</x-app-layout>