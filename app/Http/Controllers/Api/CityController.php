<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        $cities = City::withCount('office_spaces')->get();
        return CityResource::collection($cities);
    }

    public function show(City $city){
        $city->load(['office_spaces.city', 'office_spaces.photos']);
        $city->loadCount('office_spaces');
        return new CityResource($city);
    }


}
