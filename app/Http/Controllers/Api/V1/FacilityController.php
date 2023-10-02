<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityCollection;
use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::all();

        return new FacilityCollection($facilities);
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return new FacilityResource($facility);
    }
}
