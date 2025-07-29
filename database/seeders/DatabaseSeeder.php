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
                'telephone' => '081234567811',
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
                'telepon' => $pegawai['telepon'] ?? $pegawai['telephone'] ?? null,
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

        // Seed Evaluasi untuk periode aktif (Juli 2025) - NILAI SESUAI EXCEL
        $evaluasiData = [
            [
                'nama' => 'Agus Mulya, S.PT., MM',
                'c1_produktivitas' => 5,
                'c2_tanggung_jawab' => 5,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Andri Yudha Prawira, S.I.P., M.SI.',
                'c1_produktivitas' => 5,
                'c2_tanggung_jawab' => 5,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Rahmat Hidayat, SH',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 5,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Sriwantini, S.M',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 3,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Ajo Suarjo, S.M.',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 2,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Hari Sumarhadi, S.A.P.',
                'c1_produktivitas' => 5,
                'c2_tanggung_jawab' => 5,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Mayang Kusuma Nariyah, A.MD.Kom.',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 4,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Siti Noviyanti S.Sos, M.K.P',
                'c1_produktivitas' => 5,
                'c2_tanggung_jawab' => 3,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Dian Akhmad Rifqi, A.MD',
                'c1_produktivitas' => 5,
                'c2_tanggung_jawab' => 3,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Reny Yulia, SH, M.SI',
                'c1_produktivitas' => 5,
                'c2_tanggung_jawab' => 4,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Yahya',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 4,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Lia Yuliana, S.Sos., M.Si',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 4,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Soni Permana',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 3,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Muhdiman, S.Sos',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 5,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Didik Kurniawan, ST',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 4,
                'c3_kehadiran' => 3,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'Fahmi Taufik Firdaus, A.Md.',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 5,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 4,
            ],
            [
                'nama' => 'RD. Agus Hamzah',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 4,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Deden Gono Hartoyo',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 3,
                'c3_kehadiran' => 3,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 3,
            ],
            [
                'nama' => 'Andi Janwar',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 3,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 4,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Domadonna Febby Pradita',
                'c1_produktivitas' => 4,
                'c2_tanggung_jawab' => 3,
                'c3_kehadiran' => 4,
                'c4_pelanggaran' => 5,
                'c5_terlambat' => 5,
            ],
            [
                'nama' => 'Ading Supriatna',
                'c1_produktivitas' => 3,
                'c2_tanggung_jawab' => 5,
                'c3_kehadiran' => 5,
                'c4_pelanggaran' => 1,
                'c5_terlambat' => 1,
            ],
        ];

        // Buat evaluasi untuk periode aktif
        $adminUser = User::where('role', 'admin')->first();

        foreach ($evaluasiData as $evalData) {
            $pegawai = User::where('nama', 'like', '%' . explode(',', $evalData['nama'])[0] . '%')
                ->where('role', 'pegawai')->first();

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

        // Hitung CPI dan ranking untuk periode aktif dengan formula yang benar
        $this->calculateCPIAndRanking($periodeAktif->id);

        // Hitung CPI dan ranking untuk periode sebelumnya
        $this->calculateCPIAndRanking($periodeLalu->id);
    }

    /**
     * Perhitungan CPI yang sudah diperbaiki sesuai dengan Excel
     */
    private function calculateCPIAndRanking($periodeId)
    {
        // Ambil semua evaluasi pada periode tersebut
        $evaluasiList = Evaluasi::where('periode_id', $periodeId)->get();

        if ($evaluasiList->isEmpty()) {
            return;
        }

        // Ambil kriteria dan bobot
        $kriteria = Kriteria::where('status', 'aktif')->get()->keyBy('kode');

        // Langkah 2: Hitung CPI untuk setiap evaluasi menggunakan formula Excel yang BENAR
        foreach ($evaluasiList as $evaluasi) {
            $totalSkor = 0;

            // KRITERIA POSITIF (C1, C2, C3)
            // Formula yang BENAR berdasarkan reverse engineering Excel:

            // C1 - Produktivitas Kerja (Tren Positif)
            // Formula Excel: nilai * (40/3) = nilai * 13.33333
            if ($kriteria->has('C1')) {
                $c1_contribution = $evaluasi->c1_produktivitas * (40 / 3);
                $totalSkor += $c1_contribution;
            }

            // C2 - Tanggung Jawab (Tren Positif) 
            // Formula Excel: nilai * 10
            if ($kriteria->has('C2')) {
                $c2_contribution = $evaluasi->c2_tanggung_jawab * 10;
                $totalSkor += $c2_contribution;
            }

            // C3 - Kehadiran (Tren Positif)
            // Formula Excel: nilai * (20/3) = nilai * 6.66667
            if ($kriteria->has('C3')) {
                $c3_contribution = $evaluasi->c3_kehadiran * (20 / 3);
                $totalSkor += $c3_contribution;
            }

            // KRITERIA NEGATIF (C4, C5)
            // Formula yang BENAR berdasarkan reverse engineering Excel dengan batasan maksimum:

            // C4 - Pelanggaran Disiplin (Tren Negatif)
            // Formula Excel: min(20 / nilai_asli, 10)
            if ($kriteria->has('C4') && $evaluasi->c4_pelanggaran > 0) {
                $c4_contribution = min(20 / $evaluasi->c4_pelanggaran, 10);
                $totalSkor += $c4_contribution;
            }

            // C5 - Terlambat (Tren Negatif)  
            // Formula Excel: min(10 / nilai_asli, 10)
            if ($kriteria->has('C5') && $evaluasi->c5_terlambat > 0) {
                $c5_contribution = min(10 / $evaluasi->c5_terlambat, 10);
                $totalSkor += $c5_contribution;
            }

            // Update total skor
            $evaluasi->update(['total_skor' => round($totalSkor, 5)]);
        }

        // Langkah 3: Hitung ranking berdasarkan total skor (dari tertinggi ke terendah)
        $evaluasiSorted = Evaluasi::where('periode_id', $periodeId)
            ->orderBy('total_skor', 'desc')
            ->get();

        foreach ($evaluasiSorted as $index => $evaluasi) {
            $evaluasi->update(['ranking' => $index + 1]);
        }
    }
}
