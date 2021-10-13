<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $path = Storage::put('images', $request->file('file'));
        $url = $path ? asset($path) : $path;

        return response()
            ->json(['location' => $url]);
    }
}
