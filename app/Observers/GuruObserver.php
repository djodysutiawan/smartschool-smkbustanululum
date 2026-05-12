<?php

namespace App\Observers;

use App\Models\Guru;
use App\Models\User;

class GuruObserver
{
    public function updated(Guru $guru): void
    {
        if (! $guru->pengguna_id) return;

        $data = [];

        if ($guru->isDirty('nama_lengkap')) {
            $data['name'] = $guru->nama_lengkap;
        }

        if ($guru->isDirty('email') && $guru->email) {
            $tidakBentrok = ! User::where('email', $guru->email)
                ->where('id', '!=', $guru->pengguna_id)
                ->exists();

            if ($tidakBentrok) {
                $data['email'] = $guru->email;
            }
        }

        if (! empty($data)) {
            $guru->pengguna->updateQuietly($data);
        }
    }
}