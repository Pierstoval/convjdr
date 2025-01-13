<?php

namespace App\Entity\Field;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

trait StartEndDates
{
    #[ORM\Column(nullable: false)]
    #[Assert\LessThan(propertyPath: 'endsAt')]
    private \DateTimeImmutable $startsAt;

    #[ORM\Column(nullable: false)]
    #[Assert\GreaterThan(propertyPath: 'startsAt')]
    private \DateTimeImmutable $endsAt;

    public function getStartsAt(): \DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeImmutable $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): \DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTimeImmutable $endsAt): void
    {
        $this->endsAt = $endsAt;
    }
}
