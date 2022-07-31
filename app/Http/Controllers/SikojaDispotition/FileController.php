<?php

namespace App\Http\Controllers\SikojaDispotition;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    public function uploadFiles(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'file' => ['required', 'mimes:png,jpg,mp4,mov,jpeg,pdf', 'file', 'max:20480']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Data Gagal!',
                'error' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $file = $input->file('file');
            $fileName = $file->getClientOriginalName();
            $storeImage = $file->storeAs('file', str_replace(" ", "-", $fileName));
            File::create([
                'sikojadisp_id' => 1,
                'path' => $storeImage,
                'filename' => $fileName
            ]);
            return response()->json(['message' => "File Berhasil Diupload"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Gagal mengupload file",
                'error' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
