<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComponentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'uuid' => $this->uuid,
            'user' => new UserResource($this->whenLoaded('user')),
            'name' => $this->name,
            'description' => $this->description,
            'front_end_type' => $this->front_end_type,
            'style_type' => $this->style_type,
            'image' => $this->image,
            'code' => $this->code,
            'upvotes' => (int)$this->upvotes,
            'downvotes' => (int)$this->downvotes,
            'created_at' => $this->created_at,
        ];
    }
}
