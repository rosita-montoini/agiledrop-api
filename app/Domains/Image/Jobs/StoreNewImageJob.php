<?php

namespace App\Domains\Image\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreNewImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        String $title,
        String $description,
        String $path,
        String $type,
        Int $size
    ) {
        $this->data['title'] = $title;
        $this->data['description'] = $description;
        $this->data['file_path'] = $path;
        $this->data['file_type'] = $type;
        $this->data['file_size'] = $size;
    }

    /**
     * Execute the job.
     *
     * @return Image
     */
    public function handle()
    {
        $image = Image::create($this->data);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully!',
            'image' => $image
        ], 201);
    }
}
