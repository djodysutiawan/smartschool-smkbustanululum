<?php

namespace App\Observers;

use App\Models\OrangTua;

class OrangTuaObserver
{
    public function updated(OrangTua $orangTua): void
    {
        if (! $orangTua->pengguna_id) return;

        $data = [];
        if ($orangTua->isDirty('email'))        $data['email'] = $orangTua->email;
        if ($orangTua->isDirty('nama_lengkap')) $data['name']  = $orangTua->nama_lengkap;

        if (! empty($data)) {
            $orangTua->pengguna->updateQuietly($data);
        }
    }
}