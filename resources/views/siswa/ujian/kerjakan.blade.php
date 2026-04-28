<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{
        --brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box}
    body{background:var(--surface2)}
    .exam-layout{display:grid;grid-template-columns:1fr 280px;min-height:100vh;max-width:1400px;margin:0 auto;padding:20px;gap:16px}
    /* ── Top bar ── */
    .exam-main{display:flex;flex-direction:column;gap:16px}
    .exam-topbar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .et-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--brand);letter-spacing:.05em;text-transform:uppercase}
    .et-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    /* ── Timer ── */
    .timer-box{display:flex;align-items:center;gap:8px;padding:8px 16px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm)}
    .timer-box.warning{background:#fff3cd;border-color:#fde68a}
    .timer-box.danger{background:#fee2e2;border-color:#fecaca;animation:pulse-timer 1s infinite}
    @keyframes pulse-timer{0%,100%{opacity:1}50%{opacity:.7}}
    .timer-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3)}
    .timer-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--brand);letter-spacing:.05em;min-width:68px;text-align:center}
    .timer-box.warning .timer-val{color:#a16207}
    .timer-box.danger .timer-val{color:#dc2626}
    /* ── Soal card ── */
    .soal-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .soal-header{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .soal-nomor{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .soal-bobot{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .soal-jenis-pill{padding:2px 9px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--brand-50);color:var(--brand-700)}
    .soal-body{padding:24px}
    .soal-pertanyaan{font-family:'DM Sans',sans-serif;font-size:15px;color:var(--text);line-height:1.7;margin-bottom:20px;white-space:pre-wrap}
    .soal-gambar{max-width:100%;border-radius:8px;border:1px solid var(--border);margin-bottom:16px;display:block}
    /* ── Pilihan ── */
    .pilihan-list{display:flex;flex-direction:column;gap:10px}
    .pilihan-item{display:flex;align-items:flex-start;gap:12px;padding:12px 16px;border:1.5px solid var(--border);border-radius:var(--radius-sm);cursor:pointer;transition:all .15s;background:var(--surface);user-select:none}
    .pilihan-item:hover{border-color:var(--brand-100);background:var(--brand-50)}
    .pilihan-item.selected{border-color:var(--brand);background:var(--brand-50)}
    .pilihan-kode{width:30px;height:30px;border-radius:50%;border:2px solid var(--border2);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text3);flex-shrink:0;transition:all .15s}
    .pilihan-item.selected .pilihan-kode{border-color:var(--brand);background:var(--brand);color:#fff}
    .pilihan-teks{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.5;padding-top:4px}
    .pilihan-item.selected .pilihan-teks{color:var(--text);font-weight:500}
    /* ── Essay ── */
    .essay-area{width:100%;min-height:140px;padding:12px 16px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);resize:vertical;outline:none;transition:border-color .15s;background:var(--surface)}
    .essay-area:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(31,99,219,.08)}
    .essay-char-count{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);text-align:right;margin-top:4px}
    /* ── Nav bawah ── */
    .soal-nav{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);gap:10px}
    .btn-nav{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn-nav:hover{filter:brightness(.93)}
    .btn-nav:disabled{opacity:.45;cursor:not-allowed;filter:none}
    .btn-prev{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-next{background:var(--brand);color:#fff}
    .btn-selesai{background:#dc2626;color:#fff}
    /* ── Save indicator ── */
    .save-indicator{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);display:flex;align-items:center;gap:5px;min-width:90px;justify-content:center}
    .save-dot{width:7px;height:7px;border-radius:50%;background:var(--text3);transition:background .2s}
    .save-dot.saving{background:#a16207;animation:blink .6s infinite}
    .save-dot.saved{background:#15803d}
    .save-dot.error{background:#dc2626}
    @keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}
    /* ── Sidebar ── */
    .exam-sidebar{display:flex;flex-direction:column;gap:12px}
    .sidebar-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .sidebar-card-header{padding:12px 16px;border-bottom:1px solid var(--border);background:var(--surface2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)}
    .sidebar-card-body{padding:14px 16px}
    .nav-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:6px}
    .nav-soal-btn{height:36px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;border:1.5px solid var(--border);background:var(--surface);color:var(--text2);transition:all .15s}
    .nav-soal-btn:hover{background:var(--brand-50);border-color:var(--brand-100)}
    .nav-soal-btn.answered{background:#dcfce7;border-color:#bbf7d0;color:#15803d}
    .nav-soal-btn.current{background:var(--brand);border-color:var(--brand);color:#fff}
    .legend{display:flex;flex-direction:column;gap:6px;margin-top:12px}
    .legend-item{display:flex;align-items:center;gap:8px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text2)}
    .legend-dot{width:14px;height:14px;border-radius:3px;flex-shrink:0}
    .btn-selesai-full{display:flex;width:100%;align-items:center;justify-content:center;gap:8px;padding:12px;border-radius:var(--radius-sm);background:#dc2626;color:#fff;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;transition:filter .15s}
    .btn-selesai-full:hover{filter:brightness(.93)}
    .btn-selesai-full:disabled{opacity:.6;cursor:not-allowed;filter:none}
    /* ── Sesi info ── */
    .sesi-info-row{display:flex;justify-content:space-between;margin-bottom:6px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)}
    .sesi-info-row:last-child{margin-bottom:0}
    .sesi-info-row strong{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text)}
    @media(max-width:900px){.exam-layout{grid-template-columns:1fr}.exam-sidebar{order:-1}}
    @keyframes spin-btn{to{transform:rotate(360deg)}}
</style>

<div class="exam-layout">

    {{-- ═══════════════ MAIN ═══════════════ --}}
    <div class="exam-main">

        {{-- Top bar --}}
        <div class="exam-topbar">
            <div>
                <p class="et-mapel">{{ $ujian->mataPelajaran->nama_mapel ?? '—' }}</p>
                <p class="et-judul">{{ $ujian->judul }}</p>
            </div>
            @if($sesi->batas_waktu_pada)
            <div class="timer-box" id="timerBox">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <div>
                    <p class="timer-label">Sisa Waktu</p>
                    <p class="timer-val" id="timerVal">--:--</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Soal-soal --}}
        @foreach($soalList as $idx => $soal)
        @php
            $jawaban       = $jawabanTersimpan[$soal->id] ?? null;
            $pilihanSaved  = $jawaban['pilihan_jawaban_id'] ?? null;
            $essaySaved    = $jawaban['jawaban_essay'] ?? '';
            $sudahDijawab  = $pilihanSaved !== null || $essaySaved !== '';
        @endphp
        <div class="soal-card" id="soal-{{ $idx }}"@if($idx > 0) style="display:none"@endif>
            <div class="soal-header">
                <div>
                    <span class="soal-nomor">Soal {{ $idx + 1 }} dari {{ $soalList->count() }}</span>
                    <span class="soal-bobot"> · Bobot {{ $soal->bobot }} poin</span>
                </div>
                <span class="soal-jenis-pill">
                    {{ ['pilihan_ganda'=>'Pilihan Ganda','essay'=>'Essay','benar_salah'=>'Benar/Salah'][$soal->jenis_soal] ?? ucfirst($soal->jenis_soal) }}
                </span>
            </div>
            <div class="soal-body">
                @if($soal->gambar_soal)
                    <img src="{{ asset('storage/'.$soal->gambar_soal) }}" alt="Gambar Soal" class="soal-gambar">
                @endif
                <div class="soal-pertanyaan">{!! nl2br(e($soal->pertanyaan)) !!}</div>

                @if($soal->isPilihanGanda() || $soal->isBenarSalah())
                <div class="pilihan-list" id="pilihan-list-{{ $soal->id }}">
                    @foreach($soal->pilihan as $p)
                    @php $isSelected = ($pilihanSaved !== null && (int)$pilihanSaved === (int)$p->id) @endphp
                    <label class="pilihan-item{{ $isSelected ? ' selected' : '' }}" id="label-{{ $soal->id }}-{{ $p->id }}"
                        onclick="pilihJawaban({{ $soal->id }}, {{ $p->id }}, this, {{ $idx }})">
                        <input type="radio" name="jawaban_{{ $soal->id }}" value="{{ $p->id }}" {{ $isSelected ? 'checked' : '' }} style="display:none">
                        <div class="pilihan-kode">{{ $p->kode_pilihan }}</div>
                        <div class="pilihan-teks">{{ $p->teks_pilihan }}</div>
                    </label>
                    @endforeach
                </div>

                @elseif($soal->isEssay())
                <textarea class="essay-area" id="essay-{{ $soal->id }}"
                    placeholder="Tulis jawaban Anda di sini..."
                    maxlength="5000"
                    oninput="essayAutoSave({{ $soal->id }}, this.value, {{ $idx }}); updateCharCount({{ $soal->id }}, this.value.length)">{{ $essaySaved }}</textarea>
                <div class="essay-char-count" id="charcount-{{ $soal->id }}">{{ mb_strlen($essaySaved) }}/5000</div>
                @endif
            </div>
            <div class="soal-nav">
                <button class="btn-nav btn-prev" onclick="gantiSoal({{ $idx - 1 }})"{{ $idx === 0 ? ' disabled' : '' }}>
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Sebelumnya
                </button>
                <div class="save-indicator" id="save-status-{{ $soal->id }}">
                    <span class="save-dot{{ $sudahDijawab ? ' saved' : '' }}"></span>
                    <span>{{ $sudahDijawab ? 'Tersimpan' : 'Belum dijawab' }}</span>
                </div>
                @if($idx < $soalList->count() - 1)
                <button class="btn-nav btn-next" onclick="gantiSoal({{ $idx + 1 }})">
                    Berikutnya
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
                @else
                <button class="btn-nav btn-selesai" onclick="konfirmasiSelesai()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Selesaikan Ujian
                </button>
                @endif
            </div>
        </div>
        @endforeach

    </div>{{-- /exam-main --}}

    {{-- ═══════════════ SIDEBAR ═══════════════ --}}
    <div class="exam-sidebar">
        @if($sesi->batas_waktu_pada)
        <div class="sidebar-card">
            <div class="sidebar-card-header">Informasi Sesi</div>
            <div class="sidebar-card-body">
                <div class="sesi-info-row">
                    <span>Mulai</span>
                    <strong>{{ $sesi->mulai_pada->format('H:i') }}</strong>
                </div>
                <div class="sesi-info-row">
                    <span>Batas waktu</span>
                    <strong>{{ $sesi->batas_waktu_pada->format('H:i') }}</strong>
                </div>
            </div>
        </div>
        @endif

        <div class="sidebar-card">
            <div class="sidebar-card-header">Navigasi Soal</div>
            <div class="sidebar-card-body">
                <div class="nav-grid" id="navGrid">
                    @foreach($soalList as $idx => $soal)
                    @php $sdj = isset($jawabanTersimpan[$soal->id]) && ($jawabanTersimpan[$soal->id]['pilihan_jawaban_id'] !== null || $jawabanTersimpan[$soal->id]['jawaban_essay'] !== '') @endphp
                    <div class="nav-soal-btn{{ $sdj ? ' answered' : '' }}{{ $idx === 0 ? ' current' : '' }}"
                        id="nav-btn-{{ $idx }}"
                        data-soal-id="{{ $soal->id }}"
                        onclick="gantiSoal({{ $idx }})">{{ $idx + 1 }}</div>
                    @endforeach
                </div>
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background:var(--brand)"></div>
                        Sedang dikerjakan
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background:#dcfce7;border:1px solid #bbf7d0"></div>
                        Sudah dijawab
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background:var(--surface);border:1.5px solid var(--border)"></div>
                        Belum dijawab
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-card">
            <div class="sidebar-card-body" style="padding:12px">
                <form action="{{ route('siswa.ujian.selesai', $ujian->id) }}" method="POST" id="selesaiForm">
                    @csrf
                    <button type="button" class="btn-selesai-full" id="btnSelesai" onclick="konfirmasiSelesai()">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Selesaikan Ujian
                    </button>
                </form>
            </div>
        </div>
    </div>{{-- /exam-sidebar --}}

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ─── Data dari PHP ────────────────────────────────────────────
const TOTAL_SOAL  = {{ $soalList->count() }};
// URL dengan placeholder __SOAL__ yang akan diganti per soal
const JAWAB_URL   = '{{ url("siswa/ujian/{$ujian->id}/soal/__SOAL__/jawab") }}';
const CSRF        = '{{ csrf_token() }}';
const BATAS_WAKTU = @json($sesi->batas_waktu_pada?->toISOString());

// Set soal yang sudah dijawab (inisialisasi dari server)
const ANSWERED_INIT = new Set(@json(
    $soalList->filter(function($s) use ($jawabanTersimpan) {
        return isset($jawabanTersimpan[$s->id]) &&
               ($jawabanTersimpan[$s->id]['pilihan_jawaban_id'] !== null || $jawabanTersimpan[$s->id]['jawaban_essay'] !== '');
    })->pluck('id')->map(fn($id) => (string)$id)->values()
));

let currentIdx  = 0;
let essayTimers = {};
let answeredSet = new Set(ANSWERED_INIT);

// ─── Navigasi antar soal ──────────────────────────────────────
function gantiSoal(idx) {
    if (idx < 0 || idx >= TOTAL_SOAL) return;
    // Sembunyikan soal aktif
    var prevCard = document.getElementById('soal-' + currentIdx);
    var prevBtn  = document.getElementById('nav-btn-' + currentIdx);
    if (prevCard) prevCard.style.display = 'none';
    if (prevBtn)  prevBtn.classList.remove('current');
    // Tampilkan soal baru
    currentIdx = idx;
    var nextCard = document.getElementById('soal-' + currentIdx);
    var nextBtn  = document.getElementById('nav-btn-' + currentIdx);
    if (nextCard) { nextCard.style.display = ''; }
    if (nextBtn)  nextBtn.classList.add('current');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ─── Pilih jawaban PG / Benar-Salah ──────────────────────────
function pilihJawaban(soalId, pilihanId, labelEl, soalIdx) {
    // Reset pilihan lain di soal ini
    var container = document.getElementById('pilihan-list-' + soalId);
    if (container) {
        container.querySelectorAll('.pilihan-item').forEach(function(l) {
            l.classList.remove('selected');
        });
    }
    labelEl.classList.add('selected');

    updateSaveStatus(soalId, 'saving');
    answeredSet.add(String(soalId));
    refreshNavBtn(soalIdx, soalId);
    kirimJawaban(soalId, { pilihan_jawaban_id: pilihanId });
}

// ─── Essay dengan debounce 800ms ──────────────────────────────
function essayAutoSave(soalId, val, soalIdx) {
    updateSaveStatus(soalId, 'saving');
    clearTimeout(essayTimers[soalId]);
    essayTimers[soalId] = setTimeout(function() {
        answeredSet.add(String(soalId));
        refreshNavBtn(soalIdx, soalId);
        kirimJawaban(soalId, { jawaban_essay: val });
    }, 800);
}

function updateCharCount(soalId, len) {
    var el = document.getElementById('charcount-' + soalId);
    if (el) el.textContent = len + '/5000';
}

// ─── Kirim jawaban ke server ──────────────────────────────────
function kirimJawaban(soalId, payload) {
    var url = JAWAB_URL.replace('__SOAL__', soalId);
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
        },
        body: JSON.stringify(payload),
    })
    .then(function(resp) { return resp.json(); })
    .then(function(data) {
        if (data.habis_waktu) {
            window.onbeforeunload = null;
            Swal.fire({
                icon: 'warning',
                title: 'Waktu Habis!',
                text: 'Waktu ujian telah habis. Jawaban Anda otomatis dikumpulkan.',
                timer: 2500,
                showConfirmButton: false,
            }).then(function() {
                window.location.href = '{{ route("siswa.ujian.hasil", $ujian->id) }}';
            });
            return;
        }
        if (data.success) {
            updateSaveStatus(soalId, 'saved');
        } else {
            updateSaveStatus(soalId, 'error');
        }
    })
    .catch(function() {
        updateSaveStatus(soalId, 'error');
    });
}

