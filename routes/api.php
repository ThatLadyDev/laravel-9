<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

Route::get('/{user}/send', [EmailController::class, 'send']);
