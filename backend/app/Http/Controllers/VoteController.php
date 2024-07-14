<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Services\VoteService;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __construct(private VoteService $voteService) {}

    public function submitVote(VoteRequest $request)
    { 
        return $this->voteService->submitVote($request);  
    }

    public function getSubmittedVote($user_id, $election_id){
        return $this->voteService->getSubmittedVote($user_id, $election_id); 
    }

    public function getCandidatesTotalVotes($election_id){
        return $this->voteService->getCandidatesTotalVotes($election_id);
    }

    public function getElectionVotes($election_id){
        return $this->voteService->getElectionVotes($election_id);
    }
    public function checkIfVoterHadVoted($user_id, $election_id){
        
        if ($this->voteService->checkIfVoterHadVoted($user_id, $election_id)) {
            $response = response()->json(['message' => 'You have already voted'], 422);
        }else{
            $response = response()->json(['message' => 'You have not voted yet'], 200);
        }

        return $response;
    }
    
    public function getTotalVotes(){
        return $this->voteService->getTotalVotes();
    }
}
