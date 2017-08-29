<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/topics', 'TopicController@index')->middleware('api');
Route::post('/question/follower', 'QuestionFollowController@isFollowedThisQuestion')->middleware('auth:api');

Route::post('/question/follow', 'QuestionFollowController@followThisQuestion')->middleware('auth:api');

Route::get('/user/follower/{id}', 'FollowersController@index');
Route::post('/user/follow', 'FollowersController@follow');

Route::get('/answer/{answer}/votes/users', 'VoteController@hasVoted');
Route::post('/answer/vote', 'VoteController@vote');

Route::post('/message/store', 'MessageController@store');

Route::get('/question/{id}/comment', 'CommentController@question');
Route::get('/answer/{id}/comment', 'CommentController@answer');
Route::post('/comment/store', 'CommentController@store');
