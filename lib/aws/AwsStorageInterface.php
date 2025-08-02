<?php
namespace AwsS3;
interface AwsStorageInterface
{

    public function isAuthorized(): bool;

    public function getUrl(string $fileName): AwsUrlInterface;
}
