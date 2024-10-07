<?php

namespace App\Bible\Infrastructure\Repository;

use Kernel\Db\BaseRepository;
use App\Bible\Domain\Entity\Version;
use App\Bible\Domain\Collection\VersionCollection;

class VersionRepository extends BaseRepository
{
    public function getEntity(): string
    {
        return Version::class;
    }

    public function getVersions(): VersionCollection
    {
        return new VersionCollection(
            $this->findAll()
        );
    }

    public function getVersionById(int $id): ?Version
    {
        return $this->findById($id);
    }

    public function getVersionByFilter(array $filter): ?Version
    {
        return $this->findOneBy($filter);
    }

    public function saveVersion(Version $version): Version
    {
        $this->persist($version);
        $this->flush();

        return $version;
    }
}
