<?php

namespace App\Http\Controllers;

use App\Http\Resources\CandidateResource;
use App\Http\Resources\CandidateVoteResource;
use App\Http\Resources\VoteResource;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
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
        $candidate = Election::where('start_date', '<', now('Asia/Manila')->format('Y-m-d H:i:s'))
        ->where('end_date', '>', now('Asia/Manila')->format('Y-m-d H:i:s'))
        ->orderBy('created_at', 'desc')
        ->get();
        return $candidate;  
     }

    public function testRequest(Request $request)
    {
        return $request->all();
    }
}
