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
    /**
     * User repository.
     *
     * @var \App\Repository\UserRepository User repository
     */
    private UserRepository $userRepository;

    /**
     * User password encoder.
     *
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface Password encoder
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserService constructor.
     *
     * @param \App\Repository\UserRepository                                        $userRepository  User repository
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Register user.
     *
     * @param \App\Entity\User $user          User entity
     * @param string           $plainPassword Plain password
     *
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
     * Save user.
     *
     * @param User $user User entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(User $user)
    {
        $this->userRepository->save($user);
    }

    /**
     * Save user password.
     *
     * @param User $user User entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function savePassword(User $user)
    {
        if ($plainPassword = $user->getPassword()) {
            $user->setPassword($this->encodePassword($user, $plainPassword));
        }

        $this->userRepository->save($user);
    }

    /**
     * Encode password.
     *
     * @param User   $user          User entity
     * @param string $plainPassword Plain password
     *
     * @return string Encoded password
     */
    private function encodePassword(User $user, string $plainPassword)
    {
        return $this->passwordEncoder->encodePassword(
            $user,
            $plainPassword,
        );
    }
}
