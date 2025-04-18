<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MediaService
{
    public function handleMediaUpload(array|UploadedFile $mediaFiles, Model $model)
    {

        $userId = Auth::id();
        $modelName = strtolower(class_basename($model));
        $directory = Str::plural($modelName) . '/media';
        Log::info('Media files: ' . json_encode($mediaFiles));
        foreach ($mediaFiles as $mediaFile) {
            $path = $mediaFile->store($directory, 'public');
            $model->media()->create([
                'user_id'   => $userId,
                'url'       => $path,
                'type'      => $mediaFile->getMimeType(),
                'file_size' => $mediaFile->getSize(),
            ]);
        }
    }

    
    public function deleteFile(Media $media): bool
    {
        Storage::disk($media->disk)->delete($media->url);
        return $media->delete();
    }
}
