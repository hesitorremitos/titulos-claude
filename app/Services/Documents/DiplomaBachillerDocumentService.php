<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiplomaBachillerDocumentService
{
    private string $disk = 'public';

    /**
     * Store a new diploma PDF using the required directory structure.
     *
     * @param UploadedFile $file PDF file uploaded from the request.
     * @param array{
     *     fecha_emision?: string|null,
     *     mencion?: string|null,
     *     ci?: string|null,
     *     nombres?: string|null,
     *     paterno?: string|null,
     *     materno?: string|null
     * } $context Context data used to build the destination path.
     */
    public function store(UploadedFile $file, array $context): string
    {
        $directory = $this->buildDirectoryPath($context);
        $filename = $this->buildFilename($file, $context);

        Storage::disk($this->disk)->putFileAs($directory, $file, $filename);

        return "{$directory}/{$filename}";
    }

    /**
     * Replace an existing diploma PDF with a new one, deleting the previous file.
     *
     * @param string|null $currentPath Path of the current file (if any).
     * @param UploadedFile $file New PDF uploaded from the request.
     * @param array $context Context data used to build the new destination path.
     */
    public function replace(?string $currentPath, UploadedFile $file, array $context): string
    {
        if ($currentPath && Storage::disk($this->disk)->exists($currentPath)) {
            Storage::disk($this->disk)->delete($currentPath);
        }

        return $this->store($file, $context);
    }

    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (Storage::disk($this->disk)->exists($path)) {
            Storage::disk($this->disk)->delete($path);
        }
    }

    private function buildDirectoryPath(array $context): string
    {
        $year = $this->resolveYear($context['fecha_emision'] ?? null);
        $mencion = $this->sanitizeSegment($context['mencion'] ?? null, 'sin-mencion');

        return "diplomas-bachiller/{$year}/{$mencion}";
    }

    private function buildFilename(UploadedFile $file, array $context): string
    {
        $segments = [
            $this->sanitizeSegment($context['ci'] ?? null, 'sin-ci'),
            $this->sanitizeSegment($context['nombres'] ?? null, 'sin-nombre'),
            $this->sanitizeSegment($context['paterno'] ?? null, 'sin-apellido'),
            $this->sanitizeSegment($context['materno'] ?? null, 'sin-apellido'),
        ];

        $extension = strtolower($file->getClientOriginalExtension() ?: 'pdf');

        return implode('-', array_filter($segments)) . ".{$extension}";
    }

    private function resolveYear(?string $fechaEmision): string
    {
        if ($fechaEmision) {
            try {
                return Carbon::parse($fechaEmision)->format('Y');
            } catch (\Exception $exception) {
                // Continue to fallback below.
            }
        }

        return now()->format('Y');
    }

    private function sanitizeSegment(?string $value, string $fallback): string
    {
        $slug = Str::slug($value ?? '', '-');

        return $slug !== '' ? $slug : $fallback;
    }
}
