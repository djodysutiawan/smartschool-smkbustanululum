<?php

namespace App\Observers;

use App\Models\Siswa;

class SiswaObserver
{
    public function updated(Siswa $siswa): void
    {
        if (! $siswa->pengguna_id) return;

        $data = [];
        if ($siswa->isDirty('email'))        $data['email'] = $siswa->email;
        if ($siswa->isDirty('nama_lengkap')) $data['name']  = $siswa->nama_lengkap;

        if (! empty($data)) {
            $siswa->pengguna->updateQuietly($data);
        }
    }
}