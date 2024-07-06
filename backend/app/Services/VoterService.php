<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class VoterService
{ 
    public function getVoters()
    {
        return UserResource::collection(User::paginate(10));
    }

    public function getVoter($id)
    {
        return new UserResource(User::find($id));
    }
  
    public function getRandomVoters()
    {
        $randomVoters = User::inRandomOrder()->limit(6)->get();
        return UserResource::collection($randomVoters); 
    }
    public function storeVoter($data)
    {
        User::create($data);

        return  response()->json([['message' => 'Voter created successfully'], $data], 201);
    }

    public function findVoters($q)
    {
        $voters = User::where(function ($query) use ($q) {
            $query->where('student_id', 'like', '%' . $q . '%')
                ->orWhere('firstname', 'like', '%' . $q . '%')
                ->orWhere('lastname', 'like', '%' . $q . '%')
                ->orWhere('email', 'like', '%' . $q . '%')
                ->orWhere('course', 'like', '%' . $q . '%')
                ->orWhere('year_level', 'like', '%' . $q . '%')
                ->orWhere('section', 'like', '%' . $q . '%');
        })->get();

        if ($voters->count() == 0) {
            return response()->json([
                "message" => "No result found",
            ]);
        }

        return UserResource::collection($voters);
    }

    public function updateVoter($data, $voterId){
        User::where('id', $voterId)->update($data);

        return response()->json([['message' => 'Voter updated successfully'], $data], 201);;
    }
}
