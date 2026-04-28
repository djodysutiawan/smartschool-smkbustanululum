<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --piket-700:#b45309;--piket-600:#d97706;--piket-100:#fef3c7;--piket-50:#fffbeb;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
    }
    .page{padding:28px 28px 40px;max-width:2000px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-red{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .btn-green{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}

    /* Alert */
    .alert{display:flex;align-items:center;gap:10px;padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .alert-success{background:var(--green-bg);border:1px solid var(--green-border);color:var(--green)}
    .alert-warning{background:var(--piket-50);border:1px solid var(--piket-100);color:var(--piket-700)}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:var(--red)}

    /* Active guru cards */
    .aktif-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;margin-bottom:20px}
    .aktif-card{background:linear-gradient(135deg,var(--green-bg),#dcfce7);border:2px solid var(--green-border);border-radius:var(--radius);padding:18px 20px}
    .aktif-card-top{display:flex;align-items:center;gap:12px;margin-bottom:12px}
    .aktif-avatar{width:42px;height:42px;border-radius:10px;background:var(--green);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:#fff;flex-shrink:0}
    .aktif-nama{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);line-height:1.2}
    .aktif-shift{font-size:11.5px;color:var(--text3);margin-top:2px}
    .aktif-timer{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--green);margin-bottom:4px}
    .aktif-masuk{font-size:12px;color:var(--text2);margin-bottom:12px}
    .live-dot{display:inline-block;width:7px;height:7px;border-radius:50%;background:var(--green);animation:pulse-dot 2s ease-in-out infinite;margin-right:4px}
    @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.8)}}

    /* Form card */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-card-body{padding:20px}
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:16px}
    .field:last-child{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field select,.field textarea,.field input{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field select:focus,.field textarea:focus,.field input:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:72px}
    .field .hint{font-size:11.5px;color:var(--text3)}
    .field .badge-terjadwal{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);margin-left:6px}
    .form-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:18px}

    /* Validation errors */
    .field-error{font-size:11.5px;color:var(--red);font-weight:600;margin-top:2px}
    .field select.is-invalid,.field textarea.is-invalid,.field input.is-invalid{border-color:var(--red);background:var(--red-bg)}

    /* Checkout form inside aktif card */
    .checkout-form{border-top:1px solid var(--green-border);padding-top:12px;margin-top:4px}
    .checkout-form textarea{width:100%;padding:8px 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:#fff;outline:none;resize:vertical;min-height:60px;box-sizing:border-box;margin-bottom:8px}
    .checkout-form textarea:focus{border-color:var(--brand-500)}
    .checkout-actions{display:flex;gap:6px;justify-content:flex-end}

    /* Panel riwayat */
    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .panel-header{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}
    .riwayat-item{display:flex;align-items:center;gap:12px;padding:11px 20px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .riwayat-item:last-child{border-bottom:none}
    .riwayat-item:hover{background:#fafbff}
    .riwayat-avatar{width:30px;height:30px;border-radius:7px;background:var(--brand-50);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .riwayat-nama{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .riwayat-sub{font-size:11.5px;color:var(--text3);margin-top:1px}
    .riwayat-masuk{font-size:12.5px;color:var(--green);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}
    .riwayat-keluar{font-size:12.5px;color:var(--text3)}
    .riwayat-dur{margin-left:auto;font-size:12px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}
    .checkout-warn{display:inline-flex;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:var(--piket-50);color:var(--piket-700);border:1px solid var(--piket-100)}

    /* Empty state */
    .empty-inline{padding:28px;text-align:center;font-size:13px;color:var(--text3)}
    .empty-dashed{background:var(--surface2);border:2px dashed var(--border2);border-radius:var(--radius);padding:24px;text-align:center;margin-bottom:20px}

    /* Section title */
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);margin-bottom:10px;display:flex;align-items:center;gap:7px}

    /* Shift badge chips inside option hint */
    .shift-hint{display:flex;gap:8px;flex-wrap:wrap;margin-top:4px}
    .shift-chip{display:inline-flex;align-items:center;gap:4px;padding:2px 9px;border-radius:99px;font-size:11px;font-weight:700;border:1px solid var(--border);color:var(--text2);background:var(--surface3)}
    .shift-chip.pagi{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe}
    .shift-chip.siang{background:#fff7ed;color:#c2410c;border-color:#fed7aa}
    .shift-chip.sore{background:#faf5ff;color:#7e22ce;border-color:#e9d5ff}

    #live-clock{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3)}
    @media(max-width:640px){.page{padding:16px}.aktif-grid{grid-template-columns:1fr}}
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Log Piket</h1>
            <p class="page-sub">
                {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }} ·
                <span id="live-clock">--:--:--</span>
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.dashboard') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
        </div>
    </div>

    {{-- ── Session alerts ── --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('warning') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Validation errors (dari $errors bag Laravel) ── --}}
    @if($errors->any())
    <div class="alert alert-error" style="flex-direction:column;align-items:flex-start;gap:4px">
        <div style="display:flex;align-items:center;gap:8px;font-weight:700">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            Periksa kembali isian berikut:
        </div>
        <ul style="margin:4px 0 0 20px;padding:0;font-size:12.5px;font-weight:500">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ═══ GURU SEDANG AKTIF PIKET ═══ --}}
    @if($logAktif->count())
    <p class="section-title">
        <span class="live-dot"></span>
        Sedang Bertugas Piket ({{ $logAktif->count() }} guru)
    </p>
    <div class="aktif-grid">
        @foreach($logAktif as $log)
        <div class="aktif-card">
            <div class="aktif-card-top">
                <div class="aktif-avatar">
                    {{ strtoupper(substr($log->guru?->nama_lengkap ?? 'G', 0, 2)) }}
                </div>
                <div style="flex:1;min-width:0">
                    <p class="aktif-nama">{{ $log->guru?->nama_lengkap ?? '—' }}</p>
                    <p class="aktif-shift">
                        Shift {{ ucfirst($log->shift ?? 'pagi') }}
                        @if($log->guru?->nip) · NIP {{ $log->guru->nip }} @endif
                    </p>
                </div>
            </div>
            <p class="aktif-timer"
               data-masuk="{{ \Carbon\Carbon::parse($log->masuk_pada)->toIso8601String() }}"
               id="timer-{{ $log->id }}">—</p>
            <p class="aktif-masuk">Masuk pukul <strong>{{ \Carbon\Carbon::parse($log->masuk_pada)->format('H:i') }}</strong></p>

            {{-- Form Checkout --}}
            <div class="checkout-form" id="checkout-form-{{ $log->id }}" style="display:none">
                <form method="POST" action="{{ route('piket.log.checkout', $log->id) }}">
                    @csrf @method('PATCH')
                    <textarea name="catatan_keluar" placeholder="Catatan keluar (opsional)…"></textarea>
                    <div class="checkout-actions">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="hideCheckout({{ $log->id }})">Batal</button>
                        <button type="submit" class="btn btn-red btn-sm">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/></svg>
                            Check-Out
                        </button>
                    </div>
                </form>
            </div>
            <div id="checkout-btn-{{ $log->id }}">
                <button type="button" class="btn btn-red btn-sm"
                        style="width:100%;justify-content:center;margin-top:4px"
                        onclick="showCheckout({{ $log->id }})">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/></svg>
                    Akhiri Tugas Piket
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-dashed">
        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text3)">
            Tidak ada guru yang sedang bertugas piket saat ini
        </p>
    </div>
    @endif

    {{-- ═══ FORM CHECK-IN ═══ --}}
    <div class="form-card">
        <div class="form-card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            <span class="form-card-title">Mulai Tugas Piket — Check-In Guru</span>
        </div>
        <div class="form-card-body">
            <form method="POST" action="{{ route('piket.log.do-checkin') }}">
                @csrf

                {{-- ── Pilih Guru ── --}}
                <div class="field">
                    <label>
                        Guru yang Bertugas
                        <span style="color:var(--red)">*</span>
                        @if($guruTerjadwal->count())
                            <span class="badge-terjadwal">
                                <svg width="9" height="9" fill="var(--green)" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                                {{ $guruTerjadwal->count() }} terjadwal hari ini
                                ({{ ucfirst($hariIni) }})
                            </span>
                        @endif
                    </label>
                    <select name="guru_id" id="sel-guru" required
                            class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}"
                            onchange="cekStatusGuru(this.value)">
                        <option value="">— Pilih guru yang akan bertugas —</option>

                        @if($guruTerjadwal->count())
                            <optgroup label="✓ Terjadwal Hari Ini">
                                @foreach($guruTerjadwal as $guru)
                                    @php
                                        $sudahAktif   = $logAktif->where('guru_id', $guru->id)->count() > 0;
                                        $sudahSelesai = $logHariIni->where('guru_id', $guru->id)->whereNotNull('keluar_pada')->count() > 0;
                                    @endphp
                                    <option value="{{ $guru->id }}"
                                        {{ old('guru_id') == $guru->id ? 'selected' : '' }}
                                        data-aktif="{{ $sudahAktif ? '1' : '0' }}"
                                        data-selesai="{{ $sudahSelesai ? '1' : '0' }}">
                                        {{ $guru->nama_lengkap }}
                                        @if($sudahAktif) (Sedang Piket)
                                        @elseif($sudahSelesai) (Sudah Selesai)
                                        @endif
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif

                        <optgroup label="Semua Guru">
                            @foreach($semuaGuru as $guru)
                                @if(!$guruTerjadwal->contains('id', $guru->id))
                                    @php $sudahAktif = $logAktif->where('guru_id', $guru->id)->count() > 0; @endphp
                                    <option value="{{ $guru->id }}"
                                        {{ old('guru_id') == $guru->id ? 'selected' : '' }}
                                        data-aktif="{{ $sudahAktif ? '1' : '0' }}"
                                        data-selesai="0">
                                        {{ $guru->nama_lengkap }}
                                        @if($sudahAktif) (Sedang Piket) @endif
                                    </option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>

                    {{-- Warning: guru masih aktif piket --}}
                    <div id="guru-warning" style="display:none;margin-top:6px">
                        <span style="font-size:12px;font-weight:700;color:var(--piket-700);background:var(--piket-50);border:1px solid var(--piket-100);border-radius:6px;padding:5px 10px;display:inline-block">
                            ⚠️ Guru ini masih aktif piket. Lakukan check-out terlebih dahulu.
                        </span>
                    </div>

                    @error('guru_id')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Shift ── --}}
                {{--
                    Controller: 'shift' => ['nullable', 'string', 'in:pagi,siang,sore']
                    Tiga pilihan: pagi, siang, sore. Jika kosong → otomatis dari jadwal.
                --}}
                <div class="field">
                    <label>Shift <span style="font-weight:400;color:var(--text3)">(opsional — otomatis dari jadwal)</span></label>
                    <select name="shift" class="{{ $errors->has('shift') ? 'is-invalid' : '' }}">
                        <option value="">— Otomatis dari jadwal —</option>
                        <option value="pagi"  {{ old('shift') === 'pagi'  ? 'selected' : '' }}>Shift Pagi</option>
                        <option value="siang" {{ old('shift') === 'siang' ? 'selected' : '' }}>Shift Siang</option>
                        <option value="sore"  {{ old('shift') === 'sore'  ? 'selected' : '' }}>Shift Sore</option>
                    </select>
                    <div class="shift-hint">
                        <span class="shift-chip pagi">Pagi · 07:00–11:00</span>
                        <span class="shift-chip siang">Siang · 12:00–16:00</span>
                        <span class="shift-chip sore">Sore · 15:00–17:00</span>
                    </div>
                    <span class="hint">Jika tidak dipilih, shift akan ditentukan otomatis berdasarkan jadwal</span>
                    @error('shift')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Catatan ── --}}
                <div class="field">
                    <label>Catatan <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                    <textarea name="catatan"
                              class="{{ $errors->has('catatan') ? 'is-invalid' : '' }}"
                              placeholder="Kondisi awal, hal yang perlu diperhatikan, dll…"
                              maxlength="500">{{ old('catatan') }}</textarea>
                    <span class="hint">Maksimal 500 karakter</span>
                    @error('catatan')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="btn-checkin">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Mulai Tugas Piket (<span id="btn-jam">{{ now()->format('H:i') }}</span>)
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Log Hari Ini ── --}}
    @if($logHariIni->count())
    <div class="panel" style="margin-bottom:16px">
        <div class="panel-header">
            <p class="panel-title">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Log Hari Ini
            </p>
            <span style="font-size:12px;color:var(--text3)">{{ $logHariIni->count() }} sesi</span>
        </div>
        @foreach($logHariIni as $log)
        @php
            $dur = ($log->masuk_pada && $log->keluar_pada)
                ? \Carbon\Carbon::parse($log->masuk_pada)->diffInMinutes(\Carbon\Carbon::parse($log->keluar_pada))
                : null;
        @endphp
        <div class="riwayat-item">
            <div class="riwayat-avatar">{{ strtoupper(substr($log->guru?->nama_lengkap ?? 'G', 0, 2)) }}</div>
            <div style="flex:1;min-width:0">
                <p class="riwayat-nama">{{ $log->guru?->nama_lengkap ?? '—' }}</p>
                <p class="riwayat-sub">Shift {{ ucfirst($log->shift ?? '—') }}</p>
            </div>
            <p class="riwayat-masuk">{{ \Carbon\Carbon::parse($log->masuk_pada)->format('H:i') }}</p>
            <p class="riwayat-keluar">
                @if($log->keluar_pada)
                    → {{ \Carbon\Carbon::parse($log->keluar_pada)->format('H:i') }}
                @else
                    <span class="checkout-warn">Aktif</span>
                @endif
            </p>
            <p class="riwayat-dur">{{ $dur ? intdiv($dur,60).'j '.($dur%60).'m' : '—' }}</p>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ── Riwayat 7 Hari Terakhir ── --}}
    <div class="panel">
        <div class="panel-header">
            <p class="panel-title">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Riwayat 7 Hari Terakhir
            </p>
            <span style="font-size:12px;color:var(--text3)">{{ $riwayatTerakhir->count() }} log</span>
        </div>
        @forelse($riwayatTerakhir as $log)
        @php
            $dur = ($log->masuk_pada && $log->keluar_pada)
                ? \Carbon\Carbon::parse($log->masuk_pada)->diffInMinutes(\Carbon\Carbon::parse($log->keluar_pada))
                : null;
        @endphp
        <div class="riwayat-item">
            <div class="riwayat-avatar">{{ strtoupper(substr($log->guru?->nama_lengkap ?? 'G', 0, 2)) }}</div>
            <div style="flex:1;min-width:0">
                <p class="riwayat-nama">{{ $log->guru?->nama_lengkap ?? '—' }}</p>
                <p class="riwayat-sub">
                    {{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('ddd, D MMM Y') }}
                    · Shift {{ ucfirst($log->shift ?? '—') }}
                </p>
            </div>
            <p class="riwayat-masuk">
                {{ $log->masuk_pada ? \Carbon\Carbon::parse($log->masuk_pada)->format('H:i') : '—' }}
            </p>
            <p class="riwayat-keluar">
                @if($log->keluar_pada)
                    → {{ \Carbon\Carbon::parse($log->keluar_pada)->format('H:i') }}
                @else
                    <span class="checkout-warn">Belum checkout</span>
                @endif
            </p>
            <p class="riwayat-dur">{{ $dur ? intdiv($dur,60).'j '.($dur%60).'m' : '—' }}</p>
        </div>
        @empty
        <p class="empty-inline">Belum ada riwayat 7 hari terakhir</p>
        @endforelse
    </div>

