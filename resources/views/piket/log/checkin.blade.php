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
    .btn:disabled{opacity:.5;cursor:not-allowed;filter:none}
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
    .aktif-timer{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--green);margin-bottom:4px;font-variant-numeric:tabular-nums}
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
    .field select,.field textarea,.field input[type="text"]{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field select:focus,.field textarea:focus,.field input[type="text"]:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:72px}
    .field .hint{font-size:11.5px;color:var(--text3)}
    .field .badge-terjadwal{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);margin-left:6px}
    .form-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:18px}

    /* Validation errors */
    .field-error{font-size:11.5px;color:var(--red);font-weight:600;margin-top:2px}
    .field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:var(--red-bg)}

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
    .riwayat-masuk{font-size:12.5px;color:var(--green);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;white-space:nowrap}
    .riwayat-keluar{font-size:12.5px;color:var(--text3);white-space:nowrap}
    .riwayat-dur{margin-left:auto;font-size:12px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;white-space:nowrap}
    .checkout-warn{display:inline-flex;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:var(--piket-50);color:var(--piket-700);border:1px solid var(--piket-100)}

    /* Empty state */
    .empty-inline{padding:28px;text-align:center;font-size:13px;color:var(--text3)}
    .empty-dashed{background:var(--surface2);border:2px dashed var(--border2);border-radius:var(--radius);padding:24px;text-align:center;margin-bottom:20px}

    /* Section title */
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);margin-bottom:10px;display:flex;align-items:center;gap:7px}

    /* Shift chips */
    .shift-hint{display:flex;gap:8px;flex-wrap:wrap;margin-top:4px}
    .shift-chip{display:inline-flex;align-items:center;gap:4px;padding:2px 9px;border-radius:99px;font-size:11px;font-weight:700;border:1px solid var(--border);color:var(--text2);background:var(--surface3)}
    .shift-chip.pagi{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe}
    .shift-chip.siang{background:#fff7ed;color:#c2410c;border-color:#fed7aa}
    .shift-chip.sore{background:#faf5ff;color:#7e22ce;border-color:#e9d5ff}

    /* Status badge guru di select */
    .guru-status-aktif{color:var(--piket-700)}
    .guru-status-selesai{color:var(--text3)}

    #live-clock{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);font-variant-numeric:tabular-nums}
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
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
        </div>
    </div>

    {{-- ── Session alerts ── --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning" role="alert">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('warning') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error" role="alert">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Validation errors ── --}}
    @if($errors->any())
        <div class="alert alert-error" style="flex-direction:column;align-items:flex-start;gap:4px" role="alert">
            <div style="display:flex;align-items:center;gap:8px;font-weight:700">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
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
    @if($logAktif->isNotEmpty())
        <p class="section-title">
            <span class="live-dot" aria-hidden="true"></span>
            Sedang Bertugas Piket ({{ $logAktif->count() }} guru)
        </p>
        <div class="aktif-grid">
            @foreach($logAktif as $log)
                @php
                    /**
                     * Model sudah men-cast masuk_pada => 'datetime' (Carbon object).
                     * Tidak perlu Carbon::parse() lagi, tapi tetap aman jika dipanggil.
                     * Gunakan langsung karena cast sudah dijamin di Model.
                     *
                     * toIso8601String() untuk data-attribute agar JS new Date() parse
                     * dengan benar di semua browser & timezone.
                     */
                    $masukCarbon = $log->masuk_pada; // sudah Carbon dari cast model
                @endphp
                <div class="aktif-card">
                    <div class="aktif-card-top">
                        <div class="aktif-avatar" aria-hidden="true">
                            {{ strtoupper(mb_substr($log->guru?->nama_lengkap ?? 'G', 0, 2)) }}
                        </div>
                        <div style="flex:1;min-width:0">
                            <p class="aktif-nama">{{ $log->guru?->nama_lengkap ?? '—' }}</p>
                            <p class="aktif-shift">
                                Shift {{ ucfirst($log->shift ?? 'pagi') }}
                                @if($log->guru?->nip)&nbsp;· NIP {{ $log->guru->nip }}@endif
                            </p>
                        </div>
                    </div>

                    {{--
                        data-masuk pakai toIso8601String() (sudah include timezone offset)
                        agar new Date() di JS parse tepat, tidak terpengaruh timezone browser.
                    --}}
                    <p class="aktif-timer"
                       data-masuk="{{ $masukCarbon->toIso8601String() }}"
                       id="timer-{{ $log->id }}"
                       aria-live="polite"
                       aria-label="Durasi bertugas">—</p>
                    <p class="aktif-masuk">
                        Masuk pukul <strong>{{ $masukCarbon->format('H:i') }}</strong>
                    </p>

                    {{-- Form Checkout --}}
                    <div class="checkout-form" id="checkout-form-{{ $log->id }}" style="display:none" aria-hidden="true">
                        {{--
                            Route checkout menggunakan PATCH.
                            @method('PATCH') + @csrf wajib ada bersama.
                            Route::patch('piket/log/{log}/checkout', ...) di web.php.
                        --}}
                        <form method="POST" action="{{ route('piket.log.checkout', $log->id) }}">
                            @csrf
                            @method('PATCH')
                            <textarea name="catatan_keluar"
                                      placeholder="Catatan keluar (opsional)…"
                                      maxlength="500"
                                      aria-label="Catatan keluar"></textarea>
                            <div class="checkout-actions">
                                <button type="button"
                                        class="btn btn-secondary btn-sm"
                                        onclick="hideCheckout({{ $log->id }})">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-red btn-sm">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/></svg>
                                    Check-Out
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="checkout-btn-{{ $log->id }}">
                        <button type="button"
                                class="btn btn-red btn-sm"
                                style="width:100%;justify-content:center;margin-top:4px"
                                onclick="showCheckout({{ $log->id }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/></svg>
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
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            <span class="form-card-title">Mulai Tugas Piket — Check-In Guru</span>
        </div>
        <div class="form-card-body">
            <form method="POST" action="{{ route('piket.log.do-checkin') }}" id="form-checkin" novalidate>
                @csrf

                {{-- ── Pilih Guru ── --}}
                <div class="field">
                    <label for="sel-guru">
                        Guru yang Bertugas
                        <span style="color:var(--red)" aria-label="wajib diisi">*</span>
                        @if($guruTerjadwal->isNotEmpty())
                            <span class="badge-terjadwal">
                                <svg width="9" height="9" fill="var(--green)" viewBox="0 0 10 10" aria-hidden="true"><circle cx="5" cy="5" r="5"/></svg>
                                {{ $guruTerjadwal->count() }} terjadwal hari ini ({{ ucfirst($hariIni) }})
                            </span>
                        @endif
                    </label>

                    <select name="guru_id"
                            id="sel-guru"
                            required
                            class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}"
                            onchange="cekStatusGuru(this.value)">
                        <option value="">— Pilih guru yang akan bertugas —</option>

                        {{-- Optgroup guru terjadwal hari ini --}}
                        @if($guruTerjadwal->isNotEmpty())
                            <optgroup label="✓ Terjadwal Hari Ini ({{ ucfirst($hariIni) }})">
                                @foreach($guruTerjadwal as $guru)
                                    @php
                                        /**
                                         * $logAktif & $logHariIni adalah Illuminate\Support\Collection
                                         * (dari ->get() di controller), bukan array.
                                         * ->where() pada Collection aman & mengembalikan Collection.
                                         * ->isNotEmpty() lebih ekspresif dari ->count() > 0.
                                         */
                                        $sudahAktif   = $logAktif->where('guru_id', $guru->id)->isNotEmpty();
                                        $sudahSelesai = $logHariIni
                                            ->where('guru_id', $guru->id)
                                            ->whereNotNull('keluar_pada')
                                            ->isNotEmpty();
                                    @endphp
                                    <option value="{{ $guru->id }}"
                                            {{ old('guru_id') == $guru->id ? 'selected' : '' }}
                                            data-aktif="{{ $sudahAktif ? '1' : '0' }}"
                                            data-selesai="{{ $sudahSelesai ? '1' : '0' }}">
                                        {{ $guru->nama_lengkap }}
                                        @if($sudahAktif) — Sedang Piket
                                        @elseif($sudahSelesai) — Sudah Selesai
                                        @endif
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif

                        {{-- Optgroup semua guru aktif (exclude yang sudah tampil di atas) --}}
                        <optgroup label="Semua Guru Aktif">
                            @foreach($semuaGuru as $guru)
                                @if($guruTerjadwal->contains('id', $guru->id))
                                    @continue {{-- sudah ada di optgroup terjadwal --}}
                                @endif
                                @php
                                    $sudahAktif = $logAktif->where('guru_id', $guru->id)->isNotEmpty();
                                @endphp
                                <option value="{{ $guru->id }}"
                                        {{ old('guru_id') == $guru->id ? 'selected' : '' }}
                                        data-aktif="{{ $sudahAktif ? '1' : '0' }}"
                                        data-selesai="0">
                                    {{ $guru->nama_lengkap }}
                                    @if($sudahAktif) — Sedang Piket @endif
                                </option>
                            @endforeach
                        </optgroup>
                    </select>

                    {{--
                        Warning: guru masih aktif piket (ditampilkan via JS).
                        Server-side sudah menolak → ini hanya UX proaktif client-side.
                    --}}
                    <div id="guru-warning-aktif" style="display:none;margin-top:6px" role="alert">
                        <span style="font-size:12px;font-weight:700;color:var(--piket-700);background:var(--piket-50);border:1px solid var(--piket-100);border-radius:6px;padding:5px 10px;display:inline-block">
                            ⚠️ Guru ini masih aktif piket. Lakukan check-out terlebih dahulu.
                        </span>
                    </div>
                    {{-- Info: guru sudah selesai hari ini (boleh check-in lagi untuk shift berbeda) --}}
                    <div id="guru-info-selesai" style="display:none;margin-top:6px">
                        <span style="font-size:12px;font-weight:700;color:var(--brand-700);background:var(--brand-50);border:1px solid var(--brand-100);border-radius:6px;padding:5px 10px;display:inline-block">
                            ℹ️ Guru ini sudah menyelesaikan satu sesi. Check-in lagi untuk shift berikutnya.
                        </span>
                    </div>

                    @error('guru_id')
                        <span class="field-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Shift ── --}}
                {{-- Controller: 'shift' => ['nullable', 'in:pagi,siang,sore'] --}}
                {{-- Jika kosong → tentukanShift() dari jam_mulai jadwal --}}
                <div class="field">
                    <label for="sel-shift">
                        Shift
                        <span style="font-weight:400;color:var(--text3)">(opsional — otomatis dari jadwal)</span>
                    </label>
                    <select name="shift"
                            id="sel-shift"
                            class="{{ $errors->has('shift') ? 'is-invalid' : '' }}">
                        <option value="">— Otomatis dari jadwal —</option>
                        <option value="pagi"  {{ old('shift') === 'pagi'  ? 'selected' : '' }}>Shift Pagi</option>
                        <option value="siang" {{ old('shift') === 'siang' ? 'selected' : '' }}>Shift Siang</option>
                        <option value="sore"  {{ old('shift') === 'sore'  ? 'selected' : '' }}>Shift Sore</option>
                    </select>
                    <div class="shift-hint" aria-label="Referensi jam shift">
                        <span class="shift-chip pagi">Pagi · sebelum 12:00</span>
                        <span class="shift-chip siang">Siang · 12:00–14:59</span>
                        <span class="shift-chip sore">Sore · ab 15:00</span>
                    </div>
                    <span class="hint">Jika tidak dipilih, shift ditentukan otomatis berdasarkan jam mulai jadwal guru</span>
                    @error('shift')
                        <span class="field-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Catatan ── --}}
                <div class="field">
                    <label for="ta-catatan">
                        Catatan
                        <span style="font-weight:400;color:var(--text3)">(opsional)</span>
                    </label>
                    <textarea name="catatan"
                              id="ta-catatan"
                              class="{{ $errors->has('catatan') ? 'is-invalid' : '' }}"
                              placeholder="Kondisi awal, hal yang perlu diperhatikan, dll…"
                              maxlength="500">{{ old('catatan') }}</textarea>
                    <span class="hint">Maksimal 500 karakter</span>
                    @error('catatan')
                        <span class="field-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="btn-checkin">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Mulai Tugas Piket (<span id="btn-jam">{{ now()->format('H:i') }}</span>)
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Log Hari Ini ── --}}
    @if($logHariIni->isNotEmpty())
        <div class="panel" style="margin-bottom:16px">
            <div class="panel-header">
                <p class="panel-title">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Log Hari Ini
                </p>
                <span style="font-size:12px;color:var(--text3)">{{ $logHariIni->count() }} sesi</span>
            </div>
            @foreach($logHariIni as $logItem)
                @php
                    /**
                     * Model men-cast masuk_pada & keluar_pada => 'datetime' (Carbon).
                     * tanggal di-cast => 'date' (Carbon).
                     * Akses langsung aman; tidak perlu Carbon::parse() lagi.
                     */
                    $masukLog  = $logItem->masuk_pada;
                    $keluarLog = $logItem->keluar_pada;
                    $durLog    = ($masukLog && $keluarLog)
                        ? (int) $masukLog->diffInMinutes($keluarLog)
                        : null;
                @endphp
                <div class="riwayat-item">
                    <div class="riwayat-avatar" aria-hidden="true">
                        {{ strtoupper(mb_substr($logItem->guru?->nama_lengkap ?? 'G', 0, 2)) }}
                    </div>
                    <div style="flex:1;min-width:0">
                        <p class="riwayat-nama">{{ $logItem->guru?->nama_lengkap ?? '—' }}</p>
                        <p class="riwayat-sub">Shift {{ ucfirst($logItem->shift ?? '—') }}</p>
                    </div>
                    <p class="riwayat-masuk">
                        {{ $masukLog ? $masukLog->format('H:i') : '—' }}
                    </p>
                    <p class="riwayat-keluar">
                        @if($keluarLog)
                            → {{ $keluarLog->format('H:i') }}
                        @else
                            <span class="checkout-warn">Aktif</span>
                        @endif
                    </p>
                    <p class="riwayat-dur">
                        @if($durLog !== null)
                            {{ intdiv($durLog, 60) }}j {{ $durLog % 60 }}m
                        @else
                            —
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ── Riwayat 7 Hari Terakhir ── --}}
    <div class="panel">
        <div class="panel-header">
            <p class="panel-title">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Riwayat 7 Hari Terakhir
            </p>
            <span style="font-size:12px;color:var(--text3)">{{ $riwayatTerakhir->count() }} log</span>
        </div>
        @forelse($riwayatTerakhir as $logItem)
            @php
                $masukR  = $logItem->masuk_pada;
                $keluarR = $logItem->keluar_pada;
                $durR    = ($masukR && $keluarR)
                    ? (int) $masukR->diffInMinutes($keluarR)
                    : null;
                /**
                 * tanggal di-cast 'date' → Carbon object.
                 * isoFormat() langsung tersedia; tidak perlu Carbon::parse() lagi.
                 */
                $tglR = $logItem->tanggal;
            @endphp
            <div class="riwayat-item">
                <div class="riwayat-avatar" aria-hidden="true">
                    {{ strtoupper(mb_substr($logItem->guru?->nama_lengkap ?? 'G', 0, 2)) }}
                </div>
                <div style="flex:1;min-width:0">
                    <p class="riwayat-nama">{{ $logItem->guru?->nama_lengkap ?? '—' }}</p>
                    <p class="riwayat-sub">
                        {{ $tglR->locale('id')->isoFormat('ddd, D MMM Y') }}
                        · Shift {{ ucfirst($logItem->shift ?? '—') }}
                    </p>
                </div>
                <p class="riwayat-masuk">
                    {{ $masukR ? $masukR->format('H:i') : '—' }}
                </p>
                <p class="riwayat-keluar">
                    @if($keluarR)
                        → {{ $keluarR->format('H:i') }}
                    @else
                        <span class="checkout-warn">Belum checkout</span>
                    @endif
                </p>
                <p class="riwayat-dur">
                    @if($durR !== null)
                        {{ intdiv($durR, 60) }}j {{ $durR % 60 }}m
                    @else
                        —
                    @endif
                </p>
            </div>
        @empty
            <p class="empty-inline">Belum ada riwayat 7 hari terakhir</p>
        @endforelse
    </div>

