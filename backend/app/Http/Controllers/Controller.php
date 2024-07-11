<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoterRequest;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\CandidateVoteResource;
use App\Http\Resources\UserResource;
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
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function testing()
    {
       $image_url = Storage::url('public/uploaded/images/crud-layout.png');
       return response()->json(['url_image' => $image_url]);
    }

    public function testRequest()
    {
        // $image_name = 'profile_image-'.rand(11111111,99999999).'.'.$request->file('profile_image')->getClientOriginalExtension();
        // $request->file('profile_image')->storeAs('public/uploaded/images', $image_name);
        // Election::whereMonth('start_date', '2024-07')->first();
        // Election::whereMonth('start_date', Carbon::now()->month)->whereYear('start_date', Carbon::now()->year)->first()
        return Election::whereMonth('start_date', '07')->whereYear('start_date', '2024')->get();
    }
}
