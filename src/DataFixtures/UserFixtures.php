<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('jjabrane');
        $admin->setIsActive(true);
        $admin->setEmail('jabrane.pro@gmail.com');
        $admin->setRoles(array('ROLE_ADMIN','ROLE_USER'));
        $admin->setPassword($this->encoder->encodePassword($admin,'L@ravel'));

        // $product = new Product();
        $manager->persist($admin);

        $manager->flush();
    }
}
