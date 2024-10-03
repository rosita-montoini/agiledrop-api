<?php

namespace App\Http\Controllers;

use App\Domains\Image\Jobs\StoreNewImageJob;
use App\Domains\Image\Jobs\ValidateNewImageInputJob;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

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

            $image = (new StoreNewImageJob(
                $request->get('title'),
                $request->get('description'),
                $path,
                $image->getClientMimeType(),
                $image->getSize(),
            ))->handle();

            return $image;
        }

        return response()->json(['message' => 'Image upload failed.'], 500);
    }
}
