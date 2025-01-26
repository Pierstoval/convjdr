<?php

namespace App\Security\Voter;

use App\Entity\ScheduledAnimation;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class ScheduledAnimationVoter extends Voter
{
    public const CAN_ACCEPT_SCHEDULE = 'CAN_ACCEPT_SCHEDULE';
    public const CAN_REJECT_SCHEDULE = 'CAN_REJECT_SCHEDULE';

    public function __construct(private readonly AuthorizationCheckerInterface $authChecker)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return \in_array($attribute, [self::CAN_REJECT_SCHEDULE, self::CAN_ACCEPT_SCHEDULE], true)
            && $subject instanceof ScheduledAnimation;
    }

    /**
     * @param ScheduledAnimation $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        if ($this->authChecker->isGranted('ROLE_ADMIN')) {
            return true;
        }

        foreach ($subject->getAnimation()?->getCreators() as $creator) {
            if ($creator->getId() === $user->getId()) {
                return true;
            }
        }

        return false;
    }
}
