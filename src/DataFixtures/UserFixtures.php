<?php

namespace App\DataFixtures;

use App\Entity\User;
use APP\Entity\UserDetails;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private $faker;

    private $encoder;

    /**
     * UserFixtures constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create();
    }


    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('jjabrane');
        $admin->setIsActive(true);
        $admin->setEmail('jabrane.pro@gmail.com');
        $admin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $admin->setPassword($this->encoder->encodePassword($admin, 'L@ravel'));
        $admin->setCreatedAt(new \DateTime());
        $admin->setUpdatedAt(new \DateTime());

        /*create details of admin*/

        $userDetails = new  UserDetails();
        $userDetails->setStreet('1725 18e Rue');
        $userDetails->setCity('QC');
        $userDetails->setCountry('Canada');
        $userDetails->setImage('apple.png');

        $admin->setUserdetails($userDetails);
        $userDetails->setUser($admin);

        $manager->persist($userDetails);
        $manager->persist($admin);


        // Create random 20 fake users
        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $firstname = $this->faker->firstName;
            $lastname = $this->faker->lastName;
            $user->setUsername($firstname);
            $user->setEmail($firstname . '.' . $lastname . '@gmail.com');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->encoder->encodePassword(
                    $user,
                    'test'
                )
            );
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            $user->setIsActive(true);
            $manager->persist($user);
        }


        $manager->flush();
    }
}
