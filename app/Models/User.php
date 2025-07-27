<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'jabatan',
        'kelas_jabatan', // Sekarang integer
        'telepon',
        'alamat',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'kelas_jabatan' => 'integer', // Cast ke integer
        ];
    }

    // Relationship
    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class);
    }

    public function createdEvaluations()
    {
        return $this->hasMany(Evaluasi::class, 'created_by');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }

    public function getLatestEvaluation($periodeId = null)
    {
        $query = $this->evaluasi();

        if ($periodeId) {
            $query->where('periode_id', $periodeId);
        }

        return $query->latest()->first();
    }

    public function getAverageScore()
    {
        return $this->evaluasi()->avg('total_skor') ?? 0;
    }

    // Method untuk kelas jabatan
    public function getKelasJabatanText()
    {
        $kelasJabatan = [
            17 => 'Kelas 17 (Eselon I)',
            16 => 'Kelas 16 (Eselon II.a)',
            15 => 'Kelas 15 (Eselon II.b)',
            14 => 'Kelas 14 (Eselon III.a)',
            13 => 'Kelas 13 (Eselon III.b)',
            12 => 'Kelas 12 (Eselon IV.a/Camat)',
            11 => 'Kelas 11 (Eselon IV.b/Sekretaris)',
            10 => 'Kelas 10 (Fungsional Ahli Utama)',
            9 => 'Kelas 9 (Fungsional Ahli Madya)',
            8 => 'Kelas 8 (Fungsional Ahli Muda)',
            7 => 'Kelas 7 (Fungsional Ahli Pertama)',
            6 => 'Kelas 6 (Fungsional Terampil Penyelia)',
            5 => 'Kelas 5 (Fungsional Terampil Mahir)',
            4 => 'Kelas 4 (Fungsional Terampil)',
            3 => 'Kelas 3 (Fungsional Terampil Pemula)',
            2 => 'Kelas 2 (Pelaksana Lanjutan)',
            1 => 'Kelas 1 (Pelaksana Pemula)',
        ];

        return $kelasJabatan[$this->kelas_jabatan] ?? 'Kelas ' . $this->kelas_jabatan;
    }

    public function getKelasJabatanBadgeColor()
    {
        return match (true) {
            $this->kelas_jabatan >= 17 => 'purple',
            $this->kelas_jabatan >= 14 => 'indigo',
            $this->kelas_jabatan >= 12 => 'blue',
            $this->kelas_jabatan >= 9 => 'green',
            $this->kelas_jabatan >= 6 => 'yellow',
            default => 'gray'
        };
    }

    public function getKelasJabatanShort()
    {
        return 'Kelas ' . $this->kelas_jabatan;
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePegawai($query)
    {
        return $query->where('role', 'pegawai');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeByKelasJabatan($query, $kelas)
    {
        return $query->where('kelas_jabatan', $kelas);
    }
}
