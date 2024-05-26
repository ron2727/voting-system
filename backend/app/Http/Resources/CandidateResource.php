<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
             'id' => $this->id,
             'elections_id' => $this->elections_id,
             'user_id' => $this->user_id,
             'position' => $this->position,
             'user' => new UserResource($this->whenLoaded('user')), 
        ];
    }
}
