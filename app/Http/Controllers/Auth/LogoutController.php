<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Logout
     */
    public function __invoke(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->noContent();
    }
}
