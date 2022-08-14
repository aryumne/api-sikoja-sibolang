<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Notifications\SendNotification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{

    public function login(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            if (Auth::attempt($input->only('username', 'password'))) {
                $user = User::where('username', $input->username)->first();
                // cek apakah akun ini sudah diverifikasi atau belum
                if (!$user->hasVerifiedEmail()) {
                    event(new Registered($user));
                    return response()->json([
                        'message' => 'Link verfikasi telah dikirim ke email anda',
                        'data' => [
                            'user' => $user,
                            'token' => $user->createToken('bareerToken')->plainTextToken,
                        ]
                    ], Response::HTTP_OK);
                }
                return response()->json([
                    'message' => 'Berhasil Login',
                    'data' => [
                        'user' => $user,
                        'token' => $user->createToken('bareerToken')->plainTextToken,
                    ]
                ], Response::HTTP_ACCEPTED);
            } else {
                return response()->json([
                    'message' => 'User tidak ditemukan'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function user($id)
    {
        try {
            $user = User::where('username', $id)->first();
            if ($user) {
                return response()->json([
                    'message' => 'Ok'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'user not found'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'username' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $user = User::where('username', $input->username)->first();
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Logout all'
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
