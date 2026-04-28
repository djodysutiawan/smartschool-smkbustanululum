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

    .page{padding:28px 28px 40px;max-width:2000px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center}

    /* Buttons */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .alert-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
    .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}

    /* Card */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    /* Summary strip */
    .summary-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:0}
    .summary-item{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;display:flex;align-items:center;gap:10px}
    .summary-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .summary-icon.blue{background:#eff6ff}
    .summary-icon.red{background:#fee2e2}
    .summary-icon.yellow{background:#fefce8}
    .summary-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .summary-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}

    /* Log strip */
    .log-strip{display:flex;align-items:center;gap:16px;padding:12px 16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:16px;flex-wrap:wrap}
    .log-item{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .log-item span{font-weight:400;color:var(--text3)}
    .log-sep{width:1px;height:20px;background:var(--border);flex-shrink:0}

    /* Form */
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .form-grid .col-span-2{grid-column:span 2}
    .form-group{display:flex;flex-direction:column;gap:5px}
    .form-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .form-label .req{color:#dc2626;margin-left:2px}
    .form-control{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;width:100%;box-sizing:border-box}
    .form-control:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.12);background:#fff}
    .form-control.is-invalid{border-color:#dc2626}
    input.form-control{height:40px;padding:0 12px}
    textarea.form-control{resize:vertical;min-height:90px}
    .form-hint{font-size:11.5px;color:var(--text3);margin-top:2px}
    .form-error{font-size:11.5px;color:#dc2626;margin-top:2px}

    /* Ringkasan otomatis */
    .ringkasan-box{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 14px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);line-height:1.6;margin-bottom:4px}
    .ringkasan-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--brand-700);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px;display:flex;align-items:center;gap:5px}

    /* Pelanggaran mini list */
    .mini-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:6px}
    .mini-item{display:flex;align-items:center;gap:10px;padding:8px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);font-size:13px}
    .mini-item-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);flex:1}
    .mini-item-sub{font-size:12px;color:var(--text3)}
    .poin-pill{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:20px;padding:0 7px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800}
    .poin-low{background:#dcfce7;color:#15803d}
    .poin-mid{background:#fef9c3;color:#a16207}
    .poin-high{background:#fee2e2;color:#dc2626}

    /* Form footer */
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:8px;padding:16px 20px;border-top:1px solid var(--border);background:var(--surface2)}

    @media(max-width:640px){
        .page{padding:16px}
        .form-grid{grid-template-columns:1fr}
        .form-grid .col-span-2{grid-column:span 1}
        .summary-strip{grid-template-columns:1fr}
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Laporan Harian</h1>
            <p class="page-sub">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.laporan.riwayat') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Riwayat Laporan
            </a>
        </div>
    </div>

    {{-- Banner laporan sudah ada --}}
    @if($laporanHariIni)
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <div>
            Laporan hari ini <strong>sudah dibuat</strong> pada pukul {{ \Carbon\Carbon::parse($laporanHariIni->created_at)->format('H:i') }}.
            Anda dapat memperbarui isinya di bawah.
        </div>
    </div>
    @endif

    {{-- Ringkasan aktivitas hari ini --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span class="card-title">Ringkasan Aktivitas Hari Ini</span>
        </div>
        <div class="card-body">

            {{-- Log piket --}}
            @if($logHariIni)
            <div class="log-strip">
                <div class="log-item">
                    <svg width="13" height="13" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Masuk: <span>{{ $logHariIni->masuk_pada ? \Carbon\Carbon::parse($logHariIni->masuk_pada)->format('H:i') : '—' }}</span>
                </div>
                <div class="log-sep"></div>
                <div class="log-item">
                    <svg width="13" height="13" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Keluar: <span>{{ $logHariIni->keluar_pada ? \Carbon\Carbon::parse($logHariIni->keluar_pada)->format('H:i') : 'Belum checkout' }}</span>
                </div>
                @if($logHariIni->lokasi)
                <div class="log-sep"></div>
                <div class="log-item">
                    <svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Lokasi: <span>{{ $logHariIni->lokasi }}</span>
                </div>
                @endif
            </div>
            @else
            <div class="alert alert-warning" style="margin-bottom:16px">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Log piket hari ini belum tercatat. Pastikan Anda sudah melakukan check-in.
            </div>
            @endif

            {{-- Stats strip --}}
            <div class="summary-strip">
                <div class="summary-item">
                    <div class="summary-icon red">
                        <svg width="15" height="15" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <div>
                        <p class="summary-label">Pelanggaran</p>
                        <p class="summary-val">{{ $pelanggaranHariIni->count() }}</p>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon yellow">
                        <svg width="15" height="15" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </div>
                    <div>
                        <p class="summary-label">Izin Keluar</p>
                        <p class="summary-val">{{ $izinHariIni->count() }}</p>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon blue">
                        <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div>
                        <p class="summary-label">Izin Disetujui</p>
                        <p class="summary-val">
                            {{ $izinHariIni->whereIn('status', [
                                \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI,
                                \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
                            ])->count() }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Mini list pelanggaran --}}
            @if($pelanggaranHariIni->count() > 0)
            <div style="margin-top:16px">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px">Pelanggaran Tercatat Hari Ini</p>
                <ul class="mini-list">
                    @foreach($pelanggaranHariIni as $p)
                    <li class="mini-item">
                        <div style="flex:1">
                            <span class="mini-item-name">{{ $p->siswa->nama_lengkap ?? '—' }}</span>
                            <span class="mini-item-sub"> · {{ $p->siswa->kelas->nama_kelas ?? '—' }} · {{ $p->kategori->nama ?? '—' }}</span>
                        </div>
                        @php $pc = $p->poin <= 20 ? 'poin-low' : ($p->poin <= 50 ? 'poin-mid' : 'poin-high') @endphp
                        <span class="poin-pill {{ $pc }}">{{ $p->poin }} poin</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>
    </div>

    {{-- Form Laporan --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            <span class="card-title">Isi Laporan Harian</span>
        </div>

        <form action="{{ route('piket.laporan.simpan-harian') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-grid">

                    {{-- Tanggal --}}
                    <div class="form-group col-span-2">
                        <label class="form-label">Tanggal Laporan <span class="req">*</span></label>
                        <input type="date" name="tanggal"
                            class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                            value="{{ old('tanggal', today()->format('Y-m-d')) }}"
                            style="max-width:220px">
                        @error('tanggal')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Kondisi sekolah --}}
                    <div class="form-group col-span-2">
                        <label class="form-label">Kondisi Sekolah <span class="req">*</span></label>

                        @if($ringkasanOtomatis)
                        <div>
                            <p class="ringkasan-label">
                                <svg width="11" height="11" fill="none" stroke="var(--brand-700)" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                Ringkasan Otomatis (jadikan referensi)
                            </p>
                            <div class="ringkasan-box">{{ $ringkasanOtomatis }}</div>
                        </div>
                        @endif

                        <textarea name="kondisi_sekolah" rows="4"
                            class="form-control {{ $errors->has('kondisi_sekolah') ? 'is-invalid' : '' }}"
                            placeholder="Deskripsikan kondisi umum sekolah hari ini…">{{ old('kondisi_sekolah', $laporanHariIni->kondisi_sekolah ?? $ringkasanOtomatis) }}</textarea>
                        @error('kondisi_sekolah')<p class="form-error">{{ $message }}</p>@enderror
                        <p class="form-hint">Ringkasan otomatis di atas dapat dijadikan referensi. Silakan edit sesuai kebutuhan.</p>
                    </div>

                    {{-- Catatan umum --}}
                    <div class="form-group col-span-2">
                        <label class="form-label">Catatan Umum</label>
                        <textarea name="catatan_umum" rows="3"
                            class="form-control {{ $errors->has('catatan_umum') ? 'is-invalid' : '' }}"
                            placeholder="Catatan umum kegiatan piket hari ini (opsional)…">{{ old('catatan_umum', $laporanHariIni->catatan_umum ?? '') }}</textarea>
                        @error('catatan_umum')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Tamu penting --}}
                    <div class="form-group col-span-2">
                        <label class="form-label">Tamu Penting</label>
                        <textarea name="tamu_penting" rows="2"
                            class="form-control {{ $errors->has('tamu_penting') ? 'is-invalid' : '' }}"
                            placeholder="Catat tamu penting yang hadir hari ini, jika ada (opsional)…">{{ old('tamu_penting', $laporanHariIni->tamu_penting ?? '') }}</textarea>
                        @error('tamu_penting')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Kejadian khusus --}}
                    <div class="form-group col-span-2">
                        <label class="form-label">Kejadian Khusus</label>
                        <textarea name="kejadian_khusus" rows="3"
                            class="form-control {{ $errors->has('kejadian_khusus') ? 'is-invalid' : '' }}"
                            placeholder="Tuliskan kejadian di luar kebiasaan jika ada (opsional)…">{{ old('kejadian_khusus', $laporanHariIni->kejadian_khusus ?? '') }}</textarea>
                        @error('kejadian_khusus')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('piket.laporan.riwayat') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    {{ $laporanHariIni ? 'Perbarui Laporan' : 'Simpan Laporan' }}
                </button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text: @json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if($errors->any())
Swal.fire({ icon:'warning', title:'Periksa Formulir', html: @json(implode('<br>', $errors->all())), confirmButtonColor:'#1f63db' });
@endif
</script>
</x-app-layout>