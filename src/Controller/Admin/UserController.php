<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 06/04/2019
 * Time: 23:43
 */

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserController extends AbstractController
{


    /**
     * @param Request $request
     * @param UserService $userService
     * @return Response
     * @Route("/admin/userList",name="userList")
     */

    public function index(Request $request, UserService $userService): Response
    {
        $page = (int)$request->query->getInt('page', 1);
        $emailFilter = $request->query->get('email', "");

        // Get users by page number
        $users = $userService->getUsersByPage($page, $emailFilter);

        return $this->render(
            'admin/user/index.html.twig', [
                'users' => $users,
                'emailFilter' => $emailFilter
            ]
        );
    }


    /**
     * @param Request $request
     * @param UserService $userService
     * @param ValidatorInterface $validator
     * @return Response
     * @Route("/admin/new",name="new", methods={"GET","POST"})
     */


    public function new(Request $request, UserService $userService, ValidatorInterface $validator): Response
    {
        $errors = [];
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $userService->addUser($form["username"]->getData(), $form["email"]->getData(), $form["password"]->getData(), $form["roles"]->getData(), $form["isActive"]->getData());
                return $this->redirectToRoute('userList');
            }
            $errors = $validator->validate($user);
        }

        // Render the twig view
        return $this->render(
            'admin/user/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
                'errors' => $errors
            ]
        );

    }
}