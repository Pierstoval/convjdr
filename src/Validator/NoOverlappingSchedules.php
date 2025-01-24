<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
final class NoOverlappingSchedules extends Constraint
{
    public string $timeSlotAlreadyTaken = 'This schedule overlaps with another animation at the same time and place.';
    public string $sameAnimationAlreadyProposed = 'This animation has already been proposed or accepted for the same time slot.';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return NoOverlappingSchedulesValidator::class;
    }
}
