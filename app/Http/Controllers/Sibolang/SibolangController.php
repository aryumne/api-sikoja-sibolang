<?php

namespace App\Http\Controllers\Sibolang;

use App\Models\Sibolang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GalerySibolang;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SibolangController extends Controller
{
    public function index()
    {
        try {
            $response = [
                'message' => "Data Pengaduan SIBOLANG",
                'data' => Sibolang::with(['village', 'category', 'status', 'galery_sibolang'])->latest()->get()
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
            $sibolang = Sibolang::where('id', $id)->with(['village', 'category', 'status', 'sibolangdisp', 'galery_sibolang'])->get();
            if (count($sibolang) == 0) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $response = [
                'message' => "Data Pengaduan SIBOLANG",
                'data' => $sibolang
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'name' => ['required', 'string'],
            'hp' => ['required', 'string'],
            'village_id' => ['nullable', 'numeric'],
            'category_id' => ['numeric', 'required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $data = Sibolang::create([
                'title' => $input->title,
                'description' => $input->description,
                'name' => $input->name,
                'hp' => $input->hp,
                'village_id' => $input->village_id,
                'category_id' => $input->category_id,
                'status_id' => 1,
            ]);
            $response = [
                'message' => "Berhasil Menambahkan Data Pengaduan SIBOLANG",
                "data" => $data
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
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
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $sibolang = Sibolang::find($id);
            if (!$sibolang) {
                return response()->json([
                    "message" => "Data tidak ditemukan!",
                ], Response::HTTP_BAD_REQUEST);
            }
            $sibolang->status_id = $input->status_id;
            $sibolang->save();
            return response()->json(['message' => "Status Telah Diubah"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function uploadGaleries(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'sibolang_id' => ['required', 'numeric'],
            'galery' => ['required', 'mimes:png,jpeg,jpg,mp4,mov', 'file', 'max:20480']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $galery = $input->file('galery');
            $fileName = $galery->getClientOriginalName();
            $storeImage = $galery->storeAs('galery', str_replace(" ", "-", $fileName));
            GalerySibolang::create([
                'sibolang_id' => $input->sibolang_id,
                'filename' => $fileName,
                'path' => 'storage/' . $storeImage,
            ]);
            return response()->json(['message' => "Image Berhasil Diupload"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
