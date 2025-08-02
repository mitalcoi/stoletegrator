<?php

namespace Market;

class FileStorageRepository implements ImageStorageInterface
{
    public function __construct(private string $basePath, private string $baseUrl) {}

    public function getUrl(string $fileName): ?string
    {
        return $this->fileExists($fileName) ? $this->baseUrl . '/' . $fileName : null;
    }

    public function fileExists(string $fileName): bool
    {
        return file_exists($this->basePath . '/' . $fileName);
    }

    public function saveFile(string $fileName): void
    {
        file_put_contents($this->basePath . '/' . $fileName, 'stub');
    }

    public function deleteFile(string $fileName): void
    {
        unlink($this->basePath . '/' . $fileName);
    }
}
