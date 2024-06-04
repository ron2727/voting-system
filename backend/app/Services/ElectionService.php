<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Election;
use App\Services\Interfaces\ElectionFilter;
use Illuminate\Support\Facades\DB;

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
    // In Election Model find all election that the start_date is less than to current datetime and end_date is greater than to current datetime
    public function getFilteredElections($status)
    {
        if ($status == 'Active') {
            $filteredElections = Election::where('start_date', '<', now('Asia/Manila')->format('Y-m-d H:i:s'))
                ->where('end_date', '>', now('Asia/Manila')->format('Y-m-d H:i:s'))
                ->orderBy('created_at', 'desc')
                ->get();
        }
        if ($status == 'Upcoming') {
            $filteredElections = Election::where('start_date', '>', now('Asia/Manila')->format('Y-m-d H:i:s'))
                ->where('end_date', '>', now('Asia/Manila')->format('Y-m-d H:i:s'))
                ->orderBy('created_at', 'desc')
                ->get();
        }
        if ($status == 'Completed') {
            $filteredElections = Election::where('start_date', '<', now('Asia/Manila')->format('Y-m-d H:i:s'))
                ->where('end_date', '<', now('Asia/Manila')->format('Y-m-d H:i:s'))
                ->orderBy('created_at', 'desc')
                ->get();
        } 

        return $filteredElections;
    }

}
