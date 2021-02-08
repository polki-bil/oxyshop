<?php

namespace App\CoreDomain;


class UserFactory
{
    /**
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $role
     * @return User
     */
    public function create(string $name, string $password, string $email, string $role): User
    {
        return new User(
            $name,
            $password,
            $email,
            new UserRole($role)
        );
    }

    /**
     * @param string $jsonObject
     * @return User
     */
    public function createFromJson(string $jsonObject): User
    {
        $decodedData = json_decode($jsonObject, true);

        return $this->create(
            $decodedData['name'],
            $decodedData['password'],
            $decodedData['email'],
            $decodedData['role']
        );
    }

    /**
     * @param $doctrineList
     * @return array
     */
    public function createFromDoctrineList($doctrineList): array
    {
        $users = [];

        foreach ($doctrineList as $userEntity)
        {
            $users[] = $this->create(
                $userEntity->getName(),
                $userEntity->getEmail(),
                $userEntity->getPassword(),
                $userEntity->getRole()
            );
        }

        return $users;
    }
}