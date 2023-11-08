<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(false, __('The given data was invalid.'), Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        $credentials = $request->all();
        //check email
        $user = User::where('email', $credentials['email'])->get()->first();

        //check password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->jsonResponse(false, __('auth.failed'), Response::HTTP_UNAUTHORIZED);
        }

        //create token
        $token = $user->createToken('myapitoken')->plainTextToken;
        $user["user_token"] = $token;
        //get user role
        $user["user_role"] = $user->getRoleNames()[0] ?? null;

        // don't attach roles to user
        $user->unsetRelation('roles');

        return $this->jsonResponse(true, __('Logged In Successfully!'), Response::HTTP_OK, $user);
    }

    // register
    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            User::create($validated)->assignRole("employee");

            return $this->jsonResponse(true, __('Registered Successfully!'), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->jsonResponse(true, __('Logged Out Successfully!'), Response::HTTP_OK);
    }
}
