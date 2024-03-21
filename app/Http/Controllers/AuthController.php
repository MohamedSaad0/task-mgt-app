<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Exception;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        try {
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
        } catch (Exception $e) {
            return $this->error("", 'Something went wrong', 404);
        }
    }

    public function register(StoreUserRequest $request)
    {

        try {
            $validated = $request->validated();
            $user = User::create($validated);

            return $this->success([
                "user" => $user,
                "token" => $user->createToken("Register Token for" . $user->name)->plainTextToken
            ],);
        } catch (Exception $e) {
            return $this->error("", 'Something went wrong', 404);
        }
    }
}
