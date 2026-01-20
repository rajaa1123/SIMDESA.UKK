<?php

/**
 * Dynamic Form Schema Definitions for Each Layanan Type
 * 
 * This config defines which fields should be shown in the permohonan form
 * based on the selected layanan. Each field will be rendered dynamically
 * and saved to permohonan.form_data as JSON.
 */

// Helper function: Common personal data fields (to prevent dashes in PDF)
$commonPersonalFields = [
    'nama' => [
        'type' => 'text',
        'label' => 'Nama Lengkap (sesuai KTP)',
        'required' => true,
        'placeholder' => 'Nama sesuai KTP'
    ],
    'nik' => [
        'type' => 'text',
        'label' => 'NIK',
        'required' => true,
        'placeholder' => '16 digit NIK'
    ],
    'tempat_lahir' => [
        'type' => 'text',
        'label' => 'Tempat Lahir',
        'required' => true,
        'placeholder' => 'Contoh: Sidoarjo'
    ],
    'tanggal_lahir' => [
        'type' => 'date',
        'label' => 'Tanggal Lahir',
        'required' => true
    ],
    'jenis_kelamin' => [
        'type' => 'select',
        'label' => 'Jenis Kelamin',
        'required' => true,
        'options' => ['Laki-laki', 'Perempuan']
    ],
    'agama' => [
        'type' => 'select',
        'label' => 'Agama',
        'required' => true,
        'options' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']
    ],
    'pekerjaan' => [
        'type' => 'text',
        'label' => 'Pekerjaan',
        'required' => true,
        'placeholder' => 'Contoh: Karyawan Swasta, Wiraswasta'
    ],
    'alamat' => [
        'type' => 'textarea',
        'label' => 'Alamat Lengkap (sesuai KTP)',
        'required' => true,
        'placeholder' => 'Alamat sesuai KTP'
    ],
    'rt' => [
        'type' => 'text',
        'label' => 'RT',
        'required' => true,
        'placeholder' => 'Contoh: 02'
    ],
    'rw' => [
        'type' => 'text',
        'label' => 'RW',
        'required' => true,
        'placeholder' => 'Contoh: 05'
    ],
];

