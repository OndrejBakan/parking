<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class FacilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'latest_occupancy_record' => new OccupancyRecord($this->latest_occupancy_record),
            'popular_times' => $this->when(! $request->routeIs('*.index'), function () {
                return Cache::remember("{$this->id}.popular_times", 60, function() {
                    return $this->popular_times;
                });
            }),
        ];
    }
}