</div>

<script>
// ── Live clock ──────────────────────────────────────────────────────────────
function pad(n) { return String(n).padStart(2, '0'); }

function updateClock() {
    const now = new Date();
    const hms = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
    document.getElementById('live-clock').textContent = hms;

    // Update jam di tombol check-in (HH:mm saja)
    const hm = pad(now.getHours()) + ':' + pad(now.getMinutes());
    const btnJam = document.getElementById('btn-jam');
    if (btnJam) btnJam.textContent = hm;
}
updateClock();
setInterval(updateClock, 1000);

// ── Timer durasi per guru aktif ─────────────────────────────────────────────
document.querySelectorAll('[data-masuk]').forEach(function(el) {
    var masukAt = new Date(el.dataset.masuk);
    function update() {
        var diff = Math.floor((Date.now() - masukAt.getTime()) / 1000);
        if (diff < 0) { el.textContent = '00:00:00'; return; }
        el.textContent = pad(Math.floor(diff / 3600)) + ':' +
                         pad(Math.floor((diff % 3600) / 60)) + ':' +
                         pad(diff % 60);
    }
    update();
    setInterval(update, 1000);
});

// ── Toggle form checkout ────────────────────────────────────────────────────
function showCheckout(id) {
    document.getElementById('checkout-form-' + id).style.display = 'block';
    document.getElementById('checkout-btn-' + id).style.display  = 'none';
}
function hideCheckout(id) {
    document.getElementById('checkout-form-' + id).style.display = 'none';
    document.getElementById('checkout-btn-' + id).style.display  = 'block';
}

// ── Warning & disable tombol jika guru masih aktif ─────────────────────────
// Controller menolak checkin jika guru masih aktif (whereNull keluar_pada).
// View menonaktifkan tombol submit secara proaktif agar UX lebih baik.
function cekStatusGuru(guruId) {
    var warn   = document.getElementById('guru-warning');
    var btnCi  = document.getElementById('btn-checkin');

    if (!guruId) {
        warn.style.display   = 'none';
        btnCi.disabled       = false;
        return;
    }

    var opt    = document.querySelector('select[name="guru_id"] option[value="' + guruId + '"]');
    var aktif  = opt && opt.dataset.aktif === '1';

    warn.style.display = aktif ? 'block' : 'none';
    btnCi.disabled     = aktif;
}

// Jalankan saat halaman load jika ada old('guru_id') yang terisi
(function() {
    var sel = document.getElementById('sel-guru');
    if (sel && sel.value) cekStatusGuru(sel.value);
})();
</script>
</x-app-layout>