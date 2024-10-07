<?php

namespace App\Bible\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kernel\Utility\Entity;

#[ORM\Entity]
#[ORM\Table(name: "versions")]

class Version extends Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "version_code", type: "string", length: 10, nullable: false)]
    private string $versionCode;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private string $description;

    public function __construct(
        string $versionCode,
        string $description
    ) {
        $this->versionCode = $versionCode;
        $this->description = $description;
    }
}
