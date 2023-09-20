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
}
