<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements  UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
     public function LoadUserByUsername($usernameOrEmail){
         return $this->createQueryBuilder('u')
             ->where('u.username = :query OR u.email = :query')
             ->setParameter('query', $usernameOrEmail)
             ->getQuery()
             ->getOneOrNullResult();
     }

    public function getAllUsersQuery(String $emailFilter = "") : Query
    {
        $builder = $this->createQueryBuilder('u');
        if ($emailFilter !== "") {
            $builder->where('u.email LIKE :email')
                ->setParameter('email', "%".$emailFilter."%");
        }
        return $builder->orderBy('u.id', 'ASC')
            ->getQuery();
    }
}
