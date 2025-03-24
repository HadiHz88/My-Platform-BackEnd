<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaterialStoringService
{
    /**
     * Update a material file, deleting the old one if it exists
     *
     * @param UploadedFile $newFile The new uploaded file instance.
     * @param string|null $oldFilePath The path of the old file to be deleted.
     * @param int|string $courseId The ID of the course associated with the material.
     * @param string $type The type of the material (e.g., video, image, pdf).
     * @return string The stored file path.
     */
    public function update(UploadedFile $newFile, ?string $oldFilePath, int|string $courseId, string $type): string
    {
        if ($oldFilePath) {
            $this->delete($oldFilePath);
        }

        return $this->store($newFile, $courseId, $type);
    }

    /**
     * Delete a stored material file
     *
     * @param string $path The path of the file to be deleted.
     * @return bool True if the file was deleted, false otherwise.
     */
    public function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Store a material file in the appropriate directory
     *
     * @param UploadedFile $file The uploaded file instance.
     * @param int|string $courseId The ID of the course associated with the material.
     * @param string $type The type of the material (e.g., video, image, pdf).
     * @return string The stored file path.
     */
    public function store(UploadedFile $file, int|string $courseId, string $type): string
    {
        $directory = $this->getDirectory($courseId, $type);
        $filename = $this->generateFilename($file->extension());

        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Get the appropriate storage directory for the material
     *
     * @param int|string $courseId The ID of the course associated with the material.
     * @param string $type The type of the material (e.g., video, image, pdf).
     * @return string The storage directory path.
     */
    private function getDirectory(int|string $courseId, string $type): string
    {
        return sprintf('materials/%s/%s', $courseId, Str::slug($type));
    }

    /**
     * Generate a unique filename for the material
     *
     * @param string $extension The file extension.
     * @return string The generated unique filename.
     */
    private function generateFilename(string $extension): string
    {
        return sprintf('%s.%s', Str::uuid(), $extension);
    }

    /**
     * Ensure the storage symbolic link exists
     *
     * @return void
     */
    public function ensureStorageLink(): void
    {
        if (!file_exists(public_path('storage'))) {
            app('files')->link(storage_path('app/public'), public_path('storage'));
        }
    }
}
