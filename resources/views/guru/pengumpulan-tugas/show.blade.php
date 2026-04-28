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
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-nilai{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-nilai:hover{background:var(--brand-100);filter:none}
    .btn-kembalikan{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-kembalikan:hover{background:#fef9c3;filter:none}

    .layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}

    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;gap:8px}
    .detail-card-title-row{display:flex;align-items:center;gap:8px}
    .detail-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-card-body{padding:20px}

    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .info-row{display:flex;flex-direction:column;gap:3px;padding:12px 0;border-bottom:1px solid var(--surface3)}
    .info-row:last-child{border-bottom:none}
    .info-row.full{grid-column:span 2}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--text)}
    .info-val.muted{color:var(--text3);font-weight:400}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-belum_dikumpulkan{background:#f1f5f9;color:#64748b}   .badge-belum_dikumpulkan .badge-dot{background:#94a3b8}
    .badge-dikumpulkan      {background:#dcfce7;color:#15803d}   .badge-dikumpulkan       .badge-dot{background:#15803d}
    .badge-terlambat        {background:#fefce8;color:#a16207}   .badge-terlambat         .badge-dot{background:#a16207}
    .badge-sudah_dinilai    {background:#eff6ff;color:#1d4ed8}   .badge-sudah_dinilai     .badge-dot{background:#3b82f6}

    .nilai-big{display:flex;align-items:center;justify-content:center;flex-direction:column;padding:20px;text-align:center}
    .nilai-circle{width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;margin-bottom:8px}
    .nilai-high{background:#dcfce7;color:#15803d}
    .nilai-mid {background:#fefce8;color:#a16207}
    .nilai-low {background:#fee2e2;color:#dc2626}
    .nilai-none{background:var(--surface2);color:var(--text3)}
    .nilai-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}

    .file-row{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:10px}
    .file-row:last-child{margin-bottom:0}
    .file-row-icon{width:36px;height:36px;background:var(--brand-50);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}

    .umpan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.7;white-space:pre-wrap;min-height:60px}

    .form-nilai{display:flex;flex-direction:column;gap:12px}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field input,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:80px}

    .foto-preview{width:100%;border-radius:var(--radius-sm);border:1px solid var(--border);display:block}

    @media(max-width:900px){.layout{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px}.info-grid{grid-template-columns:1fr}.info-row.full{grid-column:span 1}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengumpulan</h1>
            <p class="page-sub">{{ $pengumpulan->siswa->nama_lengkap ?? '—' }} — {{ $pengumpulan->tugas->judul ?? '—' }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.pengumpulan-tugas.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('guru.tugas.show', $pengumpulan->tugas_id) }}" class="btn btn-secondary">Lihat Tugas</a>
        </div>
    </div>

    <div class="layout">
        {{-- Kiri --}}
        <div>
            {{-- Info Siswa & Tugas --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title-row">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span class="detail-card-title">Data Pengumpulan</span>
                    </div>
                    <span class="badge badge-{{ $pengumpulan->status }}">
                        <span class="badge-dot"></span>
                        {{ ucwords(str_replace('_',' ',$pengumpulan->status)) }}
                    </span>
                </div>
                <div class="detail-card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Nama Siswa</span>
                            <span class="info-val">{{ $pengumpulan->siswa->nama_lengkap ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">NIS</span>
                            <span class="info-val">{{ $pengumpulan->siswa->nis ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kelas</span>
                            <span class="info-val">{{ $pengumpulan->siswa->kelas->nama_kelas ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dikumpulkan Pada</span>
                            <span class="info-val">{{ $pengumpulan->created_at ? $pengumpulan->created_at->format('d M Y, H:i') : '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Judul Tugas</span>
                            <span class="info-val">{{ $pengumpulan->tugas->judul ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mata Pelajaran</span>
                            <span class="info-val">{{ $pengumpulan->tugas->mataPelajaran->nama_mapel ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Batas Waktu</span>
                            <span class="info-val">{{ \Carbon\Carbon::parse($pengumpulan->tugas->batas_waktu)->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dinilai Pada</span>
                            <span class="info-val {{ !$pengumpulan->dinilai_pada ? 'muted' : '' }}">
                                {{ $pengumpulan->dinilai_pada ? \Carbon\Carbon::parse($pengumpulan->dinilai_pada)->format('d M Y, H:i') : '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Konten Pengumpulan --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title-row">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span class="detail-card-title">Konten Pengumpulan</span>
                    </div>
                </div>
                <div class="detail-card-body">
                    @if($pengumpulan->path_file)
                        <div class="file-row">
                            <div class="file-row-icon">
                                <svg width="16" height="16" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1;overflow:hidden">
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ basename($pengumpulan->path_file) }}</p>
                                <p style="font-size:11.5px;color:var(--text3)">File pengumpulan</p>
                            </div>
                            <a href="{{ Storage::url($pengumpulan->path_file) }}" target="_blank" class="btn btn-secondary btn-sm">Download</a>
                        </div>
                    @endif

                    @if($pengumpulan->url_pengumpulan)
                        <div class="file-row">
                            <div class="file-row-icon" style="background:#fefce8">
                                <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                            </div>
                            <div style="flex:1;overflow:hidden">
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $pengumpulan->url_pengumpulan }}</p>
                                <p style="font-size:11.5px;color:var(--text3)">Tautan pengumpulan</p>
                            </div>
                            <a href="{{ $pengumpulan->url_pengumpulan }}" target="_blank" class="btn btn-secondary btn-sm">Buka</a>
                        </div>
                    @endif

                    @if($pengumpulan->teks_pengumpulan)
                        <div>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em">Jawaban Teks</p>
                            <div class="umpan-box">{{ $pengumpulan->teks_pengumpulan }}</div>
                        </div>
                    @endif

                    @if($pengumpulan->foto_pengumpulan)
                        <div>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em">Foto Pengumpulan</p>
                            <img src="{{ Storage::url($pengumpulan->foto_pengumpulan) }}" class="foto-preview" alt="Foto pengumpulan">
                        </div>
                    @endif

                    @if(!$pengumpulan->path_file && !$pengumpulan->url_pengumpulan && !$pengumpulan->teks_pengumpulan && !$pengumpulan->foto_pengumpulan)
                        <p style="font-size:13px;color:var(--text3);text-align:center;padding:20px 0">Belum ada konten yang dikumpulkan</p>
                    @endif
                </div>
            </div>

            {{-- Umpan Balik --}}
            @if($pengumpulan->umpan_balik)
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title-row">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span class="detail-card-title">Umpan Balik Guru</span>
                    </div>
                </div>
                <div class="detail-card-body">
                    <div class="umpan-box">{{ $pengumpulan->umpan_balik }}</div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div>
            {{-- Nilai --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title-row">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                        <span class="detail-card-title">Nilai</span>
                    </div>
                </div>
                <div class="detail-card-body">
                    @php
                        $nc = 'nilai-none';
                        if ($pengumpulan->nilai !== null) {
                            $nilaiMaks = $pengumpulan->tugas->nilai_maksimal ?? 100;
                            $pctNilai  = ($pengumpulan->nilai / $nilaiMaks) * 100;
                            $nc = $pctNilai >= 75 ? 'nilai-high' : ($pctNilai >= 50 ? 'nilai-mid' : 'nilai-low');
                        }
                    @endphp
                    <div class="nilai-big">
                        <div class="nilai-circle {{ $nc }}">
                            {{ $pengumpulan->nilai !== null ? $pengumpulan->nilai : '—' }}
                        </div>
                        <p class="nilai-label">
                            @if($pengumpulan->nilai !== null)
                                dari {{ $pengumpulan->tugas->nilai_maksimal ?? 100 }}
                            @else
                                Belum dinilai
                            @endif
                        </p>
                    </div>

                    @if(in_array($pengumpulan->status, ['dikumpulkan','terlambat','sudah_dinilai']))
                    <form action="{{ route('guru.pengumpulan-tugas.beri-nilai', $pengumpulan->id) }}" method="POST" class="form-nilai">
                        @csrf @method('PATCH')
                        <div class="field">
                            <label>Nilai <span style="color:#dc2626">*</span> <span style="font-weight:400;color:var(--text3)">(maks. {{ $pengumpulan->tugas->nilai_maksimal ?? 100 }})</span></label>
                            <input type="number" name="nilai" value="{{ old('nilai', $pengumpulan->nilai) }}"
                                   min="0" max="{{ $pengumpulan->tugas->nilai_maksimal ?? 100 }}" step="0.5" required>
                            @error('nilai')<span style="font-size:11.5px;color:#dc2626">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Umpan Balik <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                            <textarea name="umpan_balik" placeholder="Komentar untuk siswa…">{{ old('umpan_balik', $pengumpulan->umpan_balik) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            {{ $pengumpulan->nilai !== null ? 'Perbarui Nilai' : 'Simpan Nilai' }}
                        </button>
                    </form>
                    @endif

                    @if(in_array($pengumpulan->status, ['dikumpulkan','terlambat','sudah_dinilai']) && $pengumpulan->nilai !== null)
                    <form action="{{ route('guru.pengumpulan-tugas.kembalikan', $pengumpulan->id) }}" method="POST" style="margin-top:8px">
                        @csrf @method('PATCH')
                        <button type="button" class="btn btn-kembalikan" style="width:100%;justify-content:center"
                            onclick="confirmKembalikan(this.closest('form'))">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
                            Kembalikan Penilaian
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

function confirmKembalikan(form) {
    Swal.fire({
        title: 'Kembalikan Penilaian?',
        text: 'Nilai dan umpan balik akan dihapus, status kembali ke dikumpulkan/terlambat.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#a16207', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Kembalikan', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}
</script>
</x-app-layout>