</div>

<script>
(function () {
    'use strict';

    // ── Helpers ─────────────────────────────────────────────────────────────
    function pad(n) {
        return String(n).padStart(2, '0');
    }

    // ── Live clock ───────────────────────────────────────────────────────────
    var clockEl = document.getElementById('live-clock');
    var btnJamEl = document.getElementById('btn-jam');

    function updateClock() {
        var now = new Date();
        if (clockEl) {
            clockEl.textContent =
                pad(now.getHours()) + ':' +
                pad(now.getMinutes()) + ':' +
                pad(now.getSeconds());
        }
        if (btnJamEl) {
            btnJamEl.textContent =
                pad(now.getHours()) + ':' +
                pad(now.getMinutes());
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

    // ── Timer durasi per guru aktif ──────────────────────────────────────────
    // data-masuk berisi ISO 8601 string (toIso8601String() di Blade).
    // new Date(isoString) aman di semua browser modern karena ada timezone offset.
    document.querySelectorAll('[data-masuk]').forEach(function (el) {
        var masukAt = new Date(el.dataset.masuk);

        // Guard: jika parsing gagal (NaN), tampilkan '—' dan hentikan.
        if (isNaN(masukAt.getTime())) {
            el.textContent = '—';
            return;
        }

        function updateTimer() {
            var diff = Math.floor((Date.now() - masukAt.getTime()) / 1000);
            if (diff < 0) {
                el.textContent = '00:00:00';
                return;
            }
            el.textContent =
                pad(Math.floor(diff / 3600)) + ':' +
                pad(Math.floor((diff % 3600) / 60)) + ':' +
                pad(diff % 60);
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    });

    // ── Toggle form checkout ─────────────────────────────────────────────────
    window.showCheckout = function (id) {
        var form = document.getElementById('checkout-form-' + id);
        var btn  = document.getElementById('checkout-btn-' + id);
        if (form) { form.style.display = 'block'; form.setAttribute('aria-hidden', 'false'); }
        if (btn)  { btn.style.display  = 'none'; }
    };

    window.hideCheckout = function (id) {
        var form = document.getElementById('checkout-form-' + id);
        var btn  = document.getElementById('checkout-btn-' + id);
        if (form) { form.style.display = 'none'; form.setAttribute('aria-hidden', 'true'); }
        if (btn)  { btn.style.display  = 'block'; }
    };

    // ── Status guru: warning aktif & info selesai ────────────────────────────
    // Controller menolak di server-side; ini hanya UX proaktif client-side.
    // Juga disable tombol submit agar tidak dikirim sia-sia jika masih aktif.
    var warnAktif  = document.getElementById('guru-warning-aktif');
    var infoSelesai = document.getElementById('guru-info-selesai');
    var btnCheckin = document.getElementById('btn-checkin');

    window.cekStatusGuru = function (guruId) {
        // Reset semua state
        if (warnAktif)   warnAktif.style.display   = 'none';
        if (infoSelesai) infoSelesai.style.display  = 'none';
        if (btnCheckin)  btnCheckin.disabled         = false;

        if (!guruId) return;

        var sel = document.getElementById('sel-guru');
        if (!sel) return;

        // querySelector value selector membutuhkan escape untuk karakter khusus.
        // Gunakan iterasi Array untuk keamanan (menghindari CSS injection via ID).
        var opts   = Array.prototype.slice.call(sel.options);
        var opt    = opts.find(function (o) { return o.value === String(guruId); });
        if (!opt) return;

        var isAktif   = opt.dataset.aktif   === '1';
        var isSelesai = opt.dataset.selesai  === '1';

        if (isAktif) {
            if (warnAktif)  warnAktif.style.display  = 'block';
            if (btnCheckin) btnCheckin.disabled        = true;
        } else if (isSelesai) {
            if (infoSelesai) infoSelesai.style.display = 'block';
            // isSelesai TIDAK disable tombol — guru boleh check-in lagi (shift berbeda)
        }
    };

    // Jalankan saat load jika ada old('guru_id') dari failed validation
    var selGuru = document.getElementById('sel-guru');
    if (selGuru && selGuru.value) {
        window.cekStatusGuru(selGuru.value);
    }

}());
</script>
</x-app-layout>