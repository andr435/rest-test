<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
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

    /**
     * @var AlbumRepository
     */
    private $albumRep;

    /**
     * AlbumController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, AlbumRepository $alRep)
    {
        $this->em = $em;
        $this->albumRep = $alRep;
    }

    public function getAction()
    {
        return $this->view($this->albumRep->findAll(), 200);
    }

    public function postAction(Request $request)
    {
        $form = $this->createForm(AlbumType::class, new Album());
        $form->submit($request->request->all());

        if (false === $form->isValid()) {
            return $this->view($form, 400);
        }

        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        return $this->view(null, 201);
    }

    public function cgetAction(Album $album)
    {
        return $this->view($album, 200);
    }

    public function putAction(Request $request, Album $album)
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->submit($request->request->all(), false);

        if(false === $form->isValid()){
            return $this->view($form);
        }

        $this->em->flush();
        return $this->view(null, 204);
    }

    public function deleteAction(Album $album)
    {
        $this->em->remove($album);
        $this->em->flush();
        return $this->view(null, 204);
    }
}
