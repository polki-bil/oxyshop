<?php

namespace App\CoreDomain;

interface UserRepository
{
    /**
     * @param User $user
     * @return bool
     */
    public function add(User $user): bool;

    /**
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool;

    /**
     * @param int $userId
     * @return User
     * @throws UserNotFoundException
     */
    public function find(int $userId): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;
}