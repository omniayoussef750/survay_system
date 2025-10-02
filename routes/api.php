<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;

// Researcher Registration Route
Route::post('/register', [ResearcherController::class, 'register']);
Route::post('/verify-otp/{researcherId}', [ResearcherController::class, 'verifyOtp']);
Route::post('/resend-otp/{researcherId}', [ResearcherController::class, 'resendOtp']);
Route::post('/login', [ResearcherController::class, 'login']);
Route::post('/forgot-password', [ResearcherController::class, 'forgotPassword']);
Route::post('/reset-password/{researcherId}', [ResearcherController::class, 'resetPassword']); 

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ResearcherController::class)->group(function () {
        Route::get('/profile', 'getProfile');
        Route::get('/update-profile', 'updateProfile');
    
});
    Route::controller(ProjectController::class)->group(function () {
        Route::post('/create-project', 'store');
        Route::put('/update-project/{id}', 'update');
        Route::delete('/delete-project/{id}', 'destroy');
});

Route::controller(SurveyController::class)->group(function () {
        Route::post('/create-survey/{projectId}', 'store');
        Route::put('/update-survey/{surveyId}', 'update');
        Route::delete('/delete-survey/{surveyId}', 'destroy');
});

Route::controller(QuestionController::class)->group(function () {
        Route::get('/built-in-questions', 'getBuiltInQuestions');
        Route::get('/questions-by-section/{sectionId}', 'getQuestionsBySection');
        Route::get('/sections', 'getSections');
        Route::get('/question-types', 'getQuestionTypes');
        Route::post('/add-questions/{surveyId}', 'addQuestions');





});
});
