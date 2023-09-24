<?php

namespace App\Console\Commands;

use App\Models\Facility;
use App\Models\OccupancyRecord;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ParkingImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parking:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Connecting to Brno API.');
            $response = Http::get('https://services6.arcgis.com/fUWVlHWZNxUvTUh8/arcgis/rest/services/carparks_live/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json');
        } catch(ConnectionException $e)
        {
            $this->error('Can\'t connect to Brno API.');
            return;
        }

        $localFacilities = Facility::with(['latest_occupancy_record'])->get();
 
        $this->info('Processing API response.');

        $occupancyRecordsToInsert = $response
            ->collect('features')
            ->map(function ($feature) use ($localFacilities) {
                $localFacility = $localFacilities->firstWhere('source_id', $feature['attributes']['ObjectId']);

                // return empty if there's no corresponding localFacility (eg. there's a new Facility in the remote API)
                if (! $localFacility)
                    return [];

                // return empty if occupancyRecord exists and it's same (or newer for some reason) than the remote record
                $remoteOccupancyRecordCreatedAt = Carbon::createFromTimestamp(intval($feature['attributes']['startdate']) / 1000);
                if ($localFacility->latest_occupancy_record && $remoteOccupancyRecordCreatedAt->lte($localFacility->latest_occupancy_record->created_at))
                    return [];

                $this->info(sprintf('Occupancy Record for Facility ID %d will be inserted.', $localFacility->id));
                
                return [
                    'facility_id'                   => $feature['attributes']['ObjectId'],
                    'spaces_public_vacant'          => $feature['attributes']['spacesAllUsersVacant'],
                    'spaces_public_occupied'        => $feature['attributes']['spacesAllUsersOccupied'],
                    'spaces_subscribers_vacant'     => $feature['attributes']['spacesSubscribersVacant'],
                    'spaces_subscribers_occupied'   => $feature['attributes']['spacesSubscribersOccupied'],
                    'created_at'                    => $remoteOccupancyRecordCreatedAt,
                ];
            })->filter()->toArray();

        OccupancyRecord::insert($occupancyRecordsToInsert);
    }
}
