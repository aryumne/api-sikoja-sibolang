<?php

namespace App\Http\Controllers\Master;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
{
    public function index()
    {
        try {
            $response = [
                "message" => "Data Status",
                "data" => Status::all()
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'statuse' => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $data = Status::create([
                "statuse" => $input->statuse
            ]);
            $response = [
                "message" => "Data Berhasil Ditambahkan",
                "data" => $data
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        try {
            $statuse = Status::find($id);
            if (!$statuse) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                "message" => "Data Status",
                "data" => $statuse
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $input, $id)
    {
        $validator = Validator::make($input->all(), [
            'statuse' => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" =>  $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $statuse = Status::find($id);
            if (!$statuse) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $statuse->statuse = $input->statuse;
            $statuse->save();
            return response()->json([
                "message" => "Data Telah Diubah!",
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                "message" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        try {
            $statuse = Status::find($id);
            if (!$statuse) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $statuse->delete();
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
