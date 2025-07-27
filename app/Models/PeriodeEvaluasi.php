<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeriodeEvaluasi extends Model
{
    use HasFactory;

    protected $table = 'periode_evaluasi';

    protected $fillable = [
        'nama',
        'tahun',
        'bulan',
        'tgl_mulai',
        'tgl_selesai',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    // Relationships
    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'periode_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeByBulan($query, $bulan)
    {
        return $query->where('bulan', $bulan);
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'aktif';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function getFormattedPeriode()
    {
        $bulanNama = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $bulanNama[$this->bulan] . ' ' . $this->tahun;
    }

    public function getFormattedTanggal()
    {
        return $this->tgl_mulai->format('d/m/Y') . ' - ' . $this->tgl_selesai->format('d/m/Y');
    }

    public function getDurasiHari()
    {
        return $this->tgl_mulai->diffInDays($this->tgl_selesai) + 1;
    }

    public function getProgressPersentase()
    {
        $now = Carbon::now();

        if ($now->lt($this->tgl_mulai)) {
            return 0; // Belum dimulai
        }

        if ($now->gt($this->tgl_selesai)) {
            return 100; // Sudah selesai
        }

        $totalHari = $this->getDurasiHari();
        $hariTerlalui = $this->tgl_mulai->diffInDays($now) + 1;

        return round(($hariTerlalui / $totalHari) * 100);
    }

    public function getStatusBadge()
    {
        return match ($this->status) {
            'aktif' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Aktif'],
            'selesai' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Selesai'],
            'draft' => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Draft'],
            default => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Unknown']
        };
    }

    // Statistics
    public function getTotalEvaluasi()
    {
        return $this->evaluasi()->count();
    }

    public function getRataRataSkor()
    {
        return $this->evaluasi()->avg('total_skor') ?? 0;
    }

    public function getSkorTertinggi()
    {
        return $this->evaluasi()->max('total_skor') ?? 0;
    }

    public function getSkorTerendah()
    {
        return $this->evaluasi()->min('total_skor') ?? 0;
    }

    public function getTopPerformers($limit = 5)
    {
        return $this->evaluasi()
            ->with('user')
            ->orderBy('ranking')
            ->limit($limit)
            ->get();
    }

    // Validation
    public static function validationRules($id = null)
    {
        return [
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020|max:2030',
            'bulan' => 'required|integer|min:1|max:12',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'status' => 'required|in:draft,aktif,selesai',
        ];
    }

    // Check if dates overlap with existing periods
    public function hasOverlapWith($tglMulai, $tglSelesai, $excludeId = null)
    {
        $query = self::where(function ($q) use ($tglMulai, $tglSelesai) {
            $q->whereBetween('tgl_mulai', [$tglMulai, $tglSelesai])
                ->orWhereBetween('tgl_selesai', [$tglMulai, $tglSelesai])
                ->orWhere(function ($q2) use ($tglMulai, $tglSelesai) {
                    $q2->where('tgl_mulai', '<=', $tglMulai)
                        ->where('tgl_selesai', '>=', $tglSelesai);
                });
        });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Auto-generate nama based on bulan and tahun
    public function generateNama()
    {
        $bulanNama = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return 'Evaluasi Kinerja ' . $bulanNama[$this->bulan] . ' ' . $this->tahun;
    }
}
