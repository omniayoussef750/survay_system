<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SocialiteLoginController;

// Researcher Registration Route
Route::post('/register', [ResearcherController::class, 'register']);
Route::post('/verify-otp/{researcherId}', [ResearcherController::class, 'verifyOtp']);
Route::post('/resend-otp/{researcherId}', [ResearcherController::class, 'resendOtp']);
Route::post('/login', [ResearcherController::class, 'login']);
Route::post('/forgot-password', [ResearcherController::class, 'forgotPassword']);
Route::post('/reset-password/{researcherId}', [ResearcherController::class, 'resetPassword']); 
Route::post('/login-with-google',[SocialiteLoginController::class ,'loginWithGoogle']);
Route::post('/login-with-facebook',[SocialiteLoginController::class ,'loginWithFacebook']);


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ResearcherController::class)->group(function () {
        Route::get('/profile', 'getProfile');
        Route::get('/update-profile', 'updateProfile');
    
});
    Route::controller(ProjectController::class)->group(function () {
        Route::post('/create-project', 'store');
        Route::get('/get-all-projects' , 'getAllProjects');
        Route::put('/update-project/{id}', 'update');
        Route::delete('/delete-project/{id}', 'destroy');
        Route::post('/force-delete-project' , 'forceDelete');
        Route::get('/get-recycle-bin-project' , 'getRecycleBin');
        Route::get('/restore-project/{projectId}', 'restore');
        Route::post('/toggle-favorite-project/{projectId}','toggleFavoriteProject');
        Route::get('/get-favorite-projects', 'getFavoriteProjects');
});

Route::controller(SurveyController::class)->group(function () {
        Route::post('/create-survey', 'store');
        Route::get('/get-all-surveys' , 'getAllSurveys');
        Route::put('/update-survey/{surveyId}', 'update');
        Route::delete('/delete-survey/{surveyId}', 'destroy');
        Route::post('/force-delete-survey' , 'forceDelete');
        Route::get('/get-recycle-bin-survey' , 'getRecycleBin');
        Route::get('/restore-survey/{surveyId}', 'restore');
        Route::post('/toggle-favorite-survey/{surveyId}','toggleFavoriteSurvey');
        Route::get('/get-favorite-surveys', 'getFavoriteSurveys');
});

Route::controller(QuestionController::class)->group(function () {
        Route::get('/built-in-questions', 'getBuiltInQuestions');
        Route::get('/questions-by-section/{sectionId}', 'getQuestionsBySection');
        Route::get('/sections', 'getSections');
        Route::get('/question-types', 'getQuestionTypes');
        // Route::post('/add-questions/{surveyId}', 'addQuestions');
        Route::post('/add-built-in-questions/{surveyId}', 'addBuiltInQuestionsToSurvey');
        Route::post('/edit-questions/{surveyId}/{questionId}', 'editQuestion');
        Route::get('/questions-by-survey/{surveyId}', 'getQuestionsBySurvey');

});


});