return [
    /**
     * Surat Keterangan Kematian
     */
    'kematian' => array_merge($commonPersonalFields, [
        'nama_almarhum' => [
            'type' => 'text',
            'label' => 'Nama Lengkap Almarhum/Almarhumah',
            'required' => true,
            'placeholder' => 'Nama sesuai KTP'
        ],
        'tanggal_meninggal' => [
            'type' => 'date',
            'label' => 'Tanggal Meninggal',
            'required' => true
        ],
        'tempat_meninggal' => [
            'type' => 'text',
            'label' => 'Tempat Meninggal',
            'required' => true,
            'placeholder' => 'Contoh: Rumah Sakit, Rumah'
        ],
        'sebab_kematian' => [
            'type' => 'text',
            'label' => 'Sebab Kematian',
            'required' => false,
            'placeholder' => 'Opsional'
        ],
        'hubungan_pelapor' => [
            'type' => 'select',
            'label' => 'Hubungan Pelapor dengan Almarhum',
            'required' => true,
            'options' => ['Anak', 'Istri/Suami', 'Orang Tua', 'Saudara', 'Lainnya']
        ],
    ]),

    /**
     * Surat Domisili Tempat Tinggal
     */
    'domisili' => array_merge($commonPersonalFields, [
        'alamat_domisili_lengkap' => [
            'type' => 'textarea',
            'label' => 'Alamat Domisili Lengkap',
            'required' => true,
            'placeholder' => 'Alamat domisili detail termasuk RT/RW'
        ],
        'lama_tinggal' => [
            'type' => 'text',
            'label' => 'Lama Tinggal di Alamat Ini',
            'required' => false,
            'placeholder' => 'Contoh: 5 tahun'
        ],
        'keperluan' => [
            'type' => 'text',
            'label' => 'Untuk Keperluan',
            'required' => true,
            'placeholder' => 'Contoh: Melamar pekerjaan, Pendaftaran sekolah'
        ],
    ]),

    /**
     * Surat Pernyataan Ahli Waris
     */
    'ahli-waris' => array_merge($commonPersonalFields, [
        'nama_pewaris' => [
            'type' => 'text',
            'label' => 'Nama Pewaris (Yang Meninggal)',
            'required' => true
        ],
        'tanggal_meninggal_pewaris' => [
            'type' => 'date',
            'label' => 'Tanggal Meninggal Pewaris',
            'required' => true
        ],
        'hubungan_ahli_waris' => [
            'type' => 'select',
            'label' => 'Hubungan dengan Pewaris',
            'required' => true,
            'options' => ['Anak Kandung', 'Istri/Suami', 'Orang Tua', 'Saudara Kandung']
        ],
        'jumlah_ahli_waris' => [
            'type' => 'number',
            'label' => 'Jumlah Ahli Waris',
            'required' => true,
            'min' => 1
        ],
    ]),

    /**
     * Surat Keterangan Riwayat Tanah
     */
    'riwayat-tanah' => array_merge($commonPersonalFields, [
        'lokasi_tanah' => [
            'type' => 'textarea',
            'label' => 'Lokasi Tanah',
            'required' => true
        ],
        'luas_tanah' => [
            'type' => 'text',
            'label' => 'Luas Tanah',
            'required' => true,
            'placeholder' => 'Contoh: 100 m²'
        ],
        'batas_utara' => ['type' => 'text', 'label' => 'Batas Utara', 'required' => true],
        'batas_selatan' => ['type' => 'text', 'label' => 'Batas Selatan', 'required' => true],
        'batas_timur' => ['type' => 'text', 'label' => 'Batas Timur', 'required' => true],
        'batas_barat' => ['type' => 'text', 'label' => 'Batas Barat', 'required' => true],
        'asal_tanah' => [
            'type' => 'select',
            'label' => 'Asal/Perolehan Tanah',
            'required' => true,
            'options' => ['Warisan', 'Jual Beli', 'Hibah', 'Lainnya']
        ],
    ]),

    /**
     * Surat Keterangan Beda Nama
     */
    'beda-nama' => array_merge($commonPersonalFields, [
        'nama_sekarang' => ['type' => 'text', 'label' => 'Nama Saat Ini', 'required' => true],
        'nama_lama' => ['type' => 'text', 'label' => 'Nama Lama/Berbeda', 'required' => true],
        'perbedaan' => ['type' => 'textarea', 'label' => 'Penjelasan Perbedaan', 'required' => true],
        'dokumen_berbeda' => ['type' => 'text', 'label' => 'Nama Dokumen yang Berbeda', 'required' => true, 'placeholder' => 'Contoh: Ijazah, Akta Lahir'],
    ]),

    /**
     * Surat Keterangan Janda/Duda
     */
    'janda-duda' => array_merge($commonPersonalFields, [
        'status_perkawinan' => [
            'type' => 'select',
            'label' => 'Status',
            'required' => true,
            'options' => ['Janda', 'Duda']
        ],
        'nama_pasangan' => ['type' => 'text', 'label' => 'Nama Almarhum/Almarhumah Pasangan', 'required' => true],
        'tanggal_meninggal_pasangan' => ['type' => 'date', 'label' => 'Tanggal Meninggal Pasangan', 'required' => true],
        'tanggal_perkawinan' => ['type' => 'date', 'label' => 'Tanggal Perkawinan', 'required' => false],
    ]),

    /**
     * Legalisasi Dokumen
     */
    'legalisasi' => array_merge($commonPersonalFields, [
        'jenis_dokumen' => ['type' => 'text', 'label' => 'Jenis Dokumen yang Dilegalisasi', 'required' => true],
        'keperluan_legalisasi' => ['type' => 'textarea', 'label' => 'Keperluan Legalisasi', 'required' => true],
    ]),

    /**
     * Surat Keterangan Belum Menikah
     */
    'belum-menikah' => array_merge($commonPersonalFields, [
        'keperluan' => ['type' => 'text', 'label' => 'Untuk Keperluan', 'required' => true, 'placeholder' => 'Contoh: Melamar calon pasangan'],
    ]),

    /**
     * Surat Keterangan Domisili Usaha
     */
    'domisili-usaha' => array_merge($commonPersonalFields, [
        'nama_usaha' => ['type' => 'text', 'label' => 'Nama Usaha', 'required' => true],
        'jenis_usaha' => ['type' => 'text', 'label' => 'Jenis Usaha', 'required' => true],
        'alamat_usaha' => ['type' => 'textarea', 'label' => 'Alamat Usaha', 'required' => true],
        'tahun_berdiri' => ['type' => 'number', 'label' => 'Tahun Berdiri', 'required' => false, 'min' => 1900],
    ]),

    /**
     * Surat Pengantar Ijin Keramaian
     */
    'ijin-keramaian' => array_merge($commonPersonalFields, [
        'jenis_acara' => ['type' => 'text', 'label' => 'Jenis Acara', 'required' => true, 'placeholder' => 'Contoh: Pernikahan, Ulang Tahun'],
        'tanggal_acara' => ['type' => 'date', 'label' => 'Tanggal Acara', 'required' => true],
        'waktu_mulai' => ['type' => 'time', 'label' => 'Waktu Mulai', 'required' => true],
        'waktu_selesai' => ['type' => 'time', 'label' => 'Waktu Selesai', 'required' => true],
        'lokasi_acara' => ['type' => 'textarea', 'label' => 'Lokasi Acara', 'required' => true],
        'perkiraan_jumlah_tamu' => ['type' => 'number', 'label' => 'Perkiraan Jumlah Tamu', 'required' => true, 'min' => 1],
    ]),

    /**
     * Surat Keterangan Tidak Mampu (SKTM)
     */
    'sktm' => array_merge($commonPersonalFields, [
        'keperluan_sktm' => ['type' => 'text', 'label' => 'Untuk Keperluan', 'required' => true, 'placeholder' => 'Contoh: Berobat, Sekolah'],
        'jumlah_tanggungan' => ['type' => 'number', 'label' => 'Jumlah Tanggungan Keluarga', 'required' => false, 'min' => 0],
    ]),

    /**
     * Surat Pengantar Nikah
     */
    'pengantar-nikah' => array_merge($commonPersonalFields, [
        'status_perkawinan' => [
            'type' => 'select',
            'label' => 'Status Perkawinan',
            'required' => true,
            'options' => ['Jejaka', 'Perawan', 'Duda', 'Janda']
        ],
        'nama_calon_pasangan' => ['type' => 'text', 'label' => 'Nama Calon Pasangan', 'required' => true],
        'tempat_lahir_pasangan' => ['type' => 'text', 'label' => 'Tempat Lahir Pasangan', 'required' => true],
        'tanggal_lahir_pasangan' => ['type' => 'date', 'label' => 'Tanggal Lahir Pasangan', 'required' => true],
        'warga_negara_pasangan' => ['type' => 'text', 'label' => 'Warga Negara Pasangan', 'required' => true, 'placeholder' => 'Indonesia'],
        'agama_pasangan' => [
            'type' => 'select',
            'label' => 'Agama Pasangan',
            'required' => true,
            'options' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']
        ],
        'pekerjaan_pasangan' => ['type' => 'text', 'label' => 'Pekerjaan Pasangan', 'required' => true],
        'alamat_pasangan' => ['type' => 'textarea', 'label' => 'Alamat Pasangan', 'required' => true],
        'nama_ayah' => ['type' => 'text', 'label' => 'Nama Lengkap Ayah', 'required' => true],
        'nama_ibu' => ['type' => 'text', 'label' => 'Nama Lengkap Ibu', 'required' => true],
    ]),

    /**
     * Surat Pengantar SKCK
     */
    'skck' => array_merge($commonPersonalFields, [
        'keperluan' => ['type' => 'text', 'label' => 'Keperluan', 'required' => true, 'placeholder' => 'Contoh: Melamar Pekerjaan, Mendaftar CPNS'],
        'keterangan_lain' => ['type' => 'textarea', 'label' => 'Keterangan Lain', 'required' => false],
    ]),

    /**
     * Penanganan Pengaduan Masyarakat
     */
    'pengaduan' => array_merge($commonPersonalFields, [
        'perihal_pengaduan' => ['type' => 'text', 'label' => 'Perihal Pengaduan', 'required' => true],
        'uraian_pengaduan' => ['type' => 'textarea', 'label' => 'Uraian Detail Pengaduan', 'required' => true],
        'tindakan_diharapkan' => ['type' => 'textarea', 'label' => 'Tindakan yang Diharapkan', 'required' => false],
    ]),

    /**
     * Permohonan KTP Elektronik
     */
    'ktp' => array_merge($commonPersonalFields, [
        'jenis_permohonan' => [
            'type' => 'select',
            'label' => 'Jenis Permohonan',
            'required' => true,
            'options' => ['KTP Baru', 'Perpanjangan', 'Penggantian Rusak', 'Penggantian Hilang']
        ],
    ]),

    /**
     * Permohonan Kartu Keluarga (KK)
     */
    'kk' => array_merge($commonPersonalFields, [
        'jenis_permohonan_kk' => [
            'type' => 'select',
            'label' => 'Jenis Permohonan',
            'required' => true,
            'options' => ['KK Baru', 'Perubahan Data', 'Penambahan Anggota', 'Penggantian Rusak/Hilang']
        ],
        'alasan_permohonan' => ['type' => 'textarea', 'label' => 'Alasan Permohonan', 'required' => true],
    ]),

    /**
     * Permohonan Kartu Identitas Anak (KIA)
     */
    'kia' => array_merge($commonPersonalFields, [
        'nama_anak' => ['type' => 'text', 'label' => 'Nama Lengkap Anak', 'required' => true],
        'tanggal_lahir_anak' => ['type' => 'date', 'label' => 'Tanggal Lahir Anak', 'required' => true],
    ]),

    /**
     * Permohonan Pindah Tempat
     */
    'pindah-tempat' => array_merge($commonPersonalFields, [
        'alamat_tujuan_lengkap' => ['type' => 'textarea', 'label' => 'Alamat Tujuan Pindah (Lengkap)', 'required' => true],
        'provinsi_tujuan' => ['type' => 'text', 'label' => 'Provinsi Tujuan', 'required' => true],
        'kabupaten_tujuan' => ['type' => 'text', 'label' => 'Kabupaten/Kota Tujuan', 'required' => true],
        'kecamatan_tujuan' => ['type' => 'text', 'label' => 'Kecamatan Tujuan', 'required' => true],
        'desa_tujuan' => ['type' => 'text', 'label' => 'Desa/Kelurahan Tujuan', 'required' => true],
        'alasan_pindah' => ['type' => 'textarea', 'label' => 'Alasan Pindah', 'required' => true],
        'jumlah_anggota_pindah' => ['type' => 'number', 'label' => 'Jumlah Anggota Keluarga yang Pindah', 'required' => true, 'min' => 1],
    ]),

    /**
     * Permohonan Pembatalan Pindah
     */
    'pembatalan-pindah' => array_merge($commonPersonalFields, [
        'nomor_surat_pindah' => ['type' => 'text', 'label' => 'Nomor Surat Pindah yang Dibatalkan', 'required' => true],
        'alasan_pembatalan' => ['type' => 'textarea', 'label' => 'Alasan Pembatalan', 'required' => true],
    ]),

    /**
     * Permohonan Pindah Datang
     */
    'pindah-datang' => array_merge($commonPersonalFields, [
        'alamat_asal_lengkap' => ['type' => 'textarea', 'label' => 'Alamat Asal (Lengkap)', 'required' => true],
        'nomor_surat_pindah_asal' => ['type' => 'text', 'label' => 'Nomor Surat Pindah dari Daerah Asal', 'required' => false],
        'tanggal_kedatangan' => ['type' => 'date', 'label' => 'Tanggal Kedatangan', 'required' => true],
    ]),

    /**
     * Permohonan Akte Kelahiran
     */
    'akte-kelahiran' => array_merge($commonPersonalFields, [
        'nama_anak_lengkap' => ['type' => 'text', 'label' => 'Nama Lengkap Anak', 'required' => true],
        'tempat_lahir_anak' => ['type' => 'text', 'label' => 'Tempat Lahir', 'required' => true],
        'tanggal_lahir_anak' => ['type' => 'date', 'label' => 'Tanggal Lahir', 'required' => true],
        'jenis_kelamin_anak' => [
            'type' => 'select',
            'label' => 'Jenis Kelamin',
            'required' => true,
            'options' => ['Laki-laki', 'Perempuan']
        ],
        'anak_ke' => ['type' => 'number', 'label' => 'Anak Ke-', 'required' => true, 'min' => 1],
        'nama_ayah' => ['type' => 'text', 'label' => 'Nama Lengkap Ayah', 'required' => true],
        'nama_ibu' => ['type' => 'text', 'label' => 'Nama Lengkap Ibu', 'required' => true],
    ]),

    /**
     * Permohonan Akte Kematian
     */
    'akte-kematian' => array_merge($commonPersonalFields, [
        'nama_almarhum_akte' => ['type' => 'text', 'label' => 'Nama Lengkap Almarhum', 'required' => true],
        'tanggal_meninggal_akte' => ['type' => 'date', 'label' => 'Tanggal Meninggal', 'required' => true],
        'tempat_meninggal_akte' => ['type' => 'text', 'label' => 'Tempat Meninggal', 'required' => true],
    ]),

    /**
     * Permohonan Akte Perceraian
     */
    'akte-perceraian' => array_merge($commonPersonalFields, [
        'nomor_putusan_pengadilan' => ['type' => 'text', 'label' => 'Nomor Putusan Pengadilan', 'required' => true],
        'tanggal_putusan' => ['type' => 'date', 'label' => 'Tanggal Putusan', 'required' => true],
        'nama_mantan_pasangan' => ['type' => 'text', 'label' => 'Nama Mantan Pasangan', 'required' => true],
    ]),

    /**
     * Permohonan Akte Perkawinan
     */
    'akte-perkawinan' => array_merge($commonPersonalFields, [
        'nama_pasangan' => ['type' => 'text', 'label' => 'Nama Lengkap Pasangan', 'required' => true],
        'tanggal_perkawinan_akte' => ['type' => 'date', 'label' => 'Tanggal Perkawinan', 'required' => true],
        'tempat_perkawinan' => ['type' => 'text', 'label' => 'Tempat Perkawinan', 'required' => true],
    ]),

    /**
     * Permohonan Peduli Dilan (Pelayanan Keliling)
     */
    'peduli-dilan' => array_merge($commonPersonalFields, [
        'jenis_layanan_dilan' => ['type' => 'text', 'label' => 'Jenis Layanan yang Diminta', 'required' => true, 'placeholder' => 'Contoh: Pembuatan KTP, KK'],
        'keperluan_khusus' => ['type' => 'textarea', 'label' => 'Keperluan Khusus', 'required' => false, 'placeholder' => 'Contoh: Lansia, tidak bisa ke kantor'],
    ]),
];
