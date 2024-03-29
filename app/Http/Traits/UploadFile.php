<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFile
{
    public function uploadFile(UploadedFile $file, $folder = null, $disk = 'public', $filename = null): string|false
    {
        $Filename = $filename ?? Str::random(10);

        return $file->storeAs($folder, $Filename . '.' .  $file->getClientOriginalExtension(), $disk);
    }

    public function deleteFile($path, $disk = 'public'): void
    {
        Storage::disk($disk)->delete($path);
    }
}
