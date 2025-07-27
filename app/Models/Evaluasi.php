<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;

    protected $table = 'evaluasi';

    protected $fillable = [
        'user_id',
        'periode_id',
        'c1_produktivitas',
        'c2_tanggung_jawab',
        'c3_kehadiran',
        'c4_pelanggaran',
        'c5_terlambat',
        'total_skor',
        'ranking',
        'created_by',
    ];

    protected $casts = [
        'c1_produktivitas' => 'decimal:2',
        'c2_tanggung_jawab' => 'decimal:2',
        'c3_kehadiran' => 'decimal:2',
        'c4_pelanggaran' => 'decimal:2',
        'c5_terlambat' => 'decimal:2',
        'total_skor' => 'decimal:5',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeEvaluasi::class, 'periode_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper methods untuk perhitungan CPI
    public function calculateCPI()
    {
        // Ambil kriteria dan bobotnya
        $kriteria = Kriteria::where('status', 'aktif')->get();

        // Nilai-nilai kriteria
        $values = [
            'C1' => $this->c1_produktivitas,
            'C2' => $this->c2_tanggung_jawab,
            'C3' => $this->c3_kehadiran,
            'C4' => $this->c4_pelanggaran,
            'C5' => $this->c5_terlambat,
        ];

        $totalScore = 0;

        foreach ($kriteria as $k) {
            $nilai = $values[$k->kode] ?? 0;

            // Untuk tren negatif, nilai dibalik
            if ($k->tren === 'negatif') {
                // Implementasi transformasi nilai negatif
                $nilai = $this->transformNegativeValue($nilai, $k->kode);
            }

            $totalScore += $nilai * $k->bobot;
        }

        return round($totalScore, 5);
    }

    private function transformNegativeValue($value, $kriteriaCode)
    {
        // Implementasi transformasi nilai untuk kriteria negatif
        // Sesuai dengan metode CPI pada file Excel
        return $value;
    }

    public static function updateRankings($periodeId)
    {
        $evaluations = self::where('periode_id', $periodeId)
            ->orderBy('total_skor', 'desc')
            ->get();

        foreach ($evaluations as $index => $evaluation) {
            $evaluation->update(['ranking' => $index + 1]);
        }
    }

    // Scope
    public function scopeByPeriode($query, $periodeId)
    {
        return $query->where('periode_id', $periodeId);
    }

    public function scopeRanked($query)
    {
        return $query->orderBy('ranking', 'asc');
    }

    public function scopeTopPerformers($query, $limit = 5)
    {
        return $query->orderBy('total_skor', 'desc')->limit($limit);
    }
}
