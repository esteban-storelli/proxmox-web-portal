<?php

use App\Models\VmRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VmController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
	if (auth()->user()->role === 'admin') {
		$vmRequests = VmRequest::all();
		return view('admin', ['vmRequests' => $vmRequests]);
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

Route::post('/approve-request/{id}', [VmController::class, 'denyRequest']);

Route::post('/deny-request/{id}', [VmController::class, 'approveRequest']);