<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_type' => $this->user_type,
            'village' => $this->village,
            'road_no' => $this->road_no,
            'house_no' => $this->house_no,
            'union' => $this->union,
            'post_office' => $this->post_office,
            'sub_district' => $this->sub_district,
            'district' => $this->district,
            'division' => $this->division,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Optional: formatted/human times
            'created_at_formatted' => $this->created_at_formatted ?? $this->created_at?->format('d M, Y h:i A'),
            'updated_at_formatted' => $this->updated_at_formatted ?? $this->updated_at?->format('d M, Y h:i A'),
        ];
    }
}
