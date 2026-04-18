<div class="danger-zone">
    <div class="danger-header">
        <svg width="15" height="15" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <p class="danger-title">Zona Berbahaya — Hapus Akun</p>
    </div>
    <div class="danger-body">
        <p class="danger-desc">
            Setelah akun Anda dihapus, semua data dan sumber daya terkait akan dihapus secara permanen.
            Sebelum menghapus akun, pastikan Anda sudah mengunduh semua data yang ingin disimpan.
            <strong style="color:var(--red)">Tindakan ini tidak dapat dibatalkan.</strong>
        </p>
        <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteModal').classList.add('open')">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
            Hapus Akun Saya
        </button>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-header">
            <p class="modal-title" style="color:var(--red)">Konfirmasi Hapus Akun</p>
            <button class="modal-close" onclick="document.getElementById('deleteModal').classList.remove('open')">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
            @csrf @method('delete')

            <div class="modal-body">
                <div style="background:var(--red-bg);border:1px solid var(--red-border);border-radius:var(--radius-sm);padding:12px 14px;margin-bottom:18px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--red);line-height:1.5">
                    Semua data akun Anda termasuk data terhubung akan dihapus secara <strong>permanen dan tidak bisa dipulihkan</strong>.
                </div>

                <div class="field">
                    <label style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)">
                        Masukkan Password untuk Konfirmasi <span style="color:var(--red)">*</span>
                    </label>
                    <input type="password" name="password" id="deletePassword"
                        placeholder="Masukkan password Anda"
                        style="height:38px;padding:0 12px;border:1px solid {{ $errors->userDeletion->has('password') ? '#dc2626' : 'var(--border)' }};border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;box-sizing:border-box">
                    @if($errors->userDeletion->has('password'))
                        <span style="font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif">{{ $errors->userDeletion->first('password') }}</span>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="document.getElementById('deleteModal').classList.remove('open')">
                    Batal
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteAccount()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Ya, Hapus Akun Saya
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    @if($errors->userDeletion->isNotEmpty())
    document.getElementById('deleteModal').classList.add('open');
    @endif

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });

    function confirmDeleteAccount() {
        const pwd = document.getElementById('deletePassword').value;
        if (!pwd) {
            Swal.fire({icon:'warning',title:'Password Kosong',text:'Masukkan password Anda untuk konfirmasi.',confirmButtonColor:'#dc2626'});
            return;
        }
        Swal.fire({
            title:'Hapus Akun Selamanya?',
            html:'Tindakan ini <strong>tidak dapat dibatalkan</strong>. Semua data Anda akan hilang.',
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus Sekarang!',cancelButtonText:'Batal, Urungkan',
        }).then(r => {
            if (r.isConfirmed) document.getElementById('deleteAccountForm').submit();
        });
    }
</script>