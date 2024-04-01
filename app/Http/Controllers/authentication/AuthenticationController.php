<?php

namespace App\Http\Controllers\authentication;

use App\Application\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $validator = $this->validateRequest(
            $data,
            [
                'name' => 'Nome',
                'email' => 'E-mail',
                'password' => 'Senha',
            ],
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ],
            [
                'name.required' => 'O :attribute é obrigatório.',
                'name.string' => 'O :attribute informado não é válido.',
                'name.max' => 'O :attribute informado não é válido.',
                'email.required' => 'O :attribute é obrigatório.',
                'email.string' => 'O :attribute informado não é válido.',
                'email.email' => 'O :attribute informado não é válido.',
                'email.max' => 'O :attribute informado não é válido.',
                'email.unique' => 'O :attribute informado não é válido.',
                'password.required' => 'A :attribute é obrigatória.',
                'password.string' => 'A :attribute informada não é válida.',
                'password.min' => 'A :attribute informada não é válida.',
            ],
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $user = $this->userService->register($data);

        return $this->successResponse($user);
    }

    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        $data['device_name'] = $request->header('X-Device-Name');

        $response = $this->userService->login($data);

        if ($response["status"]) {
            return $this->successResponseLogin($response["token"]);
        } else {
            return response()->json([
                'message' => $response["message"]
            ], 401);
        }
    }

    public function loginMandatory()
    {
        return response()->json([
            'message' => 'Login is mandatory'
        ], 401);
    }
}
