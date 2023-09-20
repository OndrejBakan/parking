<?php

namespace App\Services\ParkingApi;

use Illuminate\Support\Facades\Http;

class BrnoOpenDataParkingService
{
    public function fetch()
    {
        $response = Http::get('https://services6.arcgis.com/fUWVlHWZNxUvTUh8/arcgis/rest/services/carparks_live/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json');

        if (! $response->status(200))
            return;
        
        $occupancyRecordsToInsert = collect($response['features']);

        dump($occupancyRecordsToInsert);
    }
}