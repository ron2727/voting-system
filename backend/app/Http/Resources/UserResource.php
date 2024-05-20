<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'student_id' => $this->student_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'course' => $this->course,
            'year_level' => $this->year_level,
            'section' => $this->section,
            'email' => $this->email,
        ];
    }
}
