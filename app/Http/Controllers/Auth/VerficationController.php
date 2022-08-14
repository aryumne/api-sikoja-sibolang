<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendNotification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Notification;
use Symfony\Component\HttpFoundation\Response;

class VerficationController extends Controller
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
            'email' => ['required', 'email:rfc,dns']
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
}