// ─── Update indikator simpan ──────────────────────────────────
function updateSaveStatus(soalId, state) {
    var el = document.getElementById('save-status-' + soalId);
    if (!el) return;
    var dot  = el.querySelector('.save-dot');
    var span = el.querySelector('span:last-child');
    dot.className = 'save-dot' + (state === 'saving' ? ' saving' : state === 'saved' ? ' saved' : state === 'error' ? ' error' : '');
    var labels = { saving: 'Menyimpan…', saved: 'Tersimpan', error: '⚠ Gagal simpan' };
    span.textContent = labels[state] || 'Belum dijawab';
}

// ─── Refresh warna tombol navigasi ───────────────────────────
function refreshNavBtn(soalIdx, soalId) {
    var btn = document.getElementById('nav-btn-' + soalIdx);
    if (!btn) return;
    if (!btn.classList.contains('current') && answeredSet.has(String(soalId))) {
        btn.classList.add('answered');
    }
}

// ─── Timer countdown ─────────────────────────────────────────
if (BATAS_WAKTU) {
    (function tick() {
        var sisa = Math.max(0, Math.floor((new Date(BATAS_WAKTU) - Date.now()) / 1000));
        var m = String(Math.floor(sisa / 60)).padStart(2, '0');
        var s = String(sisa % 60).padStart(2, '0');
        var valEl = document.getElementById('timerVal');
        var boxEl = document.getElementById('timerBox');
        if (valEl) valEl.textContent = m + ':' + s;
        if (sisa <= 0) {
            window.onbeforeunload = null;
            document.getElementById('selesaiForm').submit();
            return;
        }
        if (boxEl) {
            if (sisa <= 120)      boxEl.className = 'timer-box danger';
            else if (sisa <= 300) boxEl.className = 'timer-box warning';
        }
        setTimeout(tick, 1000);
    })();
}

