<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setNom('admin')
             ->setEmail('admin@admin.fr')
             ->setPassword($this->passwordEncoder->encodePassword($user,"admin"))
             ->setUpdatedAt(new \DateTime('now'));

        $manager->persist($user);

        $manager->flush();
    }
}
