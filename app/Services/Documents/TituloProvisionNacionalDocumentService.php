<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TituloProvisionNacionalDocumentService
{
    private string $disk = 'public';

    /**
     * Store a new TPN PDF file.
     */
    public function store(UploadedFile $file, array $context): string
    {
        $directory = $this->buildDirectoryPath($context);
        $filename = $this->buildFilename($context, $file);

        Storage::disk($this->disk)->putFileAs($directory, $file, $filename);

        return "{$directory}/{$filename}";
    }

    /**
     * Replace an existing file with a new one.
     */
    public function replace(?string $currentPath, UploadedFile $file, array $context): string
    {
        if ($currentPath && Storage::disk($this->disk)->exists($currentPath)) {
            Storage::disk($this->disk)->delete($currentPath);
        }

        return $this->store($file, $context);
    }

    /**
     * Delete an existing file if present.
     */
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

        return "titulo-provision-nacional/{$year}/{$mencion}";
    }

    private function buildFilename(array $context, UploadedFile $file): string
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

    private function sanitizeSegment(?string $value, string $fallback): string
    {
        $slug = Str::slug($value ?? '', '-');

        return $slug !== '' ? $slug : $fallback;
    }

    private function resolveYear(?string $fechaEmision): string
    {
        if ($fechaEmision) {
            try {
                return Carbon::parse($fechaEmision)->format('Y');
            } catch (\Exception $exception) {
                // Fallback to current year below.
            }
        }

        return now()->format('Y');
    }
}