// ─── Konfirmasi selesai ───────────────────────────────────────
function konfirmasiSelesai() {
    var belum = TOTAL_SOAL - answeredSet.size;
    Swal.fire({
        title: 'Kumpulkan Ujian?',
        html: belum > 0
            ? '<p style="font-size:14px;color:#475569">Masih ada <strong style="color:#dc2626">' + belum + ' soal</strong> belum dijawab.<br>Yakin ingin mengumpulkan?</p>'
            : '<p style="font-size:14px;color:#475569">Semua soal sudah dijawab.<br>Klik <strong>Ya, Kumpulkan</strong> untuk mengakhiri ujian.</p>',
        icon: belum > 0 ? 'warning' : 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Kumpulkan!',
        cancelButtonText: 'Kembali',
    }).then(function(r) {
        if (r.isConfirmed) {
            window.onbeforeunload = null;
            var btn = document.getElementById('btnSelesai');
            btn.disabled = true;
            btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin-btn .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Mengumpulkan…';
            document.getElementById('selesaiForm').submit();
        }
    });
}

// ─── Cegah tutup tab saat ujian berlangsung ───────────────────
window.addEventListener('beforeunload', function(e) {
    e.preventDefault();
    e.returnValue = '';
});
</script>
<style>@keyframes spin-btn{to{transform:rotate(360deg)}}</style>
</x-app-layout>