<?php

namespace App\Http\Controllers;

use App\Http\Resources\CandidateResource;
use App\Http\Resources\CandidateVoteResource;
use App\Http\Resources\VoteResource;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function testing()
    {
        // $positions = [
        //   'President' => [6],
        //   'Vice President' => [1, 3], 
        //   'Treasurer' => [4, 5],
        //   'Secretary' => [2]
        // ];
        
        // $votes = [];
        // foreach ($positions as $position => $candidate_id) {
        //     // $votes[$position] = [];
        //     foreach ($candidate_id as $value) { 
        //        $votes[$position][$value] = Vote::where('election_id', 6)->where('candidate_id', $value)->count();
        //     }
        // } 
        $candidate = Candidate::where('election_id', 6)->with('user')->with('votes')->get();
        return CandidateVoteResource::collection($candidate);
        // $count_votes = $candidate->votes->count();
        // return $count_votes;
    }

    public function testRequest(Request $request)
    {
        return $request->all();
    }
}
