<?php

namespace App\Http\Controllers\Sikoja;

use App\Http\Controllers\Controller;
use App\Models\Galery;
use App\Models\Sikoja;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SikojaController extends Controller
{
    public function index()
    {
        try {
            $response = [
                'message' => "Data Pengaduan SIKOJA",
                'data' => Sikoja::with(['village', 'street', 'status', 'galery'])->latest()->get()
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal Mengambil Data",
                'error' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        try {
            $sikoja = Sikoja::where('id', $id)->with(['village', 'street', 'status', 'sikojadisp', 'galery'])->get();
            if (count($sikoja) == 0) {
                return response()->json([
                    "error" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                'message' => "Data Pengaduan SIKOJA",
                'data' => $sikoja
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal Mengambil Data",
                'error' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'name' => ['required', 'string'],
            'hp' => ['required', 'string'],
            'village_id' => ['required', 'numeric'],
            'street_id' => ['numeric', 'nullable'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Data Gagal!',
                'error' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $data = Sikoja::create([
                'title' => $input->title,
                'description' => $input->description,
                'name' => $input->name,
                'hp' => $input->hp,
                'village_id' => $input->village_id,
                'street_id' => $input->street_id,
                'status_id' => 1,
            ]);
            $response = [
                'message' => "Berhasil Menambahkan Data Pengaduan SIKOJA",
                "data" => $data
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal menyimpan data",
                'error' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function updateStatus(Request $input, $id)
    {
        $validator = Validator::make($input->all(), [
            'status_id' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Data Gagal!',
                'error' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            Sikoja::findOrFail($id)->update([
                "status_id" => $input->status_id,
            ]);
            return response()->json(['message' => "Status Telah Diubah"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal mengubah status",
                'error' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
