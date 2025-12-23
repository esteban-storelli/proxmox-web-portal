<?php

use App\Models\LxcRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LxcController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
	if (auth()->user()->role === 'admin') {
		$lxcRequests = LxcRequest::all();
		return view('admin', ['lxcRequests' => $lxcRequests]);
	}
	else {
		return view('home');
	}
})->middleware('auth');

Route::get('/login', function () {
	return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout']);

Route::post('/request-lxc', [LxcController::class, 'requestLxc']);

Route::post('/approve-request/{id}', [LxcController::class, 'approveRequest']);

Route::post('/deny-request/{id}', [LxcController::class, 'denyRequest']);

Route::post('/create-lxc/{id}', [LxcController::class, 'createLxc']);