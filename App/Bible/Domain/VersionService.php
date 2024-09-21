<?php

namespace App\Bible\Domain;

use App\Bible\Domain\Collection\VersionCollection;
use App\Bible\Domain\Entity\Version;
use App\Bible\Infrastructure\Repository\VersionRepository;

class VersionService
{
    public function __construct(
        private VersionRepository $versionRepository
    ) {
    }

    public function getVersions(): VersionCollection
    {
        try {
            if ($versions = getCache('versionCollection')) {
                return $versions;
            }

            $versions = $this->versionRepository->getVersions();

            setCache('versionCollection', $versions);

            return $versions;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get versions');
        }
    }

    public function getVersionById(int $id): ?Version
    {
        try {
            if ($version = getCache('version_' . $id)) {
                return $version;
            }

            $version = $this->versionRepository->getVersionById($id);

            setCache('version_' . $id, $version);

            return $version;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get version');
        }
    }

    public function getVersionByFilter(array $filter): ?Version
    {
        try {
            if ($version = getCache('version_' . ($filter['id'] ?? $filter['versionCode']))) {
                return $version;
            }

            $version = $this->versionRepository->getVersionByFilter($filter);

            setCache('version_' . ($filter['id'] ?? $filter['versionCode']), $version);

            return $version;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get version');
        }
    }

    public function saveVersions(VersionCollection $versionCollection): array
    {
        $versions = $versionCollection->all();
        $savedVersions = [];
        foreach ($versions as $version) {
            if (!$version instanceof Version) {
                throw new \InvalidArgumentException('Invalid version object');
            }

            $savedVersions[] = $this->versionRepository->saveVersion($version);
        }

        return $savedVersions;
    }
}
