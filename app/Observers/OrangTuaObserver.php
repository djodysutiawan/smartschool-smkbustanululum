<?php

namespace App\Observers;

use App\Models\OrangTua;
use App\Models\User;

class OrangTuaObserver
{
    public function updated(OrangTua $orangTua): void
    {
        if (! $orangTua->pengguna_id) return;

        $data = [];

        if ($orangTua->isDirty('nama_lengkap')) {
            $data['name'] = $orangTua->nama_lengkap;
        }

        if ($orangTua->isDirty('email') && $orangTua->email) {
            $tidakBentrok = ! User::where('email', $orangTua->email)
                ->where('id', '!=', $orangTua->pengguna_id)
                ->exists();

            if ($tidakBentrok) {
                $data['email'] = $orangTua->email;
            }
        }

        if (! empty($data)) {
            $orangTua->pengguna->updateQuietly($data);
        }
    }
}