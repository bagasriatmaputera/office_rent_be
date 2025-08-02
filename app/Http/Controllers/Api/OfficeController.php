<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OfficeResource;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = OfficeSpace::with(['City'])->get();
        return OfficeResource::collection($offices);
    }
    public function show(OfficeSpace $officeSpace)
    {
        $officeSpace->load(['photos','benefits','city']);
        return new OfficeResource($officeSpace);
    }
}
