<?php

namespace Market;

use AwsS3\AwsStorageInterface;

class AwsBasedFileStorageRepository implements ImageStorageInterface
{
    public function __construct(private AwsStorageInterface $aws) {}

    public function getUrl(string $fileName): ?string
    {
        try {
            return (string) $this->aws->getUrl($fileName);
        } catch (\Exception) {
            return null;
        }
    }

    public function fileExists(string $fileName): bool
    {
        return $this->aws->isAuthorized();
    }

    public function saveFile(string $fileName): void
    {
        throw new \LogicException('Not implemented. Requires write-capable AWS client.');
    }

    public function deleteFile(string $fileName): void
    {
        throw new \LogicException('Not implemented. Requires write-capable AWS client.');
    }
}
