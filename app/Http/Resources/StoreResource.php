<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'idStore'           => $this->id ?? null,
            'idAddress'         => $this->id_address ?? null,
            'distance'          => $this->distance ?? null,
            'licenseNumber'     => $this->license_number ?? null,
            'operationType'     => $this->operation_type ?? null,
            'establishmentType' => $this->establishment_type ?? null,
            'entityType'        => $this->entity_name ?? null,
            'dbaName'           => $this->dba_name ?? null,
            'address'           => $this->address ?? null,
        ];
    }
}
