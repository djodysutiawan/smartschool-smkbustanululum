<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function updated(User $user): void
    {
        if (! $user->isDirty('email') && ! $user->isDirty('name')) return;

        $data = [];
        if ($user->isDirty('name'))  $data['nama_lengkap'] = $user->name;
        if ($user->isDirty('email')) $data['email']        = $user->email;

        // Sync ke guru
        if ($guru = $user->guru) {
            $guru->withoutObservers(fn () => $guru->updateQuietly($data));
        }

        // Sync ke siswa
        if ($siswa = $user->siswa) {
            $siswa->withoutObservers(fn () => $siswa->updateQuietly($data));
        }

        // Sync ke orang tua
        if ($orangTua = $user->orangTua) {
            $orangTua->withoutObservers(fn () => $orangTua->updateQuietly($data));
        }
    }
}