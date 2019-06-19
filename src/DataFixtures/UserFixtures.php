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
        $user->setEmail('admin@admin.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user,"admin"));
        // $product = new Product();
        $manager->persist($user);

        $manager->flush();
    }
}
