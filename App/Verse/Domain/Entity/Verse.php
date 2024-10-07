<?php

namespace App\Verse\Domain\Entity;

use Kernel\Utility\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Chapter\Domain\Entity\Chapter;

#[ORM\Entity]
#[ORM\Table(name: "verses")]
class Verse extends Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Chapter::class)]
    #[ORM\JoinColumn(name: "chapter_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Chapter $chapter;

    #[ORM\Column(type: "integer", nullable: false)]
    private int $verseNumber;

    public function __construct(
        Chapter $chapter,
        int $verseNumber
    ) {
        $this->chapter = $chapter;
        $this->verseNumber = $verseNumber;
    }
}
