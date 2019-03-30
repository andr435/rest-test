<?php

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UserController
 * @package App\Controller
 * @Rest\RouteResource(pluralize=false)
 */
class UserController extends FOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $userRep;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $em
     * @param UserRepository $userRep
     */
    public function __construct(EntityManagerInterface $em, UserRepository $userRep)
    {
        $this->em = $em;
        $this->userRep = $userRep;
    }

    public function getTokenAction(Request $request)
    {

    }

    public function getAccountAction()
    {
        
    }
}
