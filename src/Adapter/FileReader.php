<?php declare(strict_types=1);

namespace App\Adapter;

readonly class FileReader
{
    public function fileGetContents(string $path): ?string
    {
        return file_get_contents($path) ?: null;
    }
}