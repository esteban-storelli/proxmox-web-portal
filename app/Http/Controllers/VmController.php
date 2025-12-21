<?php

namespace App\Http\Controllers;

use App\Models\VmRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VmController extends Controller
{
    public function requestVm(Request $request) {
            $incomingFields = $request->validate([
            'machine_power' => 'required|string|in:bronze,silver,gold',
            'details' => 'max:500',
        ]);
    $incomingFields['user_id'] = auth()->id();
    VmRequest::create($incomingFields);
    return redirect('/')->with('success', 'VM request submitted successfully.');
    }
}
