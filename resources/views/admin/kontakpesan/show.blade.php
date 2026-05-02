<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root{
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;--danger:#dc2626;
}
.page{padding:28px 28px 40px;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
.header-actions{display:flex;gap:8px;flex-wrap:wrap;}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
.btn:hover{filter:brightness(.93);}
.btn-ghost{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
.btn-ghost:hover{background:var(--surface3);filter:none;}
.btn-primary{background:var(--brand-600);color:#fff;}
.btn-success{background:#15803d;color:#fff;}
.btn-warning{background:#fefce8;color:#a16207;border:1px solid #fde68a;}
.btn-warning:hover{background:#fef9c3;filter:none;}
.btn-danger{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
.btn-danger:hover{background:#fee2e2;filter:none;}

.layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;}
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
.card+.card{margin-top:16px;}
.card-header{padding:14px 20px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;}
.card-body{padding:20px;}

.msg-meta{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px;}
.meta-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;background:var(--surface2);border:1px solid var(--border);color:var(--text2);}
.meta-chip svg{color:var(--text3);}

.msg-subject{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text);margin-bottom:16px;line-height:1.3;}
.msg-body{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.8;white-space:pre-wrap;word-break:break-word;padding:20px;background:var(--surface2);border-radius:var(--radius-sm);border:1px solid var(--border);}

.badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
.badge-dot{width:6px;height:6px;border-radius:50%;}
.badge-baru{background:#fef3c7;color:#d97706;}.badge-baru .badge-dot{background:#d97706;}
.badge-dibaca{background:#dcfce7;color:#15803d;}.badge-dibaca .badge-dot{background:#15803d;}
.badge-dibalas{background:var(--brand-50);color:var(--brand-700);}.badge-dibalas .badge-dot{background:var(--brand-600);}
.badge-arsip{background:var(--surface3);color:var(--text3);}.badge-arsip .badge-dot{background:var(--text3);}

.meta-row{display:flex;justify-content:space-between;align-items:flex-start;padding:9px 0;border-bottom:1px solid var(--border);font-size:12.5px;gap:8px;}
.meta-row:last-child{border-bottom:none;}
.meta-key{color:var(--text3);font-weight:600;flex-shrink:0;}
.meta-val{color:var(--text2);font-weight:600;text-align:right;word-break:break-all;}

.action-panel{display:flex;flex-direction:column;gap:8px;}

.form-label{display:block;margin-bottom:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
.form-control{width:100%;padding:9px 12px;box-sizing:border-box;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;resize:vertical;min-height:80px;}
.form-control:focus{border-color:var(--brand-500);background:#fff;}

.sender-avatar{width:48px;height:48px;border-radius:12px;background:var(--brand-50);border:1px solid var(--brand-100);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--brand-600);flex-shrink:0;}
.catatan-box{background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius-sm);padding:12px 14px;font-size:13px;color:#92400e;line-height:1.6;}

@media(max-width:900px){.layout{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pesan</h1>
            <p class="page-sub">Pesan dari <strong style="color:var(--text2)">{{ $kontakPesan->nama_pengirim }}</strong></p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.kontak-pesan.index') }}" class="btn btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="layout">

        {{-- Kiri: Isi Pesan --}}
        <div>
            <div class="card">
                <div class="card-body">

                    {{-- Meta chips --}}
                    <div class="msg-meta">
                        <span class="meta-chip">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $kontakPesan->nama_pengirim }}
                        </span>
                        <span class="meta-chip">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            {{ $kontakPesan->email_pengirim }}
                        </span>
                        @if($kontakPesan->no_telepon)
                        <span class="meta-chip">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.82a16 16 0 0 0 6.07 6.07l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16l.19.92z"/></svg>
                            {{ $kontakPesan->no_telepon }}
                        </span>
                        @endif
                        <span class="meta-chip">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $kontakPesan->created_at->format('d M Y, H:i') }}
                        </span>
                        @php
                            $badgeMap = ['baru'=>'badge-baru','dibaca'=>'badge-dibaca','dibalas'=>'badge-dibalas','arsip'=>'badge-arsip'];
                            $labelMap = ['baru'=>'Baru','dibaca'=>'Dibaca','dibalas'=>'Dibalas','arsip'=>'Arsip'];
                        @endphp
                        <span class="badge {{ $badgeMap[$kontakPesan->status] ?? 'badge-dibaca' }}">
                            <span class="badge-dot"></span>{{ $labelMap[$kontakPesan->status] ?? $kontakPesan->status }}
                        </span>
                    </div>

                    {{-- Subjek --}}
                    <h2 class="msg-subject">{{ $kontakPesan->subjek ?? '(Tanpa Subjek)' }}</h2>

                    {{-- Isi pesan --}}
                    <div class="msg-body">{{ $kontakPesan->pesan }}</div>

                    {{-- Catatan admin jika ada --}}
                    @if($kontakPesan->catatan_admin)
                    <div style="margin-top:20px">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px">Catatan Admin</p>
                        <div class="catatan-box">{{ $kontakPesan->catatan_admin }}</div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Form tandai dibalas --}}
            @if($kontakPesan->status !== 'dibalas')
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                    Tandai Sudah Dibalas
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kontak-pesan.tandai-dibalas', $kontakPesan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div style="margin-bottom:14px">
                            <label class="form-label">Catatan Admin <span style="font-weight:500;color:var(--text3);font-size:11px">(opsional)</span></label>
                            <textarea name="catatan_admin" class="form-control" rows="3"
                                placeholder="Tuliskan catatan balasan atau tindakan yang sudah dilakukan...">{{ old('catatan_admin', $kontakPesan->catatan_admin) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success" style="width:100%;justify-content:center">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Tandai Sudah Dibalas
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        {{-- Kanan: Panel Aksi + Info --}}
        <div>

            {{-- Pengirim --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Pengirim
                </div>
                <div class="card-body">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                        <div class="sender-avatar">{{ strtoupper(substr($kontakPesan->nama_pengirim, 0, 1)) }}</div>
                        <div>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;color:var(--text)">{{ $kontakPesan->nama_pengirim }}</p>
                            <p style="font-size:12.5px;color:var(--text3);margin-top:2px">{{ $kontakPesan->email_pengirim }}</p>
                        </div>
                    </div>
                    <a href="mailto:{{ $kontakPesan->email_pengirim }}" class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Balas via Email
                    </a>
                    @if($kontakPesan->no_telepon)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$kontakPesan->no_telepon) }}" target="_blank"
                       class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:8px">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.82a16 16 0 0 0 6.07 6.07l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16l.19.92z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                </div>
            </div>

            {{-- Aksi --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Aksi
                </div>
                <div class="card-body">
                    <div class="action-panel">

                        @if($kontakPesan->status === 'baru')
                        <form action="{{ route('admin.kontak-pesan.mark-as-read', $kontakPesan->id) }}" method="POST" style="display:contents">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-ghost" style="width:100%;justify-content:center">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Tandai Dibaca
                            </button>
                        </form>
                        @endif

                        @if($kontakPesan->status !== 'arsip')
                        <form action="{{ route('admin.kontak-pesan.arsip', $kontakPesan->id) }}" method="POST" style="display:contents">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-warning" style="width:100%;justify-content:center">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 1 0 0-4h14a2 2 0 1 0 0 4M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8"/></svg>
                                Arsipkan Pesan
                            </button>
                        </form>
                        @endif

                        <button type="button" class="btn btn-danger" style="width:100%;justify-content:center"
                            onclick="confirmDelete()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                            Hapus Pesan
                        </button>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Informasi
                </div>
                <div class="card-body">
                    <div class="meta-row">
                        <span class="meta-key">ID</span>
                        <span class="meta-val">#{{ $kontakPesan->id }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Status</span>
                        <span class="badge {{ $badgeMap[$kontakPesan->status] ?? 'badge-dibaca' }}">
                            <span class="badge-dot"></span>{{ $labelMap[$kontakPesan->status] ?? $kontakPesan->status }}
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Dikirim</span>
                        <span class="meta-val">{{ $kontakPesan->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($kontakPesan->dibaca_at)
                    <div class="meta-row">
                        <span class="meta-key">Dibaca</span>
                        <span class="meta-val">{{ \Carbon\Carbon::parse($kontakPesan->dibaca_at)->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                    @if($kontakPesan->ip_address)
                    <div class="meta-row">
                        <span class="meta-key">IP Address</span>
                        <span class="meta-val">{{ $kontakPesan->ip_address }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Form hapus di luar layout --}}
<form method="POST" action="{{ route('admin.kontak-pesan.destroy', $kontakPesan->id) }}"
      id="deleteForm" style="display:none">
    @csrf @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Pesan?',
        text: 'Pesan dari "{{ addslashes($kontakPesan->nama_pengirim) }}" akan dihapus permanen.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
}
</script>
</x-app-layout>