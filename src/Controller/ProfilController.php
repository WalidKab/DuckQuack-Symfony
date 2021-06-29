<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Repository\DuckRepository;
use App\Repository\QuackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/{id}", name="profil", methods={"GET"})
     */
    public function index(DuckRepository $duckRepository, Duck $duck, QuackRepository $quackRepository): Response
    {
        return $this->render('profil/index.html.twig', [
            'duck' => $duckRepository->find($duck->getId()),
            'quacks' => $quackRepository->findBy([],['created_at'=>'DESC']),
        ]);
    }
}
