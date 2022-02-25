<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'level' => 'pelanggan',
            'api_token' => '1234567890',
            'status' => '1',
            'relasi' => $request->input('email')
        ];

        User::create($data);

        return response()->json($data);
    }

    public function login(Request $request)
        {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::where('email',$email)->first();
            
            if ($user->password === $password) {
                $token = Str::random(40);

                $user->update([
                    'api_token' => $token
                ]);

                return response()->json([
                    'pesan' => 'LOGIN SUCCES',
                    'token' => $token,
                    'data' => $user
                ]);
            }else {
                return response()->json([
                    'pesan' => 'LOGIN GAGAL',
                    'data' => ''
                ]);
            }
        }
}