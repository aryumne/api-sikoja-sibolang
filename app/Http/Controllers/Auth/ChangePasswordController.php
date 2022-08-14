<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Events\PasswordReset;

class ChangePasswordController extends Controller
{
    public function forgotPassword(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'email' => ['required', 'email:rfc,dns']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $status = Password::sendResetLink(
                $input->only('email')
            );
            if ($status !== Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => __($status),
                ], Response::HTTP_BAD_REQUEST);
            }
            return response()->json([
                'message' => __($status),
            ], Response::HTTP_ACCEPTED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function resetPassword(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'token' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $status = Password::reset(
                $input->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);

                    $user->save();

                    event(new PasswordReset($user));
                }
            );
            if ($status !== Password::PASSWORD_RESET) {
                return response()->json([
                    'message' => __($status),
                ], Response::HTTP_BAD_REQUEST);
            }
            return response()->json([
                'message' => __($status),
            ], Response::HTTP_ACCEPTED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
