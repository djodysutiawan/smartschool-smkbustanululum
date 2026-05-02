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
.page{padding:28px 28px 40px;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-primary{background:var(--brand-600);color:#fff;}
.btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
.btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
.btn-edit:hover{background:var(--brand-100);filter:none;}
.btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
.btn-del:hover{background:#fee2e2;filter:none;}
.btn-on{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
.btn-on:hover{background:#dcfce7;filter:none;}
.btn-off{background:#fefce8;color:#a16207;border:1px solid #fde68a;}
.btn-off:hover{background:#fef9c3;filter:none;}
.stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
.stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-icon.blue{background:var(--brand-50);}
.stat-icon.green{background:#f0fdf4;}
.stat-icon.yellow{background:#fefce8;}
.stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
.stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
.table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
.table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);}
.table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
.table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
.reorder-hint{font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px;}
.table-wrap{overflow-x:auto;}
table{width:100%;border-collapse:collapse;font-size:13.5px;}
thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
thead th.center{text-align:center;}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#fafbff;}
td{padding:10px 14px;color:var(--text);vertical-align:middle;}
td.center{text-align:center;}
td.muted{color:var(--text3);}
.drag-handle{cursor:grab;color:var(--text3);padding:4px;border-radius:4px;transition:color .15s;display:inline-flex;align-items:center;}
.drag-handle:hover{color:var(--brand-600);}
.drag-handle:active{cursor:grabbing;}
.urutan-badge{display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:6px;background:var(--surface2);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);}
.thumb-wrap{width:90px;height:54px;border-radius:7px;overflow:hidden;border:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.thumb-wrap img{width:100%;height:100%;object-fit:cover;}
.thumb-empty{font-size:20px;color:var(--text3);}
.slider-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);}
.slider-sub{font-size:12px;color:var(--text3);margin-top:2px;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
.badge-dot{width:5px;height:5px;border-radius:50%;}
.badge-published{background:#dcfce7;color:#15803d;}
.badge-published .badge-dot{background:#15803d;}
.badge-draft{background:#fef9c3;color:#a16207;}
.badge-draft .badge-dot{background:#a16207;}
.action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap;}
.empty-state{padding:60px 20px;text-align:center;}
.empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
.empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
.empty-sub{font-size:13px;color:var(--text3);}
.pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
.pag-info{font-size:12.5px;color:var(--text3);}
.pag-btns{display:flex;gap:4px;align-items:center;}
.pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
.pag-btn:hover{background:var(--surface2);border-color:var(--border2);}
.pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
.pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;}
@media(max-width:640px){.stats-strip{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Slider Beranda</h1>
            <p class="page-sub">Kelola gambar slider yang tampil di halaman utama website</p>
        </div>
        <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Slider
        </a>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Slider</p>
                <p class="stat-val">{{ $sliders->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Tayang</p>
                <p class="stat-val">{{ \App\Models\SliderBeranda::where('is_published',true)->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Draft</p>
                <p class="stat-val">{{ \App\Models\SliderBeranda::where('is_published',false)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Daftar Slider <span>— {{ $sliders->total() }} data</span></p>
            <p class="reorder-hint">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 9l4-4 4 4M5 15l4 4 4-4"/><path d="M9 5v14"/></svg>
                Drag baris untuk mengubah urutan
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px"></th>
                        <th style="width:44px" class="center">#</th>
                        <th style="width:100px">Foto</th>
                        <th>Judul / Subjudul</th>
                        <th>Tombol</th>
                        <th class="center" style="width:70px">Urutan</th>
                        <th class="center">Status</th>
                        <th class="center" style="width:230px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-tbody">
                    @forelse($sliders as $i => $slider)
                    <tr data-id="{{ $slider->id }}">
                        <td>
                            <span class="drag-handle" title="Drag untuk ubah urutan">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><circle cx="9" cy="5" r="1.2"/><circle cx="9" cy="12" r="1.2"/><circle cx="9" cy="19" r="1.2"/><circle cx="15" cy="5" r="1.2"/><circle cx="15" cy="12" r="1.2"/><circle cx="15" cy="19" r="1.2"/></svg>
                            </span>
                        </td>
                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">{{ $sliders->firstItem() + $i }}</span>
                        </td>
                        <td>
                            <div class="thumb-wrap">
                                @if($slider->foto_path)
                                    <img src="{{ asset('storage/'.$slider->foto_path) }}" alt="{{ $slider->foto_alt }}">
                                @elseif($slider->foto_url)
                                    <img src="{{ $slider->foto_url }}" alt="{{ $slider->foto_alt }}">
                                @else
                                    <span class="thumb-empty">🖼️</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p class="slider-title">{{ $slider->judul }}</p>
                            @if($slider->subjudul)
                                <p class="slider-sub">{{ $slider->subjudul }}</p>
                            @endif
                        </td>
                        <td>
                            @if($slider->tombol_label)
                                <span style="font-size:12.5px;font-weight:600;color:var(--text2);">{{ $slider->tombol_label }}</span>
                                @if($slider->tombol_url)
                                    <br><a href="{{ $slider->tombol_url }}" target="_blank" style="font-size:11px;color:var(--brand-600);">{{ Str::limit($slider->tombol_url,30) }}</a>
                                @endif
                            @else
                                <span style="color:var(--text3);font-size:13px;">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <span class="urutan-badge">{{ $slider->urutan }}</span>
                        </td>
                        <td class="center">
                            @if($slider->is_published)
                                <span class="badge badge-published"><span class="badge-dot"></span>Tayang</span>
                            @else
                                <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                            @endif
                        </td>
                        <td class="center">
                            {{-- Semua aksi dipisah: toggle & delete pakai form sendiri-sendiri,
                                 Edit pakai <a> murni — tidak ada form yang membungkus lebih dari 1 elemen --}}
                            <div class="action-group">

                                {{-- Toggle publish --}}
                                <form action="{{ route('admin.slider.toggle', $slider->id) }}" method="POST" style="display:contents">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $slider->is_published ? 'btn-off' : 'btn-on' }}">
                                        {{ $slider->is_published ? 'Non-aktif' : 'Aktifkan' }}
                                    </button>
                                </form>

                                {{-- Edit — murni <a>, tidak di dalam form apapun --}}
                                <a href="{{ route('admin.slider.edit', $slider->id) }}" class="btn btn-sm btn-edit">Edit</a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST" id="del-{{ $slider->id }}" style="display:contents">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete({{ $slider->id }}, '{{ addslashes($slider->judul) }}')">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                                </div>
                                <p class="empty-title">Belum ada slider</p>
                                <p class="empty-sub">Tambahkan slider pertama untuk ditampilkan di beranda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sliders->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $sliders->firstItem() }}–{{ $sliders->lastItem() }} dari {{ $sliders->total() }} slider</p>
            <div class="pag-btns">
                @if($sliders->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $sliders->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($sliders->getUrlRange(1,$sliders->lastPage()) as $page => $url)
                    @if($page == $sliders->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $sliders->lastPage() || abs($page - $sliders->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $sliders->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($sliders->hasMorePages())
                    <a href="{{ $sliders->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif

function confirmDelete(id, judul) {
    Swal.fire({
        title: 'Hapus Slider?',
        text: `Slider "${judul}" akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => {
        if (r.isConfirmed) document.getElementById('del-' + id).submit();
    });
}

Sortable.create(document.getElementById('sortable-tbody'), {
    handle: '.drag-handle', animation: 150,
    onEnd() {
        const ids = [...document.querySelectorAll('#sortable-tbody tr[data-id]')].map(tr => tr.dataset.id);
        fetch('{{ route('admin.slider.reorder') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ ids })
        }).then(r => r.json()).then(d => {
            if (d.success) Swal.fire({icon:'success',title:'Urutan disimpan!',timer:1500,showConfirmButton:false,toast:true,position:'top-end'});
        });
    }
});
</script>
</x-app-layout>