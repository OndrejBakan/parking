<?php

namespace App\Console\Commands;

use App\Models\Facility;
use App\Models\OccupancyRecord;
use App\Services\ParkingApi\BrnoOpenDataParkingService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ParkingUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parking:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BrnoOpenDataParkingService $parking)
    {
        $parking->fetch();

        die();


        $facilities = Facility::with(['latest_occupancy_record'])->get();
    
        $occupancyRecordsToInsert = Http::get('https://services6.arcgis.com/fUWVlHWZNxUvTUh8/arcgis/rest/services/carparks_live/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json')
            ->collect('features')
            ->map(function ($feature) use ($facilities) {
                $createdAt = Carbon::createFromTimestamp(intval($feature['attributes']['startdate']) / 1000);
                $localFacility = $facilities->firstWhere('source_id', $feature['attributes']['ObjectId']);

                if ($createdAt->gt($localFacility->latest_occupancy_record->created_at))
                    return [
                        'facility_id'                   => $feature['attributes']['ObjectId'],
                        'spaces_public_vacant'          => $feature['attributes']['spacesAllUsersVacant'],
                        'spaces_public_occupied'        => $feature['attributes']['spacesAllUsersOccupied'],
                        'spaces_subscribers_vacant'     => $feature['attributes']['spacesSubscribersVacant'],
                        'spaces_subscribers_occupied'   => $feature['attributes']['spacesSubscribersOccupied'],
                        'created_at'                    => Carbon::createFromTimestamp(intval($feature['attributes']['startdate']) / 1000),
                    ];
            })->filter()->toArray();
        
        OccupancyRecord::insert($occupancyRecordsToInsert);
        dump($occupancyRecordsToInsert);
    }
}
