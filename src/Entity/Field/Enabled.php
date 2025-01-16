<?php

namespace App\Entity\Field;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait Enabled
{
    #[ORM\Column(name: 'enabled', type: Types::BOOLEAN, nullable: false, options: ['default' => 0])]
    private bool $enabled = false;

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
}
