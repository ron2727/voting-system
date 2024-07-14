<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterController;
use App\Http\Resources\UserResource;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return UserResource::make($request->user());
});

// Route::post('/candidates', [CandidateController::class, 'store']);
// Route::post('/candidates', function (Request $request) {
//     return response()->json([['message' => 'New Candidate Created'], $request->all()], 201);
// });



Route::get('/election/{electionId}', [ElectionController::class, 'getElection']);
Route::get('/candidates/{electionId}', [CandidateController::class, 'getCandidates']);
Route::get('/voters/random', [VoterController::class, 'getRandomVoters']);
Route::get('/voters/find/{q}', [VoterController::class, 'findVoters']);
Route::get('/elections/filtered/{status}', [ElectionController::class, 'getFilteredElections']);
Route::get('/vote/ballot/{user_id}/{election_id}', [VoteController::class, 'getSubmittedVote']);
Route::get('/vote/total/{election_id}', [VoteController::class, 'getCandidatesTotalVotes']);
Route::get('/vote/winners/{election_id}', [VoteController::class, 'getElectionVotes']);
Route::get('/voters/total', [VoterController::class, 'getTotalVoters']);
Route::get('/votes/totalcast', [VoteController::class, 'getTotalVotes']);

Route::get('/elections/report/search/{month}/{year}', [ElectionController::class, 'getElectionByMothYear']);
Route::get('/vote/verify/{user_id}/{election_id}', [VoteController::class, 'checkIfVoterHadVoted']);
Route::post('/voters/update/{id}', [VoterController::class, 'update']);
Route::post('/vote', [VoteController::class, 'submitVote']);

Route::apiResource('voters', VoterController::class);
Route::apiResource('elections', ElectionController::class);
Route::apiResource('candidates', CandidateController::class);


Route::get('/test', [Controller::class, 'testing']);
Route::get('/testrequest', [Controller::class, 'testRequest']);