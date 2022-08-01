<?php

namespace App\Http\Controllers\Sikoja;

use App\Models\Galery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GaleryController extends Controller
{
    public function uploadGaleries(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'sikoja_id' => ['required', 'numeric'],
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
            Galery::create([
                'sikoja_id' => $input->sikoja_id,
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
