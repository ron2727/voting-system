<?php

namespace App\Services;

use App\Http\Resources\CandidateResource;
use App\Models\Candidate;

class CandidateService
{
    public function getCandidates($electionId)
    {
        return Candidate::where('election_id', $electionId)->get();
    }
    
    public function getCandidatesElection($electionId)
    {
        $candidates = Candidate::with('user')->where('election_id', $electionId)->get();

        return CandidateResource::collection($candidates); 
    }

    public function createCandidate($data)
    {
        return Candidate::create($data);
    }
}
