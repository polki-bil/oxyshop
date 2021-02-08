<?php

namespace App\Repository;

use App\CoreDomain\User;
use App\CoreDomain\UserFactory;
use App\CoreDomain\UserNotFoundException;
use App\CoreDomain\UserRepository;
use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;


class DoctrineUserRepository implements UserRepository
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var ServiceEntityRepository $serviceEntityRepository */
    private $serviceEntityRepository;

    /** @var UserFactory */
    private $userFactory;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $em,
        UserFactory $userFactory
    ) {
        $this->serviceEntityRepository = new ServiceEntityRepository($registry, UserEntity::class);
        $this->entityManager = $em;
        $this->userFactory = $userFactory;
    }

    /**
     * @inheritDoc
     */
    public function add(User $user): bool
    {
        $userEntity = new UserEntity();
        $userEntity->setEmail($user->getEmail());
        $userEntity->setName($user->getName());
        $userEntity->setPassword($user->getPassword());
        $userEntity->setRole((string) $user->getUserRole());

        try {
            $this->entityManager->persist($userEntity);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function remove(User $user): bool
    {
        // not implemented
        return false;
    }

    /**
     * @inheritDoc
     */
    public function find(int $userId): User
    {
        /** @var UserEntity $userEntity */
        $userEntity = $this->serviceEntityRepository->find($userId);

        if (empty($userEntity)) {
            throw new UserNotFoundException();
        }

        return $this->userFactory->create(
            $userEntity->getName(),
            $userEntity->getEmail(),
            $userEntity->getPassword(),
            $userEntity->getRole()
        );
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        /** @var UserEntity $userEntity */
        $userEntities = $this->serviceEntityRepository->findAll();

        return $this->userFactory->createFromDoctrineList($userEntities);
    }
}
