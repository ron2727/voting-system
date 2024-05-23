<?php

namespace App\Http\Controllers;

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
        $candidates = DB::table('votes') 
        ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
        ->join('users', 'candidates.user_id', '=', 'users.id') 
        ->select('users.*', 'votes.candidate_id', 'votes.election_id', 'candidates.user_id')
        ->where('votes.election_id', 6)
        ->where('votes.user_id', 18)
        ->get();

        return VoteResource::collection($candidates); 
    }

    public function testRequest(Request $request)
    {
        return $request->all();
    }
}
