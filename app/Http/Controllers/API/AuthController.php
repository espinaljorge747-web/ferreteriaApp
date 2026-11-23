<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//librerias 
use Illuminate\Http\JsonResponse;
use Illuminate\Suport\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request):JsonResponse
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'status'=>'error',
                'message'=>'credenciales invalidas'
            ],401);
        }
        $usuario=Auth::user();
        $token=$usuario->createToken('DispositivoFerreteria')->plainTextToken;
        return response()->json([
            'status'=>'success',
            'mensaje'=>'Bienvenido al sistema',
            'token'=>$token,
            'usuario'=>[
                'id'=>$usuario->id,
                'name'=>$usuario->name,
                'email'=>$usuario->email
            ]
        ],200);
    }
}
