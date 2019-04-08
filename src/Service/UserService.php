<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 06/04/2019
 * Time: 23:46
 */

namespace App\Service;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserService
{

    /**
     * @var UserPasswordEncoderInterface
     */

    private $passwordEncoder;
    private $userRepository;
    private $paginator;


    /**
     * UserService constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     */

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository, PaginatorInterface $paginator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;

    }

    /**
     * @param Int $page
     * @param String $emailFilter
     * @return SlidingPagination
     */

    public function getUsersByPage(Int $page = 1, String $emailFilter = ""): SlidingPagination
    {
        return $this->paginator->paginate(
        // Doctrine Query, not results
            $this->userRepository->getAllUsersQuery($emailFilter),
            // Define the page parameter
            $page,
            // Items per page
            5
        );
    }
}