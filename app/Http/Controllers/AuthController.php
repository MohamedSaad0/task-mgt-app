<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {

        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('', 'Invalid email or password', 401);
        };

        $user = User::where('email', $request->email)->first();
        $token =  $user->createToken("Login Token for" . $user->name)->plainTextToken;

        return $this->success(
            [
                "user" => $user,
                "token" => $token
            ],
        );
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);

        return $this->success([
            "user" => $user,
            "token" => $user->createToken("Register Token for" . $user->name)->plainTextToken
        ],);
    }
}
