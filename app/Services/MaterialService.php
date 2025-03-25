<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaterialService
{
    /**
     * Update a material file, deleting the old one if it exists
     *
     * @param UploadedFile $newFile
     * @param string|null $oldFilePath
     * @param string $topicId
     * @param string $type
     * @return string The path to the new material
     */
    public function update(UploadedFile $newFile, ?string $oldFilePath, string $topicId, string $type)
    {
        // Delete old file if it exists
        if ($oldFilePath) {
            $this->delete($oldFilePath);
        }

        // Store new file
        return $this->store($newFile, $topicId, $type);
    }

    /**
     * Delete a material file
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path)
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Store a material file
     *
     * @param UploadedFile $file
     * @param string $topicId
     * @param string $type
     * @return string The path to the stored material
     */
    public function store(UploadedFile $file, string $topicId, string $type)
    {
        $directory = $this->getDirectory($topicId);
        $filename = $this->generateFilename($topicId, $type, $file->extension());

        $path = $file->storeAs($directory, $filename, 'public');

        return $path;
    }

    /**
     * Get the appropriate directory for the material
     *
     * @param string $topicId
     * @return string
     */
    private function getDirectory(string $topicId)
    {
        return "materials/topic_{$topicId}";
    }

    /**
     * Generate a filename based on topic ID, type, and file extension
     *
     * @param string $topicId
     * @param string $type
     * @param string $extension
     * @return string
     */
    private function generateFilename(string $topicId, string $type, string $extension)
    {
        return sprintf(
            'material_%s_%s_%s.%s',
            $topicId,
            $type,
            Str::random(8), // Add randomness to prevent overwriting
            $extension
        );
    }

    /**
     * Ensure the storage link exists
     *
     * @return void
     */
    public function ensureStorageLink()
    {
        if (!file_exists(public_path('storage'))) {
            app('files')->link(
                storage_path('app/public'), public_path('storage')
            );
        }
    }

    /**
     * Get file mime type validation rule based on material type
     *
     * @param string|null $type
     * @return string
     */
    public function getFileValidationRule(?string $type): string
    {
        return match ($type) {
            'video' => 'mimetypes:video/*',
            'image' => 'image',
            'pdf' => 'mimetypes:application/pdf',
            'markdown' => 'mimetypes:text/markdown',
            'code' => 'mimetypes:text/plain',
            default => ''
        };
    }

    /**
     * Check if the material type requires a file upload
     *
     * @param string|null $type
     * @return bool
     */
    public function isFileUploadType(?string $type): bool
    {
        return in_array($type, ['video', 'image', 'pdf', 'markdown', 'code']);
    }

    /**
     * Check if the material type is a link
     *
     * @param string|null $type
     * @return bool
     */
    public function isLinkType(?string $type): bool
    {
        return $type === 'link';
    }
}
