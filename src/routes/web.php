<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SurveyController as WebSurveyController;
use App\Http\Controllers\Web\QuestionController as WebQuestionController;
use App\Http\Controllers\Web\AnswerController as WebAnswerController;
use App\Http\Controllers\Web\GroupController as WebGroupController;
use App\Http\Controllers\Web\InviteController as WebInviteController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SurveyResponseController;
use App\Http\Controllers\Web\QuestionCategoryController as WebQuestionCategoryController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Autenticação via SSR
Route::get('login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('login', [AuthController::class,'login'])->name('login.submit');
Route::post('logout', [AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Survey configuration screen
    Route::get('surveys/configure', [WebSurveyController::class, 'configure'])->name('surveys.configure');
    Route::post('surveys/configure', [WebSurveyController::class, 'configureSave'])->name('surveys.configure.save');
    Route::resource('surveys', WebSurveyController::class);
    Route::resource('questions', WebQuestionController::class);
    Route::resource('answers', WebAnswerController::class);
    Route::resource('question-categories', WebQuestionCategoryController::class);
    Route::delete('invites/mass-destroy', [WebInviteController::class,'massDestroy'])->name('invites.massDestroy');
    Route::post('invites/mass-send', [WebInviteController::class,'massSend'])->name('invites.massSend');
    Route::post('invites/{invite}/send', [WebInviteController::class,'send'])->name('invites.send');
    Route::resource('invites', WebInviteController::class);
    Route::resource('groups', WebGroupController::class);
});

// Rotas públicas para resposta de pesquisas
Route::get('responder/{token}', [SurveyResponseController::class, 'show'])->name('survey-response.show');
Route::post('responder/{token}', [SurveyResponseController::class, 'store'])->name('survey-response.store');
Route::get('responder/{token}/obrigado', [SurveyResponseController::class, 'thankYou'])->name('survey-response.thank-you');
Route::get('responder/ja-respondido', [SurveyResponseController::class, 'alreadyAnswered'])->name('survey-response.already-answered');
