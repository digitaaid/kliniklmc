<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Luthfi Medical Center',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Klinik LMC</b>',
    'logo_img' => 'vendor/adminlte/dist/img/lmc-b.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Klinik LMC Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' =>  'vendor/adminlte/dist/img/lmc-b.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 70,
            'height' => 70,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/lmc-b.png',
            'alt' => 'Klinik Preloader Image',
            'effect' => 'animation__shake',
            'width' => 150,
            'height' => 150,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-purple',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'text-sm',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => false,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => 'profile',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text'        => 'Landing Page',
            'url'         => '',
            'icon'        => 'fas fa-globe',
        ],
        [
            'text'        => 'Dashboard',
            'url'         => 'home',
            'icon'        => 'fas fa-home',
        ],
        // PELAYANAN
        [
            'text'    => 'Pelayanan',
            'icon'    => 'fas fa-hand-holding-medical',
            'submenu' => [
                [
                    'text' => 'Anjungan Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'anjunganantrian',
                    'shift'   => 'ml-2',
                    'can' => ['rekammedis', 'pendaftaran'],
                ],
                [
                    'text' => 'Display Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'displayantrian',
                    'shift'   => 'ml-2',
                    'can' => ['rekammedis', 'pendaftaran'],
                ],
                [
                    'text' => 'Pendaftaran Rawat Jalan',
                    'icon'    => 'fas fa-users',
                    'shift'   => 'ml-2',
                    'url'  => 'antrianpendaftaran',
                    'active'  => ['antrianpendaftaran', 'prosespendaftaran', 'lihatpendaftaran'],
                    'can' => ['rekammedis', 'pendaftaran'],
                ],
                // [
                //     'text' => 'Antrian Kasir',
                //     'icon'    => 'fas fa-users',
                //     'shift'   => 'ml-2',
                //     'url'  => 'antriankasir',
                //     'active'  => ['antriankasir', 'lihatkasir'],
                //     'can' => ['rekammedis', 'pendaftaran'],
                // ],
                [
                    'text' => 'Pelayanan Perawat',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'antrianperawat',
                    'active'  => ['antrianperawat', 'prosesperawat'],
                    'shift'   => 'ml-2',
                    'can' => ['rekammedis', 'perawat'],
                ],
                [
                    'text' => 'Pelayanan Poliklinik',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'antrianpoliklinik',
                    'active'  => ['antrianpoliklinik', 'prosespoliklinik'],
                    'shift'   => 'ml-2',
                    'can' => ['rekammedis', 'dokter'],
                ],
                [
                    'text' => 'Pelayanan Farmasi',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'antrianfarmasi',
                    'shift'   => 'ml-2',
                    'can' => ['rekammedis', 'farmasi'],
                ],
                [
                    'text' => 'Obat Kemoterapi',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'obatkemoterapi',
                    'shift'   => 'ml-2',
                    'can' => ['rekammedis', 'farmasi'],
                ],
                [
                    'text' => 'Permintaan Laboratorium',
                    'icon'    => 'fas fa-vials',
                    'url'  => 'permintaanlab_index',
                    'shift'   => 'ml-2',
                    'can' => 'laboratorium',
                    'active'  => ['permintaanlab_index', 'permintaanlab_proses'],
                ],
            ]
        ],
        // PENGELOLAAN
        [
            'text'    => 'Pengelolaan',
            'icon'    => 'fas fa-clinic-medical',
            'submenu' => [
                [
                    'text' => 'Pasien',
                    'icon'    => 'fas fa-user-injured',
                    'shift'   => 'ml-2',
                    'url'  => 'pasien',
                    'active'  => ['pasien', 'riwayatpasien'],
                    'can' => 'pendaftaran',
                ],
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'poliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'manajemen',
                ],
                [
                    'text' => 'Unit',
                    'icon'    => 'fas fa-clinic-medical',
                    'shift'   => 'ml-2',
                    'url'  => 'unit',
                    'can' => 'manajemen',
                ],
                [
                    'text' => 'Dokter',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'dokter',
                    'can' => 'manajemen',
                    'shift'   => 'ml-2',

                ],
                [
                    'text' => 'Jadwal Dokter',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'jadwaldokter',
                    'can' =>  ['pendaftaran', 'bpjs', 'manajemen', 'dokter'],
                    'shift'   => 'ml-2',

                ],
                [
                    'text' => 'Kunjungan',
                    'icon'    => 'fas fa-users',
                    'shift'   => 'ml-2',
                    'url'  => 'kunjungan',
                    'can' => ['pendaftaran', 'rekammedis'],
                ],
                [
                    'text' => 'Berkas Upload',
                    'icon'    => 'fas fa-file',
                    'url'  => 'fileupload',
                    'can' => ['pendaftaran', 'perawat', 'dokter', 'rekammedis'],
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Obat',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'obat',
                    'can' => 'farmasi',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Stok Obat',
                    'icon'    => 'fas fa-box',
                    'url'  => 'stokobat',
                    'active'  => ['stokobat',  'regex:@^stokobat(\/[0-9]+)?+$@'],
                    'can' => 'farmasi',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Jaminan',
                    'icon'    => 'fas fa-money-check-alt',
                    'url'  => 'jaminan',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Diagnosa',
                    'icon'    => 'fas fa-diagnoses',
                    'url'  => 'diagnosa',
                    'shift'   => 'ml-2',
                    'can' =>  ['perawat', 'admin',  'dokter'],
                ],
                [
                    'text' => 'Tarif Layanan & Tindakan',
                    'icon'    => 'fas fa-hand-holding-medical',
                    'url'  => 'tarif',
                    'shift'   => 'ml-2',
                    'can' =>  ['manajemen', 'admin'],
                ],
                [
                    'text' => 'Pemeriksaan Laboratorium',
                    'icon'    => 'fas fa-vials',
                    'url'  => 'pemeriksaanlab',
                    'shift'   => 'ml-2',
                    'can' =>  ['laboratorium'],
                ],
                [
                    'text' => 'Parameter Laboratorium',
                    'icon'    => 'fas fa-vials',
                    'url'  => 'parameterlab',
                    'shift'   => 'ml-2',
                    'can' =>  ['laboratorium'],
                ],
                [
                    'text' => 'Download Backup File',
                    'icon'    => 'fas fa-sync',
                    'url'  => 'download_backup_file',
                    'shift'   => 'ml-2',
                    'can' => 'manajemen',
                ],
            ],
        ],
        // LAPORAN
        [
            'text'    => 'Laporan',
            'icon'    => 'fas fa-chart-line',
            'submenu' => [
                [
                    'text' => 'Laporan Pelayanan & Tindakan',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'laporan_layanan_tindakan',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Capaian Antrian',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'capaianantrian',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Resume Rawat Jalan',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'resumerawatjalan',
                    'can' => ['pendaftaran', 'rekammedis'],
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan Pendaftaran',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'laporanpendaftaran',
                    'can' => 'pendaftaran',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan Kunjungan',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'laporankunjungan',
                    'can' => 'pendaftaran',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan SEP',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'laporansep',
                    'can' => 'pendaftaran',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan Waktu Antrian',
                    'icon'    => 'fas fa-stopwatch',
                    'url'  => 'laporanwaktuantrian',
                    'can' => 'pendaftaran',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan Perawat',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'laporanperawat',
                    'can' => 'perawat',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan Farmasi',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'laporanfarmasi',
                    'can' => 'farmasi',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan Resep Obat',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'laporanobat',
                    'shift'   => 'ml-2',
                    'can' => 'farmasi',
                ],
                [
                    'text' => 'Histori Pelayanan Obat',
                    'icon'    => 'fas fa-chart-line',
                    'url'  => 'laporanobatpasien',
                    'shift'   => 'ml-2',
                    'can' => 'farmasi',
                ],
            ],
        ],
        // ANTRIAN BPJS
        [
            'text'    => 'Integrasi Antrian BPJS',
            'icon'    => 'fas fa-project-diagram',
            'can' => ['bpjs', 'pendaftaran'],
            'submenu' => [
                [
                    'text' => 'Status Bridging',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'statusAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'poliklikAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Dokter',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'dokterAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Jadwal Dokter',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'jadwalDokterAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['pendaftaran', 'bpjs', 'manajemen'],
                ],
                [
                    'text' => 'Cek Fingerprint Peserta',
                    'icon'    => 'fas fa-fingerprint',
                    'url'  => 'fingerprintPeserta',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Anjungan Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'anjunganantrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Antrian',
                    'icon'    => 'fas fa-hospital-user',
                    'url'  => 'antrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'List Task',
                    'icon'    => 'fas fa-user-clock',
                    'url'  => 'listTaskID',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Dasboard Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'dashboardTanggalAntrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Dashboard Bulan',
                    'icon'    => 'fas fa-calendar-week',
                    'url'  => 'dashboardBulanAntrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                // [
                //     'text' => 'Jadwal Operasi',
                //     'icon'    => 'fas fa-calendar-alt',
                //     'url'  => 'jadwalOperasi',
                //     'shift'   => 'ml-2',
                // 'can' =>  ['bpjs', 'pendaftaran','manajemen'],
                // ],
                [
                    'text' => 'Antrian Per Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianPerTanggal',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Monitoring Antrian',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'monitoringAntrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Antrian Per Kodebooking',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianPerKodebooking',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Antrian Belum  Dilayani',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianBelumDilayani',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Antrian Per Dokter',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianPerDokter',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'manajemen'],
                ],

            ],
        ],
        // VCLAIM BPJS
        [
            'text'    => 'Integrasi VClaim BPJS',
            'icon'    => 'fas fa-project-diagram',
            'can' => ['bpjs', 'pendaftaran', 'manajemen'],
            'submenu' => [
                [
                    'text' => 'Peserta BPJS',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'peserta_bpjs',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'vclaim', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'SEP Rawat Jalan',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'sep_rajal',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'vclaim', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'SEP Rawat Inap',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'sep_ranap',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Surat Kontrol',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'suratkontrol',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'vclaim', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Lembar Pengajuan Klaim',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'vclaim/lpk',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Data Kunjungan',
                    'icon'    => 'fas fa-chart-bar',
                    'url'  => 'monitoringDataKunjungan',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Data Klaim',
                    'icon'    => 'fas fa-chart-pie',
                    'url'  => 'monitoringDataKlaim',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Pelayanan Peserta',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'monitoringPelayananPeserta',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Data Klaim Jasa Raharja',
                    'icon'    => 'fas fa-chart-area',
                    'url'  => 'monitoringKlaimJasaraharja',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'PRB',
                    'icon'    => 'fas fa-first-aid',
                    'url'  => 'vclaim/prb',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Referensi',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'referensiVclaim',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],
                [
                    'text' => 'Rujukan',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'rujukanBpjs',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                ],

                [
                    'text' => 'SEP',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'submenu' => [
                        [
                            'text' => 'SEP Kunjungan',
                            'icon'    => 'fas fa-id-card',
                            'url'  => 'sepkunjungan',
                            'shift'   => 'ml-3',
                            'can' => ['bpjs', 'pendaftaran', 'manajemen'],
                        ],
                    ]
                ],

            ],
        ],
        [
            'text'    => 'Integrasi Satu Sehat',
            'icon'    => 'fas fa-project-diagram',
            'can' => ['bpjs', 'pendaftaran'],
            'submenu' => [
                [
                    'text' => 'Patient',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'satusehat/patient',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'rekammedis'],
                ],
                [
                    'text' => 'Practitioner',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'satusehat/practitioner',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'rekammedis'],
                ],
                [
                    'text' => 'Organization',
                    'icon'    => 'fas fa-hospital',
                    'url'  => 'satusehat/organization',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'rekammedis'],
                ],
                [
                    'text' => 'Location',
                    'icon'    => 'fas fa-hospital',
                    'url'  => 'satusehat/location',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'rekammedis'],
                ],
                [
                    'text' => 'Encouter',
                    'icon'    => 'fas fa-user',
                    'url'  => 'satusehat/patnt',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'rekammedis'],
                ],
                [
                    'text' => 'Condition',
                    'icon'    => 'fas fa-user',
                    'url'  => 'satusehat/pient',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'rekammedis'],
                ],
            ],
        ],
        // MODUL TESTING
        [
            'text'    => 'Pengaturan Web',
            'icon'    => 'fas fa-globe',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Carousel',
                    'icon'    => 'fas fa-images',
                    'url'  => 'carousel',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Testimoni',
                    'icon'    => 'fas fa-comment-medical',
                    'url'  => 'testimoni',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Galeri',
                    'icon'    => 'fas fa-images',
                    'url'  => 'galeri',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Tanya Jawab',
                    'icon'    => 'fas fa-question-circle',
                    'url'  => 'tanyajawab',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
            ],
        ],
        // MODUL TESTING
        [
            'text'    => 'Pengaturan & Testing',
            'icon'    => 'fas fa-cogs',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Integrasi API',
                    'icon'    => 'fas fa-globe',
                    'url'  => 'integrasiAPI',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Bar & QR Code Scanner',
                    'icon'    => 'fas fa-qrcode',
                    'url'  => 'cekBarQRCode',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Thermal Printer',
                    'icon'    => 'fas fa-print',
                    'url'  => 'cekThermalPrinter',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'WhatsApp API',
                    'icon'    => 'fas fa-phone',
                    'url'  => 'whatsapp',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text'        => 'Log Viewer',
                    'url'         => 'log-viewer',
                    'icon'        => 'fas fa-info-circle',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
            ],
        ],
        // MODUL TESTING
        [
            'text'    => 'Sync Data',
            'icon'    => 'fas fa-cogs',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Antrian BPJS',
                    'icon'    => 'fas fa-globe',
                    'url'  => 'sync_antrian_bpjs',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],

            ],
        ],
        ['header' => 'PENGATURAN AKUN'],
        // USER ACCESS CONTROLL
        [
            'text'    => 'User Access Control',
            'icon'    => 'fas fa-users-cog',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'User',
                    'icon'    => 'fas fa-users',
                    'url'  => 'user',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    'active'  => ['user', 'user/create', 'user_synchronize', 'regex:@^user(\/[0-9]+)?+$@', 'regex:@^user(\/[0-9]+)?\/edit+$@',],
                ],
                [
                    'text' => 'Role & Permission',
                    'icon'    => 'fas fa-user-shield',
                    'url'  => 'role',
                    'shift'   => 'ml-2',
                    'active'  => ['role', 'role/create', 'regex:@^role(\/[0-9]+)?+$@', 'regex:@^role(\/[0-9]+)?\/edit+$@', 'regex:@^permission(\/[0-9]+)?\/edit+$@'],
                    'can' => 'admin',
                ],
            ],
        ],
        [
            'text' => 'Profile',
            'url'  => 'profile',
            'icon' => 'fas fa-fw fa-user',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'TempusDominusBs4' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesPlugins' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesFixedColumns' => [
            'active' => false,
            'files' => [
                // [
                //     'type' => 'js',
                //     'asset' => true,
                //     'location' => 'vendor/datatables-plugins/fixedcolumns/js/fixedColumns.bootstrap4.min.js',
                // ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/fixedcolumns/js/dataTables.fixedColumns.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/fixedcolumns/css/fixedColumns.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/themes/blue/pace-theme-flat-top.css'
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/pace.min.js'
                ],
            ],
        ],
        'DateRangePicker' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' =>  'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.css',
                ],
            ],
        ],
        'EkkoLightBox' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' =>  'vendor/ekko-lightbox/ekko-lightbox.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' =>  'vendor/ekko-lightbox/ekko-lightbox.css',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
