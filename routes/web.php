<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearcherController;

Route::get('/', function () {
    return view('welcome');
});

