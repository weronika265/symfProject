<?php
/**
 * User service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService.
 */
class UserService
{
    private UserRepository $userRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserService constructor.
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function registerUser(User $user, string $plainPassword)
    {
        $user->setRoles([User::ROLE_USER]);
        $user->setPassword($this->encodePassword($user, $plainPassword));

        $this->userRepository->save($user);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(User $user)
    {
        if ($plainPassword = $user->getPassword()) {
            $user->setPassword($this->encodePassword($user, $plainPassword));
        }

        $this->userRepository->save($user);
    }

    /**
     * @return string
     */
    private function encodePassword(User $user, string $plainPassword)
    {
        return $this->passwordEncoder->encodePassword(
            $user,
            $plainPassword,
        );
    }
}
