<?php

namespace App\Controller;

use App\Entity\AvailableReaction;
use App\Entity\Duck;
use App\Repository\DuckRepository;
use App\Repository\AvailableReactionRepository;
use App\Repository\QuackRepository;
use App\Repository\ReactionRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(QuackRepository $quackRepository, ReactionRepository $reactionRepository, DuckRepository $duckRepository, TagRepository $tagRepository, AvailableReactionRepository $availableReactionRepository): Response
    {
        $quacks = $quackRepository->findBy([],['created_at'=>'DESC'],30);

        foreach ($quacks as $quack){
            $quack->statistics=$reactionRepository->getQuackStatistics($quack);
        }

        return $this->render('home/index.html.twig', [
            'quacks' => $quacks,
            'ducks' => $duckRepository->findBy([],['duckname'=>'ASC'],5),
            'tags' => $tagRepository->findBy([],['name'=>'ASC'],5),
            'availableReactions'=> $availableReactionRepository->findAll(),

        ]);
    }
}
