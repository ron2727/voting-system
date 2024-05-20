<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoterRequest;
use App\Services\VoterService; 
use Illuminate\Http\Request;

class VoterController extends Controller
{
    public function __construct(private VoterService $voterService) {}
    /**
     * Display a listing of the resource.
     */
    public function getRandomVoters ()
    {
        return $this->voterService->getRandomVoters();
    }

    public function findVoters($q)
    {
        return $this->voterService->findVoters($q);  
    }
    public function index()
    {
        return $this->voterService->getVoters();
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VoterRequest $request)
    {
        $this->voterService->storeVoter($request->all());
        return response()->json([['message' => 'Voter created successfully'], $request->all()], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
