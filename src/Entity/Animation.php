<?php

namespace App\Entity;

use App\Repository\AnimationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimationRepository::class)]
class Animation
{
    use Field\Id;
    use Field\Name;
    use Field\Description;

    #[ORM\Column]
    private int $maxNumberOfParticipants = 1;

    public function getMaxNumberOfParticipants(): ?int
    {
        return $this->maxNumberOfParticipants;
    }

    public function setMaxNumberOfParticipants(?int $maxNumberOfParticipants): void
    {
        $this->maxNumberOfParticipants = $maxNumberOfParticipants ?: 1;
    }
}
