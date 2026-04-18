<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────
        // 0. SPATIE ROLES
        // ─────────────────────────────────────────────
        $roles = ['admin', 'guru', 'siswa', 'orang_tua', 'guru_piket'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // ─────────────────────────────────────────────
        // 1. USERS
        // ─────────────────────────────────────────────

        // --- Admin (1 user) ---
        $adminUser = DB::table('users')->insertGetId([
            'name'              => 'Administrator',
            'email'             => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'no_hp'             => '081200000001',
            'is_active'         => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // --- Guru Piket (1 user) ---
        $guruPiketUser = DB::table('users')->insertGetId([
            'name'              => 'Piket Bersama',
            'email'             => 'piket@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'guru_piket',
            'no_hp'             => '081200000002',
            'is_active'         => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // --- Guru Users (10 users) ---
        $guruData = [
            ['Budi Santoso',      'budi.santoso',      '081211110001', 'L'],
            ['Siti Rahayu',       'siti.rahayu',       '081211110002', 'P'],
            ['Ahmad Fauzi',       'ahmad.fauzi',       '081211110003', 'L'],
            ['Dewi Lestari',      'dewi.lestari',      '081211110004', 'P'],
            ['Rudi Hermawan',     'rudi.hermawan',     '081211110005', 'L'],
            ['Rina Marlina',      'rina.marlina',      '081211110006', 'P'],
            ['Hendra Kusuma',     'hendra.kusuma',     '081211110007', 'L'],
            ['Yuli Astuti',       'yuli.astuti',       '081211110008', 'P'],
            ['Doni Prasetyo',     'doni.prasetyo',     '081211110009', 'L'],
            ['Fitri Handayani',   'fitri.handayani',   '081211110010', 'P'],
        ];

        $guruUserIds = [];
        foreach ($guruData as [$name, $slug, $hp, $jk]) {
            $guruUserIds[] = DB::table('users')->insertGetId([
                'name'              => $name,
                'email'             => $slug . '@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'guru',
                'no_hp'             => $hp,
                'is_active'         => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // --- Siswa Users (30 users) ---
        $siswaNames = [
            ['Aldi Firmansyah',    'L'], ['Bella Safitri',      'P'],
            ['Cahya Nugroho',      'L'], ['Dina Amalia',         'P'],
            ['Eko Saputra',        'L'], ['Farah Nabila',        'P'],
            ['Gilang Ramadhan',    'L'], ['Hana Pertiwi',        'P'],
            ['Ivan Setiawan',      'L'], ['Jihan Azzahra',       'P'],
            ['Kevin Maulana',      'L'], ['Laila Nurhayati',     'P'],
            ['Maulana Yusuf',      'L'], ['Nadia Putri',         'P'],
            ['Omar Abdillah',      'L'], ['Putri Ramadhani',     'P'],
            ['Qori Ananda',        'L'], ['Rani Septyani',       'P'],
            ['Satria Wibowo',      'L'], ['Tari Oktavia',        'P'],
            ['Umar Hakim',         'L'], ['Vina Claudia',        'P'],
            ['Wahyu Hidayat',      'L'], ['Xena Puspita',        'P'],
            ['Yoga Pratama',       'L'], ['Zahra Maulidya',      'P'],
            ['Arif Budiman',       'L'], ['Bunga Citra',         'P'],
            ['Candra Wijaya',      'L'], ['Desi Permata',        'P'],
        ];

        $siswaUserIds = [];
        foreach ($siswaNames as $i => [$name, $jk]) {
            $slug = strtolower(str_replace(' ', '.', $name));
            $siswaUserIds[] = DB::table('users')->insertGetId([
                'name'              => $name,
                'email'             => $slug . '@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'siswa',
                'no_hp'             => '0822' . str_pad($i + 1, 8, '0', STR_PAD_LEFT),
                'is_active'         => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // --- Orang Tua Users (15 users) ---
        $orangTuaNames = [
            ['Bambang Santoso',   '081233330001'],
            ['Endang Rahayu',     '081233330002'],
            ['Sukirman Fauzi',    '081233330003'],
            ['Mariam Lestari',    '081233330004'],
            ['Agus Hermawan',     '081233330005'],
            ['Sri Wahyuni',       '081233330006'],
            ['Joko Kusuma',       '081233330007'],
            ['Tuti Astuti',       '081233330008'],
            ['Dwi Prasetyo',      '081233330009'],
            ['Ani Handayani',     '081233330010'],
            ['Supardi Wijaya',    '081233330011'],
            ['Eti Nurjanah',      '081233330012'],
            ['Rohman Hidayat',    '081233330013'],
            ['Lastri Pertiwi',    '081233330014'],
            ['Paijo Budiono',     '081233330015'],
        ];

        $orangTuaUserIds = [];
        foreach ($orangTuaNames as $i => [$name, $hp]) {
            $slug = strtolower(str_replace(' ', '.', $name));
            $orangTuaUserIds[] = DB::table('users')->insertGetId([
                'name'              => $name,
                'email'             => $slug . '@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'orang_tua',
                'no_hp'             => $hp,
                'is_active'         => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // --- Assign Spatie Roles ---
        $adminModel    = \App\Models\User::find($adminUser);
        $piketModel    = \App\Models\User::find($guruPiketUser);
        $adminModel->assignRole('admin');
        $piketModel->assignRole('guru_piket');

        foreach ($guruUserIds as $id) {
            \App\Models\User::find($id)?->assignRole('guru');
        }
        foreach ($siswaUserIds as $id) {
            \App\Models\User::find($id)?->assignRole('siswa');
        }
        foreach ($orangTuaUserIds as $id) {
            \App\Models\User::find($id)?->assignRole('orang_tua');
        }

        // ─────────────────────────────────────────────
        // 2. TAHUN AJARAN
        // ─────────────────────────────────────────────
        $tahunAjaranId = DB::table('tahun_ajaran')->insertGetId([
            'tahun'           => '2024/2025',
            'semester'        => 'genap',
            'tanggal_mulai'   => '2025-01-06',
            'tanggal_selesai' => '2025-06-20',
            'status'          => 'aktif',
            'keterangan'      => 'Semester Genap Tahun Pelajaran 2024/2025',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        DB::table('tahun_ajaran')->insert([
            'tahun'           => '2024/2025',
            'semester'        => 'ganjil',
            'tanggal_mulai'   => '2024-07-15',
            'tanggal_selesai' => '2024-12-20',
            'status'          => 'tidak_aktif',
            'keterangan'      => 'Semester Ganjil Tahun Pelajaran 2024/2025',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // ─────────────────────────────────────────────
        // 3. GEDUNG
        // ─────────────────────────────────────────────
        $gedungIds = [];
        $gedungList = [
            ['GD-A', 'Gedung A (Utama)',       3, 'Gedung utama sekolah, berisi ruang kelas X dan XI'],
            ['GD-B', 'Gedung B (Laboratorium)', 2, 'Gedung laboratorium komputer dan IPA'],
            ['GD-C', 'Gedung C (Administrasi)', 2, 'Gedung kantor TU, kepala sekolah, dan guru'],
        ];
        foreach ($gedungList as [$kode, $nama, $lantai, $desk]) {
            $gedungIds[] = DB::table('gedung')->insertGetId([
                'kode_gedung'   => $kode,
                'nama_gedung'   => $nama,
                'jumlah_lantai' => $lantai,
                'deskripsi'     => $desk,
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 4. RUANG
        // ─────────────────────────────────────────────
        $ruangIds = [];
        $ruangList = [
            [$gedungIds[0], 'R-101', 'Ruang Kelas X RPL 1',    1, 'kelas',               36, true,  false, true,  false],
            [$gedungIds[0], 'R-102', 'Ruang Kelas X RPL 2',    1, 'kelas',               36, true,  false, true,  false],
            [$gedungIds[0], 'R-201', 'Ruang Kelas XI RPL 1',   2, 'kelas',               36, true,  true,  true,  false],
            [$gedungIds[0], 'R-202', 'Ruang Kelas XI AKL 1',   2, 'kelas',               36, true,  false, false, false],
            [$gedungIds[1], 'LAB-01','Lab Komputer 1',          1, 'laboratorium_komputer',36, true,  true,  true,  true ],
            [$gedungIds[1], 'LAB-02','Lab Komputer 2',          1, 'laboratorium_komputer',36, true,  true,  true,  true ],
            [$gedungIds[1], 'LAB-IPA','Lab IPA',                2, 'laboratorium_ipa',    30, false, false, false, false],
            [$gedungIds[2], 'AULA',  'Aula Serbaguna',          1, 'aula',               200, true,  true,  true,  false],
        ];
        foreach ($ruangList as [$gId, $kode, $nama, $lantai, $jenis, $kap, $pry, $ac, $wifi, $pc]) {
            $ruangIds[] = DB::table('ruang')->insertGetId([
                'gedung_id'       => $gId,
                'kode_ruang'      => $kode,
                'nama_ruang'      => $nama,
                'lantai'          => $lantai,
                'jenis_ruang'     => $jenis,
                'kapasitas'       => $kap,
                'ada_proyektor'   => $pry,
                'ada_ac'          => $ac,
                'ada_wifi'        => $wifi,
                'ada_komputer'    => $pc,
                'status'          => 'tersedia',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 5. MATA PELAJARAN
        // ─────────────────────────────────────────────
        $mapelIds = [];
        $mapelList = [
            ['Pemrograman Web',           'PWB-001', 'produktif',   4, 45, true ],
            ['Basis Data',                'BDS-001', 'produktif',   4, 45, true ],
            ['Pemrograman Berorientasi Objek', 'PBO-001', 'produktif', 4, 45, true],
            ['Matematika',                'MTK-001', 'adaptif',    4, 45, false],
            ['Bahasa Indonesia',          'BIN-001', 'normatif',   3, 45, false],
            ['Bahasa Inggris',            'BIG-001', 'adaptif',    3, 45, false],
            ['Pendidikan Kewarganegaraan','PKN-001', 'normatif',   2, 45, false],
            ['Pendidikan Agama Islam',    'PAI-001', 'normatif',   3, 45, false],
            ['Akuntansi Dasar',           'AKD-001', 'produktif',  4, 45, false],
            ['Penjaskes',                 'PJK-001', 'normatif',   2, 45, false],
        ];
        foreach ($mapelList as [$nama, $kode, $kel, $jam, $dur, $lab]) {
            $mapelIds[] = DB::table('mata_pelajaran')->insertGetId([
                'nama_mapel'       => $nama,
                'kode_mapel'       => $kode,
                'kelompok'         => $kel,
                'jam_per_minggu'   => $jam,
                'durasi_per_sesi'  => $dur,
                'perlu_lab'        => $lab,
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 6. GURU (profil)
        // ─────────────────────────────────────────────
        $guruIds = [];
        $guruProfilData = [
            // [user_id, nip, nama, jk, tempat_lahir, tgl_lahir, alamat, pendidikan, jurusan, univ, th_lulus, status_kep, adalah_piket]
            [$guruUserIds[0], '198501012010011001', 'Budi Santoso',     'L', 'Bandung',    '1985-01-01', 'Jl. Merdeka No.1 Bandung',    'S1', 'Teknik Informatika', 'ITB',        2008, 'pns',    false],
            [$guruUserIds[1], '198703152011012002', 'Siti Rahayu',      'P', 'Jakarta',    '1987-03-15', 'Jl. Sudirman No.5 Jakarta',   'S1', 'Pendidikan Bahasa', 'UNJ',        2010, 'pns',    true ],
            [$guruUserIds[2], '199002202012011003', 'Ahmad Fauzi',      'L', 'Yogyakarta', '1990-02-20', 'Jl. Malioboro No.10 Yogya',   'S2', 'Matematika',        'UGM',        2013, 'p3k',    false],
            [$guruUserIds[3], '198812102013012004', 'Dewi Lestari',     'P', 'Surabaya',   '1988-12-10', 'Jl. Ahmad Yani No.3 Sby',     'S1', 'Akuntansi',         'UNAIR',      2011, 'pns',    false],
            [$guruUserIds[4], '199105252014011005', 'Rudi Hermawan',    'L', 'Semarang',   '1991-05-25', 'Jl. Pemuda No.8 Semarang',    'S1', 'Olahraga',          'UNNES',      2014, 'honorer',true ],
            [$guruUserIds[5], '198907032015012006', 'Rina Marlina',     'P', 'Bogor',      '1989-07-03', 'Jl. Pajajaran No.12 Bogor',   'S1', 'Bahasa Inggris',    'IPB',        2012, 'honorer',false],
            [$guruUserIds[6], '199304182016011007', 'Hendra Kusuma',    'L', 'Medan',      '1993-04-18', 'Jl. Gatot Subroto No.7 Medan','S1', 'Teknik Informatika', 'USU',       2015, 'honorer',true ],
            [$guruUserIds[7], '199001302017012008', 'Yuli Astuti',      'P', 'Makassar',   '1990-01-30', 'Jl. Sultan Alauddin No.2 Mks', 'S1','Pendidikan Agama',   'UIN',       2013, 'gtty',   false],
            [$guruUserIds[8], '199208122018011009', 'Doni Prasetyo',    'L', 'Palembang',  '1992-08-12', 'Jl. Jend. Sudirman No.9 Plb', 'S1', 'Teknik Informatika', 'Unsri',     2015, 'honorer',false],
            [$guruUserIds[9], '199511022019012010', 'Fitri Handayani',  'P', 'Malang',     '1995-11-02', 'Jl. Veteran No.14 Malang',    'S1', 'PKn',               'UM',         2018, 'honorer',false],
        ];

        foreach ($guruProfilData as [$uid, $nip, $nama, $jk, $tl, $ttl, $alamat, $pend, $jur, $univ, $thLls, $statKep, $adlhPiket]) {
            $guruIds[] = DB::table('guru')->insertGetId([
                'pengguna_id'          => $uid,
                'nip'                  => $nip,
                'nama_lengkap'         => $nama,
                'jenis_kelamin'        => $jk,
                'tempat_lahir'         => $tl,
                'tanggal_lahir'        => $ttl,
                'alamat'               => $alamat,
                'no_hp'                => '0812111100' . str_pad(array_search([$uid, $nip, $nama, $jk, $tl, $ttl, $alamat, $pend, $jur, $univ, $thLls, $statKep, $adlhPiket], $guruProfilData) + 1, 2, '0', STR_PAD_LEFT),
                'email'                => strtolower(str_replace(' ', '.', $nama)) . '@sims.sch.id',
                'pendidikan_terakhir'  => $pend,
                'jurusan_pendidikan'   => $jur,
                'universitas'          => $univ,
                'tahun_lulus'          => $thLls,
                'status_kepegawaian'   => $statKep,
                'tanggal_masuk'        => '2020-07-13',
                'adalah_guru_piket'    => $adlhPiket,
                'status'               => 'aktif',
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 7. KELAS
        // ─────────────────────────────────────────────
        $kelasIds = [];
        $kelasList = [
            ['X RPL 1',   'X',   'Rekayasa Perangkat Lunak', 'RPL-X-1',  $guruIds[0], $ruangIds[0]],
            ['X RPL 2',   'X',   'Rekayasa Perangkat Lunak', 'RPL-X-2',  $guruIds[1], $ruangIds[1]],
            ['XI RPL 1',  'XI',  'Rekayasa Perangkat Lunak', 'RPL-XI-1', $guruIds[2], $ruangIds[2]],
            ['XI AKL 1',  'XI',  'Akuntansi dan Keuangan',   'AKL-XI-1', $guruIds[3], $ruangIds[3]],
        ];
        foreach ($kelasList as [$nama, $tingkat, $jurusan, $kode, $waliId, $ruangId]) {
            $kelasIds[] = DB::table('kelas')->insertGetId([
                'nama_kelas'       => $nama,
                'tingkat'          => $tingkat,
                'jurusan'          => $jurusan,
                'kode_kelas'       => $kode,
                'wali_kelas_id'    => $waliId,
                'ruang_id'         => $ruangId,
                'tahun_ajaran_id'  => $tahunAjaranId,
                'kapasitas_maks'   => 36,
                'status'           => 'aktif',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 8. SISWA (profil)
        // ─────────────────────────────────────────────
        $agamaList = ['Islam', 'Islam', 'Islam', 'Kristen', 'Islam', 'Katholik', 'Islam', 'Islam', 'Hindu', 'Islam'];
        $pekerjaanList = ['PNS', 'Wiraswasta', 'Petani', 'Pedagang', 'Karyawan Swasta', 'TNI/Polri', 'Buruh', 'Guru'];
        $siswaIds = [];

        foreach ($siswaNames as $i => [$namaLengkap, $jk]) {
            $kelasId = $kelasIds[$i % count($kelasIds)];
            $nis     = '2024' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $nisn    = '00' . str_pad(100001 + $i, 8, '0', STR_PAD_LEFT);

            $siswaIds[] = DB::table('siswa')->insertGetId([
                'pengguna_id'      => $siswaUserIds[$i],
                'nis'              => $nis,
                'nisn'             => $nisn,
                'nama_lengkap'     => $namaLengkap,
                'jenis_kelamin'    => $jk,
                'tempat_lahir'     => ['Bandung', 'Jakarta', 'Bogor', 'Depok', 'Bekasi', 'Cimahi'][$i % 6],
                'tanggal_lahir'    => date('Y-m-d', strtotime('2007-01-01 +' . ($i * 30) . ' days')),
                'agama'            => $agamaList[$i % count($agamaList)],
                'alamat'           => 'Jl. Contoh No.' . ($i + 1) . ', RT 0' . (($i % 9) + 1) . '/RW 00' . (($i % 5) + 1),
                'no_hp'            => '0856' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'email'            => strtolower(str_replace([' ', "'"], ['.', ''], $namaLengkap)) . '@siswa.sims.sch.id',
                'nama_ayah'        => 'Ayah ' . explode(' ', $namaLengkap)[0],
                'pekerjaan_ayah'   => $pekerjaanList[$i % count($pekerjaanList)],
                'no_hp_ayah'       => '0813' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'nama_ibu'         => 'Ibu ' . explode(' ', $namaLengkap)[0],
                'pekerjaan_ibu'    => $pekerjaanList[($i + 3) % count($pekerjaanList)],
                'no_hp_ibu'        => '0814' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'kelas_id'         => $kelasId,
                'tahun_ajaran_id'  => $tahunAjaranId,
                'status'           => 'aktif',
                'tanggal_masuk'    => '2023-07-17',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 9. ORANG TUA (profil)
        // ─────────────────────────────────────────────
        $orangTuaIds = [];
        foreach ($orangTuaNames as $i => [$nama, $hp]) {
            $orangTuaIds[] = DB::table('orang_tua')->insertGetId([
                'pengguna_id'  => $orangTuaUserIds[$i],
                'nama_lengkap' => $nama,
                'no_hp'        => $hp,
                'email'        => strtolower(str_replace(' ', '.', $nama)) . '@orangtua.sims.sch.id',
                'alamat'       => 'Jl. Keluarga No.' . ($i + 1) . ', Bandung',
                'pekerjaan'    => $pekerjaanList[$i % count($pekerjaanList)],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 10. SISWA ORANG TUA (pivot)
        // ─────────────────────────────────────────────
        // Setiap 2 siswa punya 1 orang tua (ayah)
        foreach ($siswaIds as $i => $siswaId) {
            $otId = $orangTuaIds[$i % count($orangTuaIds)];
            $exists = DB::table('siswa_orang_tua')
                ->where('siswa_id', $siswaId)
                ->where('orang_tua_id', $otId)
                ->exists();
            if (!$exists) {
                DB::table('siswa_orang_tua')->insert([
                    'siswa_id'      => $siswaId,
                    'orang_tua_id'  => $otId,
                    'hubungan'      => 'ayah',
                    'kontak_utama'  => true,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 11. KETERSEDIAAN GURU
        // ─────────────────────────────────────────────
        $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        foreach ($guruIds as $guruId) {
            foreach ($hari as $h) {
                DB::table('ketersediaan_guru')->insert([
                    'guru_id'     => $guruId,
                    'hari'        => $h,
                    'jam_mulai'   => '07:00:00',
                    'jam_selesai' => '13:30:00',
                    'tersedia'    => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 12. JADWAL PELAJARAN
        // ─────────────────────────────────────────────
        $jadwalList = [
            // [guru_id_idx, mapel_id_idx, kelas_id_idx, ruang_id_idx, hari, jam_mulai, jam_selesai]
            [0, 0, 0, 4, 'senin',  '07:00:00', '08:30:00'],
            [0, 0, 0, 4, 'rabu',   '07:00:00', '08:30:00'],
            [1, 4, 0, 0, 'senin',  '08:30:00', '10:00:00'],
            [1, 4, 1, 1, 'selasa', '07:00:00', '08:30:00'],
            [2, 3, 0, 0, 'selasa', '07:00:00', '08:30:00'],
            [2, 3, 2, 2, 'rabu',   '08:30:00', '10:00:00'],
            [3, 8, 3, 3, 'kamis',  '07:00:00', '08:30:00'],
            [4, 9, 0, 0, 'jumat',  '07:00:00', '08:30:00'],
            [5, 5, 1, 1, 'kamis',  '08:30:00', '10:00:00'],
            [6, 1, 2, 4, 'senin',  '10:15:00', '11:45:00'],
            [7, 7, 3, 3, 'selasa', '10:15:00', '11:45:00'],
            [8, 2, 2, 5, 'rabu',   '10:15:00', '11:45:00'],
            [9, 6, 0, 0, 'kamis',  '10:15:00', '11:45:00'],
        ];

        $jadwalIds = [];
        foreach ($jadwalList as [$gi, $mi, $ki, $ri, $h, $jMul, $jSel]) {
            $jadwalIds[] = DB::table('jadwal_pelajaran')->insertGetId([
                'tahun_ajaran_id'   => $tahunAjaranId,
                'guru_id'           => $guruIds[$gi],
                'mata_pelajaran_id' => $mapelIds[$mi],
                'kelas_id'          => $kelasIds[$ki],
                'ruang_id'          => $ruangIds[$ri],
                'hari'              => $h,
                'jam_mulai'         => $jMul,
                'jam_selesai'       => $jSel,
                'sumber_jadwal'     => 'manual',
                'is_active'         => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 13. JADWAL PIKET GURU
        // ─────────────────────────────────────────────
        // Guru yang adalah_guru_piket = true: indeks 1, 4, 6
        $piketGuruIds = [$guruIds[1], $guruIds[4], $guruIds[6]];
        $piketHari    = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        foreach ($piketGuruIds as $pgId) {
            foreach ($piketHari as $h) {
                DB::table('jadwal_piket_guru')->insert([
                    'guru_id'         => $pgId,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'hari'            => $h,
                    'jam_mulai'       => '07:00:00',
                    'jam_selesai'     => '14:00:00',
                    'catatan'         => 'Jadwal piket rutin',
                    'is_active'       => true,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 14. LOG PIKET
        // ─────────────────────────────────────────────
        $logPiketData = [
            [$piketGuruIds[0], '2025-01-06', 'pagi',  '2025-01-06 07:00:00', '2025-01-06 14:00:00'],
            [$piketGuruIds[1], '2025-01-07', 'pagi',  '2025-01-07 07:05:00', '2025-01-07 14:00:00'],
            [$piketGuruIds[2], '2025-01-08', 'pagi',  '2025-01-08 06:58:00', '2025-01-08 14:00:00'],
            [$piketGuruIds[0], '2025-01-13', 'pagi',  '2025-01-13 07:02:00', '2025-01-13 14:00:00'],
            [$piketGuruIds[1], '2025-01-14', 'pagi',  '2025-01-14 07:00:00', '2025-01-14 14:00:00'],
        ];
        foreach ($logPiketData as [$gId, $tgl, $shift, $masuk, $keluar]) {
            DB::table('log_piket')->insert([
                'pengguna_id' => $guruPiketUser,
                'guru_id'     => $gId,
                'tanggal'     => $tgl,
                'shift'       => $shift,
                'masuk_pada'  => $masuk,
                'keluar_pada' => $keluar,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 15. MATERI
        // ─────────────────────────────────────────────
        $materiList = [
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'Pengantar HTML & CSS', 'Dasar-dasar pembuatan halaman web', 'file', 'materi/html-css-dasar.pdf'],
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'JavaScript ES6',       'Fitur terbaru JavaScript ES6+',      'file', 'materi/js-es6.pdf'],
            [$guruIds[0], $mapelIds[0], $kelasIds[1], 'Framework Laravel',    'Pengenalan Laravel 11',              'link', null],
            [$guruIds[2], $mapelIds[3], $kelasIds[0], 'Limit dan Turunan',    'Materi kalkulus dasar',              'file', 'materi/limit-turunan.pdf'],
            [$guruIds[2], $mapelIds[3], $kelasIds[2], 'Integral',             'Integral tak tentu dan tertentu',    'file', 'materi/integral.pdf'],
            [$guruIds[1], $mapelIds[4], $kelasIds[0], 'Teks Argumentasi',     'Struktur dan kaidah teks argumentasi','teks', null],
            [$guruIds[6], $mapelIds[1], $kelasIds[2], 'Normalisasi Basis Data','1NF, 2NF, 3NF dengan contoh kasus', 'file', 'materi/normalisasi.pdf'],
            [$guruIds[8], $mapelIds[2], $kelasIds[2], 'OOP: Class dan Object', 'Konsep OOP dengan PHP',             'video', null],
        ];
        foreach ($materiList as $i => [$gId, $mId, $kId, $judul, $desk, $jenis, $path]) {
            DB::table('materi')->insert([
                'guru_id'             => $gId,
                'mata_pelajaran_id'   => $mId,
                'kelas_id'            => $kId,
                'tahun_ajaran_id'     => $tahunAjaranId,
                'judul'               => $judul,
                'deskripsi'           => $desk,
                'jenis'               => $jenis,
                'path_file'           => $path,
                'url_eksternal'       => $jenis === 'link' ? 'https://laravel.com/docs/11.x' : null,
                'urutan'              => $i + 1,
                'dipublikasikan'      => true,
                'dipublikasikan_pada' => now()->subDays(rand(1, 30)),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 16. TUGAS
        // ─────────────────────────────────────────────
        $tugasIds = [];
        $tugasList = [
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'Membuat Halaman Profil HTML',     'Buat halaman web profil pribadi menggunakan HTML & CSS', 'file', now()->addDays(7)],
            [$guruIds[0], $mapelIds[0], $kelasIds[1], 'Form Login Responsif',            'Buat form login yang responsif dengan CSS Flexbox',      'file', now()->addDays(7)],
            [$guruIds[2], $mapelIds[3], $kelasIds[0], 'Latihan Soal Limit',              'Kerjakan soal-soal limit fungsi halaman 45-50',          'teks', now()->addDays(3)],
            [$guruIds[6], $mapelIds[1], $kelasIds[2], 'ERD Sistem Perpustakaan',         'Buat ERD untuk sistem informasi perpustakaan sekolah',   'file', now()->addDays(10)],
            [$guruIds[8], $mapelIds[2], $kelasIds[2], 'Implementasi Class Kendaraan',    'Buat class Kendaraan dengan OOP PHP, tambah inheritance', 'file', now()->addDays(5)],
        ];
        foreach ($tugasList as [$gId, $mId, $kId, $judul, $desk, $jenis, $batas]) {
            $tugasIds[] = DB::table('tugas')->insertGetId([
                'guru_id'             => $gId,
                'mata_pelajaran_id'   => $mId,
                'kelas_id'            => $kId,
                'tahun_ajaran_id'     => $tahunAjaranId,
                'judul'               => $judul,
                'deskripsi'           => $desk,
                'jenis_pengumpulan'   => $jenis,
                'batas_waktu'         => $batas,
                'nilai_maksimal'      => 100,
                'izinkan_terlambat'   => false,
                'dipublikasikan'      => true,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 17. PENGUMPULAN TUGAS
        // ─────────────────────────────────────────────
        // 10 siswa pertama mengumpulkan tugas pertama
        foreach (array_slice($siswaIds, 0, 10) as $i => $sId) {
            DB::table('pengumpulan_tugas')->insert([
                'tugas_id'         => $tugasIds[0],
                'siswa_id'         => $sId,
                'path_file'        => 'pengumpulan/tugas-1-siswa-' . ($i + 1) . '.zip',
                'nilai'            => rand(70, 100),
                'umpan_balik'      => 'Pengerjaan ' . ($i % 2 === 0 ? 'sangat baik' : 'cukup baik') . ', pertahankan.',
                'status'           => 'dinilai',
                'dikumpulkan_pada' => now()->subDays(rand(1, 5)),
                'dinilai_pada'     => now()->subDays(rand(0, 2)),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        // 8 siswa kelas XI mengumpulkan tugas ERD
        foreach (array_slice($siswaIds, 16, 8) as $i => $sId) {
            DB::table('pengumpulan_tugas')->insert([
                'tugas_id'         => $tugasIds[3],
                'siswa_id'         => $sId,
                'path_file'        => 'pengumpulan/erd-siswa-' . ($i + 1) . '.pdf',
                'nilai'            => null,
                'status'           => 'dikumpulkan',
                'dikumpulkan_pada' => now()->subDays(rand(1, 3)),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 18. UJIAN
        // ─────────────────────────────────────────────
        $ujianIds = [];
        $ujianList = [
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'UTS Pemrograman Web Kelas X RPL 1', 'uts',           '2025-03-15', '08:00:00', 90],
            [$guruIds[0], $mapelIds[0], $kelasIds[1], 'UTS Pemrograman Web Kelas X RPL 2', 'uts',           '2025-03-15', '10:00:00', 90],
            [$guruIds[2], $mapelIds[3], $kelasIds[0], 'Ulangan Harian Matematika - Limit',  'ulangan_harian','2025-02-10', '07:00:00', 60],
            [$guruIds[6], $mapelIds[1], $kelasIds[2], 'UTS Basis Data XI RPL 1',            'uts',           '2025-03-17', '08:00:00', 90],
            [$guruIds[8], $mapelIds[2], $kelasIds[2], 'Quiz OOP - Class & Object',           'quiz',          '2025-02-20', '09:00:00', 45],
        ];
        foreach ($ujianList as [$gId, $mId, $kId, $judul, $jenis, $tgl, $jam, $durasi]) {
            $ujianIds[] = DB::table('ujian')->insertGetId([
                'guru_id'           => $gId,
                'mata_pelajaran_id' => $mId,
                'kelas_id'          => $kId,
                'tahun_ajaran_id'   => $tahunAjaranId,
                'judul'             => $judul,
                'jenis'             => $jenis,
                'tanggal'           => $tgl,
                'jam_mulai'         => $jam,
                'durasi_menit'      => $durasi,
                'nilai_kkm'         => 75,
                'is_active'         => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 19. NILAI
        // ─────────────────────────────────────────────
        foreach ($siswaIds as $i => $sId) {
            $kelasId = $kelasIds[$i % count($kelasIds)];
            // Nilai Pemrog Web
            $nt  = rand(70, 95); $nh = rand(65, 90); $uts = rand(60, 90); $uas = rand(65, 95);
            $na  = round(($nt * 0.2 + $nh * 0.3 + $uts * 0.2 + $uas * 0.3), 2);
            $pred = $na >= 90 ? 'A' : ($na >= 80 ? 'B' : ($na >= 70 ? 'C' : 'D'));
            DB::table('nilai')->insert([
                'siswa_id'          => $sId,
                'mata_pelajaran_id' => $mapelIds[0],
                'guru_id'           => $guruIds[0],
                'kelas_id'          => $kelasId,
                'tahun_ajaran_id'   => $tahunAjaranId,
                'nilai_tugas'       => $nt,
                'nilai_harian'      => $nh,
                'nilai_uts'         => $uts,
                'nilai_uas'         => $uas,
                'nilai_akhir'       => $na,
                'predikat'          => $pred,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
            // Nilai Matematika
            $nt2 = rand(65, 90); $nh2 = rand(60, 85); $uts2 = rand(55, 85); $uas2 = rand(60, 90);
            $na2 = round(($nt2 * 0.2 + $nh2 * 0.3 + $uts2 * 0.2 + $uas2 * 0.3), 2);
            $pred2 = $na2 >= 90 ? 'A' : ($na2 >= 80 ? 'B' : ($na2 >= 70 ? 'C' : 'D'));
            DB::table('nilai')->insert([
                'siswa_id'          => $sId,
                'mata_pelajaran_id' => $mapelIds[3],
                'guru_id'           => $guruIds[2],
                'kelas_id'          => $kelasId,
                'tahun_ajaran_id'   => $tahunAjaranId,
                'nilai_tugas'       => $nt2,
                'nilai_harian'      => $nh2,
                'nilai_uts'         => $uts2,
                'nilai_uas'         => $uas2,
                'nilai_akhir'       => $na2,
                'predikat'          => $pred2,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 20. JURNAL MENGAJAR
        // ─────────────────────────────────────────────
        $jurnalList = [
            [$guruIds[0], $kelasIds[0], $mapelIds[0], $jadwalIds[0], '2025-01-06', 1, 'Pengantar HTML: struktur dasar, tag heading, paragraf', 'Ceramah dan demonstrasi', 30, 0],
            [$guruIds[0], $kelasIds[0], $mapelIds[0], $jadwalIds[0], '2025-01-13', 2, 'CSS Dasar: selector, box model, warna dan font', 'Praktik terbimbing', 29, 1],
            [$guruIds[1], $kelasIds[0], $mapelIds[4], $jadwalIds[2], '2025-01-07', 1, 'Teks Laporan Perjalanan: struktur dan ciri kebahasaan', 'Diskusi kelompok', 30, 0],
            [$guruIds[2], $kelasIds[0], $mapelIds[3], $jadwalIds[4], '2025-01-08', 1, 'Limit Fungsi: definisi dan pendekatan nilai limit', 'Ceramah dan latihan soal', 28, 2],
            [$guruIds[6], $kelasIds[2], $mapelIds[1], $jadwalIds[9], '2025-01-06', 1, 'ERD: Entity, Atribut, dan Relationship', 'Demonstrasi dan tanya jawab', 35, 1],
        ];
        foreach ($jurnalList as [$gId, $kId, $mId, $jId, $tgl, $prt, $materi, $metode, $hadir, $tdk]) {
            DB::table('jurnal_mengajar')->insert([
                'guru_id'              => $gId,
                'kelas_id'             => $kId,
                'mata_pelajaran_id'    => $mId,
                'jadwal_pelajaran_id'  => $jId,
                'tanggal'              => $tgl,
                'pertemuan_ke'         => $prt,
                'materi_ajar'          => $materi,
                'metode_pembelajaran'  => $metode,
                'jumlah_hadir'         => $hadir,
                'jumlah_tidak_hadir'   => $tdk,
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 21. ABSENSI
        // ─────────────────────────────────────────────
        $statusAbsensi = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'telat', 'izin', 'sakit'];
        $tanggalAbsensi = ['2025-01-06', '2025-01-07', '2025-01-08', '2025-01-09', '2025-01-10'];

        foreach ($tanggalAbsensi as $tgl) {
            foreach ($siswaIds as $i => $sId) {
                $kelasId = $kelasIds[$i % count($kelasIds)];
                $status  = $statusAbsensi[array_rand($statusAbsensi)];
                DB::table('absensi')->insert([
                    'siswa_id'            => $sId,
                    'kelas_id'            => $kelasId,
                    'jadwal_pelajaran_id' => $jadwalIds[$i % count($jadwalIds)],
                    'dicatat_oleh'        => $guruUserIds[$i % count($guruUserIds)],
                    'tanggal'             => $tgl,
                    'status'              => $status,
                    'metode'              => 'manual',
                    'jam_masuk'           => $status === 'telat' ? '07:30:00' : '07:00:00',
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 22. KATEGORI PELANGGARAN
        // ─────────────────────────────────────────────
        $kategoriIds = [];
        $kategoriList = [
            ['Terlambat Masuk Kelas',    'Siswa terlambat masuk lebih dari 15 menit',  'ringan', 5,  50,  '#FFC107'],
            ['Tidak Berseragam Lengkap', 'Siswa tidak mengenakan seragam sesuai aturan','ringan', 5,  30,  '#FF9800'],
            ['Membawa HP Tanpa Izin',    'Membawa atau menggunakan HP di kelas',        'sedang', 15, 60,  '#F44336'],
            ['Perkelahian',              'Terlibat perkelahian di lingkungan sekolah',  'berat',  50, 150, '#9C27B0'],
            ['Tidak Mengerjakan Tugas',  'Berulang kali tidak mengumpulkan tugas',      'sedang', 10, 40,  '#2196F3'],
            ['Membolos',                 'Tidak hadir tanpa keterangan lebih dari 3 hari','sedang',20, 80,  '#795548'],
        ];
        foreach ($kategoriList as [$nama, $desk, $tingkat, $poin, $batas, $warna]) {
            $kategoriIds[] = DB::table('kategori_pelanggaran')->insertGetId([
                'nama'         => $nama,
                'deskripsi'    => $desk,
                'tingkat'      => $tingkat,
                'poin_default' => $poin,
                'batas_poin'   => $batas,
                'warna'        => $warna,
                'is_active'    => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 23. PELANGGARAN
        // ─────────────────────────────────────────────
        $pelanggaranData = [
            [$siswaIds[0],  $guruUserIds[1], $kategoriIds[0], 5,  'Terlambat 20 menit pada jam pertama',      '2025-01-07', 'pending' ],
            [$siswaIds[2],  $guruUserIds[0], $kategoriIds[2], 15, 'Ketahuan menggunakan HP saat pelajaran',    '2025-01-08', 'diproses'],
            [$siswaIds[5],  $guruUserIds[1], $kategoriIds[1], 5,  'Tidak memakai dasi saat upacara',           '2025-01-06', 'selesai' ],
            [$siswaIds[8],  $guruUserIds[2], $kategoriIds[4], 10, 'Belum mengumpulkan 3 tugas berturut-turut', '2025-01-09', 'diproses'],
            [$siswaIds[10], $guruUserIds[4], $kategoriIds[5], 20, 'Membolos 3 hari tanpa keterangan',          '2025-01-10', 'pending' ],
            [$siswaIds[14], $guruUserIds[1], $kategoriIds[0], 5,  'Terlambat saat jam pelajaran ke-3',         '2025-01-13', 'selesai' ],
            [$siswaIds[18], $guruUserIds[6], $kategoriIds[3], 50, 'Terlibat perkelahian di kantin sekolah',    '2025-01-14', 'banding' ],
        ];
        foreach ($pelanggaranData as [$sId, $uId, $kId, $poin, $desk, $tgl, $status]) {
            DB::table('pelanggaran')->insert([
                'siswa_id'                  => $sId,
                'dicatat_oleh'              => $uId,
                'kategori_pelanggaran_id'   => $kId,
                'poin'                      => $poin,
                'deskripsi'                 => $desk,
                'tanggal'                   => $tgl,
                'status'                    => $status,
                'tindakan'                  => $status === 'selesai' ? 'Siswa dipanggil dan diberikan pembinaan oleh wali kelas' : null,
                'diselesaikan_pada'         => $status === 'selesai' ? now()->subDays(rand(1, 5)) : null,
                'created_at'                => now(),
                'updated_at'                => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 24. PENGUMUMAN
        // ─────────────────────────────────────────────
        $pengumumanList = [
            ['Jadwal UTS Semester Genap 2024/2025',       'UTS akan dilaksanakan pada tanggal 10-15 Maret 2025. Harap semua siswa mempersiapkan diri dengan belajar materi yang telah diberikan.',                          'semua',      $adminUser],
            ['Libur Isra Mi\'raj 2025',                   'Diberitahukan bahwa tanggal 27 Januari 2025 diliburkan dalam rangka peringatan Isra Mi\'raj Nabi Muhammad SAW.',                                                 'semua',      $adminUser],
            ['Pengumpulan Tugas Pemrograman Web',         'Reminder: Batas akhir pengumpulan tugas membuat halaman profil HTML adalah Jumat, 24 Januari 2025 pukul 23:59. Pastikan file sudah diupload.',                   'siswa',      $guruUserIds[0]],
            ['Rapat Wali Kelas',                          'Seluruh guru wali kelas diharapkan hadir dalam rapat koordinasi pada hari Sabtu, 18 Januari 2025 pukul 09.00 WIB di Ruang Kepala Sekolah.',                     'guru',       $adminUser],
            ['Informasi Pembayaran SPP Bulan Januari',    'Pembayaran SPP bulan Januari 2025 paling lambat tanggal 10 Januari 2025. Harap orang tua/wali segera melakukan pembayaran agar tidak terkena sanksi administrasi.','orang_tua',  $adminUser],
        ];
        foreach ($pengumumanList as [$judul, $isi, $target, $dibuatOleh]) {
            DB::table('pengumuman')->insert([
                'judul'               => $judul,
                'isi'                 => $isi,
                'target_role'         => $target,
                'dibuat_oleh'         => $dibuatOleh,
                'dipublikasikan_pada' => now()->subDays(rand(1, 10)),
                'kadaluarsa_pada'     => now()->addDays(rand(7, 30)),
                'dipinned'            => false,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 25. NOTIFIKASI
        // ─────────────────────────────────────────────
        // Notifikasi untuk beberapa siswa
        foreach (array_slice($siswaUserIds, 0, 5) as $i => $uId) {
            DB::table('notifikasi')->insert([
                'pengguna_id'  => $uId,
                'judul'        => 'Tugas Baru: Membuat Halaman Profil HTML',
                'pesan'        => 'Guru Budi Santoso telah memberikan tugas baru pada mata pelajaran Pemrograman Web. Deadline: ' . now()->addDays(7)->format('d M Y'),
                'jenis'        => 'tugas',
                'url_tujuan'   => '/tugas/' . $tugasIds[0],
                'sudah_dibaca' => $i % 2 === 0,
                'dibaca_pada'  => $i % 2 === 0 ? now()->subHours(rand(1, 12)) : null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
        // Notifikasi pelanggaran untuk orang tua
        foreach (array_slice($orangTuaUserIds, 0, 3) as $uId) {
            DB::table('notifikasi')->insert([
                'pengguna_id'  => $uId,
                'judul'        => 'Pemberitahuan Pelanggaran Siswa',
                'pesan'        => 'Putra/putri Anda tercatat melakukan pelanggaran di sekolah. Silakan hubungi wali kelas untuk informasi lebih lanjut.',
                'jenis'        => 'pelanggaran',
                'url_tujuan'   => '/pelanggaran',
                'sudah_dibaca' => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
        // Notifikasi untuk semua guru
        foreach ($guruUserIds as $uId) {
            DB::table('notifikasi')->insert([
                'pengguna_id'  => $uId,
                'judul'        => 'Pengumuman: Rapat Koordinasi',
                'pesan'        => 'Rapat koordinasi guru akan dilaksanakan Sabtu, 18 Januari 2025 pukul 09.00 WIB di Ruang Kepala Sekolah.',
                'jenis'        => 'pengumuman',
                'url_tujuan'   => '/pengumuman',
                'sudah_dibaca' => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        $this->command->info(' Seeder selesai! Data dummy berhasil dibuat:');
        $this->command->info('   • 1 Admin    → admin@sims.sch.id');
        $this->command->info('   • 1 Guru Piket → piket@sims.sch.id');
        $this->command->info('   • 10 Guru');
        $this->command->info('   • 30 Siswa');
        $this->command->info('   • 15 Orang Tua');
        $this->command->info('   • Password semua user: password');
    }
}