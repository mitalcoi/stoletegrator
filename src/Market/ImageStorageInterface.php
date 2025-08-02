<?php

namespace Market;

interface ImageStorageInterface
{
    public function getUrl(string $fileName): ?string;
    public function fileExists(string $fileName): bool;
    public function saveFile(string $fileName): void;
    public function deleteFile(string $fileName): void;
}
