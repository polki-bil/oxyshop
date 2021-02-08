<?php


namespace App\Repository;


use App\CoreDomain\User;
use App\CoreDomain\UserRepository;


/**
 * not really an implementation, just showcase how it could work.
 */
class FileUserRepository implements UserRepository
{
    /**
     * not really an implementation, just showcase how it could work.
     *
     * @inheritDoc
     */
    public function add(User $user): bool
    {
        if (file_exists($user->getName())) {
            return false;
        }

        file_put_contents($user->getName(), $user->getEmail().$user->getPassword().$user->getUserRole());

        return true;
    }

    public function remove(User $user): bool
    {
        // TODO: Implement remove() method.
        return false;
    }

    public function find(int $userId): ?User
    {
        // TODO: Implement find() method.
        return null;
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
        return [];
    }
}