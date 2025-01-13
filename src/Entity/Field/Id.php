<?php

namespace App\Entity\Field;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait Id
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    public function __construct()
    {
        $this->id = Uuid::v7()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
