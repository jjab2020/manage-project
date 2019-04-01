<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 31/03/2019
 * Time: 22:19
 */

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public  function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
    }
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
        // user account is expired, the user may be notified
        if (!$user->getIsActive()) {
            throw new CustomUserMessageAuthenticationException("ce membre n'est pas actif");
        }
    }

}