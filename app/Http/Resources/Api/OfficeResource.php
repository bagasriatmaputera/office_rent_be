<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'about' => $this->about,
            'slug' => $this->slug,
            'thumbnail' =>  $this->thumbnail,
            'duration' => $this->duration,
            'price' => $this->price,
            'is_open' => $this->is_open,
            'is_full_book' => $this->is_full_booked,
            'photo' => OfficePhotoResource::collection($this->whenLoaded('photos')),
            'benefits' => OfficeBenefitsResource::collection($this->whenLoaded('benefits')),
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}
