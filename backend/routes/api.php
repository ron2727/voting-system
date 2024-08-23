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
 
Route::prefix('voters')
       ->controller(VoterController::class)
       ->group(function(){ 
            Route::get('/random', 'getRandomVoters');
            Route::get('/find/{q}', 'findVoters');
            Route::get('/total', 'getTotalVoters');
            Route::get('/update/{id}', 'update');
        });

Route::prefix('vote')
       ->controller(VoteController::class)
       ->group(function(){ 
            Route::get('/', 'submitVote'); 
            Route::get('/total/{election_id}', 'getCandidatesTotalVotes');
            Route::get('/ballot/{user_id}/{election_id}', 'getSubmittedVote'); 
            Route::get('/verify/{user_id}/{election_id}', 'checkIfVoterHadVoted'); 
        });

Route::get('/election/{electionId}', [ElectionController::class, 'getElection']);
Route::get('/candidates/{electionId}', [CandidateController::class, 'getCandidates']); 
Route::get('/elections/filtered/{status}', [ElectionController::class, 'getFilteredElections']); 
Route::get('/votes/totalcast', [VoteController::class, 'getTotalVotes']); 
Route::get('/elections/report/search/{month}/{year}', [ElectionController::class, 'getElectionByMothYear']); 

Route::apiResource('voters', VoterController::class);
Route::apiResource('elections', ElectionController::class);
Route::apiResource('candidates', CandidateController::class);


Route::get('/test', [Controller::class, 'testing']);
Route::get('/testrequest', [Controller::class, 'testRequest']);