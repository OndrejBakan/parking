<?php

namespace App\Services;

use App\Models\Facility;
use App\Models\OccupancyRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ParkingApiService
{
    const API_URL = 'https://services6.arcgis.com/fUWVlHWZNxUvTUh8/arcgis/rest/services/carparks_live/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json';

    public function getOccupancyData()
    {
        $response = Http::get($this::API_URL);

        $occupancyRecordsToInsert = [];
        
        $facilities = Facility::with(['latest_occupancy_record'])->get();

        foreach($response->json()['features'] as $facility)
        {
            $createdAt = Carbon::createFromTimestamp(intval($facility['attributes']['startdate']) / 1000);
            $localFacility = $facilities->firstWhere('source_id', $facility['attributes']['ObjectId']);

            if ($createdAt->gte($localFacility->occupancy_records->first()->created_at))
                continue;

            $occupancyRecordsToInsert[] = [
                'facility_id'                   => $localFacility->id,
                'spaces_public_vacant'          => $facility['attributes']['spacesAllUsersVacant'],
                'spaces_public_occupied'        => $facility['attributes']['spacesAllUsersOccupied'],
                'spaces_subscribers_vacant'     => $facility['attributes']['spacesSubscribersVacant'],
                'spaces_subscribers_occupied'   => $facility['attributes']['spacesSubscribersOccupied'],
                'created_at'                    => Carbon::createFromTimestamp(intval($facility['attributes']['startdate']) / 1000),
            ];
        }

        OccupancyRecord::insert($occupancyRecordsToInsert);
    }
}