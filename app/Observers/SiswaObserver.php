<?php

namespace App\Observers;

use App\Models\Siswa;
use App\Models\User;

class SiswaObserver
{
    public function updated(Siswa $siswa): void
    {
        if (! $siswa->pengguna_id) return;

        $data = [];

        if ($siswa->isDirty('nama_lengkap')) {
            $data['name'] = $siswa->nama_lengkap;
        }

        if ($siswa->isDirty('email') && $siswa->email) {
            $tidakBentrok = ! User::where('email', $siswa->email)
                ->where('id', '!=', $siswa->pengguna_id)
                ->exists();

            if ($tidakBentrok) {
                $data['email'] = $siswa->email;
            }
        }

        if (! empty($data)) {
            $siswa->pengguna->updateQuietly($data);
        }
    }
}