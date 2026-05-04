<?php

namespace App\Observers;

use App\Models\Guru;

class GuruObserver
{
    public function updated(Guru $guru): void
    {
        if (! $guru->pengguna_id) return;

        $data = [];
        if ($guru->isDirty('email'))        $data['email'] = $guru->email;
        if ($guru->isDirty('nama_lengkap')) $data['name']  = $guru->nama_lengkap;

        if (! empty($data)) {
            $guru->pengguna->updateQuietly($data);
        }
    }
}