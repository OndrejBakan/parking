<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::with(['latest_occupancy_record'])->get();

        return $facilities->each->latest_occupancy_record->each(function($q) {
            $q->latest_occupancy_record->append(['spaces_public_percentages', 'spaces_subscribers_percentages']);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        // $popular_times = $facility->popular_times->groupBy('day_of_week')->toArray();

        // dump($popular_times);

        // return view('facility.show')->with('facility', $facility);
        return response()->json($facility->popular_times);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        //
    }
}
