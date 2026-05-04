<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
        // 1. PROFIL SEKOLAH
        // ─────────────────────────────────────────────
        DB::table('profil_sekolah')->insert([
            'nama_sekolah'       => 'SMK Bustanul Ulum',
            'singkatan'          => 'SMK BU',
            'npsn'               => '20580123',
            'nss'                => '342051801001',
            'akreditasi'         => 'A',
            'tahun_berdiri'      => 1998,
            'status_sekolah'     => 'Swasta',
            'jenjang'            => 'SMK',
            'alamat_lengkap'     => 'Jl. Pesantren Bustanul Ulum No. 1, Desa Tanjung',
            'desa_kelurahan'     => 'Tanjung',
            'kecamatan'          => 'Tanjung',
            'kabupaten_kota'     => 'Pamekasan',
            'provinsi'           => 'Jawa Timur',
            'kode_pos'           => '69371',
            'latitude'           => -7.1572,
            'longitude'          => 113.4779,
            'telepon'            => '(0324) 321001',
            'whatsapp'           => '081234560001',
            'email_sekolah'      => 'info@smkbustanululum.sch.id',
            'website'            => 'https://smkbustanululum.sch.id',
            'facebook_url'       => 'https://facebook.com/smkbu',
            'instagram_url'      => 'https://instagram.com/smkbustanululum',
            'youtube_url'        => 'https://youtube.com/@smkbustanululum',
            'nama_kepsek'        => 'H. Ahmad Syaifuddin, S.Pd., M.Pd.',
            'nip_kepsek'         => '197008151994121001',
            'sambutan_kepsek'    => 'Selamat datang di SMK Bustanul Ulum. Kami berkomitmen mencetak generasi unggul yang berakhlak mulia dan berdaya saing tinggi di bidang teknologi dan kejuruan.',
            'visi'               => 'Menjadi SMK unggulan yang menghasilkan lulusan berkarakter Islami, terampil, dan berdaya saing global di bidang teknologi.',
            'misi'               => "1. Menyelenggarakan pendidikan kejuruan berbasis nilai-nilai Islam.\n2. Mengembangkan kompetensi siswa sesuai kebutuhan industri.\n3. Membangun kemitraan dengan DU/DI untuk penempatan kerja.\n4. Mendorong inovasi dan kreativitas dalam pembelajaran.",
            'tujuan_sekolah'     => 'Menghasilkan lulusan yang kompeten, siap kerja, dan berakhlak mulia.',
            'sejarah_singkat'    => 'SMK Bustanul Ulum berdiri pada tahun 1998 di bawah naungan Yayasan Pondok Pesantren Bustanul Ulum.',
            'deskripsi_singkat'  => 'SMK Bustanul Ulum - Sekolah kejuruan Islami unggulan di Pamekasan dengan program keahlian teknologi.',
            'meta_title'         => 'SMK Bustanul Ulum Pamekasan | Sekolah Kejuruan Teknologi Islami',
            'meta_description'   => 'SMK Bustanul Ulum adalah sekolah menengah kejuruan swasta berbasis pesantren di Pamekasan, Jawa Timur.',
            'meta_keywords'      => 'SMK Bustanul Ulum, SMK Pamekasan, TKJ, RPL, SMK Islam',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // ─────────────────────────────────────────────
        // 2. USERS
        // ─────────────────────────────────────────────

        // Admin
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

        // Guru Piket
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

        // ─── 5 Guru ───
        // [nama, email_slug, no_hp, jenis_kelamin]
        $guruData = [
            ['Moh. Faishal Hadi, S.Kom',   'faishal.hadi@gmail.com',    '081211110001', 'L'], // 0 - Guru TKJ
            ['Miftahul Arifin, S.Kom',     'miftahul.arifin@gmail.com', '081211110002', 'L'], // 1 - Guru RPL
            ['Nurul Hidayah, S.Pd',        'nurul.hidayah@gmail.com',   '081211110003', 'P'], // 2 - Guru B.Indonesia / wali X TKJ 1
            ['Siti Aminah, S.Pd',          'siti.aminah@gmail.com',     '081211110004', 'P'], // 3 - Guru Matematika / wali X RPL 1
            ['Zuhriyah, S.Pd',             'zuhriyah@gmail.com',        '081211110005', 'P'], // 4 - Guru PAI / guru piket
        ];

        $guruUserIds = [];
        foreach ($guruData as [$name, $email, $hp, $jk]) {
            $guruUserIds[] = DB::table('users')->insertGetId([
                'name'              => $name,
                'email'             => $email,
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'guru',
                'no_hp'             => $hp,
                'is_active'         => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // ─── 20 Siswa ───
        // 10 di X TKJ 1, 10 di X RPL 1
        $siswaNames = [
            // X TKJ 1 (index 0–9)
            ['Abdurrahman Wahid',   'L'],
            ['Bagas Setiawan',      'L'],
            ['Choirul Anam',        'L'],
            ['Dina Maulidah',       'P'],
            ['Ekawati Putri',       'P'],
            ['Fathur Rozi',         'L'],
            ['Ghina Fauziyah',      'P'],
            ['Habibi Maulana',      'L'],
            ['Indah Permatasari',   'P'],
            ['Jamal Husain',        'L'],
            // X RPL 1 (index 10–19)
            ['Kholifah Nur',        'P'],
            ['Lutfiyah Aini',       'P'],
            ['M. Rizal Fahmi',      'L'],
            ['Nabilah Azzahra',     'P'],
            ['Omar Faruq',          'L'],
            ['Putri Ramadhani',     'P'],
            ['Rizky Pratama',       'L'],
            ['Siti Rohimah',        'P'],
            ['Taufiqurrahman',      'L'],
            ['Ulfatun Hasanah',     'P'],
        ];

        $siswaUserIds = [];
        foreach ($siswaNames as $i => [$name, $jk]) {
            $slug = strtolower(str_replace([' ', "'", '.'], ['.', '', ''], $name));
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

        // ─── 10 Orang Tua ───
        $orangTuaNames = [
            ['H. Wahid Hasyim',    '081233330001'],
            ['Hj. Maimunah',       '081233330002'],
            ['Sutrisno',           '081233330003'],
            ['Siti Fatimah',       '081233330004'],
            ['Moh. Arifin',        '081233330005'],
            ['Nur Laili',          '081233330006'],
            ['Hamzah Faturrahman', '081233330007'],
            ['Ruqayyah Hasanah',   '081233330008'],
            ['Abd. Aziz',          '081233330009'],
            ['Khotimatul Husna',   '081233330010'],
        ];

        $orangTuaUserIds = [];
        foreach ($orangTuaNames as $i => [$name, $hp]) {
            $slug = strtolower(str_replace([' ', '.', "'"], ['.', '', ''], $name));
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

        // Assign Spatie Roles
        \App\Models\User::find($adminUser)?->assignRole('admin');
        \App\Models\User::find($guruPiketUser)?->assignRole('guru_piket');
        foreach ($guruUserIds as $id)     { \App\Models\User::find($id)?->assignRole('guru'); }
        foreach ($siswaUserIds as $id)    { \App\Models\User::find($id)?->assignRole('siswa'); }
        foreach ($orangTuaUserIds as $id) { \App\Models\User::find($id)?->assignRole('orang_tua'); }

        // ─────────────────────────────────────────────
        // 3. TAHUN AJARAN
        // ─────────────────────────────────────────────
        $tahunAjaranId = DB::table('tahun_ajaran')->insertGetId([
            'tahun'           => '2024/2025',
            'semester'        => 'genap',
            'tanggal_mulai'   => '2025-01-06',
            'tanggal_selesai' => '2025-06-20',
            'status'          => 'aktif',
            'keterangan'      => 'Semester Genap TP 2024/2025',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        DB::table('tahun_ajaran')->insert([
            'tahun'           => '2024/2025',
            'semester'        => 'ganjil',
            'tanggal_mulai'   => '2024-07-15',
            'tanggal_selesai' => '2024-12-20',
            'status'          => 'tidak_aktif',
            'keterangan'      => 'Semester Ganjil TP 2024/2025',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // ─────────────────────────────────────────────
        // 4. JURUSAN (hanya TKJ & RPL)
        // ─────────────────────────────────────────────
        $jurusanIds = [];

        $jurusanIds[0] = DB::table('jurusan')->insertGetId([
            'nama'                  => 'Teknik Komputer dan Jaringan',
            'singkatan'             => 'TKJ',
            'slug'                  => 'teknik-komputer-jaringan',
            'kode_jurusan'          => 'TKJ-001',
            'bidang_keahlian'       => 'Teknologi Informasi dan Komunikasi',
            'program_keahlian'      => 'Teknik Komputer dan Informatika',
            'kompetensi_keahlian'   => 'Teknik Komputer dan Jaringan',
            'deskripsi_singkat'     => 'Mencetak teknisi jaringan komputer yang handal dan bersertifikat.',
            'deskripsi_lengkap'     => '<p>Jurusan TKJ membekali siswa dengan keterampilan instalasi, konfigurasi, dan pemeliharaan jaringan komputer.</p>',
            'tujuan_jurusan'        => 'Menghasilkan lulusan yang mampu merancang, membangun, dan mengelola infrastruktur jaringan komputer.',
            'lama_belajar'          => 3,
            'akreditasi'            => 'A',
            'kapasitas_per_kelas'   => 36,
            'jumlah_kelas_aktif'    => 2,
            'nama_kajur'            => 'Moh. Faishal Hadi, S.Kom',
            'is_published'          => true,
            'is_penerimaan_buka'    => true,
            'urutan'                => 1,
            'created_by'            => $adminUser,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        $jurusanIds[1] = DB::table('jurusan')->insertGetId([
            'nama'                  => 'Rekayasa Perangkat Lunak',
            'singkatan'             => 'RPL',
            'slug'                  => 'rekayasa-perangkat-lunak',
            'kode_jurusan'          => 'RPL-001',
            'bidang_keahlian'       => 'Teknologi Informasi dan Komunikasi',
            'program_keahlian'      => 'Teknik Komputer dan Informatika',
            'kompetensi_keahlian'   => 'Rekayasa Perangkat Lunak',
            'deskripsi_singkat'     => 'Mencetak programmer dan pengembang aplikasi yang kreatif dan profesional.',
            'deskripsi_lengkap'     => '<p>Jurusan RPL membekali siswa dengan kemampuan pemrograman, pengembangan web, dan aplikasi mobile.</p>',
            'tujuan_jurusan'        => 'Menghasilkan lulusan yang mampu merancang dan membangun perangkat lunak berkualitas.',
            'lama_belajar'          => 3,
            'akreditasi'            => 'A',
            'kapasitas_per_kelas'   => 36,
            'jumlah_kelas_aktif'    => 2,
            'nama_kajur'            => 'Miftahul Arifin, S.Kom',
            'is_published'          => true,
            'is_penerimaan_buka'    => true,
            'urutan'                => 2,
            'created_by'            => $adminUser,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        // ─────────────────────────────────────────────
        // 5. JURUSAN KURIKULUM
        // ─────────────────────────────────────────────
        $kurikulumData = [
            [$jurusanIds[0], 'Jaringan Dasar',                 'C2', 10, 1, 4],
            [$jurusanIds[0], 'Administrasi Sistem Jaringan',   'C3', 11, 1, 6],
            [$jurusanIds[0], 'Teknologi WAN',                  'C3', 12, 2, 6],
            [$jurusanIds[1], 'Pemrograman Dasar',              'C2', 10, 1, 4],
            [$jurusanIds[1], 'Pemrograman Web',                'C3', 11, 1, 6],
            [$jurusanIds[1], 'Basis Data',                     'C3', 11, 2, 4],
        ];
        foreach ($kurikulumData as $i => [$jId, $mapel, $kel, $kls, $sem, $jam]) {
            DB::table('jurusan_kurikulum')->insert([
                'jurusan_id'      => $jId,
                'nama_mapel'      => $mapel,
                'kelompok'        => $kel,
                'kelas'           => $kls,
                'semester'        => $sem,
                'jam_per_minggu'  => $jam,
                'urutan'          => $i + 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 6. JURUSAN KOMPETENSI
        // ─────────────────────────────────────────────
        $kompetensiData = [
            [$jurusanIds[0], 'Instalasi Jaringan LAN/WAN',          'server',        '#3B82F6'],
            [$jurusanIds[0], 'Konfigurasi Router & Switch',          'cpu-chip',      '#10B981'],
            [$jurusanIds[0], 'Keamanan Jaringan',                    'shield-check',  '#EF4444'],
            [$jurusanIds[1], 'Pengembangan Web (Frontend & Backend)', 'code-bracket',  '#6366F1'],
            [$jurusanIds[1], 'Pemrograman Mobile',                   'device-phone-mobile', '#F59E0B'],
            [$jurusanIds[1], 'Manajemen Basis Data',                 'circle-stack',  '#8B5CF6'],
        ];
        foreach ($kompetensiData as $i => [$jId, $nama, $ikon, $warna]) {
            DB::table('jurusan_kompetensi')->insert([
                'jurusan_id'      => $jId,
                'nama_kompetensi' => $nama,
                'ikon'            => $ikon,
                'badge_warna'     => $warna,
                'urutan'          => $i + 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 7. JURUSAN PROSPEK KERJA
        // ─────────────────────────────────────────────
        $prospekData = [
            [$jurusanIds[0], 'Network Engineer', 'IT & Telekomunikasi'],
            [$jurusanIds[0], 'IT Support',        'IT & Perusahaan'],
            [$jurusanIds[0], 'Teknisi Jaringan',  'IT & Infrastruktur'],
            [$jurusanIds[1], 'Web Developer',     'IT & Digital'],
            [$jurusanIds[1], 'Mobile Developer',  'IT & Digital'],
            [$jurusanIds[1], 'Software Engineer', 'IT & Industri'],
        ];
        foreach ($prospekData as $i => [$jId, $jabatan, $bidang]) {
            DB::table('jurusan_prospek_kerja')->insert([
                'jurusan_id'      => $jId,
                'jabatan'         => $jabatan,
                'bidang_industri' => $bidang,
                'urutan'          => $i + 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 8. GEDUNG
        // ─────────────────────────────────────────────
        $gedungIds = [];
        $gedungList = [
            ['GD-A', 'Gedung A (Utama)',       3, 'Gedung utama berisi ruang kelas X dan XI'],
            ['GD-B', 'Gedung B (Kejuruan)',    2, 'Gedung laboratorium komputer dan praktik kejuruan'],
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
        // 9. RUANG
        // ─────────────────────────────────────────────
        $ruangIds = [];
        $ruangList = [
            // [gedung_id, kode, nama, lantai, jenis, kap, proyektor, ac, wifi, komputer]
            [$gedungIds[0], 'R-101', 'Kelas X TKJ 1',  1, 'kelas',                 36,  true, false, true,  false],
            [$gedungIds[0], 'R-102', 'Kelas X RPL 1',  1, 'kelas',                 36,  true, false, true,  false],
            [$gedungIds[1], 'LAB-01','Lab Jaringan TKJ',1,'laboratorium_komputer',  36,  true, true,  true,  true ],
            [$gedungIds[1], 'LAB-02','Lab RPL / Coding',1,'laboratorium_komputer',  36,  true, true,  true,  true ],
        ];
        foreach ($ruangList as [$gId, $kode, $nama, $lantai, $jenis, $kap, $pry, $ac, $wifi, $pc]) {
            $ruangIds[] = DB::table('ruang')->insertGetId([
                'gedung_id'     => $gId,
                'kode_ruang'    => $kode,
                'nama_ruang'    => $nama,
                'lantai'        => $lantai,
                'jenis_ruang'   => $jenis,
                'kapasitas'     => $kap,
                'ada_proyektor' => $pry,
                'ada_ac'        => $ac,
                'ada_wifi'      => $wifi,
                'ada_komputer'  => $pc,
                'status'        => 'tersedia',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 10. MATA PELAJARAN
        // ─────────────────────────────────────────────
        $mapelIds = [];
        $mapelList = [
            // Produktif TKJ
            ['Jaringan Dasar',       'JD-001',  'produktif', 4, 45, true ],
            ['Administrasi Sistem Jaringan', 'ASJ-001', 'produktif', 6, 45, true],
            // Produktif RPL
            ['Pemrograman Web',      'PWB-001', 'produktif', 4, 45, true ],
            ['Basis Data',           'BDS-001', 'produktif', 4, 45, true ],
            // Umum
            ['Matematika',           'MTK-001', 'adaptif',   4, 45, false],
            ['Bahasa Indonesia',     'BIN-001', 'normatif',  3, 45, false],
            ['Bahasa Inggris',       'BIG-001', 'adaptif',   3, 45, false],
            ['Pendidikan Agama Islam','PAI-001', 'normatif',  3, 45, false],
        ];
        foreach ($mapelList as [$nama, $kode, $kel, $jam, $dur, $lab]) {
            $mapelIds[] = DB::table('mata_pelajaran')->insertGetId([
                'nama_mapel'      => $nama,
                'kode_mapel'      => $kode,
                'kelompok'        => $kel,
                'jam_per_minggu'  => $jam,
                'durasi_per_sesi' => $dur,
                'perlu_lab'       => $lab,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 11. GURU PROFIL
        // ─────────────────────────────────────────────
        // [user_id_idx, nip, nama, jk, tempat_lahir, tgl_lahir, pendidikan, jurusan_pend, univ, th_lulus, status, adalah_piket]
        $guruIds = [];
        $guruProfil = [
            [0, '198501012010011001', 'Moh. Faishal Hadi, S.Kom',  'L', 'Pamekasan', '1985-01-01', 'S1', 'Teknik Informatika',    'UTM',   2008, 'pns',    false],
            [1, '199105252014011005', 'Miftahul Arifin, S.Kom',    'L', 'Pamekasan', '1991-05-25', 'S1', 'Teknik Informatika',    'UTM',   2014, 'honorer',false],
            [2, '198703152011012002', 'Nurul Hidayah, S.Pd',       'P', 'Sumenep',   '1987-03-15', 'S1', 'Bahasa Indonesia',      'UNESA', 2010, 'pns',    true ],
            [3, '198812102013012004', 'Siti Aminah, S.Pd',         'P', 'Sampang',   '1988-12-10', 'S1', 'Matematika',            'UNESA', 2011, 'pns',    false],
            [4, '199001302017012008', 'Zuhriyah, S.Pd',            'P', 'Pamekasan', '1990-01-30', 'S1', 'Pendidikan Agama Islam', 'IAIN', 2013, 'honorer',true ],
        ];

        foreach ($guruProfil as $idx => [$uIdx, $nip, $nama, $jk, $tl, $ttl, $pend, $jur, $univ, $thLls, $statKep, $adlhPiket]) {
            $guruIds[] = DB::table('guru')->insertGetId([
                'pengguna_id'         => $guruUserIds[$uIdx],
                'nip'                 => $nip,
                'nama_lengkap'        => $nama,
                'jenis_kelamin'       => $jk,
                'tempat_lahir'        => $tl,
                'tanggal_lahir'       => $ttl,
                'alamat'              => 'Jl. Pesantren No.' . ($idx + 1) . ', ' . $tl,
                'no_hp'               => '08121111' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'email'               => $guruData[$uIdx][1], // email @gmail.com
                'pendidikan_terakhir' => $pend,
                'jurusan_pendidikan'  => $jur,
                'universitas'         => $univ,
                'tahun_lulus'         => $thLls,
                'status_kepegawaian'  => $statKep,
                'tanggal_masuk'       => '2020-07-13',
                'adalah_guru_piket'   => $adlhPiket,
                'status'              => 'aktif',
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 12. KELAS (X TKJ 1 & X RPL 1)
        // ─────────────────────────────────────────────
        $kelasIds = [];

        // X TKJ 1 — wali kelas: Nurul Hidayah (guruIds[2])
        $kelasIds[0] = DB::table('kelas')->insertGetId([
            'nama_kelas'      => 'X TKJ 1',
            'tingkat'         => 'X',
            'jurusan_id'      => $jurusanIds[0],
            'kode_kelas'      => 'TKJ-X-1',
            'wali_kelas_id'   => $guruIds[2],
            'ruang_id'        => $ruangIds[0],
            'tahun_ajaran_id' => $tahunAjaranId,
            'kapasitas_maks'  => 36,
            'status'          => 'aktif',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // X RPL 1 — wali kelas: Siti Aminah (guruIds[3])
        $kelasIds[1] = DB::table('kelas')->insertGetId([
            'nama_kelas'      => 'X RPL 1',
            'tingkat'         => 'X',
            'jurusan_id'      => $jurusanIds[1],
            'kode_kelas'      => 'RPL-X-1',
            'wali_kelas_id'   => $guruIds[3],
            'ruang_id'        => $ruangIds[1],
            'tahun_ajaran_id' => $tahunAjaranId,
            'kapasitas_maks'  => 36,
            'status'          => 'aktif',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // ─────────────────────────────────────────────
        // 13. SISWA PROFIL
        // ─────────────────────────────────────────────
        $agamaList     = ['Islam', 'Islam', 'Islam', 'Islam', 'Kristen'];
        $pekerjaanList = ['Petani', 'Wiraswasta', 'PNS', 'Pedagang', 'Nelayan', 'Karyawan Swasta'];
        $kotaList      = ['Pamekasan', 'Sumenep', 'Bangkalan', 'Sampang'];

        $siswaIds = [];
        foreach ($siswaNames as $i => [$namaLengkap, $jk]) {
            // 10 siswa pertama → X TKJ 1, 10 siswa berikutnya → X RPL 1
            $kelasId = $i < 10 ? $kelasIds[0] : $kelasIds[1];
            $nis     = '2024' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $nisn    = '00' . str_pad(100001 + $i, 8, '0', STR_PAD_LEFT);

            $siswaIds[] = DB::table('siswa')->insertGetId([
                'pengguna_id'    => $siswaUserIds[$i],
                'nis'            => $nis,
                'nisn'           => $nisn,
                'nama_lengkap'   => $namaLengkap,
                'jenis_kelamin'  => $jk,
                'tempat_lahir'   => $kotaList[$i % count($kotaList)],
                'tanggal_lahir'  => date('Y-m-d', strtotime('2007-01-01 +' . ($i * 25) . ' days')),
                'agama'          => $agamaList[$i % count($agamaList)],
                'alamat'         => 'Jl. Pesantren No.' . ($i + 1) . ', ' . $kotaList[$i % count($kotaList)],
                'no_hp'          => '0856' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'email'          => strtolower(str_replace([' ', "'", '.'], ['.', '', ''], $namaLengkap)) . '@gmail.com',
                'nama_ayah'      => 'H. Ayah ' . explode(' ', $namaLengkap)[0],
                'pekerjaan_ayah' => $pekerjaanList[$i % count($pekerjaanList)],
                'no_hp_ayah'     => '0813' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'nama_ibu'       => 'Hj. Ibu ' . explode(' ', $namaLengkap)[0],
                'pekerjaan_ibu'  => $pekerjaanList[($i + 2) % count($pekerjaanList)],
                'no_hp_ibu'      => '0814' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'kelas_id'       => $kelasId,
                'tahun_ajaran_id'=> $tahunAjaranId,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2024-07-15',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 14. ORANG TUA PROFIL
        // ─────────────────────────────────────────────
        $orangTuaIds = [];
        foreach ($orangTuaNames as $i => [$nama, $hp]) {
            $orangTuaIds[] = DB::table('orang_tua')->insertGetId([
                'pengguna_id'  => $orangTuaUserIds[$i],
                'nama_lengkap' => $nama,
                'no_hp'        => $hp,
                'email'        => strtolower(str_replace([' ', '.', "'"], ['.', '', ''], $nama)) . '@gmail.com',
                'alamat'       => 'Jl. Keluarga No.' . ($i + 1) . ', Pamekasan',
                'pekerjaan'    => $pekerjaanList[$i % count($pekerjaanList)],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 15. SISWA ORANG TUA (pivot)
        // ─────────────────────────────────────────────
        foreach ($siswaIds as $i => $siswaId) {
            $otId = $orangTuaIds[$i % count($orangTuaIds)];
            $exists = DB::table('siswa_orang_tua')
                ->where('siswa_id', $siswaId)
                ->where('orang_tua_id', $otId)
                ->exists();
            if (!$exists) {
                DB::table('siswa_orang_tua')->insert([
                    'siswa_id'     => $siswaId,
                    'orang_tua_id' => $otId,
                    'hubungan'     => ($i % 2 === 0) ? 'ayah' : 'ibu',
                    'kontak_utama' => true,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 16. KETERSEDIAAN GURU
        // ─────────────────────────────────────────────
        $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        foreach ($guruIds as $guruId) {
            foreach ($hari as $h) {
                DB::table('ketersediaan_guru')->insert([
                    'guru_id'     => $guruId,
                    'hari'        => $h,
                    'jam_mulai'   => '07:00:00',
                    'jam_selesai' => '14:00:00',
                    'tersedia'    => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 17. JADWAL PELAJARAN
        // ─────────────────────────────────────────────
        // [guru_idx, mapel_idx, kelas_idx, ruang_idx, hari, jam_mulai, jam_selesai]
        $jadwalList = [
            [0, 0, 0, 2, 'senin',  '07:00:00', '08:30:00'], // Faishal  - Jaringan Dasar   - X TKJ 1 - Lab TKJ
            [0, 0, 0, 2, 'rabu',   '07:00:00', '08:30:00'], // Faishal  - Jaringan Dasar   - X TKJ 1 - Lab TKJ
            [1, 2, 1, 3, 'senin',  '07:00:00', '08:30:00'], // Arifin   - Pemrograman Web  - X RPL 1 - Lab RPL
            [1, 2, 1, 3, 'rabu',   '07:00:00', '08:30:00'], // Arifin   - Pemrograman Web  - X RPL 1 - Lab RPL
            [1, 3, 1, 3, 'selasa', '07:00:00', '08:30:00'], // Arifin   - Basis Data       - X RPL 1 - Lab RPL
            [3, 4, 0, 0, 'selasa', '08:45:00', '10:15:00'], // Aminah   - Matematika       - X TKJ 1 - R-101
            [3, 4, 1, 1, 'kamis',  '08:45:00', '10:15:00'], // Aminah   - Matematika       - X RPL 1 - R-102
            [2, 5, 0, 0, 'rabu',   '08:45:00', '10:15:00'], // Hidayah  - B. Indonesia     - X TKJ 1 - R-101
            [2, 5, 1, 1, 'jumat',  '08:45:00', '10:15:00'], // Hidayah  - B. Indonesia     - X RPL 1 - R-102
            [4, 7, 0, 0, 'jumat',  '07:00:00', '08:30:00'], // Zuhriyah - PAI              - X TKJ 1 - R-101
            [4, 7, 1, 1, 'kamis',  '07:00:00', '08:30:00'], // Zuhriyah - PAI              - X RPL 1 - R-102
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
        // 18. JADWAL PIKET GURU
        // ─────────────────────────────────────────────
        $piketGuruIds = [$guruIds[2], $guruIds[4]]; // Hidayah & Zuhriyah
        foreach ($piketGuruIds as $pgId) {
            foreach ($hari as $h) {
                DB::table('jadwal_piket_guru')->insert([
                    'guru_id'         => $pgId,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'hari'            => $h,
                    'jam_mulai'       => '07:00:00',
                    'jam_selesai'     => '14:00:00',
                    'catatan'         => 'Jadwal piket rutin mingguan',
                    'is_active'       => true,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 19. LOG PIKET
        // ─────────────────────────────────────────────
        $logPiketData = [
            [$piketGuruIds[0], '2025-01-06', 'pagi', '2025-01-06 07:00:00', '2025-01-06 14:00:00'],
            [$piketGuruIds[1], '2025-01-07', 'pagi', '2025-01-07 07:05:00', '2025-01-07 14:00:00'],
            [$piketGuruIds[0], '2025-01-08', 'pagi', '2025-01-08 06:58:00', '2025-01-08 14:00:00'],
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
        // 20. MATERI
        // ─────────────────────────────────────────────
        $materiList = [
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'Pengantar Jaringan Komputer',  'Konsep dasar jaringan, topologi, dan protokol',   'file', 'materi/jaringan-dasar.pdf'],
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'Pengkabelan UTP & STP',        'Cara membuat kabel UTP straight dan crossover',   'file', 'materi/pengkabelan.pdf'],
            [$guruIds[1], $mapelIds[2], $kelasIds[1], 'HTML5 Struktur Dasar',         'Tag-tag dasar HTML5 dan semantik web',             'file', 'materi/html5-dasar.pdf'],
            [$guruIds[1], $mapelIds[2], $kelasIds[1], 'CSS3 & Flexbox',               'Styling modern dengan CSS3 dan Flexbox layout',   'link', null],
            [$guruIds[1], $mapelIds[3], $kelasIds[1], 'Normalisasi Basis Data',       '1NF, 2NF, 3NF dengan studi kasus nyata',          'file', 'materi/normalisasi.pdf'],
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
                'url_eksternal'       => $jenis === 'link' ? 'https://css-tricks.com/snippets/css/a-guide-to-flexbox/' : null,
                'urutan'              => $i + 1,
                'dipublikasikan'      => true,
                'dipublikasikan_pada' => now()->subDays(rand(1, 15)),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 21. TUGAS
        // ─────────────────────────────────────────────
        $tugasIds = [];
        $tugasList = [
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'Membuat Topologi Jaringan Sederhana', 'Rancang topologi star/bus menggunakan Cisco Packet Tracer', 'file', now()->addDays(7)],
            [$guruIds[1], $mapelIds[2], $kelasIds[1], 'Membuat Halaman Profil Web',          'Buat halaman profil pribadi menggunakan HTML5 dan CSS3',   'file', now()->addDays(7)],
            [$guruIds[1], $mapelIds[3], $kelasIds[1], 'ERD Sistem Informasi Perpustakaan',   'Buat ERD lengkap beserta normalisasi sampai 3NF',           'file', now()->addDays(10)],
            [$guruIds[3], $mapelIds[4], $kelasIds[0], 'Soal Latihan Matriks',                'Kerjakan 20 soal matriks dan determinan',                   'teks', now()->addDays(3)],
        ];
        foreach ($tugasList as [$gId, $mId, $kId, $judul, $desk, $jenis, $batas]) {
            $tugasIds[] = DB::table('tugas')->insertGetId([
                'guru_id'           => $gId,
                'mata_pelajaran_id' => $mId,
                'kelas_id'          => $kId,
                'tahun_ajaran_id'   => $tahunAjaranId,
                'judul'             => $judul,
                'deskripsi'         => $desk,
                'jenis_pengumpulan' => $jenis,
                'batas_waktu'       => $batas,
                'nilai_maksimal'    => 100,
                'izinkan_terlambat' => false,
                'dipublikasikan'    => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 22. PENGUMPULAN TUGAS
        // ─────────────────────────────────────────────
        // 8 siswa X TKJ 1 kumpul tugas topologi
        foreach (array_slice($siswaIds, 0, 8) as $i => $sId) {
            DB::table('pengumpulan_tugas')->insert([
                'tugas_id'         => $tugasIds[0],
                'siswa_id'         => $sId,
                'path_file'        => 'pengumpulan/topologi-' . ($i + 1) . '.pkt',
                'nilai'            => rand(75, 100),
                'umpan_balik'      => $i % 2 === 0 ? 'Topologi sudah benar dan rapi' : 'Cukup baik, perbaiki labeling',
                'status'           => 'dinilai',
                'dikumpulkan_pada' => now()->subDays(rand(1, 4)),
                'dinilai_pada'     => now()->subDays(rand(0, 2)),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        // 6 siswa X RPL 1 kumpul tugas web
        foreach (array_slice($siswaIds, 10, 6) as $i => $sId) {
            DB::table('pengumpulan_tugas')->insert([
                'tugas_id'         => $tugasIds[1],
                'siswa_id'         => $sId,
                'path_file'        => 'pengumpulan/web-profil-' . ($i + 1) . '.zip',
                'nilai'            => null,
                'status'           => 'dikumpulkan',
                'dikumpulkan_pada' => now()->subDays(rand(1, 3)),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 23. UJIAN
        // ─────────────────────────────────────────────
        $ujianIds = [];
        $ujianList = [
            [$guruIds[0], $mapelIds[0], $kelasIds[0], 'UTS Jaringan Dasar X TKJ 1',    'uts',            '2025-03-15', '08:00:00', 90],
            [$guruIds[1], $mapelIds[2], $kelasIds[1], 'UTS Pemrograman Web X RPL 1',   'uts',            '2025-03-15', '10:00:00', 90],
            [$guruIds[3], $mapelIds[4], $kelasIds[0], 'Ulangan Harian Matematika',     'ulangan_harian', '2025-02-10', '07:00:00', 60],
            [$guruIds[1], $mapelIds[3], $kelasIds[1], 'Quiz Basis Data - ERD',         'quiz',           '2025-02-20', '09:00:00', 45],
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
        // 24. NILAI
        // ─────────────────────────────────────────────
        foreach ($siswaIds as $i => $sId) {
            $kelasId    = $i < 10 ? $kelasIds[0] : $kelasIds[1];
            $mapelProd  = $i < 10 ? $mapelIds[0] : $mapelIds[2]; // JD atau PWB
            $guruProd   = $i < 10 ? $guruIds[0]  : $guruIds[1];

            // Nilai Produktif
            $nt = rand(70, 98); $nh = rand(68, 95); $uts = rand(65, 92); $uas = rand(70, 98);
            $na = round($nt * 0.2 + $nh * 0.3 + $uts * 0.2 + $uas * 0.3, 2);
            $pred = $na >= 90 ? 'A' : ($na >= 80 ? 'B' : ($na >= 70 ? 'C' : 'D'));

            $exists = DB::table('nilai')
                ->where('siswa_id', $sId)
                ->where('mata_pelajaran_id', $mapelProd)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->exists();
            if (!$exists) {
                DB::table('nilai')->insert([
                    'siswa_id'          => $sId,
                    'mata_pelajaran_id' => $mapelProd,
                    'guru_id'           => $guruProd,
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
            }

            // Nilai Matematika
            $nt2 = rand(60, 90); $nh2 = rand(60, 88); $uts2 = rand(58, 85); $uas2 = rand(62, 90);
            $na2 = round($nt2 * 0.2 + $nh2 * 0.3 + $uts2 * 0.2 + $uas2 * 0.3, 2);
            $pred2 = $na2 >= 90 ? 'A' : ($na2 >= 80 ? 'B' : ($na2 >= 70 ? 'C' : 'D'));

            $exists2 = DB::table('nilai')
                ->where('siswa_id', $sId)
                ->where('mata_pelajaran_id', $mapelIds[4])
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->exists();
            if (!$exists2) {
                DB::table('nilai')->insert([
                    'siswa_id'          => $sId,
                    'mata_pelajaran_id' => $mapelIds[4],
                    'guru_id'           => $guruIds[3],
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
        }

        // ─────────────────────────────────────────────
        // 25. JURNAL MENGAJAR
        // ─────────────────────────────────────────────
        $jurnalList = [
            [$guruIds[0], $kelasIds[0], $mapelIds[0], $jadwalIds[0],  '2025-01-06', 1, 'Pengantar jaringan komputer: definisi, manfaat, dan jenis jaringan', 'Ceramah dan tanya jawab',   10, 0],
            [$guruIds[0], $kelasIds[0], $mapelIds[0], $jadwalIds[0],  '2025-01-13', 2, 'Topologi jaringan: star, bus, ring, mesh',                           'Demonstrasi Packet Tracer', 9,  1],
            [$guruIds[1], $kelasIds[1], $mapelIds[2], $jadwalIds[2],  '2025-01-06', 1, 'Struktur dasar HTML5: head, body, tag semantik',                     'Praktik coding langsung',   10, 0],
            [$guruIds[1], $kelasIds[1], $mapelIds[2], $jadwalIds[2],  '2025-01-08', 2, 'CSS3: selector, box model, warna, dan font',                         'Praktik terbimbing',        9,  1],
            [$guruIds[3], $kelasIds[0], $mapelIds[4], $jadwalIds[5],  '2025-01-07', 1, 'Pengantar matriks dan operasi dasar',                                'Ceramah dan latihan soal',  10, 0],
        ];
        foreach ($jurnalList as [$gId, $kId, $mId, $jId, $tgl, $prt, $materi, $metode, $hadir, $tdk]) {
            DB::table('jurnal_mengajar')->insert([
                'guru_id'             => $gId,
                'kelas_id'            => $kId,
                'mata_pelajaran_id'   => $mId,
                'jadwal_pelajaran_id' => $jId,
                'tanggal'             => $tgl,
                'pertemuan_ke'        => $prt,
                'materi_ajar'         => $materi,
                'metode_pembelajaran' => $metode,
                'jumlah_hadir'        => $hadir,
                'jumlah_tidak_hadir'  => $tdk,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 26. ABSENSI SISWA
        // ─────────────────────────────────────────────
        $statusAbsensi  = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'telat', 'izin', 'sakit'];
        $tanggalAbsensi = ['2025-01-06', '2025-01-07', '2025-01-08', '2025-01-09', '2025-01-10'];

        foreach ($tanggalAbsensi as $tgl) {
            foreach ($siswaIds as $i => $sId) {
                $kelasId = $i < 10 ? $kelasIds[0] : $kelasIds[1];
                $status  = $statusAbsensi[array_rand($statusAbsensi)];
                $exists  = DB::table('absensi')
                    ->where('siswa_id', $sId)
                    ->where('tanggal', $tgl)
                    ->where('kelas_id', $kelasId)
                    ->exists();
                if (!$exists) {
                    DB::table('absensi')->insert([
                        'siswa_id'            => $sId,
                        'kelas_id'            => $kelasId,
                        'jadwal_pelajaran_id' => $jadwalIds[$i % count($jadwalIds)],
                        'dicatat_oleh'        => $guruUserIds[$i % count($guruUserIds)],
                        'tanggal'             => $tgl,
                        'status'              => $status,
                        'metode'              => 'manual',
                        'jam_masuk'           => $status === 'telat' ? '07:25:00' : '07:00:00',
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ]);
                }
            }
        }

        // ─────────────────────────────────────────────
        // 27. ABSENSI GURU
        // ─────────────────────────────────────────────
        $statusGuru = ['hadir', 'hadir', 'hadir', 'hadir', 'telat', 'izin'];
        foreach ($tanggalAbsensi as $tgl) {
            foreach ($guruIds as $i => $gId) {
                $status = $statusGuru[array_rand($statusGuru)];
                DB::table('absensi_guru')->insert([
                    'guru_id'      => $gId,
                    'dicatat_oleh' => $guruPiketUser,
                    'tanggal'      => $tgl,
                    'jam_masuk'    => $status === 'telat' ? '07:20:00' : '07:00:00',
                    'jam_keluar'   => '14:00:00',
                    'status'       => $status,
                    'metode'       => 'manual',
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        // ─────────────────────────────────────────────
        // 28. LAPORAN HARIAN PIKET
        // ─────────────────────────────────────────────
        $laporanData = [
            ['2025-01-06', 'Kondisi sekolah kondusif. Upacara bendera berjalan lancar.', null,                                      'Memastikan semua siswa terlambat mendapat surat izin masuk.'],
            ['2025-01-07', 'Kondisi sekolah normal. Ada 2 siswa terlambat.',             'Siswa kelas X TKJ 1 kedapatan merokok di toilet.', 'Siswa dipanggil ke BK untuk pembinaan.'],
            ['2025-01-08', 'Kondisi baik. Hujan deras jam 10.00 WIB.',                  null,                                      'Mengarahkan siswa agar tidak keluar kelas saat hujan.'],
        ];
        foreach ($laporanData as $i => [$tgl, $catatan, $kejadian, $tindak]) {
            DB::table('laporan_harian_piket')->insert([
                'dibuat_oleh'        => $guruPiketUser,
                'tanggal'            => $tgl,
                'catatan_umum'       => $catatan,
                'kejadian_khusus'    => $kejadian,
                'tindak_lanjut'      => $tindak,
                'rekap_absensi'      => json_encode(['hadir' => 18 - $i, 'izin' => $i, 'sakit' => 0, 'alfa' => 0]),
                'jumlah_pelanggaran' => $i,
                'kondisi_sekolah'    => 'Baik',
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 29. KATEGORI PELANGGARAN
        // ─────────────────────────────────────────────
        $kategoriIds = [];
        $kategoriList = [
            ['Terlambat Masuk',          'Masuk sekolah/kelas lebih dari 15 menit',    'ringan', 5,  50,  '#FFC107'],
            ['Tidak Berseragam Lengkap', 'Seragam tidak sesuai ketentuan sekolah',      'ringan', 5,  30,  '#FF9800'],
            ['Membawa HP Tanpa Izin',    'Membawa/menggunakan HP saat KBM',             'sedang', 15, 60,  '#F44336'],
            ['Membolos',                 'Tidak hadir tanpa keterangan > 3 hari',       'sedang', 20, 80,  '#795548'],
            ['Merokok di Sekolah',       'Merokok di area lingkungan sekolah',          'berat',  40, 120, '#E53935'],
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
        // 30. PELANGGARAN
        // ─────────────────────────────────────────────
        $pelanggaranData = [
            [$siswaIds[0],  $guruUserIds[2], $kategoriIds[0], 5,  'Terlambat 20 menit, pintu gerbang sudah ditutup',   '2025-01-07', 'selesai' ],
            [$siswaIds[2],  $guruUserIds[0], $kategoriIds[2], 15, 'Ketahuan menggunakan HP saat praktik jaringan',      '2025-01-08', 'diproses'],
            [$siswaIds[5],  $guruUserIds[2], $kategoriIds[1], 5,  'Tidak memakai dasi saat hari Senin',                '2025-01-06', 'selesai' ],
            [$siswaIds[10], $guruUserIds[1], $kategoriIds[2], 15, 'Menggunakan HP saat pelajaran pemrograman web',      '2025-01-09', 'diproses'],
            [$siswaIds[12], $guruUserIds[2], $kategoriIds[4], 40, 'Ketahuan merokok di toilet lantai 1 GD-A',          '2025-01-07', 'banding' ],
        ];
        foreach ($pelanggaranData as [$sId, $uId, $kId, $poin, $desk, $tgl, $status]) {
            DB::table('pelanggaran')->insert([
                'siswa_id'                => $sId,
                'dicatat_oleh'            => $uId,
                'kategori_pelanggaran_id' => $kId,
                'poin'                    => $poin,
                'deskripsi'               => $desk,
                'tanggal'                 => $tgl,
                'status'                  => $status,
                'tindakan'                => $status === 'selesai' ? 'Siswa dipanggil dan mendapat pembinaan wali kelas' : null,
                'diselesaikan_pada'       => $status === 'selesai' ? now()->subDays(rand(1, 5)) : null,
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 31. IZIN KELUAR SISWA
        // ─────────────────────────────────────────────
        $izinData = [
            [$siswaIds[0],  '2025-01-08', '09:00', '11:00', 'Ke Puskesmas untuk periksa kesehatan',      'berobat',           'disetujui'   ],
            [$siswaIds[3],  '2025-01-09', '10:00', '13:00', 'Keperluan administrasi KK di Disdukcapil',  'keperluan_keluarga','disetujui'   ],
            [$siswaIds[10], '2025-01-10', '11:00', '12:00', 'Menjemput adik di SD karena orang tua sakit','keperluan_keluarga','menunggu'   ],
            [$siswaIds[13], '2025-01-13', '08:00', '10:00', 'Ambil hasil lab kesehatan di klinik',       'berobat',           'sudah_kembali'],
        ];
        foreach ($izinData as $i => [$sId, $tgl, $keluar, $kembali, $tujuan, $kategori, $status]) {
            DB::table('izin_keluar_siswa')->insert([
                'siswa_id'        => $sId,
                'tahun_ajaran_id' => $tahunAjaranId,
                'tanggal'         => $tgl,
                'jam_keluar'      => $keluar,
                'jam_kembali'     => $kembali,
                'tujuan'          => $tujuan,
                'kategori'        => $kategori,
                'status'          => $status,
                'diproses_oleh'   => $status !== 'menunggu' ? $guruPiketUser : null,
                'diproses_pada'   => $status !== 'menunggu' ? now()->subHours(rand(1, 5)) : null,
                'nomor_surat'     => in_array($status, ['disetujui', 'sudah_kembali'])
                    ? 'IZN/2025/' . str_pad($i + 1, 4, '0', STR_PAD_LEFT)
                    : null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 32. PENGUMUMAN
        // ─────────────────────────────────────────────
        $pengumumanList = [
            ['Jadwal UTS Semester Genap 2024/2025',  'UTS dilaksanakan 10-15 Maret 2025. Seluruh siswa wajib hadir.',                                                 'semua',     $adminUser],
            ['Libur Isra Mi\'raj 1446 H',            'Senin, 27 Januari 2025 libur nasional peringatan Isra Mi\'raj. KBM ditiadakan.',                                'semua',     $adminUser],
            ['Reminder: Kumpul Tugas Pemrograman Web','Batas pengumpulan tugas halaman web profil: Jumat 24 Jan 2025 pukul 23.59. Upload ke sistem.',                  'siswa',     $guruUserIds[1]],
            ['Rapat Koordinasi Wali Kelas',           'Wali kelas hadir Sabtu 18 Jan 2025 pukul 09.00 di Ruang Kepala Sekolah. Agenda: evaluasi akademik.',            'guru',      $adminUser],
            ['Info Pembayaran SPP Januari 2025',      'Bayar SPP paling lambat 10 Januari 2025. Hubungi bendahara untuk info lebih lanjut.',                           'orang_tua', $adminUser],
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
        // 33. NOTIFIKASI
        // ─────────────────────────────────────────────
        foreach (array_slice($siswaUserIds, 0, 8) as $i => $uId) {
            DB::table('notifikasi')->insert([
                'pengguna_id'  => $uId,
                'judul'        => 'Tugas Baru: Membuat Halaman Web Profil',
                'pesan'        => 'Guru Miftahul Arifin memberikan tugas baru Pemrograman Web. Deadline: ' . now()->addDays(7)->format('d M Y'),
                'jenis'        => 'tugas',
                'url_tujuan'   => '/tugas/' . ($tugasIds[1] ?? 2),
                'sudah_dibaca' => $i % 2 === 0,
                'dibaca_pada'  => $i % 2 === 0 ? now()->subHours(rand(1, 8)) : null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
        foreach (array_slice($orangTuaUserIds, 0, 3) as $uId) {
            DB::table('notifikasi')->insert([
                'pengguna_id'  => $uId,
                'judul'        => 'Pemberitahuan Pelanggaran Siswa',
                'pesan'        => 'Putra/putri Anda tercatat melakukan pelanggaran di sekolah. Mohon hubungi wali kelas.',
                'jenis'        => 'pelanggaran',
                'url_tujuan'   => '/pelanggaran',
                'sudah_dibaca' => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
        foreach ($guruUserIds as $uId) {
            DB::table('notifikasi')->insert([
                'pengguna_id'  => $uId,
                'judul'        => 'Rapat Koordinasi Guru',
                'pesan'        => 'Rapat koordinasi guru Sabtu 18 Jan 2025 pukul 09.00 di Ruang Kepala Sekolah. Wajib hadir.',
                'jenis'        => 'pengumuman',
                'url_tujuan'   => '/pengumuman',
                'sudah_dibaca' => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 34. GALERI KATEGORI
        // ─────────────────────────────────────────────
        $galeriKategoriIds = [];
        $galeriKategoriList = [
            ['Kegiatan Belajar Mengajar', 'kegiatan-belajar-mengajar', 'Dokumentasi kegiatan KBM di kelas dan lab', 'foto'],
            ['Prestasi & Lomba',          'prestasi-lomba',            'Dokumentasi prestasi dan lomba siswa',       'foto'],
            ['Sarana & Prasarana',        'sarana-prasarana',          'Foto gedung, lab, dan fasilitas sekolah',    'foto'],
        ];
        foreach ($galeriKategoriList as $i => [$nama, $slug, $desk, $tipe]) {
            $galeriKategoriIds[] = DB::table('galeri_kategori')->insertGetId([
                'nama'         => $nama,
                'slug'         => $slug,
                'deskripsi'    => $desk,
                'tipe'         => $tipe,
                'is_published' => true,
                'urutan'       => $i + 1,
                'created_by'   => $adminUser,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 35. GALERI FOTO
        // ─────────────────────────────────────────────
        $galeriList = [
            [$galeriKategoriIds[0], 'Praktik Jaringan TKJ', 'Siswa TKJ sedang praktik pengkabelan UTP di Lab Jaringan', true,  false],
            [$galeriKategoriIds[0], 'Coding Bersama RPL',   'Siswa RPL belajar HTML5 dan CSS3 di Lab Komputer',         false, false],
            [$galeriKategoriIds[1], 'Juara LKS TKJ 2024',   'Siswa TKJ meraih Juara 1 LKS Tingkat Kabupaten 2024',      true,  true ],
            [$galeriKategoriIds[2], 'Lab Komputer RPL',      'Fasilitas Lab Komputer jurusan RPL dengan 36 unit PC',     true,  false],
            [$galeriKategoriIds[2], 'Lab Jaringan TKJ',      'Lab Jaringan dengan perangkat Cisco lengkap',              false, true ],
        ];
        foreach ($galeriList as $i => [$katId, $judul, $ket, $isPub, $isFeat]) {
            DB::table('galeri_foto')->insert([
                'galeri_kategori_id' => $katId,
                'judul'              => $judul,
                'keterangan'         => $ket,
                'foto_path'          => 'galeri/foto-' . ($i + 1) . '.jpg',
                'alt_text'           => $judul . ' - SMK Bustanul Ulum',
                'sumber'             => 'Dokumentasi SMK Bustanul Ulum',
                'tanggal_foto'       => now()->subDays(rand(10, 90))->format('Y-m-d'),
                'is_published'       => $isPub,
                'is_featured'        => $isFeat,
                'urutan'             => $i + 1,
                'uploaded_by'        => $adminUser,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 36. PRESTASI
        // ─────────────────────────────────────────────
        $prestasiList = [
            ['Juara 1 LKS TKJ Kabupaten Pamekasan 2024', 'kabupaten', 'Teknologi Informasi', 'LKS SMK 2024',   'Dinas Pendidikan Pamekasan', 'Juara 1', '2024-11-15', $siswaIds[0],  $jurusanIds[0]],
            ['Best Project Web Design Competition Jatim', 'provinsi',  'Teknologi Informasi', 'Web Design Jatim','Kemendikbud Jawa Timur',    'Juara 2', '2024-09-05', $siswaIds[10], $jurusanIds[1]],
        ];
        foreach ($prestasiList as [$judul, $tingkat, $bidang, $event, $penyelenggara, $peringkat, $tgl, $siswaId, $jurusanId]) {
            DB::table('prestasi')->insert([
                'judul'         => $judul,
                'tingkat'       => $tingkat,
                'bidang'        => $bidang,
                'nama_event'    => $event,
                'penyelenggara' => $penyelenggara,
                'peringkat'     => $peringkat,
                'tanggal'       => $tgl,
                'tahun'         => (int) substr($tgl, 0, 4),
                'tipe_penerima' => 'siswa',
                'siswa_id'      => $siswaId,
                'jurusan_id'    => $jurusanId,
                'is_published'  => true,
                'is_featured'   => false,
                'urutan'        => 0,
                'created_by'    => $adminUser,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 37. BERITA KATEGORI
        // ─────────────────────────────────────────────
        $beritaKatIds = [];
        foreach ([
            ['Berita Sekolah', 'berita-sekolah', '#3B82F6'],
            ['Kegiatan',       'kegiatan',       '#10B981'],
            ['Prestasi',       'prestasi',       '#F59E0B'],
        ] as $i => [$nama, $slug, $warna]) {
            $beritaKatIds[] = DB::table('berita_kategori')->insertGetId([
                'nama'         => $nama,
                'slug'         => $slug,
                'warna'        => $warna,
                'is_published' => true,
                'urutan'       => $i + 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 38. BERITA PUBLIK
        // ─────────────────────────────────────────────
        $beritaList = [
            [
                $beritaKatIds[2],
                'Siswa TKJ SMK Bustanul Ulum Raih Juara 1 LKS Kabupaten Pamekasan',
                'tkj-juara-1-lks-pamekasan-2024',
                'Siswa TKJ berhasil meraih Juara 1 pada LKS tingkat Kabupaten Pamekasan.',
                '<p>SMK Bustanul Ulum kembali mengharumkan nama sekolah di ajang LKS Tingkat Kabupaten Pamekasan. Abdurrahman Wahid, siswa kelas X TKJ 1, berhasil meraih Juara 1 pada bidang TKJ.</p>',
                'published',
            ],
            [
                $beritaKatIds[1],
                'SMK Bustanul Ulum Gelar Peringatan Maulid Nabi 1446 H',
                'maulid-nabi-1446h-smk-bu',
                'SMK Bustanul Ulum menggelar peringatan Maulid Nabi Muhammad SAW dengan penuh khidmat.',
                '<p>SMK Bustanul Ulum menggelar peringatan Maulid Nabi Muhammad SAW 1446 H pada Kamis, 19 September 2024 di Aula Serbaguna.</p>',
                'published',
            ],
        ];
        foreach ($beritaList as [$katId, $judul, $slug, $ringkasan, $konten, $status]) {
            DB::table('berita_publik')->insert([
                'berita_kategori_id' => $katId,
                'judul'              => $judul,
                'slug'               => $slug,
                'ringkasan'          => $ringkasan,
                'konten'             => $konten,
                'author_id'          => $adminUser,
                'status'             => $status,
                'published_at'       => $status === 'published' ? now()->subDays(rand(1, 30)) : null,
                'is_featured'        => false,
                'allow_comment'      => false,
                'views'              => rand(10, 150),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 39. AGENDA SEKOLAH
        // ─────────────────────────────────────────────
        $agendaList = [
            ['UTS Semester Genap 2024/2025',    'Ujian Tengah Semester seluruh kelas',                 'Semua Ruang Kelas', '2025-03-10', '2025-03-15', '07:00', '13:00', 'ujian',    '#EF4444'],
            ['Libur Isra Mi\'raj 1446 H',       'Libur nasional peringatan Isra Mi\'raj',              null,                '2025-01-27', '2025-01-27', null,    null,    'libur',    '#94A3B8'],
            ['Penerimaan Rapor Semester Genap', 'Pembagian rapor semester genap kepada orang tua/wali','Aula SMK BU',       '2025-06-25', '2025-06-25', '08:00', '12:00', 'kegiatan', '#F59E0B'],
            ['PPDB 2025/2026',                  'Penerimaan Peserta Didik Baru TA 2025/2026',          'SMK Bustanul Ulum', '2025-06-01', '2025-07-10', '08:00', '14:00', 'ppdb',     '#8B5CF6'],
        ];
        foreach ($agendaList as [$judul, $desk, $lokasi, $tglMul, $tglSel, $jamMul, $jamSel, $tipe, $warna]) {
            DB::table('agenda_sekolah')->insert([
                'judul'           => $judul,
                'deskripsi'       => $desk,
                'lokasi'          => $lokasi,
                'tanggal_mulai'   => $tglMul,
                'tanggal_selesai' => $tglSel,
                'jam_mulai'       => $jamMul,
                'jam_selesai'     => $jamSel,
                'warna'           => $warna,
                'tipe'            => $tipe,
                'is_published'    => true,
                'created_by'      => $adminUser,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 40. SLIDER BERANDA
        // ─────────────────────────────────────────────
        $sliderList = [
            ['Selamat Datang di SMK Bustanul Ulum', 'Sekolah Kejuruan Unggulan Berbasis Pesantren di Pamekasan', 'Lihat Jurusan', '/jurusan', true, 1],
            ['Daftar Sekarang - PPDB 2025/2026',    'Buka 2 Program Keahlian: TKJ dan RPL',                     'Daftar PPDB',   '/ppdb',    true, 2],
            ['Prestasi Membanggakan',               'Juara 1 LKS TKJ Kabupaten Pamekasan 2024',                 'Lihat Prestasi','/prestasi', true, 3],
        ];
        foreach ($sliderList as [$judul, $subjudul, $label, $url, $isPub, $urutan]) {
            DB::table('slider_beranda')->insert([
                'judul'        => $judul,
                'subjudul'     => $subjudul,
                'foto_path'    => 'slider/slide-' . $urutan . '.jpg',
                'foto_alt'     => $judul . ' - SMK Bustanul Ulum',
                'tombol_label' => $label,
                'tombol_url'   => $url,
                'is_published' => $isPub,
                'urutan'       => $urutan,
                'created_by'   => $adminUser,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 41. LINK CEPAT
        // ─────────────────────────────────────────────
        foreach ([
            ['PPDB Online',    '/ppdb',     'academic-cap',    '#3B82F6', 1],
            ['E-Learning',     '/elearning','computer-desktop','#10B981', 2],
            ['Cek Nilai',      '/nilai',    'chart-bar',       '#F59E0B', 3],
            ['Absensi Online', '/absensi',  'clipboard-list',  '#8B5CF6', 4],
            ['Kontak Sekolah', '/kontak',   'phone',           '#EF4444', 5],
        ] as [$label, $url, $ikon, $warna, $urutan]) {
            DB::table('link_cepat')->insert([
                'label'         => $label,
                'url'           => $url,
                'ikon'          => $ikon,
                'warna'         => $warna,
                'buka_tab_baru' => false,
                'is_published'  => true,
                'urutan'        => $urutan,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 42. KONTAK PESAN
        // ─────────────────────────────────────────────
        $kontakList = [
            ['Ahmad Zaini',    'zaini@gmail.com',  '081298760001', 'Informasi PPDB 2025',   'Apakah ada beasiswa untuk calon siswa berprestasi?',        'baru'   ],
            ['Maryam Hasanah', 'maryam@yahoo.com', '081298760002', 'Jurusan RPL',           'Apakah lulusan RPL bisa langsung kerja atau harus kuliah?', 'dibaca' ],
            ['Rudi Santoso',   'rudi@gmail.com',   null,           'Fasilitas Lab Komputer','Berapa jumlah komputer di lab RPL?',                        'dibalas'],
        ];
        foreach ($kontakList as [$nama, $email, $hp, $subjek, $pesan, $status]) {
            DB::table('kontak_pesan')->insert([
                'nama_pengirim'  => $nama,
                'email_pengirim' => $email,
                'no_telepon'     => $hp,
                'subjek'         => $subjek,
                'pesan'          => $pesan,
                'status'         => $status,
                'ip_address'     => '127.0.0.1',
                'dibaca_at'      => $status !== 'baru' ? now()->subDays(rand(1, 3)) : null,
                'dibaca_oleh'    => $status !== 'baru' ? $adminUser : null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // DONE
        // ─────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('✅ Seeder SMK Bustanul Ulum (versi ringkas) selesai!');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('👤  Admin          → admin@gmail.com');
        $this->command->info('🛡  Guru Piket     → piket@gmail.com');
        $this->command->info('');
        $this->command->info('👨‍🏫  5 Guru:');
        $this->command->info('    faishal.hadi@gmail.com     (Guru TKJ)');
        $this->command->info('    miftahul.arifin@gmail.com  (Guru RPL)');
        $this->command->info('    nurul.hidayah@gmail.com    (Wali X TKJ 1 / B.Indonesia / Piket)');
        $this->command->info('    siti.aminah@gmail.com      (Wali X RPL 1 / Matematika)');
        $this->command->info('    zuhriyah@gmail.com         (PAI / Piket)');
        $this->command->info('');
        $this->command->info('🎓  20 Siswa:');
        $this->command->info('    10 siswa → X TKJ 1  (abdurrahman.wahid@gmail.com, dst.)');
        $this->command->info('    10 siswa → X RPL 1  (kholifah.nur@gmail.com, dst.)');
        $this->command->info('');
        $this->command->info('👨‍👩‍👧  10 Orang Tua → [slug]@gmail.com');
        $this->command->info('🔑  Password semua: password');
        $this->command->info('');
        $this->command->info('📚  Jurusan: TKJ | RPL');
        $this->command->info('🏫  2 Kelas: X TKJ 1 | X RPL 1');
        $this->command->info('📖  8 Mata Pelajaran');
        $this->command->info('📅  11 Jadwal Pelajaran');
        $this->command->info('═══════════════════════════════════════════════════════');
    }
}