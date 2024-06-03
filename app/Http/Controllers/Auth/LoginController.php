<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginApiReqest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\BaseResource;
use App\Http\Resources\TokenResource;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Login
     * @unauthenticated
     */
    public function __invoke(LoginApiReqest $request)
    {
        //
        $data = $request->validated();


        $user = User::whereEmail($data['email'])->first();

        if(!$user || ($user && !Hash::check($data['password'], $user?->password))){
            return (new BaseResource([
                'message' => "Email or password are wrong"
            ]))
            ->response()
            ->setStatusCode(Response::HTTP_NOT_ACCEPTABLE);
        }
        $token = $user->createToken(\Str::random())->plainTextToken;
        //    $token =  auth('jwt-guard')->login($user);
        return new TokenResource([
            'token' => $token
        ]);
    }
}
