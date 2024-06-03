<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterApiRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * @unauthenticated
     * Register User
     */
    public function __invoke(RegisterApiRequest $request)
    {
     $data = $request->validated();
     $data['password'] = Hash::make($data['password']);

     User::create($data);

     return response()->noContent();
    }
}
