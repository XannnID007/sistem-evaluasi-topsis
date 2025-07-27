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
        'kelas_jabatan',
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
}
