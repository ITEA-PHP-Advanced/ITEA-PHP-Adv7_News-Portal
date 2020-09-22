<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserFixtures extends AbstractFixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $adminUser = new User('admin@dev.com');
        $adminUserPass = $this->passwordEncoder->encodePassword($adminUser, 'dev');
        $adminUser->setPassword($adminUserPass);

        $manager->persist($adminUser);

        for ($i = 0; $i < 5; ++$i) {
            $user = new User($this->faker->email);
            $userPass = $this->passwordEncoder->encodePassword($user, 'test');
            $user->setPassword($userPass);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
