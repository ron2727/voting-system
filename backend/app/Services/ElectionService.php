<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Election;

class ElectionService
{
    public function getAllElections()
    {
        return Election::orderBy('created_at', 'desc')->get();
    }

    public function storeElection($data)
    {
        return Election::create($data);
    }

    public function getElection($id){ 
        return Election::find($id);
    }

}
