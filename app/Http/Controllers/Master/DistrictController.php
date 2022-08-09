<?php

namespace App\Http\Controllers\Master;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DistrictController extends Controller
{
    public function index()
    {
        try {
            $response = [
                "message" => "Data Distrik",
                "data" => District::all()
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
            'district' => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $data = District::create([
                "district" => $input->district
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
            $district = District::find($id);
            if (!$district) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                "message" => "Data Distrik",
                "data" => $district
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
            'district' => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" =>  $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $district = District::find($id);
            if (!$district) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $district->district = $input->district;
            $district->save();
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
            $district = District::find($id);
            if (!$district) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $district->delete();
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
