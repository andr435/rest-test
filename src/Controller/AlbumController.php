<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Class AlbumController
 * @package App\Controller
 * @Rest\RouteResource("Album", pluralize=false)
 */
class AlbumController extends FOSRestController
{
    public function getAction()
    {
	    echo "get album";
    }

    public function postAction()
    {
	    echo "post album";
    }

    public function cgetAction(int $album)
    {
	    echo "echo get 1 album";
    }

    public function putAction(int $album)
    {
	    echo "update album";
    }

    public function deleteAction(int $album)
    {
	    echo "delete album";
    }
}
