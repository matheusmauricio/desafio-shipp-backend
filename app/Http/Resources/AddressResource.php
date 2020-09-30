<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'idAddress'     => $this->id ?? null,
            'county'        => $this->county ?? null,
            'streetNumber'  => $this->street_number ?? null,
            'streetName'    => $this->street_name ?? null,
            'addressLine2'  => $this->address_line2 ?? null,
            'addressLine3'  => $this->address_line3 ?? null,
            'city'          => $this->city ?? null,
            'state'         => $this->state ?? null,
            'zipCode'       => $this->zip_code ?? null,
            'squareFootage' => $this->square_footage ?? null,
            'location'      => $this->location ?? null,
            'latitude'      => $this->latitude ?? null,
            'longitude'     => $this->longitude ?? null,
            'needsRecoding' => $this->needs_recoding ?? null,
        ];
    }
}
