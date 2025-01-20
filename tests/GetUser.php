<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait GetUser
{
    protected function getUser(string $username = 'admin'): User
    {
        if (!isset($this->client) || !$this->client instanceof KernelBrowser) {
            throw new \RuntimeException(\sprintf('Trait "%s" used by class "%s" can only be used in an instance of "%s".', self::class, static::class, AbstractCrudTestCase::class));
        }

        return $this->client->getContainer()->get(UserRepository::class)->loadUserByIdentifier($username);
    }
}
