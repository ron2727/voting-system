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
        $isCandidateExistInElection = Candidate::where('user_id', $data['user_id'])->where('election_id', $data['election_id'])->exists();
        if ($isCandidateExistInElection) {
            return response()->json(['errors' => [
                'candidate' => 'Candidate already exists'
            ]], 409);
        } 

        Candidate::create($data); 

        return response()->json([['message' => 'New Candidate Created'], $data], 201);
    }
}
