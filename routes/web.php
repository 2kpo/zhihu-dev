<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email/verify/{token}', ['as' => 'email.verify', 'uses' => 'EmailController@verify']);

Route::resource('questions', 'QuestionsController', ['names' => [
    'create' => 'question.create',
    'show' => 'question.show',
    ]]);
Route::post('/questions/{question}/answer', 'AnswerController@store');
Route::get('/questions/{question}/follow', 'QuestionFollowController@follows');
Route::get('/notifications', 'NotificationsController@index');
Route::get('/inbox', 'InboxController@index');
Route::get('/inbox/{dialog_id}', 'InboxController@show');
Route::post('/inbox/{dialog_id}/store', 'InboxController@store');
Route::get('/notifications/{notification}', 'NotificationsController@show');
Route::get('/dashboard', 'UserController@avatar');
Route::post('/dashboard/upload', 'UserController@upload');
Route::get('/password', 'PasswordController@index');
Route::post('/password/update', 'PasswordController@update');

