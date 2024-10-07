<?php

namespace App\Verse\Domain\Entity;

use App\Bible\Domain\Entity\Version;
use Doctrine\ORM\Mapping as ORM;
use Kernel\Utility\Entity;

#[ORM\Entity]
#[ORM\Table(name: "verses")]
class VerseContent extends Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Verse::class)]
    #[ORM\JoinColumn(name: "verse_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Verse $verse;

    #[ORM\ManyToOne(targetEntity: Version::class)]
    #[ORM\JoinColumn(name: "version_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Version $version;

    #[ORM\Column(type: "string", nullable: false)]
    private string $content;

    public function __construct(
        Verse $verse,
        Version $version,
        string $content
    ) {
        $this->verse = $verse;
        $this->version = $version;
        $this->content = $content;
    }
}
