<?php

namespace Market;

readonly class ProductImage
{
    public function __construct(
        private string $fileName,
        private ImageStorageInterface $storage
    ) {}

    public function getUrl(): ?string
    {
        return $this->storage->fileExists($this->fileName)
            ? $this->storage->getUrl($this->fileName)
            : null;
    }

    public function update(): bool
    {
        try {
            if (!$this->storage->fileExists($this->fileName)) {
                $this->storage->deleteFile($this->fileName);
            }
            $this->storage->saveFile($this->fileName);
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
