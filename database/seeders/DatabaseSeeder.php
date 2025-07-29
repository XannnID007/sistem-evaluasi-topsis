<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\PeriodeEvaluasi;
use App\Models\Evaluasi;

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
            'kelas_jabatan' => 17,
            'telepon' => '081234567890',
            'alamat' => 'Kantor Kecamatan Cangkuang',
            'status' => 'aktif',
        ]);

        // Seed Pegawai Users (21 pegawai berdasarkan data Excel)
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
                'nama' => 'Sriwantini, S.M',
                'username' => 'sriwantini',
                'email' => 'sriwantini@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Sub Bagian Umum dan Kepegawaian Kecamatan Cangkuang',
                'kelas_jabatan' => 9,
                'telepon' => '081234567894',
            ],
            [
                'nama' => 'Ajo Suarjo, S.M.',
                'username' => 'ajo.suarjo',
                'email' => 'ajosuarjo@kecamatancangkuang.go.id',
                'jabatan' => 'Penelaah Teknis Kebijakan Sub Bagian Program dan Keuangan Kecamatan Cangkuang',
                'kelas_jabatan' => 9,
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
            [
                'nama' => 'Didik Kurniawan, ST',
                'username' => 'didik.kurniawan',
                'email' => 'didikkurniawan@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Seksi Pembangunan Kecamatan Cangkuang',
                'kelas_jabatan' => 8,
                'telepon' => '081234567805',
            ],
            [
                'nama' => 'Fahmi Taufik Firdaus, A.Md.',
                'username' => 'fahmi.taufik',
                'email' => 'fahmitaufik@kecamatancangkuang.go.id',
                'jabatan' => 'Arsiparis Terampil Sub Bagian Umum dan Kepegawaian Kecamatan Cangkuang',
                'kelas_jabatan' => 6,
                'telepon' => '081234567806',
            ],
            [
                'nama' => 'RD. Agus Hamzah',
                'username' => 'agus.hamzah',
                'email' => 'agushamzah@kecamatancangkuang.go.id',
                'jabatan' => 'Pengolah Data dan Informasi Umum',
                'kelas_jabatan' => 6,
                'telepon' => '081234567807',
            ],
            [
                'nama' => 'Deden Gono Hartoyo',
                'username' => 'deden.gono',
                'email' => 'dedengono@kecamatancangkuang.go.id',
                'jabatan' => 'Pengolah Data dan Informasi',
                'kelas_jabatan' => 6,
                'telepon' => '081234567808',
            ],
            [
                'nama' => 'Andi Janwar',
                'username' => 'andi.janwar',
                'email' => 'andijanwar@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Umum',
                'kelas_jabatan' => 5,
                'telepon' => '081234567809',
            ],
            [
                'nama' => 'Domadonna Febby Pradita',
                'username' => 'domadonna.febby',
                'email' => 'domadonnafebby@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Administrasi',
                'kelas_jabatan' => 5,
                'telepon' => '081234567810',
            ],
            [
                'nama' => 'Ading Supriatna',
                'username' => 'ading.supriatna',
                'email' => 'adingsupriatna@kecamatancangkuang.go.id',
                'jabatan' => 'Keamanan dan Kebersihan',
                'kelas_jabatan' => 4,
                'telepon' => '081234567811',
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
        $periodeAktif = PeriodeEvaluasi::create([
            'nama' => 'Evaluasi Kinerja Juli 2025',
            'tahun' => 2025,
            'bulan' => 7,
            'tgl_mulai' => '2025-07-01',
            'tgl_selesai' => '2025-07-31',
            'status' => 'aktif',
        ]);

        $periodeLalu = PeriodeEvaluasi::create([
            'nama' => 'Evaluasi Kinerja Juni 2025',
            'tahun' => 2025,
            'bulan' => 6,
            'tgl_mulai' => '2025-06-01',
            'tgl_selesai' => '2025-06-30',
            'status' => 'selesai',
        ]);

        // Seed Evaluasi untuk periode aktif (Juli 2025)
        $evaluasiData = [
            [
                'nama' => 'Agus Mulya, S.PT., MM',
                'c1_produktivitas' => 85,
                'c2_tanggung_jawab' => 90,
                'c3_kehadiran' => 88,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Andri Yudha Prawira, S.I.P., M.SI.',
                'c1_produktivitas' => 85,
                'c2_tanggung_jawab' => 88,
                'c3_kehadiran' => 87,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Rahmat Hidayat, SH',
                'c1_produktivitas' => 75,
                'c2_tanggung_jawab' => 85,
                'c3_kehadiran' => 82,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Sriwantini, S.M',
                'c1_produktivitas' => 75,
                'c2_tanggung_jawab' => 75,
                'c3_kehadiran' => 80,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Ajo Suarjo, S.M.',
                'c1_produktivitas' => 75,
                'c2_tanggung_jawab' => 70,
                'c3_kehadiran' => 79,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Hari Sumarhadi, S.A.P.',
                'c1_produktivitas' => 88,
                'c2_tanggung_jawab' => 85,
                'c3_kehadiran' => 90,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Mayang Kusuma Nariyah, A.MD.Kom.',
                'c1_produktivitas' => 78,
                'c2_tanggung_jawab' => 80,
                'c3_kehadiran' => 85,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Siti Noviyanti S.Sos, M.K.P',
                'c1_produktivitas' => 83,
                'c2_tanggung_jawab' => 75,
                'c3_kehadiran' => 87,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Dian Akhmad Rifqi, A.MD',
                'c1_produktivitas' => 82,
                'c2_tanggung_jawab' => 75,
                'c3_kehadiran' => 86,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Reny Yulia, SH, M.SI',
                'c1_produktivitas' => 86,
                'c2_tanggung_jawab' => 82,
                'c3_kehadiran' => 88,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Yahya',
                'c1_produktivitas' => 76,
                'c2_tanggung_jawab' => 78,
                'c3_kehadiran' => 83,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Lia Yuliana, S.Sos., M.Si',
                'c1_produktivitas' => 77,
                'c2_tanggung_jawab' => 79,
                'c3_kehadiran' => 81,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Soni Permana',
                'c1_produktivitas' => 74,
                'c2_tanggung_jawab' => 73,
                'c3_kehadiran' => 79,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Muhdiman, S.Sos',
                'c1_produktivitas' => 81,
                'c2_tanggung_jawab' => 88,
                'c3_kehadiran' => 85,
                'c4_pelanggaran' => 0,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Didik Kurniawan, ST',
                'c1_produktivitas' => 78,
                'c2_tanggung_jawab' => 80,
                'c3_kehadiran' => 75,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Fahmi Taufik Firdaus, A.Md.',
                'c1_produktivitas' => 80,
                'c2_tanggung_jawab' => 84,
                'c3_kehadiran' => 87,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'RD. Agus Hamzah',
                'c1_produktivitas' => 76,
                'c2_tanggung_jawab' => 79,
                'c3_kehadiran' => 85,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Deden Gono Hartoyo',
                'c1_produktivitas' => 73,
                'c2_tanggung_jawab' => 72,
                'c3_kehadiran' => 75,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Andi Janwar',
                'c1_produktivitas' => 74,
                'c2_tanggung_jawab' => 73,
                'c3_kehadiran' => 78,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Domadonna Febby Pradita',
                'c1_produktivitas' => 73,
                'c2_tanggung_jawab' => 72,
                'c3_kehadiran' => 77,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Ading Supriatna',
                'c1_produktivitas' => 70,
                'c2_tanggung_jawab' => 84,
                'c3_kehadiran' => 82,
                'c4_pelanggaran' => 3,
                'c5_terlambat' => 5,
            ],
        ];

        // Buat evaluasi untuk periode aktif
        $adminUser = User::where('role', 'admin')->first();

        foreach ($evaluasiData as $evalData) {
            $pegawai = User::where('nama', $evalData['nama'])->where('role', 'pegawai')->first();

            if ($pegawai) {
                Evaluasi::create([
                    'user_id' => $pegawai->id,
                    'periode_id' => $periodeAktif->id,
                    'c1_produktivitas' => $evalData['c1_produktivitas'],
                    'c2_tanggung_jawab' => $evalData['c2_tanggung_jawab'],
                    'c3_kehadiran' => $evalData['c3_kehadiran'],
                    'c4_pelanggaran' => $evalData['c4_pelanggaran'],
                    'c5_terlambat' => $evalData['c5_terlambat'],
                    'created_by' => $adminUser->id,
                ]);
            }
        }

        // Buat juga beberapa evaluasi untuk periode sebelumnya (Juni 2025) dengan nilai sedikit berbeda
        $evaluasiDataJuni = [
            [
                'nama' => 'Agus Mulya, S.PT., MM',
                'c1_produktivitas' => 82,
                'c2_tanggung_jawab' => 87,
                'c3_kehadiran' => 85,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Andri Yudha Prawira, S.I.P., M.SI.',
                'c1_produktivitas' => 83,
                'c2_tanggung_jawab' => 85,
                'c3_kehadiran' => 84,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Rahmat Hidayat, SH',
                'c1_produktivitas' => 72,
                'c2_tanggung_jawab' => 82,
                'c3_kehadiran' => 80,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Sriwantini, S.M',
                'c1_produktivitas' => 73,
                'c2_tanggung_jawab' => 73,
                'c3_kehadiran' => 78,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Ajo Suarjo, S.M.',
                'c1_produktivitas' => 73,
                'c2_tanggung_jawab' => 68,
                'c3_kehadiran' => 76,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Hari Sumarhadi, S.A.P.',
                'c1_produktivitas' => 85,
                'c2_tanggung_jawab' => 83,
                'c3_kehadiran' => 88,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Mayang Kusuma Nariyah, A.MD.Kom.',
                'c1_produktivitas' => 76,
                'c2_tanggung_jawab' => 78,
                'c3_kehadiran' => 83,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Siti Noviyanti S.Sos, M.K.P',
                'c1_produktivitas' => 81,
                'c2_tanggung_jawab' => 73,
                'c3_kehadiran' => 85,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Dian Akhmad Rifqi, A.MD',
                'c1_produktivitas' => 80,
                'c2_tanggung_jawab' => 73,
                'c3_kehadiran' => 84,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Reny Yulia, SH, M.SI',
                'c1_produktivitas' => 84,
                'c2_tanggung_jawab' => 80,
                'c3_kehadiran' => 86,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 2,
            ],
            [
                'nama' => 'Yahya',
                'c1_produktivitas' => 74,
                'c2_tanggung_jawab' => 76,
                'c3_kehadiran' => 81,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Lia Yuliana, S.Sos., M.Si',
                'c1_produktivitas' => 75,
                'c2_tanggung_jawab' => 77,
                'c3_kehadiran' => 79,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Soni Permana',
                'c1_produktivitas' => 72,
                'c2_tanggung_jawab' => 71,
                'c3_kehadiran' => 77,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Muhdiman, S.Sos',
                'c1_produktivitas' => 79,
                'c2_tanggung_jawab' => 86,
                'c3_kehadiran' => 83,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Didik Kurniawan, ST',
                'c1_produktivitas' => 76,
                'c2_tanggung_jawab' => 78,
                'c3_kehadiran' => 73,
                'c4_pelanggaran' => 2,
                'c5_terlambat' => 4,
            ],
        ];

        foreach ($evaluasiDataJuni as $evalData) {
            $pegawai = User::where('nama', $evalData['nama'])->where('role', 'pegawai')->first();

            if ($pegawai) {
                Evaluasi::create([
                    'user_id' => $pegawai->id,
                    'periode_id' => $periodeLalu->id,
                    'c1_produktivitas' => $evalData['c1_produktivitas'],
                    'c2_tanggung_jawab' => $evalData['c2_tanggung_jawab'],
                    'c3_kehadiran' => $evalData['c3_kehadiran'],
                    'c4_pelanggaran' => $evalData['c4_pelanggaran'],
                    'c5_terlambat' => $evalData['c5_terlambat'],
                    'created_by' => $adminUser->id,
                ]);
            }
        }

        // Hitung CPI dan ranking untuk periode aktif
        $this->calculateCPIAndRanking($periodeAktif->id);

        // Hitung CPI dan ranking untuk periode sebelumnya
        $this->calculateCPIAndRanking($periodeLalu->id);
    }

    private function calculateCPIAndRanking($periodeId)
    {
        // Ambil semua evaluasi pada periode tersebut
        $evaluasiList = Evaluasi::where('periode_id', $periodeId)->get();

        if ($evaluasiList->isEmpty()) {
            return;
        }

        // Ambil kriteria dan bobot
        $kriteria = Kriteria::where('status', 'aktif')->get()->keyBy('kode');

        // Hitung nilai minimum untuk transformasi
        $minValues = [
            'c1' => $evaluasiList->min('c1_produktivitas'),
            'c2' => $evaluasiList->min('c2_tanggung_jawab'),
            'c3' => $evaluasiList->min('c3_kehadiran'),
            'c4' => $evaluasiList->max('c4_pelanggaran'), // Max untuk kriteria negatif
            'c5' => $evaluasiList->max('c5_terlambat'),   // Max untuk kriteria negatif
        ];

        // Hitung CPI untuk setiap evaluasi
        foreach ($evaluasiList as $evaluasi) {
            $totalSkor = 0;

            // C1 - Produktivitas Kerja (Positif)
            if ($kriteria->has('C1') && $minValues['c1'] > 0) {
                $normalized = ($evaluasi->c1_produktivitas / $minValues['c1']) * 100;
                $totalSkor += $normalized * $kriteria['C1']->bobot;
            }

            // C2 - Tanggung Jawab (Positif)
            if ($kriteria->has('C2') && $minValues['c2'] > 0) {
                $normalized = ($evaluasi->c2_tanggung_jawab / $minValues['c2']) * 100;
                $totalSkor += $normalized * $kriteria['C2']->bobot;
            }

            // C3 - Kehadiran (Positif)
            if ($kriteria->has('C3') && $minValues['c3'] > 0) {
                $normalized = ($evaluasi->c3_kehadiran / $minValues['c3']) * 100;
                $totalSkor += $normalized * $kriteria['C3']->bobot;
            }

            // C4 - Pelanggaran Disiplin (Negatif)
            if ($kriteria->has('C4') && $minValues['c4'] > 0) {
                $normalized = ($minValues['c4'] / max($evaluasi->c4_pelanggaran, 1)) * 100;
                $totalSkor += $normalized * $kriteria['C4']->bobot;
            }

            // C5 - Terlambat (Negatif)
            if ($kriteria->has('C5') && $minValues['c5'] > 0) {
                $normalized = ($minValues['c5'] / max($evaluasi->c5_terlambat, 1)) * 100;
                $totalSkor += $normalized * $kriteria['C5']->bobot;
            }

            // Update total skor
            $evaluasi->update(['total_skor' => round($totalSkor, 5)]);
        }

        // Hitung ranking berdasarkan total skor
        $evaluasiSorted = Evaluasi::where('periode_id', $periodeId)
            ->orderBy('total_skor', 'desc')
            ->get();

        foreach ($evaluasiSorted as $index => $evaluasi) {
            $evaluasi->update(['ranking' => $index + 1]);
        }
    }
}
