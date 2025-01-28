<?php

namespace App\Enum;

enum ScheduleAnimationState: string
{
    case CREATED = 'created';
    case PENDING_REVIEW = 'pending_review';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';
}
