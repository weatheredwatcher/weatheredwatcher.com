<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{

    private $passwordEncoder;
    private $created;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->created = new \DateTime();
    }

    public function load(ObjectManager $manager)
    {
        $user = new user();
        $user->setUsername('admin');
        $user->setEmail('david.duggins@hey.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 
            'password'
        ));
        $user->setRoles(array('ROLE_USER', 'ROLE_ADMIN'));
        $user->setCreated($this->created);
        $user->setUpdated($this->created);   
        $manager->persist($user);

        $manager->flush();
    }
}
