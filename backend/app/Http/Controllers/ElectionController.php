<?php

namespace App\Http\Controllers;

use App\Http\Requests\ElectionRequest;
use App\Services\ElectionService;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function __construct(private ElectionService $electionService){}
    public function index()
    {
        return $this->electionService->getAllElections();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ElectionRequest $request)
    {
        $this->electionService->storeElection($request->all());

        return response()->json([['message' => 'Election created successfully'], $request->all()], 201);
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

    public function getElection(string $id)
    { 
        return $this->electionService->getElection($id); 
    }

}
