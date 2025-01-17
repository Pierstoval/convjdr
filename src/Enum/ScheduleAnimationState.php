<?php

namespace App\Enum;

enum ScheduleAnimationState: string
{
    case CREATED = 'created';
    case PENDING_REVIEW = 'pending_review';
    case REFUSED = 'refused';
    case ACCEPTED = 'accepted';
}
