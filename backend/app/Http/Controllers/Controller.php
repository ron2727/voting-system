<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function testing()
    {
        return Vote::where('candidate_id', 6)->where('election_id', 6)->get(); 
    }

    public function testRequest(Request $request)
    {
        return $request->all();
    }
}
