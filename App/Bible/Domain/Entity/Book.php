<?php

namespace App\Bible\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kernel\Utility\Entity;

#[ORM\Entity]
#[ORM\Table(name: "books")]
class Book extends Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "json", nullable: false)]
    private array $abbreviation;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: "string", length: 3, nullable: false)]
    private string $testament;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private string $author;

    #[ORM\Column(name: "total_chapters", type: "integer", nullable: true)]
    private int $totalChapters;

    #[ORM\Column(type: "string", length: 255, nullable: true, name: "`group`")]
    private string $group;

    public function __construct(
        array $abbreviation,
        string $author,
        int $totalChapters,
        string $group,
        string $name,
        string $testament
    ) {
        $this->abbreviation = $abbreviation;
        $this->author = $author;
        $this->totalChapters = $totalChapters;
        $this->group = $group;
        $this->name = $name;
        $this->testament = $testament;
    }
}
