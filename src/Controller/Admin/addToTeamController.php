<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 22/04/2019
 * Time: 17:44
 */

namespace App\Controller\Admin;


use App\Entity\User;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class addToTeamController extends AbstractController
{

    /**
     * @param User $user
     * @param TeamRepository $teamRepository
     * @return Response
     * @Route("/{id}/addToTeam",name="addToTeam",methods={"GET","POST"})
     */


    public function index(User $user,TeamRepository $teamRepository):Response
    {

        $repo = $teamRepository->findAll();

        return $this->render(
            'admin/user/addUserTeam.html.twig', [
                'user_index' => $user->getUsername(),
                'teams' => $repo
            ]
        );
    }

}