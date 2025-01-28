<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LocaleListener implements EventSubscriberInterface
{
    public function __construct(private readonly TokenStorageInterface $tokenStorage)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $req = $event->getRequest();

        if ($req->attributes->has('_locale')) {
            // Some other part of the app must have overriden the locale: let it go
            return;
        }

        if ($req->query->has('lang')) {
            $req->attributes->set('_locale', $req->query->get('lang'));

            return;
        }

        $user = $this->tokenStorage->getToken()?->getUser();
        if ($user instanceof User) {
            $req->attributes->set('_locale', $user->getLocale());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            /**
             * Must be used before Symfony's locale listener.
             * @see \Symfony\Component\HttpKernel\EventListener\LocaleListener
             */
            KernelEvents::REQUEST => ['onKernelRequest', 17],
        ];
    }
}
