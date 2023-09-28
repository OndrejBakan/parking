<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Facility extends Model
{
    use HasFactory;

    public function occupancy_records() : HasMany
    {
        return $this->hasMany(OccupancyRecord::class);
    }

    public function latest_occupancy_record() : HasOne
    {
        return $this->hasOne(OccupancyRecord::class)->latest();
    }

    public function getPopularTimesAttribute()
    {
        $facilityId = $this->id;

        return OccupancyRecord::selectRaw('STRFTIME("%w", DATETIME(created_at, "localtime")) AS day_of_week')
            ->selectRaw('STRFTIME("%H", DATETIME(created_at, "localtime")) AS hour_of_day')
            ->selectRaw('AVG((spaces_public_occupied * 100.0) / (spaces_public_occupied + spaces_public_vacant)) AS occupancy_percentage')
            ->where('facility_id', $facilityId)
            ->groupBy(['day_of_week', 'hour_of_day'])
            ->get();
    }
}
