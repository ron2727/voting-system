<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\VoterController;
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
    return $request->user();
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

Route::apiResource('voters', VoterController::class);
Route::apiResource('elections', ElectionController::class);
Route::apiResource('candidates', CandidateController::class);


Route::get('/test', [Controller::class, 'testing']);
Route::get('/testrequest', [Controller::class, 'testRequest']);