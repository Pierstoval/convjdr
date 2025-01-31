<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class TimeSlotVoter extends Voter
{
    public const CAN_CREATE_TIME_SLOTS_FOR_EVENT = 'CAN_CREATE_TIME_SLOTS_FOR_EVENT';

    public function __construct(private readonly AuthorizationCheckerInterface $authChecker)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::CAN_CREATE_TIME_SLOTS_FOR_EVENT;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($this->authChecker->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($subject instanceof Event) {
            return $subject->hasCreator($user);
        }

        return false;
    }
}
