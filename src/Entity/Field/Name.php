<?php

namespace App\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

trait Name
{
    #[ORM\Column(name: 'name', length: 255, nullable: false)]
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
