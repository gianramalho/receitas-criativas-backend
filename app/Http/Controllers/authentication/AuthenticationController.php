<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use App\Models\Domain\Device;
use App\Models\Domain\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];

        $messages = [
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
        ];

        $attributes = [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400,
            ]);
        } else {
            $validatedData = $validator->validate();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'status' => 200,
            ]);
        }
    }

    public function login(Request $request)
    {
        $deviceName = $request->header('X-Device-Name');

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $user->tokens()->delete();
        $device = Device::where('name', $deviceName)->first();

        if($device && $device->users_id == null || $device->users_id == $user->id){
            $device->users_id = $user->id;
            $device->save();
            $token = $user->createToken('auth_token')->plainTextToken;
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function loginMandatory(){
            return response()->json([
                'message' => 'Login is mandatory'
            ], 401);
    }
}
