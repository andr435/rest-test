<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Album;
use App\Form\AlbumType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AlbumController
 * @package App\Controller
 * @Rest\RouteResource("Album", pluralize=false)
 */
class AlbumController extends FOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAction()
    {
	    $this->view("get album", 200);
    }

    public function postAction(Request $request)
    {
        $form = $this->createForm(AlbumType::class, new Album());
        $form->submit($request->request->all());

        if (false === $form->isValid()) {
            return $this->handleView(
                $this->view($form)
            );
        }

        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        return $this->handleView(
            $this->view(null, Response::HTTP_CREATED)
        );
    }

    public function cgetAction(Album $album)
    {
        $this->view($album, 200);
    }

    public function putAction(Request $request, Album $album)
    {
        $this->view("update album", 200);
    }

    public function deleteAction(Album $album)
    {
        $this->view("delete album", 200);
    }
}
