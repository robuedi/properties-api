<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\CityResource;
use Log;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'code' => $this->whenHas('code'),
            'cities' => $this->whenLoaded('cities', function () {
                Log::info($this->cities);
                return CountryResource::collection($this->cities);
            }),
        ];
    }
}
