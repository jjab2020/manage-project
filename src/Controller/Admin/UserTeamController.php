<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 21/04/2019
 * Time: 19:18
 */

namespace App\Controller\Admin;

use App\Entity\Team;
use App\Form\TeamType;
use App\Service\TeamService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTeamController extends AbstractController
{

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param TeamService $teamService
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/userTeam",name="userTeam")
     */


    public function index(PaginatorInterface $paginator, Request $request, TeamService $teamService)
    {

        $page = (int)$request->query->getInt('page', 1);

        // Get users by page number
        $userTeams = $teamService->getUserGroupsByPage($page);
        return $this->render(
            'admin/user_group/index.html.twig', [
                'teams' => $userTeams

            ]
        );

    }

    /**
     * @param Request $request
     * @param TeamService $service
     * @param ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/userTeam/new",name="newTeam")
     */


    public function new(Request $request, TeamService $service, ValidatorInterface $validator)
    {
        $errors = [];

        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        // Check is form submited and is it valid

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $service->addTeam($form->getData()->getName());

                return $this->redirectToRoute('userTeam');
            }
            $errors = $validator->validate($team);
        }

        return $this->render(
            'admin/user_group/new.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors
            ]
        );
    }
}