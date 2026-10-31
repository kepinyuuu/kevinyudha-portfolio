<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * The disk used for all image uploads.
     *
     * Reads FILESYSTEM_DISK from env (defaults to 's3').
     * Compatible with S3, Cloudflare R2, or 'public' for local dev.
     */
    protected function disk(): \Illuminate\Contracts\Filesystem\Filesystem
    {
        return Storage::disk(config('filesystems.default'));
    }

    /**
     * Store uploaded image, return the stored path (relative key).
     */
    public function store(UploadedFile $file, string $directory = 'uploads'): string
    {
        $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $this->disk()->putFileAs($directory, $file, $filename, 'public');
        return $directory . '/' . $filename;
    }

    /**
     * Replace existing image: delete old, store new.
     */
    public function replace(?string $oldPath, UploadedFile $newFile, string $directory = 'uploads'): string
    {
        $this->delete($oldPath);
        return $this->store($newFile, $directory);
    }

    /**
     * Delete image from disk.
     */
    public function delete(?string $path): void
    {
        if ($path && $this->disk()->exists($path)) {
            $this->disk()->delete($path);
        }
    }

    /**
     * Get the full public URL for a stored image path.
     *
     * For S3/R2: uses the AWS_URL env (public bucket/custom domain URL).
     * For local 'public' disk: uses asset('storage/...').
     */
    public function url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return $this->disk()->url($path);
    }
}
