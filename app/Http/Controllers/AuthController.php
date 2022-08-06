<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendNotification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Notification;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function verifyEmail(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'username' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('username', $input->username)->first();
        try {
            if ($user->hasVerifiedEmail()) {
                return response()->json([
                    'message' => 'Akun anda sudah di verifikasi sebelumnya'
                ], Response::HTTP_FORBIDDEN);
            }
            $user->email_verified_at = now();
            $user->save();
            return response()->json([
                'message' => 'Akun terverifikasi',
            ], Response::HTTP_ACCEPTED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function resendEmailVerification(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'email' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $user = User::where('email', $input->email)->first();
            if ($user->hasVerifiedEmail()) {
                return response()->json([
                    'message' => 'Akun anda sudah di verifikasi'
                ], Response::HTTP_FORBIDDEN);
            } else {
                // kalau belum maka kirimkan email verifikasi
                Notification::send($user, new SendNotification($user));
                return response()->json([
                    'message' => 'Link verfikasi telah dikirim ke email anda'
                ], Response::HTTP_OK);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function user()
    {
        try {
            $response = [
                "message" => "Data User",
                "data" => User::with(['role', 'instance'])->get()
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function updateProfile(Request $input, $id)
    {
        $rules = [
            'name' => ['string', 'nullable'],
            'username' => ['string', 'unique:users', 'nullable'],
            'email' => ['email:rfc,dns', 'unique:users', 'nullable'],
            'role_id' => ['numeric', 'nullable'],
            'instance_id' => ['numeric', 'nullable'],
        ];
        try {
            $user = User::find($id);
            if ($user->username !== $input->username) {
                $rules['username'] = ['string', 'unique:users', 'nullable'];
            }
            if ($user->email !== $input->email) {
                $rules['email'] = ['email:rfc,dns', 'unique:users',  'nullable'];
            }

            $validator = Validator::make($input->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $user->name = $input->name !== null ? $input->name : $user->name;
            $user->username = $input->username !== null ? $input->username : $user->username;
            $user->email = $input->email !== null ? $input->email : $user->email;
            $user->role_id = $input->role_id !== null ? $input->role_id : $user->role_id;
            $user->instance_id = $input->instance_id !== null ? $input->instance_id : $user->instance_id;
            $user->save();
            return response()->json([
                'message' => 'User telah diupdate',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
    }


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
                    // kalau belum maka kirimkan email verifikasi
                    Notification::send($user, new SendNotification($user));
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

    public function register(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:users'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role_id' => ['required', 'numeric'],
            'instance_id' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = User::create([
                'name' => $input->name,
                'username' => $input->username,
                'email' => $input->email,
                'password' => Hash::make($input->password),
                'role_id' => $input->role_id,
                'instance_id' => $input->instance_id,
            ]);
            return response()->json([
                'message' => 'User berhasil register',
                'data' => $user
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
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

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $user->delete();
            return response()->json([
                "message" => "Data Telah Dihapus!"
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" =>  $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
