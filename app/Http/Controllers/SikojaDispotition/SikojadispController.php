<?php

namespace App\Http\Controllers\SikojaDispotition;

use App\Models\Sikojadisp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SikojadispController extends Controller
{
    public function index()
    {
        try {
            $response = [
                'message' => "Data Disposisi SIKOJA",
                'data' => Sikojadisp::with(['sikoja', 'file', 'instance'])->latest()->get()
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
            $sikojadisp = Sikojadisp::where('sikoja_id', $id)->with(['sikoja', 'file', 'instance'])->get();
            if (count($sikojadisp) == 0) {
                return response()->json([
                    "error" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                'message' => "Data Pengaduan SIKOJA",
                'data' => $sikojadisp
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
            'sikoja_id' => ['required', 'numeric'],
            'instance_id' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Data Gagal!',
                'error' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $data = Sikojadisp::create([
                'sikoja_id' => $input->sikoja_id,
                'instance_id' => $input->instance_id,
            ]);
            $response = [
                'message' => "Data berhasil tersimpan!",
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

    public function update(Request $input, $id)
    {
        $validator = Validator::make($input->all(), [
            'instance_id' => ["required", "numeric"],
            'validate_date' => ["required"],
            'description' => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Data Gagal!',
                'error' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            Sikojadisp::findOrFail($id)->update([
                'instance_id' => $input->instance_id,
                'validate_date' => $input->validate_date,
                'description' => $input->description,
            ]);
            $response = [
                'message' => "Data telah diupdate!",
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal mengupdate data",
                'error' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
