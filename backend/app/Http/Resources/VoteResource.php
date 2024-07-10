<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [ 
            'user_id' => $this->user_id,
            'election_id' => $this->election_id,
            'candidate_id' => $this->candidate_id,
            'position' => $this->position,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'course' => $this->course,
            'year_level' => $this->year_level,
            'section' => $this->section,
            'profile_image' => 'http://127.0.0.1:8000'.Storage::url('public/uploaded/images/'.$this->profile_image)
        ];
    }
}
