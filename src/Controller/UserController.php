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

    public function postTokenAction(Request $request)
    {
        $userName = $request->request->get('username', null);
        $pwd = $request->request->get('password', null);
        if(is_null($userName) || is_null($pwd)){
            throw new HttpException(400, "missing username or password");
        }

        $user = $this->userRep->findOneBy(["username" => $userName]);
        if(!$user || $user->getPassword() != md5($pwd)){
            throw new HttpException(400, "incorrect credentials");
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        return $this->view(['token' => 'Bearer '.$token], 204);

    }

    public function getAccountAction()
    {
        
    }
}
