<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'kode',
        'nama',
        'bobot',
        'tren',
        'status',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePositive($query)
    {
        return $query->where('tren', 'positif');
    }

    public function scopeNegative($query)
    {
        return $query->where('tren', 'negatif');
    }

    // Helper methods
    public function isPositive()
    {
        return $this->tren === 'positif';
    }

    public function isNegative()
    {
        return $this->tren === 'negatif';
    }

    public function getBobotPersentase()
    {
        return $this->bobot * 100;
    }

    public function getFormattedBobot()
    {
        return number_format($this->getBobotPersentase(), 0) . '%';
    }

    // Validation rules
    public static function validationRules($id = null)
    {
        return [
            'kode' => 'required|string|max:10|unique:kriteria,kode,' . $id,
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'tren' => 'required|in:positif,negatif',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }

    // Check if total bobot equals 100%
    public static function checkTotalBobot($excludeId = null)
    {
        $query = self::where('status', 'aktif');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->sum('bobot');
    }

    public static function validateTotalBobot($newBobot, $excludeId = null)
    {
        $currentTotal = self::checkTotalBobot($excludeId);
        $newTotal = $currentTotal + $newBobot;

        return abs($newTotal - 1.0) < 0.001; // Allow small floating point differences
    }
}
