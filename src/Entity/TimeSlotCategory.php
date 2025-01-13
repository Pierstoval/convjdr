<?php

namespace App\Entity;

use App\Repository\TimeSlotCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeSlotCategoryRepository::class)]
class TimeSlotCategory
{
    use Field\Id;
    use Field\Name;
    use Field\Description;
}
