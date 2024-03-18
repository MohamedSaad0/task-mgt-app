<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function login()
    {
        return response()->json("Logged in Successfully");
    }

    public function register(StoreUserRequest $request)
    {
        // $validated = $request->validated();
        $request->validated($request->all());

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return $this->sucess([
            "user" => $user,
            "token" => $user->createToken("APIToken")->palinTextToken
        ]);
    }
}
