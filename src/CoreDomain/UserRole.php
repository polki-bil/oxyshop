<?php


namespace App\CoreDomain;


class UserRole
{
    private $role;

    private const VALID_ROLES = ['ADMIN', 'USER'];

    /**
     * UserRole constructor.
     * @param string $role
     */
    public function __construct(string $role)
    {
        if (!in_array($role, self::VALID_ROLES))
        {
            throw new invalidUserRoleException();
        }

        $this->role = $role;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->role;
    }
}
