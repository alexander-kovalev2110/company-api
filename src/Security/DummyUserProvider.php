<?php
// src/Security/DummyUserProvider.php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class DummyUserProvider implements UserProviderInterface
{
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return new class($identifier) implements UserInterface {
            private string $username;

            public function __construct(string $username)
            {
                $this->username = $username;
            }

            public function getUserIdentifier(): string
            {
                return $this->username;
            }

            public function getRoles(): array
            {
                return ['ROLE_USER'];
            }

            // ⚡ добавляем : void
            public function eraseCredentials(): void {}
        };
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return true;
    }

    // устаревший метод для совместимости
    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }
}