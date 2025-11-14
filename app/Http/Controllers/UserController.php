<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\UserService;

use App\Models\User;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function create(CreateUserRequest $request)
    {
        $data = request(['name', 'email', 'password']);
        
        $user = $this->userService->create($data);

        $token = auth()->attempt([
            "email" => $data["email"],
            "password" => $data["password"]
        ]);

        return [
            "user" => $user,
            "token_data" => $this->respondWithToken($token)
        ];
    }

    public function login(LoginRequest $request)
    {
        try {
            
            $credentials = request(['email', 'password']);
    
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return [
                "user" => $this->userService->findByEmail($credentials['email']),
                "token_data" => $this->respondWithToken($token)
            ];
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function userTotalVBucks()
    {
        return $this->userService->userTotalVBucks(Auth::user()->id);
    }

    public function userVBuckBallance()
    {
        return $this->userService->userVBuckBallance(Auth::user()->id);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
