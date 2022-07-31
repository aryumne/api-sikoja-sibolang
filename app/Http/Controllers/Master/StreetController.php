<?php

namespace App\Http\Controllers\Master;

use App\Models\Street;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class StreetController extends Controller
{
    public function index()
    {
        try {
            $response = [
                "message" => "Data Street",
                "data" => Street::all()
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => "Gagal mengambil data",
                "error" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'street' => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validasi data gagal!",
                "error" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $data = Street::create([
                "street" => $input->street
            ]);
            $response = [
                "message" => "Data Berhasil Ditambahkan",
                "data" => $data
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                "message" => "Gagal menyimpan data",
                "error" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        try {
            $street = Street::find($id);
            if (!$street) {
                return response()->json([
                    "error" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                "message" => "Data Street",
                "data" => $street
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => "Gagal mengambil data",
                "error" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $input, $id)
    {
        $validator = Validator::make($input->all(), [
            'street' => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validasi data gagal!",
                "error" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $street = Street::find($id);
            if (!$street) {
                return response()->json([
                    "error" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $street->street = $input->street;
            $street->save();
            return response()->json([
                "message" => "Data Telah Diubah!",
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                "message" => "Gagal menyimpan data",
                "error" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        try {
            $street = Street::find($id);
            if (!$street) {
                return response()->json([
                    "error" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $street->delete();
            return response()->json([
                "message" => "Data Telah Dihapus!"
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                "message" => "Gagal menghapus data",
                "error" => $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
