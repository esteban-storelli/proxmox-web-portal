<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VmController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
	if (auth()->user()->role === 'admin') {
		return view('admin');
	}
	else {
		return view('home');
	}
})->middleware('auth');


Route::get('/login', function () {
	return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::post('/request-vm', [VmController::class, 'requestVm']);