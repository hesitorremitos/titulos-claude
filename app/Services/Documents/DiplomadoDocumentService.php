<?php

namespace App\Services\Documents;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiplomadoDocumentService
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
        $gestion = $this->buildGestionSegment($context['gestion'] ?? null);
        $mencion = $this->sanitizeSegment($context['mencion'] ?? null, 'sin-mencion');

        return "diplomados/{$gestion}/{$mencion}";
    }

    private function buildFilename(array $context, UploadedFile $file): string
    {
        $segments = [
            $this->sanitizeSegment($context['ci'] ?? null, 'sin-ci'),
            $this->sanitizeSegment($context['nombres'] ?? null, 'sin-nombre'),
            $this->sanitizeSegment($context['paterno'] ?? null, 'sin-apellido'),
            $this->sanitizeSegment($context['materno'] ?? null, 'sin-apellido'),
        ];

        if (! empty($context['nro_tpn'])) {
            $segments[] = $this->sanitizeSegment($context['nro_tpn'], 'sin-tpn');
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: 'pdf');

        return implode('-', array_filter($segments)) . ".{$extension}";
    }

    private function buildGestionSegment(?int $gestion): string
    {
        if ($gestion && $gestion >= 1900 && $gestion <= 2100) {
            return (string) $gestion;
        }

        return 'sin-gestion';
    }

    private function sanitizeSegment(?string $value, string $fallback): string
    {
        $slug = Str::slug($value ?? '', '-');

        return $slug !== '' ? $slug : $fallback;
    }
}
