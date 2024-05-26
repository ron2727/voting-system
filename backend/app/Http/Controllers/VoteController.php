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
        $this->voteService->submitVote($request);
        return response()->json([['message' => 'Vote is submitted'], $request->all()], 201);
    
    }

    public function getSubmittedVote($user_id, $election_id){
        return $this->voteService->getSubmittedVote($user_id, $election_id); 
    }

    public function getCandidatesTotalVotes($election_id){
        return $this->voteService->getCandidatesTotalVotes($election_id);
    }

}
