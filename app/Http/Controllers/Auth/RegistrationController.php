<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
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
