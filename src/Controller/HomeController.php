<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Repository\DuckRepository;
use App\Repository\QuackRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(QuackRepository $quackRepository, DuckRepository $duckRepository, TagRepository $tagRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'quacks' => $quackRepository->findBy([],['created_at'=>'DESC'],30),
            'ducks' => $duckRepository->findBy([],['duckname'=>'ASC'],5),
            'tags' => $tagRepository->findBy([],['name'=>'ASC'],5)
        ]);
    }
}
