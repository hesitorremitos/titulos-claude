<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaestriaDocumentService
{
    private string $disk = 'public';

    public function store(UploadedFile $file, array $context): string
    {
        $directory = $this->buildDirectoryPath($context);
        $filename = $this->buildFilename($context, $file);

        Storage::disk($this->disk)->putFileAs($directory, $file, $filename);

        return "{$directory}/{$filename}";
    }

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
        $gestion = $this->buildGestionSegment($context['gestion_inicial'] ?? null, $context['gestion_final'] ?? null);
        $mencion = $this->sanitizeSegment($context['mencion'] ?? null, 'sin-mencion');

        return "maestrias/{$gestion}/{$mencion}";
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

    private function buildGestionSegment(?int $inicial, ?int $final): string
    {
        $start = $this->sanitizeGestionYear($inicial);
        $end = $this->sanitizeGestionYear($final);

        if ($start && $end) {
            return "{$start}-{$end}";
        }

        if ($start || $end) {
            return (string) ($start ?? $end);
        }

        return 'sin-gestion';
    }

    private function sanitizeGestionYear(?int $year): ?int
    {
        if ($year && $year >= 1900 && $year <= 2100) {
            return $year;
        }

        return null;
    }

    private function sanitizeSegment(?string $value, string $fallback): string
    {
        $slug = Str::slug($value ?? '', '-');

        return $slug !== '' ? $slug : $fallback;
    }
}
