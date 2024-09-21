<?php

namespace App\Bible\Application;

use App\Bible\Application\DTO\VersionFilterDTO;
use App\Bible\Domain\Entity\Version;
use App\Bible\Domain\VersionService;
use App\Bible\Application\DTO\VersionDTO;
use App\Bible\Domain\Collection\VersionCollection;
use App\Bible\Infrastructure\Client\VersionClient;

class VersionApplication
{
    public function __construct(
        private VersionClient $versionClient,
        private VersionService $versionService
    ) {
    }

    public function getVersions(): VersionCollection
    {
        return $this->versionService->getVersions();
    }

    public function getVersionById(int $id): ?Version
    {
        return $this->versionService->getVersionById($id);
    }

    public function getVersionByFilter(VersionFilterDTO $filter): ?Version
    {
        return $this->versionService->getVersionByFilter($filter->toArray());
    }

    public function saveVersions(VersionDTO $versions): array
    {
        return $this->versionService->saveVersions($versions->getVersionCollection());
    }
}
