<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Store an uploaded image with custom naming
     *
     * @param UploadedFile $image
     * @param string $modelType
     * @param int|string $modelId
     * @return string The path to the stored image
     */
    public function store(UploadedFile $image, string $modelType, int|string $modelId): string
    {
        $directory = $this->getDirectory($modelType);
        $filename = $this->generateFilename($modelType, $modelId, $image->extension());

        return $image->storeAs($directory, $filename, 'public');
    }

    /**
     * Update an image, deleting the old one if it exists
     *
     * @param UploadedFile $newImage
     * @param string|null $oldImagePath
     * @param string $modelType
     * @param int|string $modelId
     * @return string The path to the new image
     */
    public function update(UploadedFile $newImage, ?string $oldImagePath, string $modelType, $modelId): string
    {
        // Delete old image if it exists
        if ($oldImagePath) {
            $this->delete($oldImagePath);
        }

        // Store new image
        return $this->store($newImage, $modelType, $modelId);
    }

    /**
     * Delete an image
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Get the appropriate directory for the model type
     *
     * @param string $modelType
     * @return string
     */
    private function getDirectory(string $modelType): string
    {
        return Str::plural(Str::slug($modelType)) . '-images';
    }

    /**
     * Generate a filename based on model type and ID
     *
     * @param string $modelType
     * @param int|string $modelId
     * @param string $extension
     * @return string
     */
    private function generateFilename(string $modelType, int|string $modelId, string $extension): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            Str::slug($modelType),
            $modelId,
            Str::random(8), // Add randomness to prevent overwriting if ID is reused
            $extension
        );
    }

    /**
     * Create a symbolic link if it doesn't exist
     *
     * @return void
     */
    public function ensureStorageLink(): void
    {
        if (!file_exists(public_path('storage'))) {
            app('files')->link(
                storage_path('app/public'), public_path('storage')
            );
        }
    }
}
