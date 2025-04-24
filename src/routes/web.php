<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SurveyController as WebSurveyController;
use App\Http\Controllers\Web\QuestionController as WebQuestionController;
use App\Http\Controllers\Web\AnswerController as WebAnswerController;
use App\Http\Controllers\Web\GroupController as WebGroupController;
use App\Http\Controllers\Web\InviteController as WebInviteController;
use App\Http\Controllers\Web\QuestionGroupController as WebQuestionGroupController;
use App\Http\Controllers\Web\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Autenticação via SSR
Route::get('login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('login', [AuthController::class,'login'])->name('login.submit');
Route::post('logout', [AuthController::class,'logout'])->name('logout');
Route::get('register', [AuthController::class,'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class,'register'])->name('register.submit');

Route::middleware('auth')->group(function () {
    Route::resource('surveys', WebSurveyController::class);
    Route::resource('questions', WebQuestionController::class);
    Route::resource('question-groups', WebQuestionGroupController::class);
    Route::resource('answers', WebAnswerController::class);
    Route::delete('invites/mass-destroy', [WebInviteController::class,'massDestroy'])->name('invites.massDestroy');
    Route::post('invites/mass-send', [WebInviteController::class,'massSend'])->name('invites.massSend');
    Route::post('invites/{invite}/send', [WebInviteController::class,'send'])->name('invites.send');
    Route::resource('invites', WebInviteController::class);
    Route::resource('groups', WebGroupController::class);
});
