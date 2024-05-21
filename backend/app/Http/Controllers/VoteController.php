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
}
