<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function updated(User $user): void
    {
        // Sync email ke tabel guru
        if ($user->isDirty('email') || $user->isDirty('name')) {
            if ($guru = $user->guru) {
                $guru->withoutObserver(function () use ($guru, $user) {
                    $data = [];
                    if ($user->isDirty('email')) $data['email'] = $user->email;
                    if ($user->isDirty('name'))  $data['nama_lengkap'] = $user->name;
                    $guru->updateQuietly($data);
                });
            }

            if ($siswa = $user->siswa) {
                $data = [];
                if ($user->isDirty('email')) $data['email'] = $user->email;
                if ($user->isDirty('name'))  $data['nama_lengkap'] = $user->name;
                $siswa->updateQuietly($data);
            }

            if ($orangTua = $user->orangTua) {
                $data = [];
                if ($user->isDirty('email')) $data['email'] = $user->email;
                if ($user->isDirty('name'))  $data['nama_lengkap'] = $user->name;
                $orangTua->updateQuietly($data);
            }
        }
    }
}