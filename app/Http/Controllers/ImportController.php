<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StreetImport;
use App\Imports\VillageImport;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    public function streetImport(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'file' => ['required', 'file', 'mimes:xlsx']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $file = $input->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('file', str_replace(" ", "-", $fileName));
            Excel::import(new StreetImport, $file);
            return response()->json(['message' => "File Berhasil Diupload"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function villageImport(Request $input)
    {
        $validator = Validator::make($input->all(), [
            'file' => ['required', 'file', 'mimes:xlsx']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $file = $input->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('file', str_replace(" ", "-", $fileName));
            Excel::import(new VillageImport, $file);
            return response()->json(['message' => "File Berhasil Diupload"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
