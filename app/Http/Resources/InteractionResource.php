<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'component_id' => $this->component_id,
            'type' => $this->type,
        ];
    }
}

