<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $address = $this->address;
        if ($address === null && $this->sectional_unit) {
            $address = $this->sectional_unit->address();
        }
        return [
            'id' => $this->id,
            'description' => $this->description,
            'description_title' => $this->description_title,
            'video_url' => $this->video_url,
            'cover_image' => $this->cover_image,
            'title' => $this->title,
            'features' => $this->features,
            'is_rental' => $this->is_rental,
            'price' => $this->price,
            'images' => ImageResource::collection($this->images),
            'address' => new AddressResource($address),
            'is_sectional' => $this->sectional_unit !== null
        ];
    }
}
