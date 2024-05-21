<?php

namespace App\Services;

use App\Models\Vote;

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
}
