<?php

namespace App\Http\Controllers;

use App\Domains\Image\Jobs\StoreNewImageJob;
use App\Domains\Image\Jobs\ValidateNewImageInputJob;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $requestParams = [
            'image' => $request->file('image'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ];

        (new ValidateNewImageInputJob($requestParams))->handle(new \App\Domains\Image\NewImageValidator);

        if ($request->hasFile('image')) {
            
            $image = $request->file('image');

            $path = $image->store('images', 'public');

            $imageUrl = Storage::url($path);

            $image = (new StoreNewImageJob(
                $request->get('title'),
                $request->get('description'),
                $imageUrl,
                $image->getClientMimeType(),
                $image->getSize(),
            ))->handle();

            return $image;
        }

        return response()->json(['message' => 'Image upload failed.'], 500);
    }
}
