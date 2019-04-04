<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function dashboard()
    {
        $user = $this->getUser();
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'username' => $user->getUsername()
        ]);
    }
}
