<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 06/04/2019
 * Time: 23:46
 */

namespace App\Service;

use App\Entity\User;
use App\Entity\UserDetails;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserService
{

    /**
     * @var UserPasswordEncoderInterface
     */

    private $passwordEncoder;
    private $userRepository;
    private $page;
    private $validator;


    /**
     * UserService constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @param PaginatorInterface $page
     * @param ValidatorInterface $validator
     */

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository, PaginatorInterface $page, ValidatorInterface $validator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
        $this->page = $page;
        $this->validator = $validator;


    }

    /**
     * @param Int $page
     * @param String $emailFilter
     * @return SlidingPagination
     */

    public function getUsersByPage(Int $page = 1, String $emailFilter = ""): SlidingPagination
    {
        return $this->page->paginate(
        // Doctrine Query, not results
            $this->userRepository->getAllUsersQuery($emailFilter),
            // Define the page parameter
            $page,
            // Items per page
            8
        );
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param array $roles
     * @param bool $active
     * @param $filename
     * @param $street
     * @param $city
     * @param $country
     * @return User
     */


    public function addUser(string $username, string $email, string $password, array $roles, bool $active,$filename,$street,$city,$country): User
    {
        $errors = null;
        $result = null;

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setIsActive($active);

        $userDetails = new UserDetails();
        $userDetails->setCity($city);
        $userDetails->setImage($filename);
        $userDetails->setStreet($street);
        $userDetails->setCountry($country);
        $user->setUserdetails($userDetails);
        $userDetails->setUser($user);

        $this->userRepository->saveUser($user,$userDetails);
        return $user;

        /*$errors = $this->validator->validate($user);
        $result = $this->getErrorsFromValidator($errors);*/
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return array
     */

    private function getErrorsFromValidator(ConstraintViolationListInterface $errors)
    {
        $formattedErrors = [];
        foreach ($errors as $error) {
            $formattedErrors[$error->getPropertyPath()] = $error->getMessage();
        }
        return $formattedErrors;
    }

}