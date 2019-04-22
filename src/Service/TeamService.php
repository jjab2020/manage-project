<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 21/04/2019
 * Time: 18:56
 */

namespace App\Service;


use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Repository\UserTeamRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TeamService
{
    protected $validator;
    protected $teamRepository;
    protected $userTeamRepository;
    protected $paginator;

    /**
     * TeamService constructor.
     * @param ValidatorInterface $validator
     * @param TeamRepository $teamRepository
     * @param UserTeamRepository $userTeamRepository
     */

    public function __construct(ValidatorInterface $validator, TeamRepository $teamRepository, UserTeamRepository $userTeamRepository,PaginatorInterface $paginator)
    {
        $this->validator = $validator;
        $this->teamRepository = $teamRepository;
        $this->userTeamRepository = $userTeamRepository;
        $this->paginator=$paginator;

    }

    public function addTeam(string $name)
    {
        $team = new Team();
        $team->setName($name);
        $errors = $this->validator->validate($team);
        if ($errors->count()) {
            return $errors;
        }
        $this->teamRepository->save($team);
        return true;
    }
    public function getUserGroupsByPage($page = 1): SlidingPagination
    {
        return $this->paginator->paginate(
        // Doctrine Query, not results
            $this->teamRepository->getAlluserTeamsQuery(),
            // Define the page parameter
            $page,
            // Items per page
            5
        );
    }
}