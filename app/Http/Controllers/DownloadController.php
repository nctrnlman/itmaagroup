<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    public function download($folder, $filename)
    {
        $filePath = storage_path("app/public/{$folder}/" . $filename);

        if (File::exists($filePath)) {
            return Response::download($filePath, $filename);
        } else {
            abort(404, 'File not found.');
        }
    }
}
