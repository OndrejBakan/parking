<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupancyRecord extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'spaces_public_occupied' => $this->spaces_public_occupied,
            'spaces_public_vacant' => $this->spaces_public_vacant,
            'spaces_public_percentages' => $this->spaces_public_percentages,
            'spaces_subscribers_occupied' => $this->spaces_public_vacant,
            'spaces_subscribers_vacant' => $this->spaces_public_occupied,
            'created_at' => $this->created_at,
        ];
    }
}
