<?php

namespace App\Http\Controllers\Sibolang;

use App\Models\Sibolangdisp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FileSibolangdisp;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SibolangdispController extends Controller
{
    public function index()
    {
        try {
            $response = [
                'message' => "Data Disposisi SIBOLANG Disposisi",
                'data' => Sibolangdisp::with(['sibolang', 'file_sibolangdisp', 'instance'])->latest()->get()
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        try {
            $sibolangdisp = Sibolangdisp::where('sibolang_id', $id)->with(['sibolang', 'file_sibolangdisp', 'instance'])->get();
            if (count($sibolangdisp) === 0) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                'message' => "Data Pengaduan SIKOJA",
                'data' => $sibolangdisp
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'sibolang_id' => ['required', 'numeric'],
            'instance_id' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $data = Sibolangdisp::create([
                'sibolang_id' => $input->sibolang_id,
                'instance_id' => $input->instance_id,
            ]);
            $response = [
                'message' => "Data berhasil tersimpan!",
                "data" => $data
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $input, $id)
    {
        $validator = Validator::make($input->all(), [
            'instance_id' => ["numeric", "nullable"],
            'start_date' => ["string", 'nullable'],
            'estimation_date' => ["string", 'nullable'],
            'description' => ["string", "nullable"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $disp = Sibolangdisp::find($id);
            $disp->instance_id = $input->instance_id !== null ? $input->instance_id : $disp->instance_id;
            $disp->start_date = $input->start_date !== null ? $input->start_date : $disp->start_date;
            $disp->description = $input->description !== null ? $input->description : $disp->description;
            $disp->estimation_date = $input->estimation_date !== null ? $input->estimation_date : $disp->estimation_date;
            $disp->save();
            $response = [
                'message' => "Data telah diupdate!",
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function uploadFiles(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'file' => ['required', 'mimes:png,jpg,mp4,mov,jpeg,pdf', 'file', 'max:20480'],
            'sibolangdisp_id' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $file = $input->file('file');
            $fileName = $file->getClientOriginalName();
            $storeImage = $file->storeAs('file', str_replace(" ", "-", $fileName));
            FileSibolangdisp::create([
                'sibolangdisp_id' => $input->sibolangdisp_id,
                'path' => 'storage/' . $storeImage,
                'filename' => $fileName
            ]);
            return response()->json(['message' => "File Berhasil Diupload"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
