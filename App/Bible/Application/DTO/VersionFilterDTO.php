<?php

namespace App\Bible\Application\DTO;

class VersionFilterDTO
{
    public function __construct(
        private ?int $id = null,
        private ?string $versionCode = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersionCode(): ?string
    {
        return $this->versionCode;
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this));
    }
}
