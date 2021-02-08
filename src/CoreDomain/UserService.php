<?php


namespace App\CoreDomain;


class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EmailValidator
     */
    private $emailValidator;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var PasswordValidator
     */
    private $passwordValidator;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param EmailValidator $emailValidator
     * @param PasswordValidator $passwordValidator
     * @param UserFactory $userFactory
     */
    public function __construct(
        UserRepository $userRepository,
        EmailValidator $emailValidator,
        PasswordValidator $passwordValidator,
        UserFactory $userFactory
    ) {
        $this->userRepository = $userRepository;
        $this->emailValidator = $emailValidator;
        $this->passwordValidator = $passwordValidator;
        $this->userFactory = $userFactory;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function addUser(User $user): bool
    {
        if (!$this->emailValidator->validate($user->getEmail()))
        {
            return false;
        }

        if (!$this->passwordValidator->validate($user->getPassword()))
        {
            return false;
        }
        // easiest hash with default bcrypt, and automatic salt
        $encryptedPassword = password_hash($user->getPassword(),  PASSWORD_BCRYPT);

        $userWithPassword = $this->userFactory->create(
            $user->getName(),
            $encryptedPassword,
            $user->getEmail(),
            (string) $user->getUserRole()
        );

        return $this->userRepository->add($userWithPassword);
    }

    /**
     * @return array
     */
    public function findAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}
