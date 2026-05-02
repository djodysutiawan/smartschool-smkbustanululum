<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
            'misi'               => '1. Menyelenggarakan pendidikan kejuruan berbasis nilai-nilai Islam.\n2. Mengembangkan kompetensi siswa sesuai kebutuhan industri.\n3. Membangun kemitraan dengan DU/DI untuk penempatan kerja.\n4. Mendorong inovasi dan kreativitas dalam pembelajaran.',
            'tujuan_sekolah'     => 'Menghasilkan lulusan yang kompeten, siap kerja, dan berakhlak mulia.',
            'sejarah_singkat'    => 'SMK Bustanul Ulum berdiri pada tahun 1998 di bawah naungan Yayasan Pondok Pesantren Bustanul Ulum. Berawal dari satu jurusan, kini telah berkembang menjadi sekolah kejuruan terkemuka dengan empat program keahlian.',
            'deskripsi_singkat'  => 'SMK Bustanul Ulum - Sekolah kejuruan Islami unggulan di Pamekasan dengan 4 program keahlian teknologi.',
            'meta_title'         => 'SMK Bustanul Ulum Pamekasan | Sekolah Kejuruan Teknologi Islami',
            'meta_description'   => 'SMK Bustanul Ulum adalah sekolah menengah kejuruan swasta berbasis pesantren di Pamekasan, Jawa Timur, dengan program keahlian TKJ, RPL, MM, dan AKL.',
            'meta_keywords'      => 'SMK Bustanul Ulum, SMK Pamekasan, TKJ, RPL, Multimedia, SMK Islam',
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

        // Guru Users (12 guru)
        $guruData = [
            ['Moh. Faishal Hadi, S.Kom',        'faishal.hadi',      '081211110001', 'L'],
            ['Nurul Hidayah, S.Pd',              'nurul.hidayah',     '081211110002', 'P'],
            ['Abd. Rahman, S.T',                 'abd.rahman',        '081211110003', 'L'],
            ['Siti Aminah, S.Pd',                'siti.aminah',       '081211110004', 'P'],
            ['Miftahul Arifin, S.Kom',           'miftahul.arifin',   '081211110005', 'L'],
            ['Halimatus Sa\'diyah, S.Pd',        'halimatus.sadiyah', '081211110006', 'P'],
            ['Achmad Fauzi, S.T',                'achmad.fauzi',      '081211110007', 'L'],
            ['Zuhriyah, S.Pd',                   'zuhriyah',          '081211110008', 'P'],
            ['Moh. Syaiful Islam, S.Kom',        'syaiful.islam',     '081211110009', 'L'],
            ['Rofiqoh Nur Aini, S.Pd',           'rofiqoh.aini',      '081211110010', 'P'],
            ['Khoirul Anam, S.T',                'khoirul.anam',      '081211110011', 'L'],
            ['Dewi Masyitoh, S.Pd',              'dewi.masyitoh',     '081211110012', 'P'],
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

        // Siswa Users (40 siswa)
        $siswaNames = [
            ['Abdurrahman Wahid',   'L'], ['Aisyah Fitria',        'P'],
            ['Bagas Setiawan',      'L'], ['Choirul Anam',         'L'],
            ['Dina Maulidah',       'P'], ['Ekawati Putri',        'P'],
            ['Fathur Rozi',         'L'], ['Ghina Fauziyah',       'P'],
            ['Habibi Maulana',      'L'], ['Indah Permatasari',    'P'],
            ['Jamal Husain',        'L'], ['Kholifah Nur',         'P'],
            ['Lutfiyah Aini',       'P'], ['M. Rizal Fahmi',       'L'],
            ['Nabilah Azzahra',     'P'], ['Omar Faruq',           'L'],
            ['Putri Ramadhani',     'P'], ['Qomariyah',            'P'],
            ['Rizky Pratama',       'L'], ['Siti Rohimah',         'P'],
            ['Taufiqurrahman',      'L'], ['Ulfatun Hasanah',      'P'],
            ['Vicky Firmansyah',    'L'], ['Wahyu Kurniawan',      'L'],
            ['Xena Aulia',          'P'], ['Yahya Al-Anshor',      'L'],
            ['Zulaikha Nisa',       'P'], ['Ardiansyah Putra',     'L'],
            ['Badriyah Hanum',      'P'], ['Chairul Umam',         'L'],
            ['Desi Wulandari',      'P'], ['Erfan Hakim',          'L'],
            ['Faiqotul Himmah',     'P'], ['Ghalih Maulana',       'L'],
            ['Hidayatul Ummah',     'P'], ['Ilham Syahputra',      'L'],
            ['Jauharotul Wardah',   'P'], ['Khoirun Nisa',         'P'],
            ['Lailatul Fitriyah',   'P'], ['M. Faqih Amrullah',    'L'],
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

        // Orang Tua Users (20)
        $orangTuaNames = [
            ['H. Wahid Hasyim',       '081233330001'],
            ['Hj. Maimunah',          '081233330002'],
            ['Sutrisno',              '081233330003'],
            ['Siti Fatimah',          '081233330004'],
            ['Moh. Arifin',           '081233330005'],
            ['Nur Laili',             '081233330006'],
            ['Hamzah Faturrahman',    '081233330007'],
            ['Ruqayyah Hasanah',      '081233330008'],
            ['Abd. Aziz',             '081233330009'],
            ['Khotimatul Husna',      '081233330010'],
            ['Syamsul Arifin',        '081233330011'],
            ['Musyarofah',            '081233330012'],
            ['Muhlis Anwar',          '081233330013'],
            ['Hj. Mariyam',           '081233330014'],
            ['Zainal Abidin',         '081233330015'],
            ['Maftuhah',              '081233330016'],
            ['Khoirul Huda',          '081233330017'],
            ['Samsiyah',              '081233330018'],
            ['Fathorrozi',            '081233330019'],
            ['Nafisah',               '081233330020'],
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
        foreach ($guruUserIds as $id)      { \App\Models\User::find($id)?->assignRole('guru'); }
        foreach ($siswaUserIds as $id)     { \App\Models\User::find($id)?->assignRole('siswa'); }
        foreach ($orangTuaUserIds as $id)  { \App\Models\User::find($id)?->assignRole('orang_tua'); }

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
        // 4. JURUSAN
        // ─────────────────────────────────────────────
        $jurusanData = [
            [
                'nama'                  => 'Teknik Komputer dan Jaringan',
                'singkatan'             => 'TKJ',
                'slug'                  => 'teknik-komputer-jaringan',
                'kode_jurusan'          => 'TKJ-001',
                'bidang_keahlian'       => 'Teknologi Informasi dan Komunikasi',
                'program_keahlian'      => 'Teknik Komputer dan Informatika',
                'kompetensi_keahlian'   => 'Teknik Komputer dan Jaringan',
                'deskripsi_singkat'     => 'Mencetak teknisi jaringan komputer yang handal dan bersertifikat.',
                'deskripsi_lengkap'     => '<p>Jurusan TKJ membekali siswa dengan keterampilan instalasi, konfigurasi, dan pemeliharaan jaringan komputer. Lulusan siap bekerja sebagai Network Engineer, IT Support, dan teknisi jaringan.</p>',
                'tujuan_jurusan'        => 'Menghasilkan lulusan yang mampu merancang, membangun, dan mengelola infrastruktur jaringan komputer.',
                'lama_belajar'          => 3,
                'akreditasi'            => 'A',
                'kapasitas_per_kelas'   => 36,
                'jumlah_kelas_aktif'    => 6,
                'nama_kajur'            => 'Moh. Faishal Hadi, S.Kom',
                'is_published'          => true,
                'is_penerimaan_buka'    => true,
                'urutan'                => 1,
                'created_by'            => $adminUser,
            ],
            [
                'nama'                  => 'Rekayasa Perangkat Lunak',
                'singkatan'             => 'RPL',
                'slug'                  => 'rekayasa-perangkat-lunak',
                'kode_jurusan'          => 'RPL-001',
                'bidang_keahlian'       => 'Teknologi Informasi dan Komunikasi',
                'program_keahlian'      => 'Teknik Komputer dan Informatika',
                'kompetensi_keahlian'   => 'Rekayasa Perangkat Lunak',
                'deskripsi_singkat'     => 'Mencetak programmer dan pengembang aplikasi yang kreatif dan profesional.',
                'deskripsi_lengkap'     => '<p>Jurusan RPL membekali siswa dengan kemampuan pemrograman, pengembangan web, dan aplikasi mobile. Lulusan siap menjadi Web Developer, Mobile Developer, dan Software Engineer.</p>',
                'tujuan_jurusan'        => 'Menghasilkan lulusan yang mampu merancang dan membangun perangkat lunak berkualitas.',
                'lama_belajar'          => 3,
                'akreditasi'            => 'A',
                'kapasitas_per_kelas'   => 36,
                'jumlah_kelas_aktif'    => 4,
                'nama_kajur'            => 'Miftahul Arifin, S.Kom',
                'is_published'          => true,
                'is_penerimaan_buka'    => true,
                'urutan'                => 2,
                'created_by'            => $adminUser,
            ],
            [
                'nama'                  => 'Multimedia',
                'singkatan'             => 'MM',
                'slug'                  => 'multimedia',
                'kode_jurusan'          => 'MM-001',
                'bidang_keahlian'       => 'Teknologi Informasi dan Komunikasi',
                'program_keahlian'      => 'Teknik Komputer dan Informatika',
                'kompetensi_keahlian'   => 'Multimedia',
                'deskripsi_singkat'     => 'Mencetak desainer grafis dan konten kreator berbakat.',
                'deskripsi_lengkap'     => '<p>Jurusan Multimedia mengajarkan desain grafis, videografi, animasi, dan produksi konten digital. Lulusan siap bekerja sebagai Graphic Designer, Content Creator, dan Video Editor.</p>',
                'tujuan_jurusan'        => 'Menghasilkan lulusan yang kreatif dan kompeten di bidang produksi konten digital.',
                'lama_belajar'          => 3,
                'akreditasi'            => 'B',
                'kapasitas_per_kelas'   => 30,
                'jumlah_kelas_aktif'    => 4,
                'nama_kajur'            => 'Achmad Fauzi, S.T',
                'is_published'          => true,
                'is_penerimaan_buka'    => true,
                'urutan'                => 3,
                'created_by'            => $adminUser,
            ],
            [
                'nama'                  => 'Akuntansi dan Keuangan Lembaga',
                'singkatan'             => 'AKL',
                'slug'                  => 'akuntansi-keuangan-lembaga',
                'kode_jurusan'          => 'AKL-001',
                'bidang_keahlian'       => 'Bisnis dan Manajemen',
                'program_keahlian'      => 'Keuangan dan Perbankan',
                'kompetensi_keahlian'   => 'Akuntansi dan Keuangan Lembaga',
                'deskripsi_singkat'     => 'Mencetak tenaga akuntansi dan keuangan yang profesional dan amanah.',
                'deskripsi_lengkap'     => '<p>Jurusan AKL membekali siswa dengan keterampilan pembukuan, akuntansi, dan manajemen keuangan. Lulusan siap bekerja sebagai Akuntan, Staff Keuangan, dan Kasir profesional.</p>',
                'tujuan_jurusan'        => 'Menghasilkan lulusan yang mampu mengelola keuangan dan akuntansi lembaga secara profesional.',
                'lama_belajar'          => 3,
                'akreditasi'            => 'A',
                'kapasitas_per_kelas'   => 36,
                'jumlah_kelas_aktif'    => 4,
                'nama_kajur'            => 'Halimatus Sa\'diyah, S.Pd',
                'is_published'          => true,
                'is_penerimaan_buka'    => true,
                'urutan'                => 4,
                'created_by'            => $adminUser,
            ],
        ];

        $jurusanIds = [];
        foreach ($jurusanData as $j) {
            $jurusanIds[] = DB::table('jurusan')->insertGetId(array_merge($j, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ─────────────────────────────────────────────
        // 5. JURUSAN KURIKULUM
        // ─────────────────────────────────────────────
        $kurikulumData = [
            // TKJ
            [$jurusanIds[0], 'Jaringan Dasar',                'C2', 10, 1, 4],
            [$jurusanIds[0], 'Perencanaan & Pengalamatan Jaringan', 'C3', 11, 1, 6],
            [$jurusanIds[0], 'Administrasi Sistem Jaringan',  'C3', 12, 1, 8],
            [$jurusanIds[0], 'Teknologi WAN',                 'C3', 12, 2, 6],
            // RPL
            [$jurusanIds[1], 'Pemrograman Dasar',             'C2', 10, 1, 4],
            [$jurusanIds[1], 'Pemrograman Web',               'C3', 11, 1, 6],
            [$jurusanIds[1], 'Basis Data',                    'C3', 11, 2, 4],
            [$jurusanIds[1], 'Pemrograman Berorientasi Objek','C3', 12, 1, 6],
            // MM
            [$jurusanIds[2], 'Desain Grafis',                 'C2', 10, 1, 4],
            [$jurusanIds[2], 'Videografi & Fotografi',        'C3', 11, 1, 6],
            [$jurusanIds[2], 'Animasi 2D & 3D',               'C3', 12, 1, 6],
            // AKL
            [$jurusanIds[3], 'Akuntansi Dasar',               'C2', 10, 1, 4],
            [$jurusanIds[3], 'Akuntansi Perusahaan Jasa',     'C3', 11, 1, 6],
            [$jurusanIds[3], 'Akuntansi Perusahaan Dagang',   'C3', 12, 1, 6],
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
            [$jurusanIds[0], 'Instalasi Jaringan LAN/WAN',   'server',      '#3B82F6'],
            [$jurusanIds[0], 'Konfigurasi Router & Switch',  'cpu-chip',    '#10B981'],
            [$jurusanIds[0], 'Keamanan Jaringan',            'shield-check', '#EF4444'],
            [$jurusanIds[1], 'Pengembangan Web (Frontend & Backend)', 'code-bracket', '#6366F1'],
            [$jurusanIds[1], 'Pemrograman Mobile',           'device-phone-mobile', '#F59E0B'],
            [$jurusanIds[1], 'Manajemen Basis Data',         'circle-stack', '#8B5CF6'],
            [$jurusanIds[2], 'Desain Grafis & Ilustrasi',    'paint-brush',  '#EC4899'],
            [$jurusanIds[2], 'Produksi Video & Editing',     'film',         '#F97316'],
            [$jurusanIds[2], 'Animasi Digital',              'sparkles',     '#14B8A6'],
            [$jurusanIds[3], 'Pembukuan & Jurnal',           'book-open',    '#0EA5E9'],
            [$jurusanIds[3], 'Laporan Keuangan',             'chart-bar',    '#22C55E'],
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
            [$jurusanIds[0], 'Network Engineer',     'IT & Telekomunikasi'],
            [$jurusanIds[0], 'IT Support',           'IT & Perusahaan'],
            [$jurusanIds[0], 'Teknisi Jaringan',     'IT & Infrastruktur'],
            [$jurusanIds[1], 'Web Developer',        'IT & Digital'],
            [$jurusanIds[1], 'Mobile Developer',     'IT & Digital'],
            [$jurusanIds[1], 'Software Engineer',    'IT & Industri'],
            [$jurusanIds[2], 'Graphic Designer',     'Kreatif & Advertising'],
            [$jurusanIds[2], 'Video Editor',         'Media & Broadcasting'],
            [$jurusanIds[2], 'Content Creator',      'Digital Marketing'],
            [$jurusanIds[3], 'Staf Akuntansi',       'Keuangan & Perbankan'],
            [$jurusanIds[3], 'Kasir Profesional',    'Ritel & Bisnis'],
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
            ['GD-C', 'Gedung C (Administrasi)',2, 'Gedung kantor TU, kepala sekolah, dan ruang guru'],
            ['GD-D', 'Gedung D (Kelas XII)',   2, 'Gedung khusus kelas XII semua jurusan'],
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
            // [gedung_id_idx, kode, nama, lantai, jenis, kap, proyektor, ac, wifi, komputer]
            [$gedungIds[0], 'R-101', 'Kelas X TKJ 1',       1, 'kelas', 36, true, false, true,  false],
            [$gedungIds[0], 'R-102', 'Kelas X TKJ 2',       1, 'kelas', 36, true, false, true,  false],
            [$gedungIds[0], 'R-103', 'Kelas X RPL 1',       1, 'kelas', 36, true, false, true,  false],
            [$gedungIds[0], 'R-104', 'Kelas X MM 1',        1, 'kelas', 30, true, false, true,  false],
            [$gedungIds[0], 'R-201', 'Kelas XI TKJ 1',      2, 'kelas', 36, true, false, true,  false],
            [$gedungIds[0], 'R-202', 'Kelas XI RPL 1',      2, 'kelas', 36, true, false, true,  false],
            [$gedungIds[0], 'R-203', 'Kelas XI MM 1',       2, 'kelas', 30, true, false, true,  false],
            [$gedungIds[0], 'R-204', 'Kelas XI AKL 1',      2, 'kelas', 36, true, false, false, false],
            [$gedungIds[1], 'LAB-01','Lab Jaringan TKJ',    1, 'laboratorium_komputer', 36, true, true, true, true],
            [$gedungIds[1], 'LAB-02','Lab RPL / Coding',    1, 'laboratorium_komputer', 36, true, true, true, true],
            [$gedungIds[1], 'LAB-03','Lab Multimedia',      2, 'laboratorium_komputer', 30, true, true, true, true],
            [$gedungIds[2], 'AULA',  'Aula Serbaguna',      1, 'aula',  200, true, true, true, false],
            [$gedungIds[3], 'R-301', 'Kelas XII TKJ 1',     1, 'kelas', 36, true, false, true, false],
            [$gedungIds[3], 'R-302', 'Kelas XII RPL 1',     1, 'kelas', 36, true, false, true, false],
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
            ['Jaringan Dasar',                  'JD-001',  'produktif', 4, 45, true ],
            ['Administrasi Sistem Jaringan',    'ASJ-001', 'produktif', 6, 45, true ],
            ['Teknologi WAN',                   'WAN-001', 'produktif', 4, 45, true ],
            // Produktif RPL
            ['Pemrograman Web',                 'PWB-001', 'produktif', 4, 45, true ],
            ['Basis Data',                      'BDS-001', 'produktif', 4, 45, true ],
            ['Pemrograman Berorientasi Objek',  'PBO-001', 'produktif', 4, 45, true ],
            // Produktif MM
            ['Desain Grafis',                   'DG-001',  'produktif', 4, 45, true ],
            ['Videografi',                      'VG-001',  'produktif', 4, 45, true ],
            // Produktif AKL
            ['Akuntansi Dasar',                 'AKD-001', 'produktif', 4, 45, false],
            // Adaptif / Normatif Umum
            ['Matematika',                      'MTK-001', 'adaptif',   4, 45, false],
            ['Bahasa Indonesia',                'BIN-001', 'normatif',  3, 45, false],
            ['Bahasa Inggris',                  'BIG-001', 'adaptif',   3, 45, false],
            ['Pendidikan Agama Islam',          'PAI-001', 'normatif',  3, 45, false],
            ['Pendidikan Kewarganegaraan',      'PKN-001', 'normatif',  2, 45, false],
            ['Penjaskes',                       'PJK-001', 'normatif',  2, 45, false],
        ];
        foreach ($mapelList as [$nama, $kode, $kel, $jam, $dur, $lab]) {
            $mapelIds[] = DB::table('mata_pelajaran')->insertGetId([
                'nama_mapel'     => $nama,
                'kode_mapel'     => $kode,
                'kelompok'       => $kel,
                'jam_per_minggu' => $jam,
                'durasi_per_sesi'=> $dur,
                'perlu_lab'      => $lab,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 11. GURU PROFIL
        // ─────────────────────────────────────────────
        $guruIds = [];
        $guruProfil = [
            // [user_id_idx, nip, nama, jk, tempat_lahir, tgl_lahir, pendidikan, jurusan, universitas, th_lulus, status, piket]
            [0, '198501012010011001', 'Moh. Faishal Hadi, S.Kom',     'L', 'Pamekasan',  '1985-01-01', 'S1', 'Teknik Informatika',  'UTM',       2008, 'pns',    false],
            [1, '198703152011012002', 'Nurul Hidayah, S.Pd',           'P', 'Sumenep',    '1987-03-15', 'S1', 'Bahasa Indonesia',    'UNESA',     2010, 'pns',    true ],
            [2, '199002202012011003', 'Abd. Rahman, S.T',              'L', 'Bangkalan',  '1990-02-20', 'S1', 'Teknik Elektro',      'ITS',       2013, 'p3k',    false],
            [3, '198812102013012004', 'Siti Aminah, S.Pd',             'P', 'Sampang',    '1988-12-10', 'S1', 'Matematika',          'UNESA',     2011, 'pns',    false],
            [4, '199105252014011005', 'Miftahul Arifin, S.Kom',        'L', 'Pamekasan',  '1991-05-25', 'S1', 'Teknik Informatika',  'UTM',       2014, 'honorer',false],
            [5, '198907032015012006', 'Halimatus Sa\'diyah, S.Pd',     'P', 'Sumenep',    '1989-07-03', 'S1', 'Akuntansi',           'UNAIR',     2012, 'pns',    true ],
            [6, '199304182016011007', 'Achmad Fauzi, S.T',             'L', 'Bangkalan',  '1993-04-18', 'S1', 'Desain Komunikasi Visual','ITS',   2015, 'honorer',false],
            [7, '199001302017012008', 'Zuhriyah, S.Pd',                'P', 'Pamekasan',  '1990-01-30', 'S1', 'Pendidikan Agama Islam','IAIN',    2013, 'honorer',true ],
            [8, '199208122018011009', 'Moh. Syaiful Islam, S.Kom',     'L', 'Sampang',    '1992-08-12', 'S1', 'Teknik Informatika',  'UTM',       2015, 'honorer',false],
            [9, '199511022019012010', 'Rofiqoh Nur Aini, S.Pd',        'P', 'Sumenep',    '1995-11-02', 'S1', 'Bahasa Inggris',      'UNESA',     2018, 'honorer',false],
            [10,'199007152018011011', 'Khoirul Anam, S.T',             'L', 'Bangkalan',  '1990-07-15', 'S1', 'Teknik Informatika',  'ITS',       2014, 'honorer',false],
            [11,'199312202020012012', 'Dewi Masyitoh, S.Pd',           'P', 'Pamekasan',  '1993-12-20', 'S1', 'PKn',                 'UNESA',     2017, 'gtty',   false],
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
                'email'               => strtolower(str_replace([' ', "'", ',', '.'], ['.', '', '', ''], $nama)) . '@smkbu.sch.id',
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
        // 12. KELAS (dengan jurusan_id)
        // ─────────────────────────────────────────────
        $kelasIds = [];
        $kelasList = [
            ['X TKJ 1',   'X',   $jurusanIds[0], 'TKJ-X-1',   $guruIds[0],  $ruangIds[0]],
            ['X TKJ 2',   'X',   $jurusanIds[0], 'TKJ-X-2',   $guruIds[2],  $ruangIds[1]],
            ['X RPL 1',   'X',   $jurusanIds[1], 'RPL-X-1',   $guruIds[4],  $ruangIds[2]],
            ['X MM 1',    'X',   $jurusanIds[2], 'MM-X-1',    $guruIds[6],  $ruangIds[3]],
            ['XI TKJ 1',  'XI',  $jurusanIds[0], 'TKJ-XI-1',  $guruIds[1],  $ruangIds[4]],
            ['XI RPL 1',  'XI',  $jurusanIds[1], 'RPL-XI-1',  $guruIds[8],  $ruangIds[5]],
            ['XI MM 1',   'XI',  $jurusanIds[2], 'MM-XI-1',   $guruIds[10], $ruangIds[6]],
            ['XI AKL 1',  'XI',  $jurusanIds[3], 'AKL-XI-1',  $guruIds[5],  $ruangIds[7]],
            ['XII TKJ 1', 'XII', $jurusanIds[0], 'TKJ-XII-1', $guruIds[3],  $ruangIds[12]],
            ['XII RPL 1', 'XII', $jurusanIds[1], 'RPL-XII-1', $guruIds[9],  $ruangIds[13]],
        ];
        foreach ($kelasList as [$nama, $tingkat, $jurusanId, $kode, $waliId, $ruangId]) {
            $kelasIds[] = DB::table('kelas')->insertGetId([
                'nama_kelas'      => $nama,
                'tingkat'         => $tingkat,
                'jurusan_id'      => $jurusanId,
                'kode_kelas'      => $kode,
                'wali_kelas_id'   => $waliId,
                'ruang_id'        => $ruangId,
                'tahun_ajaran_id' => $tahunAjaranId,
                'kapasitas_maks'  => 36,
                'status'          => 'aktif',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 13. SISWA PROFIL
        // ─────────────────────────────────────────────
        $agamaList   = ['Islam', 'Islam', 'Islam', 'Islam', 'Islam', 'Islam', 'Kristen', 'Islam'];
        $pekerjaanList = ['Petani', 'Wiraswasta', 'PNS', 'Pedagang', 'Nelayan', 'Karyawan Swasta', 'Buruh', 'Guru'];
        $kotaList    = ['Pamekasan', 'Sumenep', 'Bangkalan', 'Sampang', 'Pamekasan', 'Sumenep'];
        $siswaIds = [];

        foreach ($siswaNames as $i => [$namaLengkap, $jk]) {
            $kelasId = $kelasIds[$i % count($kelasIds)];
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
                'alamat'         => 'Jl. Pesantren No.' . ($i + 1) . ' RT 0' . (($i % 9) + 1) . '/RW 00' . (($i % 5) + 1) . ', ' . $kotaList[$i % count($kotaList)],
                'no_hp'          => '0856' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'email'          => strtolower(str_replace([' ', "'", '.'], ['.', '', ''], $namaLengkap)) . '@siswa.smkbu.sch.id',
                'nama_ayah'      => 'H. Ayah ' . explode(' ', $namaLengkap)[0],
                'pekerjaan_ayah' => $pekerjaanList[$i % count($pekerjaanList)],
                'no_hp_ayah'     => '0813' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'nama_ibu'       => 'Hj. Ibu ' . explode(' ', $namaLengkap)[0],
                'pekerjaan_ibu'  => $pekerjaanList[($i + 3) % count($pekerjaanList)],
                'no_hp_ibu'      => '0814' . str_pad(10000001 + $i, 8, '0', STR_PAD_LEFT),
                'kelas_id'       => $kelasId,
                'tahun_ajaran_id'=> $tahunAjaranId,
                'status'         => 'aktif',
                'tanggal_masuk'  => '2023-07-17',
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
                'email'        => strtolower(str_replace([' ', '.', "'"], ['.', '', ''], $nama)) . '@ortu.smkbu.sch.id',
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
                ->where('orang_tua_id', $otId)->exists();
            if (!$exists) {
                DB::table('siswa_orang_tua')->insert([
                    'siswa_id'     => $siswaId,
                    'orang_tua_id' => $otId,
                    'hubungan'     => ($i % 3 === 0) ? 'ibu' : 'ayah',
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
            [0,  0,  0,  8,  'senin',   '07:00:00', '08:30:00'], // Faishal - JD - X TKJ 1 - Lab TKJ
            [0,  0,  1,  8,  'selasa',  '07:00:00', '08:30:00'], // Faishal - JD - X TKJ 2 - Lab TKJ
            [4,  3,  2,  9,  'senin',   '07:00:00', '08:30:00'], // Arifin  - PWB - X RPL 1 - Lab RPL
            [4,  3,  2,  9,  'rabu',    '07:00:00', '08:30:00'], // Arifin  - PWB - X RPL 1 - Lab RPL
            [6,  6,  3,  10, 'senin',   '07:00:00', '08:30:00'], // Fauzi   - DG - X MM 1 - Lab MM
            [2,  1,  4,  8,  'senin',   '10:15:00', '11:45:00'], // Rahman  - ASJ - XI TKJ 1 - Lab TKJ
            [8,  4,  5,  9,  'selasa',  '10:15:00', '11:45:00'], // Syaiful - BDS - XI RPL 1 - Lab RPL
            [10, 7,  6,  10, 'rabu',    '10:15:00', '11:45:00'], // Anam    - VG - XI MM 1 - Lab MM
            [5,  8,  7,  7,  'kamis',   '07:00:00', '08:30:00'], // Halimatus - AKD - XI AKL 1 - R204
            [3,  9,  0,  0,  'selasa',  '08:45:00', '10:15:00'], // Aminah  - MTK - X TKJ 1 - R101
            [1,  10, 2,  2,  'rabu',    '08:45:00', '10:15:00'], // Hidayah - BIN - X RPL 1 - R103
            [9,  11, 4,  4,  'kamis',   '08:45:00', '10:15:00'], // Rofiqoh - BIG - XI TKJ 1 - R201
            [7,  12, 5,  5,  'jumat',   '07:00:00', '08:30:00'], // Zuhriyah - PAI - XI RPL 1 - R202
            [11, 13, 7,  7,  'jumat',   '07:00:00', '08:30:00'], // Dewi    - PKN - XI AKL 1 - R204
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
        // Guru piket: idx 1 (Hidayah), 5 (Halimatus), 7 (Zuhriyah)
        $piketGuruIds = [$guruIds[1], $guruIds[5], $guruIds[7]];
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
            [$piketGuruIds[2], '2025-01-08', 'pagi', '2025-01-08 06:58:00', '2025-01-08 14:00:00'],
            [$piketGuruIds[0], '2025-01-13', 'pagi', '2025-01-13 07:02:00', '2025-01-13 14:00:00'],
            [$piketGuruIds[1], '2025-01-14', 'pagi', '2025-01-14 07:00:00', '2025-01-14 14:00:00'],
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
            [$guruIds[0],  $mapelIds[0],  $kelasIds[0],  'Pengantar Jaringan Komputer',     'Konsep dasar jaringan, topologi, dan protokol',              'file', 'materi/jaringan-dasar.pdf'],
            [$guruIds[0],  $mapelIds[0],  $kelasIds[1],  'Pengkabelan UTP & STP',           'Cara membuat kabel UTP straight dan crossover',              'file', 'materi/pengkabelan.pdf'],
            [$guruIds[4],  $mapelIds[3],  $kelasIds[2],  'HTML5 Struktur Dasar',            'Tag-tag dasar HTML5 dan semantik web',                       'file', 'materi/html5-dasar.pdf'],
            [$guruIds[4],  $mapelIds[3],  $kelasIds[2],  'CSS3 & Flexbox',                  'Styling modern dengan CSS3 dan Flexbox layout',              'link', null],
            [$guruIds[6],  $mapelIds[6],  $kelasIds[3],  'Prinsip Desain Grafis',           'Teori warna, tipografi, dan komposisi desain',               'file', 'materi/desain-grafis.pdf'],
            [$guruIds[2],  $mapelIds[1],  $kelasIds[4],  'Konfigurasi Router Cisco',        'Konfigurasi dasar router Cisco dengan CLI',                  'file', 'materi/cisco-router.pdf'],
            [$guruIds[8],  $mapelIds[4],  $kelasIds[5],  'Normalisasi Basis Data',          '1NF, 2NF, 3NF dengan studi kasus nyata',                     'file', 'materi/normalisasi.pdf'],
            [$guruIds[10], $mapelIds[7],  $kelasIds[6],  'Dasar Videografi',                'Teknik pengambilan gambar dan komposisi video',               'video', null],
            [$guruIds[5],  $mapelIds[8],  $kelasIds[7],  'Persamaan Dasar Akuntansi',       'Pengantar persamaan akuntansi dan laporan keuangan',          'teks', null],
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
                'dipublikasikan_pada' => now()->subDays(rand(1, 20)),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 21. TUGAS
        // ─────────────────────────────────────────────
        $tugasIds = [];
        $tugasList = [
            [$guruIds[0],  $mapelIds[0],  $kelasIds[0],  'Membuat Topologi Jaringan Sederhana',   'Rancang topologi star/bus untuk lab sekolah menggunakan Cisco Packet Tracer', 'file', now()->addDays(7)],
            [$guruIds[4],  $mapelIds[3],  $kelasIds[2],  'Membuat Halaman Profil Web',             'Buat halaman profil pribadi menggunakan HTML5 dan CSS3',                      'file', now()->addDays(7)],
            [$guruIds[6],  $mapelIds[6],  $kelasIds[3],  'Desain Poster Hari Kemerdekaan',         'Buat poster digital menggunakan Adobe Illustrator / CorelDRAW',               'file', now()->addDays(10)],
            [$guruIds[8],  $mapelIds[4],  $kelasIds[5],  'ERD Sistem Informasi Perpustakaan',      'Buat ERD lengkap beserta normalisasi sampai 3NF',                             'file', now()->addDays(10)],
            [$guruIds[5],  $mapelIds[8],  $kelasIds[7],  'Latihan Persamaan Akuntansi',            'Kerjakan soal persamaan dasar akuntansi halaman 30-35 buku paket',            'teks', now()->addDays(5)],
            [$guruIds[3],  $mapelIds[9],  $kelasIds[0],  'Soal Latihan Matriks',                   'Kerjakan 20 soal matriks dan determinan',                                     'teks', now()->addDays(3)],
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
        foreach (array_slice($siswaIds, 0, 8) as $i => $sId) {
            DB::table('pengumpulan_tugas')->insert([
                'tugas_id'         => $tugasIds[0],
                'siswa_id'         => $sId,
                'path_file'        => 'pengumpulan/topologi-' . ($i + 1) . '.pkt',
                'nilai'            => rand(75, 100),
                'umpan_balik'      => 'Topologi sudah ' . ($i % 2 === 0 ? 'benar dan rapi' : 'cukup baik, perbaiki labeling'),
                'status'           => 'dinilai',
                'dikumpulkan_pada' => now()->subDays(rand(1, 4)),
                'dinilai_pada'     => now()->subDays(rand(0, 2)),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        foreach (array_slice($siswaIds, 8, 6) as $i => $sId) {
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
            [$guruIds[0],  $mapelIds[0],  $kelasIds[0],  'UTS Jaringan Dasar X TKJ 1',        'uts',            '2025-03-15', '08:00:00', 90],
            [$guruIds[4],  $mapelIds[3],  $kelasIds[2],  'UTS Pemrograman Web X RPL 1',        'uts',            '2025-03-15', '10:00:00', 90],
            [$guruIds[6],  $mapelIds[6],  $kelasIds[3],  'UTS Desain Grafis X MM 1',           'uts',            '2025-03-16', '08:00:00', 90],
            [$guruIds[3],  $mapelIds[9],  $kelasIds[0],  'Ulangan Harian Matematika - Matriks','ulangan_harian', '2025-02-10', '07:00:00', 60],
            [$guruIds[8],  $mapelIds[4],  $kelasIds[5],  'Quiz Basis Data - ERD',              'quiz',           '2025-02-20', '09:00:00', 45],
            [$guruIds[2],  $mapelIds[1],  $kelasIds[4],  'Praktik UTS ASJ XI TKJ 1',           'uts',            '2025-03-17', '08:00:00', 120],
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
            $kelasId = $kelasIds[$i % count($kelasIds)];

            // Nilai Mapel Produktif (sesuai jurusan kelas)
            $mapelNilai = $mapelIds[$i % 9]; // mapel produktif
            $guruNilai  = $guruIds[$i % count($guruIds)];

            $nt  = rand(70, 98); $nh = rand(68, 95); $uts = rand(65, 92); $uas = rand(70, 98);
            $na  = round($nt * 0.2 + $nh * 0.3 + $uts * 0.2 + $uas * 0.3, 2);
            $pred = $na >= 90 ? 'A' : ($na >= 80 ? 'B' : ($na >= 70 ? 'C' : 'D'));

            // Cek unique constraint
            $exists = DB::table('nilai')
                ->where('siswa_id', $sId)
                ->where('mata_pelajaran_id', $mapelNilai)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->exists();

            if (!$exists) {
                DB::table('nilai')->insert([
                    'siswa_id'          => $sId,
                    'mata_pelajaran_id' => $mapelNilai,
                    'guru_id'           => $guruNilai,
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
            $na2  = round($nt2 * 0.2 + $nh2 * 0.3 + $uts2 * 0.2 + $uas2 * 0.3, 2);
            $pred2 = $na2 >= 90 ? 'A' : ($na2 >= 80 ? 'B' : ($na2 >= 70 ? 'C' : 'D'));

            $exists2 = DB::table('nilai')
                ->where('siswa_id', $sId)
                ->where('mata_pelajaran_id', $mapelIds[9])
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->exists();

            if (!$exists2) {
                DB::table('nilai')->insert([
                    'siswa_id'          => $sId,
                    'mata_pelajaran_id' => $mapelIds[9],
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
            [$guruIds[0],  $kelasIds[0], $mapelIds[0],  $jadwalIds[0],  '2025-01-06', 1,  'Pengantar jaringan komputer: definisi, manfaat, dan jenis jaringan', 'Ceramah dan tanya jawab', 36, 0],
            [$guruIds[0],  $kelasIds[0], $mapelIds[0],  $jadwalIds[0],  '2025-01-13', 2,  'Topologi jaringan: star, bus, ring, mesh', 'Demonstrasi Packet Tracer', 34, 2],
            [$guruIds[4],  $kelasIds[2], $mapelIds[3],  $jadwalIds[2],  '2025-01-06', 1,  'Struktur dasar HTML5: head, body, tag semantik', 'Praktik coding langsung', 36, 0],
            [$guruIds[4],  $kelasIds[2], $mapelIds[3],  $jadwalIds[2],  '2025-01-08', 2,  'CSS3: selector, box model, warna, dan font', 'Praktik terbimbing', 35, 1],
            [$guruIds[6],  $kelasIds[3], $mapelIds[6],  $jadwalIds[4],  '2025-01-06', 1,  'Prinsip desain grafis: teori warna CMYK/RGB', 'Ceramah dan presentasi', 30, 0],
            [$guruIds[2],  $kelasIds[4], $mapelIds[1],  $jadwalIds[5],  '2025-01-06', 1,  'Pengenalan CLI Router Cisco: mode operasi dan perintah dasar', 'Lab praktik', 35, 1],
            [$guruIds[8],  $kelasIds[5], $mapelIds[4],  $jadwalIds[6],  '2025-01-07', 1,  'Konsep basis data relasional dan ERD', 'Diskusi kelompok dan studi kasus', 36, 0],
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
        $statusAbsensi = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'telat', 'izin', 'sakit'];
        $tanggalAbsensi = ['2025-01-06', '2025-01-07', '2025-01-08', '2025-01-09', '2025-01-10'];

        foreach ($tanggalAbsensi as $tgl) {
            foreach ($siswaIds as $i => $sId) {
                $kelasId = $kelasIds[$i % count($kelasIds)];
                $status  = $statusAbsensi[array_rand($statusAbsensi)];
                // Cek unique constraint
                $exists = DB::table('absensi')
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
        $statusGuru = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'telat', 'izin', 'sakit'];
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
            ['2025-01-06', 'Kondisi sekolah kondusif. Upacara bendera berjalan lancar.', null,                                   'Memastikan semua siswa terlambat mendapat surat izin masuk.'],
            ['2025-01-07', 'Kondisi sekolah normal. Ada 3 siswa terlambat.',             'Siswa kelas X TKJ 1 kedapatan merokok di toilet.',   'Siswa dipanggil ke BK untuk pembinaan.'],
            ['2025-01-08', 'Kondisi baik. Hujan deras jam 10.00 WIB.',                  null,                                   'Mengarahkan siswa agar tidak keluar kelas saat hujan.'],
        ];
        foreach ($laporanData as $i => [$tgl, $catatan, $kejadian, $tindak]) {
            DB::table('laporan_harian_piket')->insert([
                'dibuat_oleh'       => $guruPiketUser,
                'tanggal'           => $tgl,
                'catatan_umum'      => $catatan,
                'kejadian_khusus'   => $kejadian,
                'tindak_lanjut'     => $tindak,
                'rekap_absensi'     => json_encode(['hadir' => 10 - $i, 'izin' => $i, 'sakit' => 0, 'alfa' => 0]),
                'jumlah_pelanggaran'=> $i,
                'kondisi_sekolah'   => 'Baik',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 29. KATEGORI PELANGGARAN
        // ─────────────────────────────────────────────
        $kategoriIds = [];
        $kategoriList = [
            ['Terlambat Masuk',          'Masuk sekolah/kelas lebih dari 15 menit',     'ringan', 5,  50,  '#FFC107'],
            ['Tidak Berseragam Lengkap', 'Seragam tidak sesuai ketentuan sekolah',       'ringan', 5,  30,  '#FF9800'],
            ['Membawa HP Tanpa Izin',    'Membawa/menggunakan HP saat KBM',              'sedang', 15, 60,  '#F44336'],
            ['Perkelahian',              'Terlibat perkelahian di lingkungan sekolah',   'berat',  50, 150, '#9C27B0'],
            ['Tidak Mengerjakan Tugas',  'Berulang kali tidak mengumpulkan tugas',       'sedang', 10, 40,  '#2196F3'],
            ['Membolos',                 'Tidak hadir tanpa keterangan > 3 hari',        'sedang', 20, 80,  '#795548'],
            ['Merokok di Sekolah',       'Merokok di area lingkungan sekolah',           'berat',  40, 120, '#E53935'],
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
            [$siswaIds[0],  $guruUserIds[1], $kategoriIds[0], 5,  'Terlambat 20 menit, pintu gerbang sudah ditutup',        '2025-01-07', 'selesai' ],
            [$siswaIds[2],  $guruUserIds[0], $kategoriIds[2], 15, 'Ketahuan menggunakan HP saat praktik jaringan',           '2025-01-08', 'diproses'],
            [$siswaIds[5],  $guruUserIds[1], $kategoriIds[1], 5,  'Tidak memakai dasi saat hari Senin',                     '2025-01-06', 'selesai' ],
            [$siswaIds[8],  $guruUserIds[4], $kategoriIds[4], 10, 'Tidak mengumpulkan 3 tugas desain grafis berturut-turut', '2025-01-09', 'diproses'],
            [$siswaIds[12], $guruUserIds[1], $kategoriIds[6], 40, 'Ketahuan merokok di toilet lantai 1 GD-A',               '2025-01-07', 'banding' ],
            [$siswaIds[15], $guruUserIds[2], $kategoriIds[5], 20, 'Membolos 3 hari berturut-turut tanpa keterangan',         '2025-01-10', 'pending' ],
            [$siswaIds[20], $guruUserIds[1], $kategoriIds[0], 5,  'Terlambat karena macet, ada surat keterangan orangtua',   '2025-01-13', 'selesai' ],
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
            [$siswaIds[0],  '2025-01-08', '09:00', '11:00', 'Ke Puskesmas untuk periksa kesehatan',       'berobat',          'disetujui'],
            [$siswaIds[3],  '2025-01-09', '10:00', '13:00', 'Keperluan administrasi KK di Disdukcapil',   'keperluan_keluarga','disetujui'],
            [$siswaIds[7],  '2025-01-10', '11:00', '12:00', 'Menjemput adik di SD karena orang tua sakit','keperluan_keluarga','menunggu' ],
            [$siswaIds[10], '2025-01-13', '08:00', '10:00', 'Ambil hasil lab kesehatan di klinik',        'berobat',          'sudah_kembali'],
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
                'nomor_surat'     => $status === 'disetujui' || $status === 'sudah_kembali'
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
            ['Jadwal UTS Semester Genap 2024/2025',          'UTS akan dilaksanakan pada tanggal 10-15 Maret 2025. Seluruh siswa wajib hadir dan mempersiapkan diri dengan baik. Siswa yang tidak hadir tanpa keterangan dianggap tidak mengikuti UTS.',  'semua',      $adminUser],
            ['Libur Isra Mi\'raj 1446 H',                    'Diberitahukan bahwa hari Senin, 27 Januari 2025 adalah hari libur nasional dalam rangka peringatan Isra Mi\'raj Nabi Muhammad SAW. Kegiatan belajar mengajar ditiadakan.',                   'semua',      $adminUser],
            ['Pengumpulan Tugas Pemrograman Web',             'Reminder: Batas pengumpulan tugas membuat halaman web profil adalah Jumat, 24 Januari 2025 pukul 23.59 WIB. Upload file ke sistem. Tugas tidak diterima lewat WhatsApp.',                   'siswa',      $guruUserIds[4]],
            ['Rapat Koordinasi Wali Kelas',                   'Semua guru wali kelas wajib hadir dalam rapat koordinasi Sabtu, 18 Januari 2025 pukul 09.00 WIB di Ruang Kepala Sekolah. Agenda: evaluasi akademik semester genap.',                        'guru',       $adminUser],
            ['Informasi Pembayaran SPP Januari 2025',         'Pembayaran SPP bulan Januari 2025 paling lambat 10 Januari 2025. Orang tua/wali murid yang belum melunasi harap segera menghubungi bendahara sekolah. Info: 081234560001.',                 'orang_tua',  $adminUser],
            ['Pendaftaran Lomba LKS Tingkat Kabupaten',       'Bagi siswa TKJ dan RPL kelas XI yang berminat mengikuti Lomba Kompetensi Siswa (LKS) tingkat Kabupaten Pamekasan, segera daftar ke Pak Faishal paling lambat 20 Januari 2025.',            'siswa',      $guruUserIds[0]],
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
        foreach (array_slice($orangTuaUserIds, 0, 4) as $uId) {
            DB::table('notifikasi')->insert([
                'pengguna_id'  => $uId,
                'judul'        => 'Pemberitahuan Pelanggaran Siswa',
                'pesan'        => 'Putra/putri Anda tercatat melakukan pelanggaran di sekolah. Mohon hubungi wali kelas untuk informasi lengkap.',
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
                'judul'        => 'Pengumuman: Rapat Koordinasi Guru',
                'pesan'        => 'Rapat koordinasi guru dilaksanakan Sabtu, 18 Januari 2025 pukul 09.00 WIB di Ruang Kepala Sekolah. Wajib hadir.',
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
            ['Ekstrakurikuler',           'ekstrakurikuler',           'Kegiatan ekskul dan OSIS',                   'semua'],
            ['Video Profil Sekolah',      'video-profil-sekolah',      'Video profil dan dokumentasi sekolah',       'video'],
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
            [$galeriKategoriIds[0], 'Praktik Jaringan TKJ', 'Siswa TKJ sedang praktik pengkabelan UTP di Lab Jaringan', true, false],
            [$galeriKategoriIds[0], 'Coding Bersama RPL',   'Siswa RPL belajar HTML5 dan CSS3 di Lab Komputer',         false, false],
            [$galeriKategoriIds[1], 'Juara LKS TKJ 2024',   'Siswa TKJ meraih Juara 1 LKS Tingkat Kabupaten 2024',      true, true],
            [$galeriKategoriIds[2], 'Kegiatan OSIS',         'Pelantikan OSIS SMK Bustanul Ulum periode 2024/2025',       false, false],
            [$galeriKategoriIds[4], 'Lab Komputer RPL',      'Fasilitas Lab Komputer jurusan RPL dengan 36 unit PC',      true, false],
            [$galeriKategoriIds[4], 'Lab Jaringan TKJ',      'Lab Jaringan dengan perangkat Cisco lengkap',               false, true],
        ];
        foreach ($galeriList as $i => [$katId, $judul, $ket, $isPub, $isFeat]) {
            DB::table('galeri_foto')->insert([
                'galeri_kategori_id'   => $katId,
                'judul'                => $judul,
                'keterangan'           => $ket,
                'foto_path'            => 'galeri/foto-' . ($i + 1) . '.jpg',
                'alt_text'             => $judul . ' - SMK Bustanul Ulum',
                'sumber'               => 'Dokumentasi SMK Bustanul Ulum',
                'tanggal_foto'         => now()->subDays(rand(10, 90))->format('Y-m-d'),
                'is_published'         => $isPub,
                'is_featured'          => $isFeat,
                'urutan'               => $i + 1,
                'uploaded_by'          => $adminUser,
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 36. GALERI VIDEO
        // ─────────────────────────────────────────────
        DB::table('galeri_video')->insert([
            'galeri_kategori_id' => $galeriKategoriIds[3],
            'judul'              => 'Profil SMK Bustanul Ulum 2024',
            'deskripsi'          => 'Video profil resmi SMK Bustanul Ulum Pamekasan tahun 2024',
            'tipe_sumber'        => 'youtube',
            'video_url'          => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'video_embed_id'     => 'dQw4w9WgXcQ',
            'video_embed_url'    => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'thumbnail_url'      => 'https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg',
            'durasi'             => '05:30',
            'tanggal_video'      => '2024-07-01',
            'is_published'       => true,
            'is_featured'        => true,
            'urutan'             => 1,
            'uploaded_by'        => $adminUser,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // ─────────────────────────────────────────────
        // 37. PRESTASI
        // ─────────────────────────────────────────────
        $prestasiList = [
            ['Juara 1 LKS TKJ Kabupaten Pamekasan 2024', 'provinsi',      'Teknologi Informasi', 'LKS SMK 2024',     'Dinas Pendidikan Pamekasan',   'Juara 1', '2024-11-15', $siswaIds[0],  $jurusanIds[0]],
            ['Juara 2 Olimpiade Matematika Kabupaten',    'kabupaten',     'Akademik',            'Olimpiade MTK SMK','MGMP Matematika Pamekasan',     'Juara 2', '2024-10-20', $siswaIds[3],  null],
            ['Best Project Web Design Competition',       'provinsi',      'Teknologi Informasi', 'Web Design Jatim', 'Kemendikbud Jawa Timur',        'Juara 2', '2024-09-05', $siswaIds[10], $jurusanIds[1]],
            ['Juara 1 Desain Poster Islami Nasional',     'nasional',      'Seni & Desain',       'Festival Desain Islam 2024','Kemenag RI',          'Juara 1', '2024-08-17', $siswaIds[6],  $jurusanIds[2]],
        ];
        foreach ($prestasiList as [$judul, $tingkat, $bidang, $event, $penyelenggara, $peringkat, $tgl, $siswaId, $jurusanId]) {
            DB::table('prestasi')->insert([
                'judul'          => $judul,
                'tingkat'        => $tingkat,
                'bidang'         => $bidang,
                'nama_event'     => $event,
                'penyelenggara'  => $penyelenggara,
                'peringkat'      => $peringkat,
                'tanggal'        => $tgl,
                'tahun'          => (int) substr($tgl, 0, 4),
                'tipe_penerima'  => 'siswa',
                'siswa_id'       => $siswaId,
                'jurusan_id'     => $jurusanId,
                'is_published'   => true,
                'is_featured'    => $tingkat === 'nasional',
                'urutan'         => 0,
                'created_by'     => $adminUser,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 38. BERITA KATEGORI
        // ─────────────────────────────────────────────
        $beritaKatIds = [];
        $beritaKatList = [
            ['Berita Sekolah',  'berita-sekolah',  '#3B82F6'],
            ['Pengumuman',      'pengumuman',       '#EF4444'],
            ['Kegiatan',        'kegiatan',         '#10B981'],
            ['Prestasi',        'prestasi',         '#F59E0B'],
            ['Penerimaan Siswa','penerimaan-siswa', '#8B5CF6'],
        ];
        foreach ($beritaKatList as $i => [$nama, $slug, $warna]) {
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
        // 39. BERITA PUBLIK
        // ─────────────────────────────────────────────
        $beritaList = [
            [
                $beritaKatIds[3],
                'Siswa TKJ SMK Bustanul Ulum Raih Juara 1 LKS Kabupaten Pamekasan',
                'tkj-juara-1-lks-pamekasan-2024',
                'Siswa jurusan TKJ berhasil meraih Juara 1 pada Lomba Kompetensi Siswa tingkat Kabupaten Pamekasan.',
                '<p>SMK Bustanul Ulum kembali mengharumkan nama sekolah di ajang Lomba Kompetensi Siswa (LKS) Tingkat Kabupaten Pamekasan. Abdurrahman Wahid, siswa kelas XI TKJ 1, berhasil meraih Juara 1 pada bidang TKJ setelah bersaing ketat dengan peserta dari berbagai SMK se-Kabupaten Pamekasan.</p><p>Keberhasilan ini tidak terlepas dari bimbingan intensif Bapak Moh. Faishal Hadi, S.Kom selaku guru produktif TKJ dan dukungan penuh dari pihak sekolah.</p>',
                'published',
            ],
            [
                $beritaKatIds[2],
                'SMK Bustanul Ulum Gelar Peringatan Maulid Nabi 1446 H',
                'maulid-nabi-1446h-smk-bu',
                'SMK Bustanul Ulum menggelar peringatan Maulid Nabi Muhammad SAW dengan penuh khidmat dan meriah.',
                '<p>SMK Bustanul Ulum menggelar peringatan Maulid Nabi Muhammad SAW 1446 H pada Kamis, 19 September 2024. Acara berlangsung meriah di Aula Serbaguna dengan dihadiri seluruh siswa, guru, dan tamu undangan dari yayasan pondok pesantren.</p>',
                'published',
            ],
            [
                $beritaKatIds[4],
                'PPDB SMK Bustanul Ulum Tahun Ajaran 2025/2026 Resmi Dibuka',
                'ppdb-2025-2026-smk-bu',
                'Pendaftaran Peserta Didik Baru (PPDB) SMK Bustanul Ulum untuk tahun ajaran 2025/2026 resmi dibuka mulai 1 Juni 2025.',
                '<p>SMK Bustanul Ulum dengan bangga mengumumkan pembukaan PPDB untuk Tahun Ajaran 2025/2026. Tersedia empat program keahlian: TKJ, RPL, Multimedia, dan AKL. Pendaftaran dilakukan secara online dan offline mulai 1 Juni 2025.</p>',
                'draft',
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
                'views'              => rand(10, 200),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 40. AGENDA SEKOLAH
        // ─────────────────────────────────────────────
        $agendaList = [
            ['UTS Semester Genap 2024/2025',      'Ujian Tengah Semester seluruh kelas',                    'Semua Ruang Kelas',  '2025-03-10', '2025-03-15', '07:00', '13:00', 'ujian',    '#EF4444'],
            ['Libur Isra Mi\'raj 1446 H',         'Libur nasional peringatan Isra Mi\'raj',                 null,                 '2025-01-27', '2025-01-27', null,    null,    'libur',    '#94A3B8'],
            ['Praktik Kerja Lapangan Kelas XII',  'PKL siswa kelas XII di DU/DI mitra sekolah',            'DU/DI Mitra',        '2025-02-03', '2025-04-25', '08:00', '16:00', 'kegiatan', '#10B981'],
            ['LKS Tingkat Provinsi Jawa Timur',   'Lomba Kompetensi Siswa mewakili Kabupaten Pamekasan',   'Surabaya',           '2025-04-10', '2025-04-12', '08:00', '17:00', 'kegiatan', '#3B82F6'],
            ['Penerimaan Rapor Semester Genap',   'Pembagian rapor semester genap kepada orang tua/wali',   'Aula SMK BU',        '2025-06-25', '2025-06-25', '08:00', '12:00', 'kegiatan', '#F59E0B'],
            ['PPDB 2025/2026',                    'Penerimaan Peserta Didik Baru TA 2025/2026',             'SMK Bustanul Ulum',  '2025-06-01', '2025-07-10', '08:00', '14:00', 'ppdb',     '#8B5CF6'],
        ];
        foreach ($agendaList as [$judul, $desk, $lokasi, $tglMul, $tglSel, $jamMul, $jamSel, $tipe, $warna]) {
            DB::table('agenda_sekolah')->insert([
                'judul'          => $judul,
                'deskripsi'      => $desk,
                'lokasi'         => $lokasi,
                'tanggal_mulai'  => $tglMul,
                'tanggal_selesai'=> $tglSel,
                'jam_mulai'      => $jamMul,
                'jam_selesai'    => $jamSel,
                'warna'          => $warna,
                'tipe'           => $tipe,
                'is_published'   => true,
                'created_by'     => $adminUser,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 41. SLIDER BERANDA
        // ─────────────────────────────────────────────
        $sliderList = [
            ['Selamat Datang di SMK Bustanul Ulum',    'Sekolah Kejuruan Unggulan Berbasis Pesantren di Pamekasan, Jawa Timur', 'Lihat Jurusan', '/jurusan', true, 1],
            ['Daftar Sekarang - PPDB 2025/2026',       'Buka 4 Program Keahlian: TKJ, RPL, Multimedia, dan AKL',                'Daftar PPDB',   '/ppdb',    true, 2],
            ['Prestasi Membanggakan',                  'Juara 1 LKS TKJ Kabupaten Pamekasan 2024',                              'Lihat Prestasi','/prestasi', true, 3],
        ];
        foreach ($sliderList as [$judul, $subjudul, $label, $url, $isPub, $urutan]) {
            DB::table('slider_beranda')->insert([
                'judul'         => $judul,
                'subjudul'      => $subjudul,
                'foto_path'     => 'slider/slide-' . $urutan . '.jpg',
                'foto_alt'      => $judul . ' - SMK Bustanul Ulum',
                'tombol_label'  => $label,
                'tombol_url'    => $url,
                'is_published'  => $isPub,
                'urutan'        => $urutan,
                'created_by'    => $adminUser,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 42. LINK CEPAT
        // ─────────────────────────────────────────────
        $linkList = [
            ['PPDB Online',         '/ppdb',        'academic-cap',    '#3B82F6', false, 1],
            ['E-Learning',          '/elearning',   'computer-desktop','#10B981', false, 2],
            ['Cek Nilai',           '/nilai',        'chart-bar',       '#F59E0B', false, 3],
            ['Absensi Online',      '/absensi',     'clipboard-list',  '#8B5CF6', false, 4],
            ['Kontak Sekolah',      '/kontak',      'phone',           '#EF4444', false, 5],
        ];
        foreach ($linkList as [$label, $url, $ikon, $warna, $tabBaru, $urutan]) {
            DB::table('link_cepat')->insert([
                'label'         => $label,
                'url'           => $url,
                'ikon'          => $ikon,
                'warna'         => $warna,
                'buka_tab_baru' => $tabBaru,
                'is_published'  => true,
                'urutan'        => $urutan,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 43. KONTAK PESAN
        // ─────────────────────────────────────────────
        $kontakList = [
            ['Ahmad Zaini',      'zaini@gmail.com',   '081298760001', 'Informasi PPDB 2025',    'Apakah ada beasiswa untuk calon siswa berprestasi?',           'baru'],
            ['Maryam Hasanah',   'maryam@yahoo.com',  '081298760002', 'Jurusan RPL',             'Apakah lulusan RPL bisa langsung kerja atau harus kuliah?',    'dibaca'],
            ['Rudi Santoso',     'rudi@gmail.com',    null,           'Fasilitas Lab Komputer',  'Berapa jumlah komputer di lab RPL? Apakah kondisinya baik?',   'dibalas'],
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
        $this->command->info('✅ Seeder SMK Bustanul Ulum selesai!');
        $this->command->info('═══════════════════════════════════════════');
        $this->command->info('👤 Admin         → admin@smkbu.sch.id');
        $this->command->info('🛡  Guru Piket    → piket@smkbu.sch.id');
        $this->command->info('👨‍🏫 12 Guru        → [slug]@smkbu.sch.id');
        $this->command->info('🎓 40 Siswa       → [slug]@smkbu.sch.id');
        $this->command->info('👨‍👩‍👧 20 Orang Tua   → [slug]@ortu.smkbu.sch.id');
        $this->command->info('🔑 Password semua: password');
        $this->command->info('');
        $this->command->info('📚 Jurusan: TKJ | RPL | Multimedia | AKL');
        $this->command->info('🏫 10 Kelas (X, XI, XII)');
        $this->command->info('📖 15 Mata Pelajaran');
        $this->command->info('📅 14 Jadwal Pelajaran');
        $this->command->info('═══════════════════════════════════════════');
    }
}