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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'jabatan' => 'Administrator Sistem',
            'kelas_jabatan' => 'Camat',
            'telepon' => '081234567890',
            'alamat' => 'Kantor Kecamatan Cangkuang',
            'status' => 'aktif',
        ]);

        // Seed Pegawai Users (berdasarkan data Excel)
        $pegawaiData = [
            [
                'nama' => 'Agus Mulya, S.PT., MM',
                'username' => 'agus.mulya',
                'email' => 'agusmulya@kecamatancangkuang.go.id',
                'jabatan' => 'Kepala Seksi Pelayanan',
                'kelas_jabatan' => 'Kepala Seksi',
                'telepon' => '081234567891',
            ],
            [
                'nama' => 'Andri Yudha Prawira, S.I.P., M.SI.',
                'username' => 'andri yudha',
                'email' => 'andriyudha@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Pelayanan Publik',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567892',
            ],
            [
                'nama' => 'Rahmat Hidayat, SH',
                'username' => 'rahmat hidayat',
                'email' => 'rahmathidayat@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Hukum',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567893',
            ],
            [
                'nama' => 'Sriwantini, S.M',
                'username' => 'sriwantini',
                'email' => 'sriwantini@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Keuangan',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567894',
            ],
            [
                'nama' => 'Ajo Suarjo, S.M',
                'username' => 'ajo suarjo',
                'email' => 'ajosuarjo@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Administrasi',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567895',
            ],
            [
                'nama' => 'Hari Sumarhadi, S.A.P.',
                'username' => 'hari sumarhadi',
                'email' => 'harisumarhadi@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Administrasi',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567896',
            ],
            [
                'nama' => 'Mayang Kusuma Nariyah, A.MD.Kom',
                'username' => 'mayang kusuma',
                'email' => 'mayangkusuma@kecamatancangkuang.go.id',
                'jabatan' => 'Staff IT',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567897',
            ],
            [
                'nama' => 'Siti Noviyanti S.Sos, M.K.P',
                'username' => 'siti noviyanti',
                'email' => 'sitinoviyanti@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Administrasi',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567898',
            ],
            [
                'nama' => 'Dian Akhmad Rifqi, A.MD',
                'username' => 'dian akhmad',
                'email' => 'dianakhmad@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Teknis',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567899',
            ],
            [
                'nama' => 'Reny Yulia, SH, M.SI',
                'username' => 'reny yulia',
                'email' => 'renyyulia@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Hukum',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567800',
            ],
            [
                'nama' => 'Yahya',
                'username' => 'yahya',
                'email' => 'yahya@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Umum',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567801',
            ],
            [
                'nama' => 'Lia Yuliana, S.Sos., M.Si',
                'username' => 'lia. yuliana',
                'email' => 'liayuliana@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Pelayanan',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567802',
            ],
            [
                'nama' => 'Soni Permana',
                'username' => 'soni permana',
                'email' => 'sonipermana@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Lapangan',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567803',
            ],
            [
                'nama' => 'Muhdiman, S.Sos',
                'username' => 'muhdiman',
                'email' => 'muhdiman@kecamatancangkuang.go.id',
                'jabatan' => 'Supervisor Pelayanan',
                'kelas_jabatan' => 'Supervisor',
                'telepon' => '081234567804',
            ],
            [
                'nama' => 'Didik Kurniawan, ST',
                'username' => 'didik kurniawan',
                'email' => 'didikkurniawan@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Teknis',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567805',
            ],
            [
                'nama' => 'Fahmi Taufik Firdaus, A.MD',
                'username' => 'fahmi taufik',
                'email' => 'fahmitaufik@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Teknis',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567806',
            ],
            [
                'nama' => 'RD. Agus Hamzah',
                'username' => 'agus hamzah',
                'email' => 'agushamzah@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Pelayanan',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567807',
            ],
            [
                'nama' => 'Deden Gono Hartoyo',
                'username' => 'deden gono',
                'email' => 'dedengono@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Lapangan',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567808',
            ],
            [
                'nama' => 'Andi Janwar',
                'username' => 'andi janwar',
                'email' => 'andijanwar@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Umum',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567809',
            ],
            [
                'nama' => 'Domadonna Febby Pradita',
                'username' => 'domadonna febby',
                'email' => 'domadonnafebby@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Administrasi',
                'kelas_jabatan' => 'Staff',
                'telepon' => '081234567810',
            ],
            [
                'nama' => 'Ading Supriatna',
                'username' => 'ading supriatna',
                'email' => 'adingsupriatna@kecamatancangkuang.go.id',
                'jabatan' => 'Staff Pelayanan',
                'kelas_jabatan' => 'Staff',
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
        PeriodeEvaluasi::create([
            'nama' => 'Evaluasi Kinerja Juni 2025',
            'tahun' => 2025,
            'bulan' => 6,
            'tgl_mulai' => '2025-06-01',
            'tgl_selesai' => '2025-06-30',
            'status' => 'aktif',
        ]);

        PeriodeEvaluasi::create([
            'nama' => 'Evaluasi Kinerja Mei 2025',
            'tahun' => 2025,
            'bulan' => 5,
            'tgl_mulai' => '2025-05-01',
            'tgl_selesai' => '2025-05-31',
            'status' => 'selesai',
        ]);
    }
}
