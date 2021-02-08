<?php

namespace App\CoreDomain;

use JsonSerializable;

class User implements JsonSerializable
{
    private $name;
    private $password;
    private $email;
    private $userRole;

    /**
     * User constructor.
     * @param string $name
     * @param string $password
     * @param string $email
     * @param UserRole $userRole
     */
    public function __construct(
        string $name,
        string $password,
        string $email,
        UserRole $userRole
    ) {
      $this->name = $name;
      $this->password = $password;
      $this->email = $email;
      $this->userRole = $userRole;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return UserRole
     */
    public function getUserRole(): UserRole
    {
        return $this->userRole;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'password' => $this->getPassword(),
            'email' => $this->getEmail(),
            'role' => (string) $this->getUserRole()
        ];
    }
}
