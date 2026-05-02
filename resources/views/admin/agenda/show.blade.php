<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;--danger:#dc2626;
}
.page{padding:28px 28px 48px;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
.breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px;}
.breadcrumb a{color:var(--brand-600);text-decoration:none;font-weight:600;}
.breadcrumb a:hover{text-decoration:underline;}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-primary{background:var(--brand-600);color:#fff;}
.btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
.btn-secondary:hover{background:var(--surface3);filter:none;}
.btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
.btn-edit:hover{background:var(--brand-100);filter:none;}
.btn-danger-soft{background:#fff0f0;color:var(--danger);border:1px solid #fecaca;}
.btn-danger-soft:hover{background:#fee2e2;filter:none;}

.detail-grid{display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;}
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
.card:last-child{margin-bottom:0;}
.card-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;background:var(--surface2);}
.card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);}
.card-body{padding:20px;}

/* Color bar */
.agenda-color-bar{height:5px;width:100%;}

/* Agenda title block */
.agenda-header{padding:20px 24px;}
.agenda-big-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:10px;}
.agenda-badges{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}

.badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
.badge-dot{width:5px;height:5px;border-radius:50%;}
.badge-published{background:#dcfce7;color:#15803d;}
.badge-published .badge-dot{background:#15803d;}
.badge-draft{background:#f1f5f9;color:#64748b;}
.badge-draft .badge-dot{background:#64748b;}
.badge-tipe{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}

/* Info grid */
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.info-item{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px;}
.info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px;}
.info-value{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);}
.info-value.large{font-size:18px;}

/* Deskripsi */
.deskripsi-text{font-family:'DM Sans',sans-serif;font-size:14px;line-height:1.8;color:var(--text2);white-space:pre-wrap;}

/* Meta sidebar */
.meta-list{display:flex;flex-direction:column;gap:0;}
.meta-item{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;padding:11px 0;border-bottom:1px solid var(--surface3);font-size:12.5px;}
.meta-item:last-child{border-bottom:none;padding-bottom:0;}
.meta-key{color:var(--text3);font-weight:600;white-space:nowrap;flex-shrink:0;}
.meta-val{color:var(--text2);font-weight:700;text-align:right;}

/* Color swatch */
.color-swatch{display:inline-flex;align-items:center;gap:6px;}
.color-swatch-dot{width:16px;height:16px;border-radius:4px;border:1px solid rgba(0,0,0,.08);}

.empty-desc{color:var(--text3);font-style:italic;font-size:13.5px;}

@media(max-width:900px){.detail-grid{grid-template-columns:1fr;}.info-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:640px){.page{padding:16px;}.info-grid{grid-template-columns:1fr;}.agenda-big-title{font-size:18px;}}
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.agenda.index') }}">Agenda Sekolah</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>{{ Str::limit($agenda->judul, 40) }}</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Agenda</h1>
            <p class="page-sub">Informasi lengkap kegiatan sekolah</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <form action="{{ route('admin.agenda.toggle', $agenda) }}" method="POST" style="margin:0">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-secondary">
                    @if($agenda->is_published)
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        Sembunyikan
                    @else
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Publikasikan
                    @endif
                </button>
            </form>
            <a href="{{ route('admin.agenda.edit', $agenda) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="detail-grid">
        {{-- Main --}}
        <div>
            {{-- Agenda Title Card --}}
            <div class="card">
                <div class="agenda-color-bar" style="background:{{ $agenda->warna ?? '#94a3b8' }}"></div>
                <div class="agenda-header">
                    <h2 class="agenda-big-title">{{ $agenda->judul }}</h2>
                    <div class="agenda-badges">
                        <span class="badge {{ $agenda->is_published ? 'badge-published' : 'badge-draft' }}">
                            <span class="badge-dot"></span>
                            {{ $agenda->is_published ? 'Published' : 'Draft' }}
                        </span>
                        @if($agenda->tipe)
                            <span class="badge badge-tipe">{{ ucfirst($agenda->tipe) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Waktu & Lokasi --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <p class="card-title">Waktu & Lokasi</p>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <p class="info-label">Tanggal Mulai</p>
                            <p class="info-value">{{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div class="info-item">
                            <p class="info-label">Tanggal Selesai</p>
                            <p class="info-value">
                                {{ $agenda->tanggal_selesai
                                    ? \Carbon\Carbon::parse($agenda->tanggal_selesai)->translatedFormat('l, d F Y')
                                    : '—' }}
                            </p>
                        </div>
                        <div class="info-item">
                            <p class="info-label">Jam Mulai</p>
                            <p class="info-value">
                                {{ $agenda->jam_mulai ? \Carbon\Carbon::parse($agenda->jam_mulai)->format('H:i') . ' WIB' : '—' }}
                            </p>
                        </div>
                        <div class="info-item">
                            <p class="info-label">Jam Selesai</p>
                            <p class="info-value">
                                {{ $agenda->jam_selesai ? \Carbon\Carbon::parse($agenda->jam_selesai)->format('H:i') . ' WIB' : '—' }}
                            </p>
                        </div>
                        @if($agenda->lokasi)
                        <div class="info-item" style="grid-column:1/-1">
                            <p class="info-label">Lokasi</p>
                            <p class="info-value" style="display:flex;align-items:center;gap:6px;">
                                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                                {{ $agenda->lokasi }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <p class="card-title">Deskripsi</p>
                </div>
                <div class="card-body">
                    @if($agenda->deskripsi)
                        <p class="deskripsi-text">{{ $agenda->deskripsi }}</p>
                    @else
                        <p class="empty-desc">Tidak ada deskripsi untuk agenda ini.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            {{-- Info Meta --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p class="card-title">Informasi</p>
                </div>
                <div class="card-body">
                    <div class="meta-list">
                        <div class="meta-item">
                            <span class="meta-key">ID</span>
                            <span class="meta-val">#{{ $agenda->id }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-key">Status</span>
                            <span class="meta-val">
                                <span class="badge {{ $agenda->is_published ? 'badge-published' : 'badge-draft' }}" style="padding:2px 8px">
                                    <span class="badge-dot"></span>
                                    {{ $agenda->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-key">Tipe</span>
                            <span class="meta-val">{{ $agenda->tipe ? ucfirst($agenda->tipe) : '—' }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-key">Warna</span>
                            <span class="meta-val">
                                <span class="color-swatch">
                                    <span class="color-swatch-dot" style="background:{{ $agenda->warna ?? '#94a3b8' }}"></span>
                                    {{ $agenda->warna ?? '—' }}
                                </span>
                            </span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-key">Dibuat</span>
                            <span class="meta-val">{{ $agenda->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-key">Diperbarui</span>
                            <span class="meta-val">{{ $agenda->updated_at->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Durasi --}}
            @php
                $mulai    = \Carbon\Carbon::parse($agenda->tanggal_mulai);
                $selesai  = $agenda->tanggal_selesai ? \Carbon\Carbon::parse($agenda->tanggal_selesai) : $mulai;
                $durasi   = $mulai->diffInDays($selesai) + 1;
                $sudahLewat = $selesai->isPast();
                $sedangBerlangsung = $mulai->lte(now()) && $selesai->gte(now());
            @endphp
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <p class="card-title">Durasi & Status</p>
                </div>
                <div class="card-body">
                    <div style="text-align:center;padding:8px 0 16px;">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:36px;font-weight:800;color:var(--brand-600);line-height:1;">
                            {{ $durasi }}
                        </p>
                        <p style="font-size:13px;color:var(--text3);font-weight:600;margin-top:4px;">
                            {{ $durasi == 1 ? 'hari' : 'hari' }}
                        </p>
                    </div>
                    <div style="text-align:center;">
                        @if($sudahLewat)
                            <span class="badge" style="background:#f1f5f9;color:#64748b">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Sudah Selesai
                            </span>
                        @elseif($sedangBerlangsung)
                            <span class="badge" style="background:#dcfce7;color:#15803d">
                                <span class="badge-dot" style="background:#15803d"></span>
                                Sedang Berlangsung
                            </span>
                        @else
                            <span class="badge" style="background:#dbeafe;color:#1d4ed8">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Akan Datang — {{ $mulai->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card">
                <div class="card-body" style="display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('admin.agenda.edit', $agenda) }}" class="btn btn-edit" style="width:100%;justify-content:center;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Agenda
                    </a>
                    <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST" id="deleteForm">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger-soft" style="width:100%;justify-content:center;" onclick="confirmDelete()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            Hapus Agenda
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
@endif

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Agenda?',
        text: 'Agenda "{{ addslashes($agenda->judul) }}" akan dihapus permanen.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
}
</script>
</x-app-layout>