<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\PeriodeEvaluasi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User
        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@kecamatancangkuang.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'jabatan' => 'Administrator Sistem',
            'kelas_jabatan' => 17, // Kelas tertinggi untuk admin
            'telepon' => '081234567890',
            'alamat' => 'Kantor Kecamatan Cangkuang',
            'status' => 'aktif',
        ]);

        // Seed Pegawai Users (berdasarkan data gambar dengan kelas jabatan angka)
        $pegawaiData = [
            [
                'nama' => 'Agus Mulya, S.PT., MM',
                'username' => 'agus.mulya',
                'email' => 'agusmulya@kecamatancangkuang.go.id',
                'jabatan' => 'Plt. Plt.(u) Camat Kecamatan Cangkuang',
                'kelas_jabatan' => 12,
                'telepon' => '081234567891',
            ],
            [
                'nama' => 'Andri Yudha Prawira, S.I.P., M.SI.',
                'username' => 'andri.yudha',
                'email' => 'andriyudha@kecamatancangkuang.go.id',
                'jabatan' => 'Sekretaris Kecamatan Sekretariat Kecamatan Cangkuang',
                'kelas_jabatan' => 11,
                'telepon' => '081234567892',
            ],
            [
                'nama' => 'Rahmat Hidayat, SH',
                'username' => 'rahmat.hidayat',
                'email' => 'rahmathidayat@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Sub Bagian Program dan Keuangan Kecamatan Cangkuang',
                'kelas_jabatan' => 9,
                'telepon' => '081234567893',
            ],
            [
                'nama' => 'Ajo Suarjo, S.M.',
                'username' => 'ajo.suarjo',
                'email' => 'ajosuarjo@kecamatancangkuang.go.id',
                'jabatan' => 'Penelaah Teknis Kebijakan Sub Bagian Program dan Keuangan Kecamatan Cangkuang',
                'kelas_jabatan' => 9,
                'telepon' => '081234567894',
            ],
            [
                'nama' => 'Fahmi Taufik Firdaus, A.Md.',
                'username' => 'fahmi.taufik',
                'email' => 'fahmitaufik@kecamatancangkuang.go.id',
                'jabatan' => 'Arsiparis Terampil Sub Bagian Umum dan Kepegawaian Kecamatan Cangkuang',
                'kelas_jabatan' => 6,
                'telepon' => '081234567895',
            ],
            [
                'nama' => 'Hari Sumarhadi, S.A.P.',
                'username' => 'hari.sumarhadi',
                'email' => 'harisumarhadi@kecamatancangkuang.go.id',
                'jabatan' => 'Pengolah Data dan Informasi Sub Bagian Umum dan Kepegawaian Kecamatan Cangkuang',
                'kelas_jabatan' => 6,
                'telepon' => '081234567896',
            ],
            [
                'nama' => 'Mayang Kusuma Nariyah, A.MD.Kom.',
                'username' => 'mayang.kusuma',
                'email' => 'mayangkusuma@kecamatancangkuang.go.id',
                'jabatan' => 'Pengolah Data dan Informasi Sub Bagian Program dan Keuangan Kecamatan Cangkuang',
                'kelas_jabatan' => 6,
                'telepon' => '081234567897',
            ],
            [
                'nama' => 'Siti Noviyanti S.Sos, M.K.P',
                'username' => 'siti.noviyanti',
                'email' => 'sitinoviyanti@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Seksi Pemerintahan Kecamatan Cangkuang',
                'kelas_jabatan' => 8,
                'telepon' => '081234567898',
            ],
            [
                'nama' => 'Dian Akhmad Rifqi, A.MD',
                'username' => 'dian.akhmad',
                'email' => 'dianakhmad@kecamatancangkuang.go.id',
                'jabatan' => 'Pengolah Data dan Informasi Seksi Pemerintahan Kecamatan Cangkuang',
                'kelas_jabatan' => 6,
                'telepon' => '081234567899',
            ],
            [
                'nama' => 'Reny Yulia, SH, M.SI',
                'username' => 'reny.yulia',
                'email' => 'renyyulia@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Seksi Pemberdayaan Masyarakat Kecamatan Cangkuang',
                'kelas_jabatan' => 8,
                'telepon' => '081234567800',
            ],
            [
                'nama' => 'Yahya',
                'username' => 'yahya',
                'email' => 'yahya@kecamatancangkuang.go.id',
                'jabatan' => 'Pengolah Data dan Informasi Seksi Pembangunan Kecamatan Cangkuang',
                'kelas_jabatan' => 6,
                'telepon' => '081234567801',
            ],
            [
                'nama' => 'Lia Yuliana, S.Sos., M.Si',
                'username' => 'lia.yuliana',
                'email' => 'liayuliana@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Seksi Sosial Budaya Kecamatan Cangkuang',
                'kelas_jabatan' => 8,
                'telepon' => '081234567802',
            ],
            [
                'nama' => 'Soni Permana',
                'username' => 'soni.permana',
                'email' => 'sonipermana@kecamatancangkuang.go.id',
                'jabatan' => 'Pengolah Data dan Informasi Seksi Sosial Budaya Kecamatan Cangkuang',
                'kelas_jabatan' => 6,
                'telepon' => '081234567803',
            ],
            [
                'nama' => 'Muhdiman, S.Sos',
                'username' => 'muhdiman',
                'email' => 'muhdiman@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Seksi Ketentraman dan Ketertiban Umum Kecamatan Cangkuang',
                'kelas_jabatan' => 8,
                'telepon' => '081234567804',
            ],
        ];

        foreach ($pegawaiData as $pegawai) {
            User::create([
                'nama' => $pegawai['nama'],
                'username' => $pegawai['username'],
                'email' => $pegawai['email'],
                'password' => Hash::make('password123'), // default password
                'role' => 'pegawai',
                'jabatan' => $pegawai['jabatan'],
                'kelas_jabatan' => $pegawai['kelas_jabatan'],
                'telepon' => $pegawai['telepon'],
                'alamat' => 'Kecamatan Cangkuang, Bandung',
                'status' => 'aktif',
            ]);
        }

        // Seed Kriteria (berdasarkan data Excel)
        $kriteriaData = [
            [
                'kode' => 'C1',
                'nama' => 'Produktivitas Kerja',
                'bobot' => 0.40,
                'tren' => 'positif',
                'status' => 'aktif',
            ],
            [
                'kode' => 'C2',
                'nama' => 'Tanggung Jawab',
                'bobot' => 0.20,
                'tren' => 'positif',
                'status' => 'aktif',
            ],
            [
                'kode' => 'C3',
                'nama' => 'Kehadiran',
                'bobot' => 0.20,
                'tren' => 'positif',
                'status' => 'aktif',
            ],
            [
                'kode' => 'C4',
                'nama' => 'Pelanggaran Disiplin',
                'bobot' => 0.10,
                'tren' => 'negatif',
                'status' => 'aktif',
            ],
            [
                'kode' => 'C5',
                'nama' => 'Terlambat',
                'bobot' => 0.10,
                'tren' => 'negatif',
                'status' => 'aktif',
            ],
        ];

        foreach ($kriteriaData as $kriteria) {
            Kriteria::create($kriteria);
        }

        // Seed Periode Evaluasi
        PeriodeEvaluasi::create([
            'nama' => 'Evaluasi Kinerja April 2025',
            'tahun' => 2025,
            'bulan' => 4,
            'tgl_mulai' => '2025-04-01',
            'tgl_selesai' => '2025-04-30',
            'status' => 'aktif',
        ]);

        PeriodeEvaluasi::create([
            'nama' => 'Evaluasi Kinerja Maret 2025',
            'tahun' => 2025,
            'bulan' => 3,
            'tgl_mulai' => '2025-03-01',
            'tgl_selesai' => '2025-03-31',
            'status' => 'selesai',
        ]);
    }
}
