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
use Symfony\Component\HttpKernel\Exception\HttpException;


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
	try{
	$form->submit($request->request->all());

        if (false === $form->isValid()) {
            return $this->view($form, 400);
	}
	} catch(\Exception $e){
		throw new HttpException(400, "invalid or missing data");
	}	

        $this->em->persist($form->getData());
        $this->em->flush();

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
