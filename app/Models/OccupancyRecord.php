<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupancyRecord extends Model
{
    use HasFactory;
    
    protected $appends = [
       //'spaces_public_percentages',
       //'spaces_subscribers_percentages',
    ];

    public function getSpacesPublicPercentagesAttribute()
    {
        if ($this->spaces_public_vacant == 0 && $this->spaces_public_occupied == 0)
            return [
                'spaces_public_vacant_percentage' => NULL,
                'spaces_public_occupied_percentage' => NULL];
        
        $spacesPublicTotal = $this->spaces_public_vacant + $this->spaces_public_occupied;

        return ['spaces_public_vacant_percentage' => ($this->spaces_public_vacant / $spacesPublicTotal) * 100,
                'spaces_public_occupied_percentage' => ($this->spaces_public_occupied / $spacesPublicTotal) * 100];
    }

    public function getSpacesSubscribersPercentagesAttribute()
    {
        if ($this->spaces_subscribers_vacant == 0 && $this->spaces_subscribers_occupied == 0)
            return [
                'spaces_subscribers_vacant_percentage' => NULL,
                'spaces_subscribers_occupied_percentage' => NULL];
        
        $spacesSubscribersTotal = $this->spaces_subscribers_vacant + $this->spaces_subscribers_occupied;

        return ['spaces_subscribers_vacant_percentage' => ($this->spaces_subscribers_vacant / $spacesSubscribersTotal) * 100,
                'spaces_subscribers_occupied_percentage' => ($this->spaces_subscribers_occupied / $spacesSubscribersTotal) * 100];
    }
}
