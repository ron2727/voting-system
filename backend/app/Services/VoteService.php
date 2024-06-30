<?php

namespace App\Services;

use App\Http\Resources\CandidateVoteResource;
use App\Http\Resources\VoteResource;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class VoteService
{
    public function submitVote($request)
    {
        $vote = $request->except(['user_id', 'election_id']); 

        foreach ($vote as $value) {
            Vote::create([
                'user_id' => $request->user_id,
                'election_id' => $request->election_id,
                'candidate_id' => $value
            ]);
        } 
    }

    public function getSubmittedVote($user_id, $election_id)
    {
        $candidates = DB::table('votes') 
        ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
        ->join('users', 'candidates.user_id', '=', 'users.id') 
        ->select('users.*', 'votes.candidate_id', 'votes.election_id', 'candidates.user_id', 'candidates.position')
        ->where('votes.election_id', $election_id)
        ->where('votes.user_id', $user_id)
        ->get();

        return VoteResource::collection($candidates);  
    }

    public function getCandidatesTotalVotes($election_id)
    { 
        $candidate = Candidate::where('election_id', $election_id)->with('user')->with('votes')->get();
        return CandidateVoteResource::collection($candidate);
    }

    public function getElectionVotes($election_id)
    { 

        $result = Candidate::where('election_id', $election_id)->with('user')->with('votes')->get();
 
        $candidate = CandidateVoteResource::collection($result); 
 
        return $this->getElectionCandidatesWithPosition($candidate);

    }
    
    public function getElectionCandidatesWithPosition($election_candidates){
        $candidatesPosition = [
            'President' => ['candidates' => []],
            'Vice President' => ['candidates' => []],
            'Secretary' => ['candidates' => []],
            'Treasurer' => ['candidates' => []]
        ];

        foreach ($election_candidates as $candidate) {
            array_push($candidatesPosition[$candidate->position]['candidates'], $candidate);
        } 
        
        return response()->json($candidatesPosition);
    }
}
